<?php

namespace App\Controllers;

class Category extends BaseController
{
    protected $breadcrumbService;
    protected $menuService;
    protected $categoryService;

    public function __construct()
    {
        $this->breadcrumbService = service('breadcrumbService');
        $this->menuService = service('menuService');
        $this->categoryService = service('categoryService');
    }

    public function index(...$slugs)
    {
        helper(['menu']);

        $pager = service('pager');
        $page = (int) $this->request->getGet('page');
        $page = $page > 0 ? $page : 1;
        $per_page = 15;

        // ====== دریافت سورت ======
        $sortField = $this->request->getGet('sort_field') ?? 'published_at';
        $sortType = $this->request->getGet('sort_type') ?? 'desc';

        // اعتبارسنجی
        $allowedFields = ['published_at', 'price', 'visit_count', 'created_at'];
        $allowedTypes = ['asc', 'desc'];
        $sortField = in_array($sortField, $allowedFields) ? $sortField : 'published_at';
        $sortType = in_array($sortType, $allowedTypes) ? $sortType : 'desc';

        $menu = $this->findMenuBySlugs($slugs);

        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('دسته‌بندی یافت نشد');
        }

        $subMenus = [];
        if ($menu['level'] == 1 || $menu['level'] == 2) {
            $menu1Slug = $slugs[0] ?? null;
            $subMenus = $this->menuService->getSubMenusWithImages($menu, $menu['level'], $menu1Slug);
        }

        $menu3Ids = $this->getMenu3Ids($menu);

        // ====== دریافت فیلترها از GET ======
        $filters = [];
        $allFilterParams = $this->request->getGet();
        foreach ($allFilterParams as $key => $value) {
            if (strpos($key, 'filter_') === 0) {
                $labelId = str_replace('filter_', '', $key);
                $optionIds = array_map('intval', explode(',', $value));
                $filters[$labelId] = $optionIds;
            }
        }

        // ====== دریافت داده‌های فیلتر ======
        $filterData = $this->categoryService->getFilterData($menu3Ids);

        // ====== دریافت محصولات با فیلترها و سورت ======
        $totalProducts = $this->categoryService->countProductsWithFilters($menu3Ids, $filters);
        $products = $this->categoryService->getProductsWithFilters(
            $menu3Ids,
            $filters,
            $per_page,
            ($page - 1) * $per_page,
            $sortField,
            $sortType
        );

        $pagination = $pager->makeLinks($page, $per_page, $totalProducts, 'shop_pagination');

        $breadcrumb = $this->breadcrumbService->buildFromMenu($menu);

        $this->viewData['menu'] = $menu;
        $this->viewData['subMenus'] = $subMenus;
        $this->viewData['filterData'] = $filterData;
        $this->viewData['selectedFilters'] = $filters;
        $this->viewData['products'] = $products;
        $this->viewData['breadcrumb'] = $breadcrumb;
        $this->viewData['title'] = $menu['name'];
        $this->viewData['pagination'] = $pagination;
        $this->viewData['sortField'] = $sortField;   // ← اضافه کن
        $this->viewData['sortType'] = $sortType;     // ← اضافه کن

        if ($this->request->isAJAX()) {
            return view('category/index_content', $this->viewData);
        }

        return view('category/index', $this->viewData);
    }

    private function findMenuBySlugs(array $slugs)
    {
        $count = count($slugs);

        // سطح ۳: آخرین اسلاگ
        if ($count >= 3) {
            $menu3Model = model('App\Models\Menu3Model');
            $menu3 = $menu3Model
                ->where('slug', end($slugs))
                ->where('is_active', 1)
                ->first();
            if ($menu3) {
                $menu3['level'] = 3;
                return $menu3;
            }
        }

        // سطح ۲: آخرین اسلاگ (نه دومین از آخر!)
        if ($count >= 2) {
            $menu2Model = model('App\Models\Menu2Model');
            $menu2 = $menu2Model
                ->where('slug', end($slugs))  // ← اینجا رو اصلاح کن
                ->where('is_active', 1)
                ->first();
            if ($menu2) {
                $menu2['level'] = 2;
                return $menu2;
            }
        }

        // سطح ۱: اولین اسلاگ
        if ($count >= 1) {
            $menu1Model = model('App\Models\Menu1Model');
            $menu1 = $menu1Model
                ->where('slug', $slugs[0])
                ->where('is_active', 1)
                ->first();
            if ($menu1) {
                $menu1['level'] = 1;
                return $menu1;
            }
        }

        return null;
    }

    private function getMenu3Ids($menu)
    {
        $menu3Ids = [];

        if ($menu['level'] == 3) {
            // مستقیم منوی سطح ۳
            $menu3Ids[] = $menu['id'];

        } elseif ($menu['level'] == 2) {
            // تمام منوهای سطح ۳ زیرمجموعه این منوی سطح ۲
            $menu3Model = model('App\Models\Menu3Model');
            $children = $menu3Model
                ->where('menu_2_id', $menu['id'])
                ->where('is_active', 1)
                ->findAll();

            if (!empty($children)) {
                $menu3Ids = array_column($children, 'id');
            } else {
                // اگه زیرمجموعه نداشت، منوی هیدن رو پیدا کن یا بساز
                $hiddenMenu = $this->menuService->getOrCreateHiddenMenu3($menu['id']);
                if ($hiddenMenu) {
                    $menu3Ids[] = $hiddenMenu['id'];
                }
            }

        } elseif ($menu['level'] == 1) {
            // تمام منوهای سطح ۳ زیرمجموعه این منوی سطح ۱
            $menu2Model = model('App\Models\Menu2Model');
            $menu2Ids = $menu2Model
                ->where('menu_1_id', $menu['id'])
                ->where('is_active', 1)
                ->findColumn('id');

            if (!empty($menu2Ids)) {
                $menu3Model = model('App\Models\Menu3Model');
                $menu3List = $menu3Model
                    ->whereIn('menu_2_id', $menu2Ids)
                    ->where('is_active', 1)
                    ->findAll();
                $menu3Ids = array_column($menu3List, 'id');

                // برای منوهای سطح ۲ که زیرمجموعه ندارن، منوی هیدن رو پیدا کن
                foreach ($menu2Ids as $menu2Id) {
                    $hasMenu3 = false;
                    foreach ($menu3List as $m3) {
                        if ($m3['menu_2_id'] == $menu2Id) {
                            $hasMenu3 = true;
                            break;
                        }
                    }

                    if (!$hasMenu3) {
                        $hiddenMenu = $this->menuService->getOrCreateHiddenMenu3($menu2Id);
                        if ($hiddenMenu) {
                            $menu3Ids[] = $hiddenMenu['id'];
                        }
                    }
                }
            }
        }

        return array_unique($menu3Ids);
    }
}
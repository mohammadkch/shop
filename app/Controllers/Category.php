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

        $allowedFields = ['published_at', 'price', 'visit_count', 'created_at'];
        $allowedTypes = ['asc', 'desc'];
        $sortField = in_array($sortField, $allowedFields) ? $sortField : 'published_at';
        $sortType = in_array($sortType, $allowedTypes) ? $sortType : 'desc';

        // ====== پیدا کردن منو بر اساس اسلاگ‌ها ======
        if (empty($slugs) || (count($slugs) === 1 && empty($slugs[0]))) {
            // حالت level 0: همه محصولات
            $menu = [
                'id' => 0,
                'name' => 'همه محصولات',
                'slug' => 'all',
                'level' => 0,
                'description' => 'همه محصولات فروشگاه'
            ];
        } else {
            $menu = $this->findMenuBySlugs($slugs);
            if (!$menu) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('دسته‌بندی یافت نشد');
            }
        }

        // ====== زیرمنوها (فقط برای level 1 و 2) ======
        $subMenus = [];
        if ($menu['level'] == 0) {
            // سطح ۰ → همه منوهای سطح ۱ به عنوان ساب‌منو
            $subMenus = $this->menuService->getSubMenusWithImages($menu, 0);
        } elseif ($menu['level'] == 1 || $menu['level'] == 2) {
            $menu1Slug = $slugs[0] ?? null;
            $subMenus = $this->menuService->getSubMenusWithImages($menu, $menu['level'], $menu1Slug);
        }

        // ====== دریافت menu3Ids ======
        $menu3Ids = $this->getMenu3Ids($menu);

        // ====== دریافت فیلترها ======
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

        // ====== دریافت محصولات ======
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
        $this->viewData['sortField'] = $sortField;
        $this->viewData['sortType'] = $sortType;

        if ($this->request->isAJAX()) {
            return view('category/index_content', $this->viewData);
        }

        return view('category/index', $this->viewData);
    }

    private function findMenuBySlugs(array $slugs)
    {

        // اگر هیچ اسلاگی وجود نداشت → سطح صفر
        if (empty($slugs)) {
            return ['level' => 0, 'id' => 0, 'name' => 'همه محصولات', 'slug' => ''];
        }

        if (count($slugs) > 3) {
            return null;
        }

        $menu1 = model('App\Models\Menu1Model')
            ->where('slug', $slugs[0])
            ->where('is_active', 1)
            ->first();
        if (!$menu1) {
            return null;
        }

        $menu1['level'] = 1;
        if (count($slugs) === 1) {
            return $menu1;
        }

        $menu2 = model('App\Models\Menu2Model')
            ->where('menu_1_id', $menu1['id'])
            ->where('slug', $slugs[1])
            ->where('is_active', 1)
            ->where('is_visible', 1)
            ->first();
        if (!$menu2) {
            return null;
        }

        $menu2['level'] = 2;
        if (count($slugs) === 2) {
            return $menu2;
        }

        $menu3 = model('App\Models\Menu3Model')
            ->where('menu_2_id', $menu2['id'])
            ->where('slug', $slugs[2])
            ->where('is_active', 1)
            ->where('is_visible', 1)
            ->first();
        if ($menu3) {
            $menu3['level'] = 3;
            return $menu3;
        }

        return null;
    }

    private function getMenu3Ids($menu)
    {
        $menu3Ids = [];

        if ($menu['level'] == 0) {
            // سطح ۰ → همه menu_3 های فعال
            $menu3Model = model('App\Models\Menu3Model');
            $allMenu3 = $menu3Model->where('is_active', 1)->findAll();
            $menu3Ids = array_column($allMenu3, 'id');
            return array_unique($menu3Ids);
        } elseif ($menu['level'] == 3) {
            $menu3Ids[] = $menu['id'];

        } elseif ($menu['level'] == 2) {
            $menu3Model = model('App\Models\Menu3Model');
            $children = $menu3Model
                ->where('menu_2_id', $menu['id'])
                ->where('is_active', 1)
                ->findAll();

            $menu3Ids = array_column($children, 'id');

        } elseif ($menu['level'] == 1) {
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

            }
        }

        return array_unique($menu3Ids);
    }
}

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
        helper(['menu', 'blog_content']);

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

        $isAllProductsPage = empty($slugs) || (count($slugs) === 1 && empty($slugs[0]));
        $allProductsPage = null;
        $contentBlocks = [];

        // ====== صفحه مستقل همه محصولات یا منوی واقعی ======
        if ($isAllProductsPage) {
            $allProductsPage = model('App\Models\AllProductsPageModel')->find(1);
            if (!$allProductsPage) {
                throw new \RuntimeException('تنظیمات صفحه همه محصولات پیدا نشد.');
            }
            $menu = null;
            if (!$this->request->isAJAX()) {
                $contentBlocks = model('App\Models\AllProductsPageBlockModel')
                    ->where('all_products_page_id', $allProductsPage['id'])
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
                foreach ($contentBlocks as &$block) {
                    if (!empty($block['content'])) {
                        $block['content'] = sanitizeBlogHtml($block['content']);
                    }
                }
                unset($block);
            }
        } else {
            $menu = $this->findMenuBySlugs($slugs);
            if (!$menu) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('دسته‌بندی یافت نشد');
            }
        }

        // ====== زیرمنوها (فقط برای level 1 و 2) ======
        $subMenus = [];
        if ($isAllProductsPage) {
            $subMenus = $this->menuService->getSubMenusWithImages(null, 0);
        } elseif ($menu['level'] == 1 || $menu['level'] == 2) {
            $menu1Slug = $slugs[0] ?? null;
            $subMenus = $this->menuService->getSubMenusWithImages($menu, $menu['level'], $menu1Slug);
        }

        // ====== دریافت menu3Ids ======
        $menu3Ids = $this->getMenu3Ids($menu, $isAllProductsPage);

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
        $breadcrumb = $isAllProductsPage
            ? $this->breadcrumbService->buildAllProducts($allProductsPage['h1_title'])
            : $this->breadcrumbService->buildFromMenu($menu);

        $pageHeading = $isAllProductsPage ? $allProductsPage['h1_title'] : $menu['name'];

        $this->viewData['menu'] = $menu;
        $this->viewData['isAllProductsPage'] = $isAllProductsPage;
        $this->viewData['allProductsPage'] = $allProductsPage;
        $this->viewData['contentBlocks'] = $contentBlocks;
        $this->viewData['pageHeading'] = $pageHeading;
        $this->viewData['subMenus'] = $subMenus;
        $this->viewData['filterData'] = $filterData;
        $this->viewData['selectedFilters'] = $filters;
        $this->viewData['products'] = $products;
        $this->viewData['breadcrumb'] = $breadcrumb;
        $this->viewData['title'] = $isAllProductsPage
            ? (!empty($allProductsPage['meta_title']) ? $allProductsPage['meta_title'] : $pageHeading . ' | فروشگاه مومو')
            : (($menu['level'] === 1 && !empty($menu['meta_title'])) ? $menu['meta_title'] : $menu['name']);
        if ($isAllProductsPage) {
            $this->viewData['metaDescription'] = $allProductsPage['meta_description']
                ?: 'مشاهده و خرید همه محصولات فروشگاه مومو با امکان فیلتر و مرتب‌سازی.';
            $this->viewData['canonicalUrl'] = site_url('category');
        } elseif ($menu['level'] === 1) {
            $this->viewData['metaDescription'] = $menu['meta_description']
                ?: ($menu['description'] ?: 'مشاهده و خرید محصولات دسته‌بندی ' . $menu['name'] . ' از فروشگاه مومو.');
        }
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

    private function getMenu3Ids(?array $menu, bool $isAllProductsPage = false)
    {
        $menu3Ids = [];

        if ($isAllProductsPage) {
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

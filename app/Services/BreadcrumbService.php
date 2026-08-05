<?php

namespace App\Services;

class BreadcrumbService
{
    public function buildAllProducts(string $title): array
    {
        return [[
            'name' => $title,
            'full_slug' => null,
            'is_last' => true,
        ]];
    }

    /**
     * ساخت breadcrumb از روی منو (برای صفحه کتگوری)
     */
    public function buildFromMenu($menu)
    {
        $breadcrumb = [];

        $menu1 = null;
        $menu2 = null;

        if ($menu['level'] == 3) {
            // ====== سطح ۳ ======
            $menu2Model = model('App\Models\Menu2Model');
            $menu2 = $menu2Model->find($menu['menu_2_id']);

            if ($menu2) {
                $menu1Model = model('App\Models\Menu1Model');
                $menu1 = $menu1Model->find($menu2['menu_1_id']);
            }

            // منوی سطح ۱ (اگه وجود داشت)
            if ($menu1) {
                $breadcrumb[] = [
                    'name' => $menu1['name'],
                    'full_slug' => $menu1['slug'],
                    'is_last' => false
                ];
            }

            // منوی سطح ۲ (اگه قابل نمایش بود)
            if ($menu2 && (int) ($menu2['is_visible'] ?? 1) === 1) {
                $slug2 = $menu1 ? $menu1['slug'] . '/' . $menu2['slug'] : $menu2['slug'];
                $breadcrumb[] = [
                    'name' => $menu2['name'],
                    'full_slug' => $slug2,
                    'is_last' => false
                ];
            }

            // منوی سطح ۳ (خودش)
            $slug3 = '';
            if ($menu1 && $menu2) {
                $slug3 = $menu1['slug'] . '/' . $menu2['slug'] . '/' . $menu['slug'];
            } elseif ($menu2) {
                $slug3 = $menu2['slug'] . '/' . $menu['slug'];
            } else {
                $slug3 = $menu['slug'];
            }

            if ((int) ($menu['is_visible'] ?? 1) === 1) {
                $breadcrumb[] = [
                    'name' => $menu['name'],
                    'full_slug' => $slug3,
                    'is_last' => true
                ];
            }

        } elseif ($menu['level'] == 2) {
            // ====== سطح ۲ ======
            $menu1Model = model('App\Models\Menu1Model');
            $menu1 = $menu1Model->find($menu['menu_1_id']);

            if ($menu1) {
                $breadcrumb[] = [
                    'name' => $menu1['name'],
                    'full_slug' => $menu1['slug'],
                    'is_last' => false
                ];
            }

            if ((int) ($menu['is_visible'] ?? 1) === 1) {
                $slug2 = $menu1 ? $menu1['slug'] . '/' . $menu['slug'] : $menu['slug'];
                $breadcrumb[] = [
                    'name' => $menu['name'],
                    'full_slug' => $slug2,
                    'is_last' => true
                ];
            }

        } elseif ($menu['level'] == 1) {
            // ====== سطح ۱ ======
            $breadcrumb[] = [
                'name' => $menu['name'],
                'full_slug' => $menu['slug'],
                'is_last' => true
            ];
        }

        if (!empty($breadcrumb)) {
            foreach ($breadcrumb as &$item) {
                $item['is_last'] = false;
            }
            unset($item);
            $breadcrumb[array_key_last($breadcrumb)]['is_last'] = true;
        }

        return $breadcrumb;
    }

    /**
     * ساخت breadcrumb از روی محصول (برای صفحه محصول)
     */
    public function buildFromProduct($product)
    {
        $breadcrumb = [];

        if (!empty($product['category']) && isset($product['category']['id'])) {
            $category = $product['category'];

            // منوی سطح ۱
            if (!empty($category['menu_1_name']) && !empty($category['menu_1_slug'])) {
                $breadcrumb[] = [
                    'name' => $category['menu_1_name'],
                    'full_slug' => $category['menu_1_slug'],
                    'is_last' => false
                ];
            }

            // منوی سطح ۲
            if (!empty($category['menu_2_name']) &&
                !empty($category['menu_2_slug']) &&
                (int) ($category['menu_2_is_visible'] ?? 1) === 1) {
                $slug2 = $category['menu_1_slug'] . '/' . $category['menu_2_slug'];
                $breadcrumb[] = [
                    'name' => $category['menu_2_name'],
                    'full_slug' => $slug2,
                    'is_last' => false
                ];
            }

            // منوی سطح ۳ (فقط اگه فعال باشه)
            if (!empty($category['name']) && !empty($category['slug'])) {
                $menu3Model = model('App\Models\Menu3Model');
                $menu3 = $menu3Model->find($category['id']);

                if ($menu3 && $menu3['is_active'] == 1 && (int) ($menu3['is_visible'] ?? 1) === 1) {
                    $slug3 = $category['menu_1_slug'] . '/' . $category['menu_2_slug'] . '/' . $category['slug'];
                    $breadcrumb[] = [
                        'name' => $category['name'],
                        'full_slug' => $slug3,
                        'is_last' => false
                    ];
                }
            }
        }

        // خود محصول
        $breadcrumb[] = [
            'name' => $product['name'],
            'full_slug' => null,
            'is_last' => true
        ];

        return $breadcrumb;
    }
}

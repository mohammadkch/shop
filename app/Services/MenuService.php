<?php

namespace App\Services;

use App\Models\Menu1ImageModel;
use App\Models\Menu1Model;
use App\Models\Menu2Model;
use App\Models\Menu3Model;
use Config\Database;

class MenuService
{
    protected $db;
    protected $menu1Model;
    protected $menu2Model;
    protected $menu3Model;
    protected $menu1ImageModel;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->menu1Model = new Menu1Model();
        $this->menu2Model = new Menu2Model();
        $this->menu3Model = new Menu3Model();
        $this->menu1ImageModel = new Menu1ImageModel();
    }

    public function getShopMenus()
    {
        $menu1List = $this->menu1Model->getData(['is_active' => 1]);
        $images = $this->menu1ImageModel->getData(['is_active' => 1]);
        $imageMap = [];
        foreach ($images as $img) {
            $imageMap[$img['menu_1_id']] = $img;
        }

        $menu2List = $this->menu2Model->getData(['is_active' => 1]);
        $menu2ByMenu1 = [];
        foreach ($menu2List as $menu2) {
            $menu2ByMenu1[$menu2['menu_1_id']][] = $menu2;
        }

        $menu3List = $this->menu3Model->getData(['is_active' => 1]);
        $menu3ByMenu2 = [];
        foreach ($menu3List as $menu3) {
            $menu3ByMenu2[$menu3['menu_2_id']][] = $menu3;
        }

        $menus = [];
        foreach ($menu1List as $menu1) {
            $menu1Id = $menu1['id'];
            $menu1Slug = $menu1['slug'];  // ← ذخیره کن

            $menuItem = [
                'id' => $menu1Id,
                'name' => $menu1['name'],
                'slug' => $menu1['slug'],
                'image' => $imageMap[$menu1Id] ?? null,
                'children' => []
            ];

            if (isset($menu2ByMenu1[$menu1Id])) {
                foreach ($menu2ByMenu1[$menu1Id] as $menu2) {
                    $menu2Id = $menu2['id'];
                    $menu2Slug = $menu2['slug'];  // ← ذخیره کن

                    $subMenuItem = [
                        'id' => $menu2Id,
                        'name' => $menu2['name'],
                        'slug' => $menu2['slug'],
                        'menu_1_id' => $menu1Id,
                        'menu_1_slug' => $menu1Slug,  // ← اضافه کن
                        'children' => []
                    ];

                    if (isset($menu3ByMenu2[$menu2Id])) {
                        foreach ($menu3ByMenu2[$menu2Id] as $menu3) {
                            $subMenuItem['children'][] = [
                                'id' => $menu3['id'],
                                'name' => $menu3['name'],
                                'slug' => $menu3['slug'],
                                'menu_2_id' => $menu2Id,
                                'menu_2_slug' => $menu2Slug,  // ← اضافه کن
                                'menu_1_slug' => $menu1Slug   // ← اضافه کن
                            ];
                        }
                    }

                    $menuItem['children'][] = $subMenuItem;
                }
            }

            $menus[] = $menuItem;
        }

        return $menus;
    }

    public function getOrCreateHiddenMenu3($menu2Id)
    {
        $menu3Model = new \App\Models\Menu3Model();

        // اول ببین منوی هیدن وجود داره یا نه
        $hiddenMenu = $menu3Model
            ->where('menu_2_id', $menu2Id)
            ->where('is_active', 0)
            ->first();

        if ($hiddenMenu) {
            return $hiddenMenu;
        }

        // منوی هیدن رو بساز
        $menu2Model = new \App\Models\Menu2Model();
        $menu2 = $menu2Model->find($menu2Id);

        if (!$menu2) {
            return null;
        }

        $slug = 'all-' . $menu2['slug'] . '-' . $menu2Id;

        $menu3Id = $menu3Model->insert([
            'menu_2_id' => $menu2Id,
            'name' => 'همه محصولات ' . $menu2['name'],
            'slug' => $slug,
            'is_active' => 0,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        return $menu3Model->find($menu3Id);
    }

    public function getSubMenusWithImages($menu, $level, $menu1Slug = null)
    {
        $db = \Config\Database::connect();
        $result = [];

        if ($level == 1) {
            $subMenus = $db->table('menu_2')
                ->where('menu_1_id', $menu['id'])
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->get()
                ->getResultArray();

            foreach ($subMenus as &$sub) {
                $image = $db->table('menu_2_image')
                    ->where('menu_2_id', $sub['id'])
                    ->where('menu_2_image_type_id', 2)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->get()
                    ->getResultArray();
                $sub['image'] = !empty($image) ? $image[0] : null;
                // برای سطح ۱، path = menu_slug/sub_slug
                $sub['path'] = $menu['slug'] . '/' . $sub['slug'];
            }
            $result = $subMenus;

        } elseif ($level == 2) {
            $subMenus = $db->table('menu_3')
                ->where('menu_2_id', $menu['id'])
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->get()
                ->getResultArray();

            foreach ($subMenus as &$sub) {
                $image = $db->table('menu_3_image')
                    ->where('menu_3_id', $sub['id'])
                    ->where('menu_3_image_type_id', 2)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->get()
                    ->getResultArray();
                $sub['image'] = !empty($image) ? $image[0] : null;
                // برای سطح ۲، path = menu1_slug/menu_slug/sub_slug
                $sub['path'] = $menu1Slug . '/' . $menu['slug'] . '/' . $sub['slug'];
            }
            $result = $subMenus;
        }

        return $result;
    }
}
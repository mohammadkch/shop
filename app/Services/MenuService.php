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
        // دریافت منوهای سطح 1 فعال
        $menu1List = $this->menu1Model->getData(['is_active' => 1]);

        // دریافت عکس‌های منوهای سطح 1
        $images = $this->menu1ImageModel->getData(['is_active' => 1]);
        $imageMap = [];
        foreach ($images as $img) {
            $imageMap[$img['menu_1_id']] = $img;
        }

        // دریافت منوهای سطح 2 فعال
        $menu2List = $this->menu2Model->getData(['is_active' => 1]);
        $menu2ByMenu1 = [];
        foreach ($menu2List as $menu2) {
            $menu2ByMenu1[$menu2['menu_1_id']][] = $menu2;
        }

        // دریافت منوهای سطح 3 فعال
        $menu3List = $this->menu3Model->getData(['is_active' => 1]);
        $menu3ByMenu2 = [];
        foreach ($menu3List as $menu3) {
            $menu3ByMenu2[$menu3['menu_2_id']][] = $menu3;
        }

        // ساخت ساختار نهایی
        $menus = [];
        foreach ($menu1List as $menu1) {
            $menu1Id = $menu1['id'];

            $menuItem = [
                'id' => $menu1Id,
                'name' => $menu1['name'],
                'slug' => $menu1['slug'],
                'image' => $imageMap[$menu1Id] ?? null,
                'children' => []
            ];

            // اضافه کردن منوهای سطح 2
            if (isset($menu2ByMenu1[$menu1Id])) {
                foreach ($menu2ByMenu1[$menu1Id] as $menu2) {
                    $menu2Id = $menu2['id'];

                    $subMenuItem = [
                        'id' => $menu2Id,
                        'name' => $menu2['name'],
                        'slug' => $menu2['slug'],
                        'menu_1_id' => $menu1Id,
                        'children' => []
                    ];

                    // اضافه کردن منوهای سطح 3
                    if (isset($menu3ByMenu2[$menu2Id])) {
                        foreach ($menu3ByMenu2[$menu2Id] as $menu3) {
                            $subMenuItem['children'][] = [
                                'id' => $menu3['id'],
                                'name' => $menu3['name'],
                                'slug' => $menu3['slug'],
                                'menu_2_id' => $menu2Id
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
}
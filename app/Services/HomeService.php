<?php

namespace App\Services;

use App\Models\HomeStoryModel;
use App\Models\HomeSliderModel;
use App\Models\HomeSelectedCategoryModel;
use App\Models\Menu1ImageModel;

class HomeService
{
    protected $homeStoryModel;
    protected $homeSliderModel;
    protected $homeSelectedCategoryModel;
    protected $menu1ImageModel;

    public function __construct()
    {
        $this->homeStoryModel = new HomeStoryModel();
        $this->homeSliderModel = new HomeSliderModel();
        $this->homeSelectedCategoryModel = new HomeSelectedCategoryModel();
        $this->menu1ImageModel = new Menu1ImageModel();
    }

    /**
     * دریافت استوری‌های فعال
     */
    public function getStories($mediaPath)
    {
        $stories = $this->homeStoryModel->getData(['is_active' => 1]);

        return array_map(function ($item) use ($mediaPath) {
            return [
                'type'     => $item['type'],
                'user'     => $item['title'],
                'avatar'   => $mediaPath . $item['avatar'],
                'url'      => $mediaPath . $item['url'],
                'duration' => $item['duration'] !== null ? (int) $item['duration'] : null,
                'link'     => $item['link'],
            ];
        }, $stories);
    }

    /**
     * دریافت اسلایدرهای فعال
     */
    public function getSliders($mediaPath)
    {
        $sliders = $this->homeSliderModel->getData(['is_active' => 1]);

        return array_map(function ($item) use ($mediaPath) {
            return [
                'title' => $item['title'],
//                'image' => $assetsPath . 'images/' . $item['image'],
                'image' => $mediaPath . $item['image'],
                'link'  => $item['link'] ?? '#',
            ];
        }, $sliders);
    }
    public function getSelectedCategories($mediaPath)
    {
        $selected = $this->homeSelectedCategoryModel->getSelectedMenus();

        $result = [];
        foreach ($selected as $item) {
            // ====== تشخیص سطح بر اساس اولویت ======
            if (!empty($item['menu_3_id'])) {
                // سطح ۳
                $menuId = $item['menu_3_id'];
                $menuName = $item['menu_3_name'];
                $menuSlug = $item['menu_3_slug'];
                $imageName = $item['menu_3_image_name'] ?? null;
                $link = site_url('category/' . $item['menu_1_slug'] . '/' . $item['menu_2_slug'] . '/' . $menuSlug);

            } elseif (!empty($item['menu_2_id'])) {
                // سطح ۲
                $menuId = $item['menu_2_id'];
                $menuName = $item['menu_2_name'];
                $menuSlug = $item['menu_2_slug'];
                $imageName = $item['menu_2_image_name'] ?? null;
                $link = site_url('category/' . $item['menu_1_slug'] . '/' . $menuSlug);

            } else {
                // سطح ۱
                $menuId = $item['menu_1_id'];
                $menuName = $item['menu_1_name'];
                $menuSlug = $item['menu_1_slug'];
                $imageName = $item['menu_1_image_name'] ?? null;
                $link = site_url('category/' . $menuSlug);
            }

            $result[] = [
                'id'    => $menuId,
                'name'  => $menuName,
                'slug'  => $menuSlug,
                'image' => $imageName ? $mediaPath . 'menus/' . $imageName : null,
                'link'  => $link,
            ];
        }

        return $result;
    }

    /**
     * دریافت تمام دیتاهای صفحه اصلی
     */
    public function getHomeData($mediaPath)
    {
        return [
            'stories'    => $this->getStories($mediaPath),
            'sliders'    => $this->getSliders($mediaPath),
            'categories' => $this->getSelectedCategories($mediaPath),
        ];
    }
}
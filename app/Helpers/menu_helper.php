<?php

function renderShopMegaMenu($shopMenus, $assetsPath)
{
    if (empty($shopMenus)) {
        return '';
    }

    $html = '<li id="mega-menu-fire" class="block border-e-2 pe-3 border-e-gray-300">
                <a href="javascript:void(0)" class="flex relative font-bold hover:text-primary transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 me-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    فروشگاه
                    <!-- <span class="absolute end-0 block">-->
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </span>
                </a>
                <div id="mega-menu-fire-target" class="bg-white dark:bg-custom-dark dark:border dark:border-gray-700 container z-50 hidden top-[92%] drop-shadow-sm dark:shadow-[0_2px_6px_rgba(0,0,0,0.4)] absolute mt-1 me-10 rounded-b-md transition-colors duration-300">
                    <div class="grid grid-cols-12">
                        <div class="col-span-2 h-[400px] overflow-y-scroll border-e border-gray-400">
                            <ul class="my-2 space-y-1">';

    // رندر منوهای سطح 1 (سمت راست مگامنو) - با لینک
    foreach ($shopMenus as $index => $menu) {
        $menuId = $menu['id'];
        $activeClass = $index === 0 ? 'bg-gray-200 dark:bg-[#1f242c]' : '';
        $html .= '<li data-mega-id="' . $menuId . '" class="px-4 w-full rounded-lg border-opacity-0 hover:border-opacity-100 mega-menu-li dark:bg-custom-dark hover:bg-gray-200 dark:hover:bg-[#1f242c] text-gray-800 dark:text-gray-200 transition-colors duration-200 ' . $activeClass . '">
                    <a href="' . site_url('category/' . $menu['slug']) . '" class="flex items-center justify-between py-3">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8l4-2 4 2V6z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ms-1">
                                <p class="text-xs">' . htmlspecialchars($menu['name']) . '</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                </li>';
    }

    $html .= '</ul>
                        </div> <!-- col-span-2 ends -->
                        <div class="col-span-10 bg-white dark:bg-zinc-900">';

    // رندر محتوای هر منو (سطح 2 و 3)
    foreach ($shopMenus as $index => $menu) {
        $displayClass = $index === 0 ? '' : 'hidden';
        $html .= '<div data-mega-target="' . $menu['id'] . '" class="grid ' . $displayClass . ' h-[400px] overflow-y-scroll grid-cols-8 gap-10 m-3">';

        $maxItemsPerColumn = 14;
        $columns = [];
        $currentColumn = [];
        $currentColumnItemCount = 0;

        foreach ($menu['children'] as $menu2) {
            $itemCount = 1 + count($menu2['children']);

            if ($itemCount > $maxItemsPerColumn) {
                if (!empty($currentColumn)) {
                    $columns[] = $currentColumn;
                    $currentColumn = [];
                    $currentColumnItemCount = 0;
                }
                $columns[] = [$menu2];
                continue;
            }

            if ($currentColumnItemCount + $itemCount > $maxItemsPerColumn) {
                $columns[] = $currentColumn;
                $currentColumn = [$menu2];
                $currentColumnItemCount = $itemCount;
            } else {
                $currentColumn[] = $menu2;
                $currentColumnItemCount += $itemCount;
            }
        }

        if (!empty($currentColumn)) {
            $columns[] = $currentColumn;
        }

        // رندر ستون‌ها
        foreach ($columns as $columnItems) {
            $html .= '<div class="col-span-2">';
            foreach ($columnItems as $menu2) {
                // ====== منوی سطح ۲ با لینک ======
                $menu2Link = site_url('category/' . $menu2['menu_1_slug'] . '/' . $menu2['slug']);
                $html .= '<div class="mb-4">
                            <a href="' . $menu2Link . '" class="text-sm font-bold hover:text-primary transition block">
                                ' . htmlspecialchars($menu2['name']) . '
                            </a>
                            <div class="mt-3 space-y-4">';

                // منوهای سطح 3 با لینک کامل
                if (!empty($menu2['children'])) {
                    foreach ($menu2['children'] as $menu3) {
                        $fullSlug = $menu3['menu_1_slug'] . '/' . $menu3['menu_2_slug'] . '/' . $menu3['slug'];
                        $html .= '<a href="' . site_url('category/' . $fullSlug) . '" class="text-xs text-gray-600 block hover:text-primary dark:text-gray-300">' . htmlspecialchars($menu3['name']) . '</a>';
                    }
                }

                $html .= '</div>
                        </div>';
            }
            $html .= '</div>';
        }

        // ستون آخر برای بنر
        $html .= '<div class="col-span-2">
                    <div class="me-4">';
        if (!empty($menu['image']) && !empty($menu['image']['image_name'])) {
            $imagePath = base_url() . 'images/banners/' . $menu['image']['image_name'];
            $html .= '<a href="' . site_url('category/' . $menu['slug']) . '">
                        <img src="' . $imagePath . '" loading="lazy" alt="' . htmlspecialchars($menu['image']['alt'] ?? $menu['name']) . '" class="w-full rounded-lg">
                      </a>';
        } else {
            $html .= '<a href="' . site_url('category/' . $menu['slug']) . '">
                        <img src="' . $assetsPath . 'images/banner/banner-placeholder.jpg" loading="lazy" alt="' . htmlspecialchars($menu['name']) . '" class="w-full rounded-lg">
                      </a>';
        }
        $html .= '</div>
                </div>';

        $html .= '</div>';
    }

    $html .= '</div>
                    </div>
                </div>
            </li>';

    return $html;
}
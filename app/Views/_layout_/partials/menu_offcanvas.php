<!-- RESPONSIVE MENU -->
<div id="offcanvas-right"
     class="offcanvas invisible overflow-y-scroll fixed top-0 start-0 sm:w-100 w-[80%] h-full bg-white dark:bg-[#0d1117] text-gray-900 dark:text-gray-100 border-e border-gray-200 dark:border-gray-800 shadow-xl dark:shadow-[0_0_20px_rgba(0,0,0,0.6)] transform -translate-x-full transition-all duration-300 opacity-0 z-50"
     role="navigation" aria-labelledby="store-menu-title" aria-modal="true">

    <!-- header -->
    <div class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center justify-between">
        <h2 id="store-menu-title" class="font-bold text-base">فروشگاه دیارا</h2>
        <button onclick="closeOffcanvas()" class="cursor-pointer" aria-label="بستن منوی فروشگاه">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor"
                 class="size-8 text-gray-700 dark:text-gray-300 hover:text-primary-500 transition-colors">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- navigation -->
    <nav class="p-3" aria-label="منوی اصلی">
        <ul class="space-y-2 text-sm">

            <!-- صفحه اصلی -->
            <li class="bg-gray-50 dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#1f242c] p-3 transition-colors duration-200">
                <a href="<?= site_url('/') ?>" class="block">صفحه اصلی</a>
            </li>

            <!-- فروشگاه -->
            <li class="bg-gray-50 dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-100 transition-colors duration-200">
                <button onclick="toggleMobileMenu('mobile-shop')"
                        class="flex justify-between w-full text-start items-center p-3">
                    <span class="font-bold">فروشگاه</span>
                    <svg xmlns="http://www.w3.org/2000/svg" id="icon-mobile-shop"
                         class="h-5 w-5 transition-transform duration-200 text-gray-600 dark:text-gray-300"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <!-- لایه 1: منوهای اصلی -->
                <ul id="mobile-shop" class="hidden border-t border-gray-200 dark:border-gray-700">
                    <?php if (!empty($shopMenus)): ?>
                        <?php foreach ($shopMenus as $menu1): ?>
                            <li class="border-b border-gray-100 dark:border-gray-800 last:border-0">

                                <?php if (!empty($menu1['children'])): ?>
                                    <!-- لایه 1 با زیرمنو -->
                                    <button onclick="toggleMobileMenu('mobile-m1-<?= $menu1['id'] ?>')"
                                            class="flex justify-between w-full text-start items-center px-4 py-3 hover:bg-gray-100 dark:hover:bg-[#1f242c] transition-colors">
                                        <a href="<?= site_url('category/' . $menu1['slug']) ?>"
                                           class="flex-1 text-start"
                                           onclick="event.stopPropagation()">
                                            <?= htmlspecialchars($menu1['name']) ?>
                                        </a>
                                        <svg xmlns="http://www.w3.org/2000/svg" id="icon-mobile-m1-<?= $menu1['id'] ?>"
                                             class="h-4 w-4 transition-transform duration-200 text-gray-500 dark:text-gray-400 flex-shrink-0"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>

                                    <!-- لایه 2 -->
                                    <ul id="mobile-m1-<?= $menu1['id'] ?>" class="hidden bg-gray-50 dark:bg-[#0d1117]">
                                        <?php foreach ($menu1['children'] as $menu2): ?>
                                            <li class="border-b border-gray-100 dark:border-gray-800 last:border-0">

                                                <?php if (!empty($menu2['children'])): ?>
                                                    <!-- لایه 2 با زیرمنو -->
                                                    <button onclick="toggleMobileMenu('mobile-m2-<?= $menu2['id'] ?>')"
                                                            class="flex justify-between w-full text-start items-center px-6 py-2 hover:bg-gray-100 dark:hover:bg-[#1f242c] transition-colors">
                                                        <a href="<?= site_url('category/' . $menu1['slug'] . '/' . $menu2['slug']) ?>"
                                                           class="flex-1 text-start text-gray-700 dark:text-gray-300"
                                                           onclick="event.stopPropagation()">
                                                            <?= htmlspecialchars($menu2['name']) ?>
                                                        </a>
                                                        <svg xmlns="http://www.w3.org/2000/svg" id="icon-mobile-m2-<?= $menu2['id'] ?>"
                                                             class="h-4 w-4 transition-transform duration-200 text-gray-500 dark:text-gray-400 flex-shrink-0"
                                                             viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>

                                                    <!-- لایه 3 -->
                                                    <ul id="mobile-m2-<?= $menu2['id'] ?>" class="hidden bg-white dark:bg-zinc-900">
                                                        <?php foreach ($menu2['children'] as $menu3): ?>
                                                            <li class="border-b border-gray-100 dark:border-gray-800 last:border-0">
                                                                <a href="<?= site_url('category/' . $menu1['slug'] . '/' . $menu2['slug'] . '/' . $menu3['slug']) ?>"
                                                                   class="block px-8 py-2 text-xs text-gray-600 dark:text-gray-400 hover:text-primary hover:bg-gray-50 dark:hover:bg-[#1f242c] transition-colors">
                                                                    <?= htmlspecialchars($menu3['name']) ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>

                                                <?php else: ?>
                                                    <!-- لایه 2 بدون زیرمنو -->
                                                    <a href="<?= site_url('category/' . $menu1['slug'] . '/' . $menu2['slug']) ?>"
                                                       class="block px-6 py-2 text-gray-700 dark:text-gray-300 hover:text-primary hover:bg-gray-100 dark:hover:bg-[#1f242c] transition-colors">
                                                        <?= htmlspecialchars($menu2['name']) ?>
                                                    </a>
                                                <?php endif; ?>

                                            </li>
                                        <?php endforeach; ?>
                                    </ul>

                                <?php else: ?>
                                    <!-- لایه 1 بدون زیرمنو -->
                                    <a href="<?= site_url('category/' . $menu1['slug']) ?>"
                                       class="block px-4 py-3 hover:text-primary hover:bg-gray-100 dark:hover:bg-[#1f242c] transition-colors">
                                        <?= htmlspecialchars($menu1['name']) ?>
                                    </a>
                                <?php endif; ?>

                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </li>

            <!-- درباره ما -->
            <li class="bg-gray-50 dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#1f242c] p-3 transition-colors duration-200">
                <a href="<?= site_url('about') ?>" class="block">درباره ما</a>
            </li>

            <!-- بلاگ -->
            <li class="bg-gray-50 dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#1f242c] p-3 transition-colors duration-200">
                <a href="#" class="block">بلاگ</a>
            </li>

            <!-- تماس با ما -->
            <li class="bg-gray-50 dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#1f242c] p-3 transition-colors duration-200">
                <a href="<?= site_url('contact') ?>" class="block">تماس با ما</a>
            </li>

        </ul>
    </nav>
</div>
<!-- END RESPONSIVE MENU -->

<script>
    function toggleMobileMenu(id) {
        var el = document.getElementById(id);
        var icon = document.getElementById('icon-' + id);
        if (!el) return;

        var isHidden = el.classList.contains('hidden');
        el.classList.toggle('hidden', !isHidden);
        if (icon) icon.classList.toggle('rotate-180', isHidden);
    }
</script>
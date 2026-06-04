<!-- HEADER -->
<header id="topHeader"
        class="py-3 bg-white dark:bg-custom-dark border-b border-gray-200 dark:border-gray-700 shadow-md dark:shadow-none sticky top-0 start-0 end-0 z-20 transition-colors duration-300">

    <div class="container">
        <div class="grid place-items-center gap-3 grid-cols-12">

            <!-- logo - در موبایل 6 ستون، در دسکتاپ 2 ستون -->
            <div class="lg:col-span-2 lg:order-1 col-span-6 w-full">
                <a href="<?= site_url('admin/dashboard') ?>">
                    <div class="xl:text-start text-start flex items-center xl:justify-start justify-start">
                        <img class="h-12 dark:invert" src="<?= $assetsPath ?>images/logo.png" loading="lazy" alt="">
                    </div>
                </a>
            </div>

            <!-- search - فقط دسکتاپ -->
            <div class="lg:col-span-6 lg:block lg:order-2 hidden w-full">
                <div class="flex items-center w-full justify-between">
                    <div class="flex w-full items-center">
                        <div class="relative flex items-center w-full">
                            <input type="text" id="searchInput"
                                   class="w-full appearance-none rounded-xl border border-gray-300 dark:border-gray-700 py-3 ps-4 pe-10 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-custom-dark text-gray-900 dark:text-gray-100 transition-colors duration-300"
                                   placeholder="جستجوی محصولات ...."/>
                            <button class="p-2 rounded-3xl absolute end-1 hover:opacity-90 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                </svg>
                            </button>
                            <div id="searchResults" class="absolute top-13 end-0 start-0 z-10 bg-white dark:bg-custom-dark border border-gray-300 dark:border-gray-700 rounded-xl shadow-lg dark:shadow-[0_4px_12px_rgba(0,0,0,0.4)] overflow-hidden transition-colors duration-300 hidden"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- تاریخ + خروج -->
            <div class="lg:col-span-4 col-span-6 order-3 w-full">
                <div class="flex items-center justify-end gap-2">

                    <!-- تاریخ شمسی - دو باکس جدا -->
                    <?php helper('jalali'); ?>
                    <div class="flex items-center gap-2">
                        <div class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1.5 text-gray-700 dark:text-gray-300 text-sm font-medium bg-gray-50 dark:bg-gray-800">
                            <i class="ri-calendar-2-line text-base ml-1"></i>
                            <span><?= jdate('j F Y') ?></span>
                        </div>
                        <div class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1.5 text-gray-700 dark:text-gray-300 text-sm font-medium bg-gray-50 dark:bg-gray-800">
                            <i class="ri-time-line text-base ml-1"></i>
                            <span><?= jdate('H:i') ?></span>
                        </div>
                    </div>

                    <!-- Divider - فقط در دسکتاپ -->
                    <div class="hidden md:inline-block mx-4 h-6 w-px self-center bg-gray-300 dark:bg-gray-600"></div>

                    <!-- دکمه خروج - فقط در دسکتاپ -->
                    <a href="<?= site_url('admin/logout') ?>"
                       class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition-colors duration-200 flex items-center gap-2 text-sm font-medium hidden md:flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        <span>خروج</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END HEADER -->
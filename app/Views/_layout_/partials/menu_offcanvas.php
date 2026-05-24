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
    <nav style="padding-left: 12px" class="relative space-y-3 divide-y divide-gray-100 dark:divide-gray-800 p-3 overflow-y-scroll h-full"
         style="padding-left: 0!important;" aria-label="منوی اصلی">
        <ul class="space-y-2 text-sm">

            <!-- item -->
            <li
                class="bg-gray-50 dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#1f242c] p-2 transition-colors duration-200">
                <a href="/" class="block">صفحه اصلی</a>
            </li>

            <!-- dropdown -->
            <li
                class="bg-gray-50 dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#1f242c] p-2 transition-colors duration-200">

                <button class="flex justify-between w-full text-start items-center" aria-expanded="false"
                        aria-controls="menu1" id="menu1-button" onclick="toggleDropdown('menu1')">
                    <span>گوشی موبایل</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 transition-transform transform text-gray-600 dark:text-gray-300"
                         id="icon-menu1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>

                <ul id="menu1"
                    class="hidden bg-gray-100 dark:bg-[#0d1117] dark:text-gray-200 rounded-md mt-2 border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300"
                    role="menu" aria-labelledby="menu1-button">

                    <li class="border-b border-gray-200 dark:border-gray-700">
                        <button class="flex justify-between w-full px-6 py-2 text-start items-center"
                                aria-expanded="false" aria-controls="submenu1" id="submenu1-button"
                                onclick="toggleDropdown('submenu1')">
                            <span>برند</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 transition-transform transform text-gray-600 dark:text-gray-300"
                                 id="icon-submenu1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <!-- Submenu -->
                        <ul id="submenu1" class="hidden bg-gray-50 dark:bg-custom-dark dark:text-gray-300" role="menu"
                            aria-labelledby="submenu1-button">
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                سامسونگ
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                اپل
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                شیائومی
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                هواوی
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                نوکیا
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                ال‌جی
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                سونی
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                گوگل
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                وان پلاس
                            </li>
                            <li
                                class="px-8 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                                موتورولا
                            </li>
                        </ul>
                    </li>

                    <li
                        class="px-6 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                        <a href="/category/flagship" class="block">پرچمدار</a>
                    </li>
                    <li
                        class="px-6 py-2 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                        <a href="/category/mid-range" class="block">میان‌رده</a>
                    </li>
                    <li class="px-6 py-2 hover:bg-gray-100 dark:hover:bg-[#1f242c]">
                        <a href="/category/budget" class="block">اقتصادی</a>
                    </li>
                </ul>
            </li>

            <!-- pages -->
            <li
                class="bg-gray-50 dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-[#1f242c] p-2 transition-colors duration-200">
                <a href="/pages" class="block">صفحات</a>
            </li>

        </ul>
    </nav>
</div>
<!-- END RESPONSIVE MENU -->

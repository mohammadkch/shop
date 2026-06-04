<!-- HEADER -->
<header id="topHeader"
        class="py-3 bg-white dark:bg-custom-dark border-b border-gray-200 dark:border-gray-700 shadow-md dark:shadow-none sticky top-0 start-0 end-0 z-20 transition-colors duration-300">

    <div class="container">
        <!-- row top header -->
        <div class="grid place-items-center gap-3 grid-cols-12">
            <!-- respnsive menu -->
            <div class="lg:hidden col-span-4 w-full">
                <a href="javascript:void(0)" onclick="toggleOffcanvas('offcanvas-right')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-6 dark:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5"/>
                    </svg>
                </a>
            </div>
            <!-- logo -->
            <div class="lg:col-span-2 lg:order-1 order-2 col-span-4 w-full">
                <a href="index.html">
                    <div class="xl:text-start text-center flex items-center xl:justify-start justify-center">
                        <img class="h-12 dark:invert" src="<?= $assetsPath ?>images/logo.png" loading="lazy" alt="">
                    </div>
                </a>
            </div>
            <!-- search and filter -->
            <div class="lg:col-span-6 lg:block lg:order-2 order-4 hidden col-span-4 w-full">
                <div class="flex items-center w-full justify-between">
                    <!-- search -->
                    <div class="flex w-full items-center">
                        <!--Search component-->
                        <div class="relative flex items-center w-full">
                            <input type="text" id="searchInput"
                                   class="w-full appearance-none rounded-xl border border-gray-300 dark:border-gray-700 py-3 ps-4 pe-10 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-custom-dark text-gray-900 dark:text-gray-100 transition-colors duration-300"
                                   placeholder="جستجوی محصولات ...."/>

                            <button class="p-2 rounded-3xl absolute end-1 hover:opacity-90 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                </svg>
                            </button>
                            <!--Search results-->
                            <div id="searchResults"
                                 class="absolute top-13 end-0 start-0 z-10 bg-white dark:bg-custom-dark border border-gray-300 dark:border-gray-700 rounded-xl shadow-lg dark:shadow-[0_4px_12px_rgba(0,0,0,0.4)] overflow-hidden transition-colors duration-300 hidden">
                                <!-- The results content will be filled by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- login and basket and favorite and dark mode -->
            <div class="lg:col-span-4 col-span-4 order-3 w-full">
                <div class="flex items-baseline justify-end">
                    <!-- basket and call and darkmode -->
                    <div class="flex items-baseline md:me-5 me-2">
                        <!-- heart -->
                        <a href="" class="lg:block hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                            </svg>
                        </a>
                        <!-- basket -->
                        <div onclick="toggleOffcanvas('offcanvas-left')" class="relative md:ms-5 ms-2 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                            </svg>
                            <span
                                class="size-4 text-sm -top-2 -start-2 absolute bg-secondary dark:bg-primary-400 text-white dark:text-gray-100 rounded-lg text-center shadow-sm dark:shadow-[0_0_4px_rgba(255,255,255,0.2)] transition-colors duration-300">2</span>
                        </div>
                        <!-- dark mode -->
                        <div class="md:ms-5 ms-2">
                            <button id="dark-mode-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor"
                                     class="size-6 dark:block hidden dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor"
                                     class="size-6 dark:hidden block dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="lg:inline-block hidden me-3 h-10 w-px self-stretch bg-gray-200 dark:bg-gray-700">
                    </div>
                    <!-- login -->
                    <a href="" data-modal-target="LoginModal"
                       class="bg-white dark:bg-custom-dark text-gray-900 dark:text-gray-100 modal-trigger flex lg:py-2 lg:px-3 lg:border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-[#1f242c] transition-colors duration-200">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="lg:size-6 lg:me-2 size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="lg:inline-block hidden">ورود / ثبت نام</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- mega menu -->
        <div id="megaMenu" class="lg:grid gap-y-0 hidden relative grid-cols-12">
            <div class="xl:col-span-10 col-span-12 place-self-start">
                <nav class="flex gap-x-9 mt-10 items-center">
                    <!-- menu -->
                    <ul class="flex dark:text-white items-center space-x-8 tracking-tight">
                        <?= renderShopMegaMenu($shopMenus ?? [], $assetsPath) ?>

                        <li class="">
                            <a href="" class="flex space-x-3 hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                                </svg>
                                <span>صفحه اصلی</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="" class="flex space-x-3 hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                                </svg>
                                <span>لیست کالا ها</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="" class="flex space-x-3 hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z"/>
                                </svg>
                                <span>سوالی دارید</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="" class="flex space-x-3 hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                                </svg>
                                <span>پیگیری سفارش</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="" class="flex space-x-3 hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/>
                                </svg>
                                <span>بلاگ</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="" class="flex space-x-3 hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                </svg>
                                <span>تماس با ما</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="xl:col-span-2 xl:block hidden place-self-end place-items-center">
                <div class="text-end">
                    <a href=""
                       class="flex hover:bg-primary-600 transition item-center text-white bg-primary p-3 rounded-3xl text-sm space-x-3">
                        <span>091212345678</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END HEADER -->
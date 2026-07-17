<?php
// تشخیص صفحه فعال از viewData
$controllerName = $viewData['controllerName'] ?? ''; // کامل: "App\Controllers\Customer\Profile"
$methodName = $viewData['methodName'] ?? ''; // "index" یا "changePassword"

// استخراج نام ساده کنترلر
$simpleController = '';
if (strpos($controllerName, 'Customer\\') !== false) {
    $parts = explode('\\', $controllerName);
    $simpleController = end($parts); // "Profile", "Dashboard", "Orders"
}

// تابع کمکی برای تشخیص فعال بودن منو
function isActive($targetController, $targetMethod = null, $simpleController, $methodName)
{
    if ($targetController !== $simpleController) {
        return false;
    }
    if ($targetMethod && $targetMethod !== $methodName) {
        return false;
    }
    return true;
}

$avatar = !empty($customer['avatar'])
        ? base_url('images/avatar/' . $customer['avatar'])
        : base_url('images/user/user.jpg');
?>

<!-- ====== سایدبار دسکتاپ ====== -->
<div class="lg:col-span-1 lg:block hidden">
    <div class="sticky top-20">
        <div class="relative p-4 pt-24 mb-8 bg-white dark:bg-custom-dark rounded-2xl shadow-[0_4px_30px_#edf0f5] dark:shadow-lg">

            <!-- آواتار و هدر -->
            <div class="absolute top-[-10px] start-0 end-0 mx-auto w-[230px] h-[75px] z-0">
                <svg width="230" height="75" viewBox="0 0 230 75" fill="none" class="absolute top-0 start-0 end-0 bottom-0 z-[-1] fill-custom-light dark:fill-[#0d1117]">
                    <path d="M230 0H0V10C26.2258 10.6605 43.6909 20.4901 52.0499 27.9356C60.4088 35.3811 84.5186 61.9259 84.5186 61.9259C101.038 79.219 128.627 79.219 145.146 61.9259C145.146 61.9259 169.146 35.4578 177.549 28.0042C185.953 20.5506 203.675 10.6625 230 10V0Z"></path>
                </svg>
                <img class="absolute top-[-10px] start-0 end-0 mx-auto w-[73px] h-[73px] rounded-full object-cover border-4 border-white dark:border-custom-dark"
                     src="<?= $avatar ?>"
                     alt="پروفایل">
            </div>

            <div class="relative z-0 mx-6 mb-5">
                <div class="relative z-10 bg-white dark:bg-custom-dark text-center">
                    <div class="text-lg font-bold text-gray-800 dark:text-gray-200">
                        <?= esc($customer['firstname'] ?? '') ?> <?= esc($customer['lastname'] ?? '') ?>
                    </div>
                    <div class="text-primary-500 py-1 pb-2.5 text-sm">
                        <?= esc($customer['mobile'] ?? '') ?>
                    </div>
                </div>
            </div>

            <!-- منو -->
            <ul class="space-y-2.5">
                <!-- پیشخوان -->
                <li class="py-2.5 px-1">
                    <a href="<?= site_url('customer/dashboard') ?>"
                       class="relative flex justify-start items-center py-1 px-5 text-gray-800 dark:text-gray-300 hover:text-primary transition-colors <?= isActive('Dashboard', null, $simpleController, $methodName) ? 'text-primary font-bold' : '' ?>
                              before:content-[''] before:absolute before:top-0 before:right-0 before:bottom-0 before:w-1 before:rounded before:bg-primary before:scale-y-0 before:origin-center before:transition before:duration-300
                              <?= isActive('Dashboard', null, $simpleController, $methodName) ? 'before:scale-y-100' : 'hover:before:scale-y-100' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none" class="me-2.5">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.78325 2.1665H6.59991C7.77491 2.1665 8.71658 3.12484 8.71658 4.30067V7.1415C8.71658 8.32484 7.77491 9.27484 6.59991 9.27484H3.78325C2.61658 9.27484 1.66658 8.32484 1.66658 7.1415V4.30067C1.66658 3.12484 2.61658 2.1665 3.78325 2.1665ZM3.78325 11.7246H6.59991C7.77491 11.7246 8.71658 12.6754 8.71658 13.8588V16.6996C8.71658 17.8746 7.77491 18.8329 6.59991 18.8329H3.78325C2.61658 18.8329 1.66658 17.8746 1.66658 16.6996V13.8588C1.66658 12.6754 2.61658 11.7246 3.78325 11.7246ZM16.2167 2.1665H13.4C12.225 2.1665 11.2833 3.12484 11.2833 4.30067V7.1415C11.2833 8.32484 12.225 9.27484 13.4 9.27484H16.2167C17.3833 9.27484 18.3333 8.32484 18.3333 7.1415V4.30067C18.3333 3.12484 17.3833 2.1665 16.2167 2.1665ZM13.4 11.7246H16.2167C17.3833 11.7246 18.3333 12.6754 18.3333 13.8588V16.6996C18.3333 17.8746 17.3833 18.8329 16.2167 18.8329H13.4C12.225 18.8329 11.2833 17.8746 11.2833 16.6996V13.8588C11.2833 12.6754 12.225 11.7246 13.4 11.7246Z" fill="currentColor"/>
                        </svg>
                        پیشخوان
                    </a>
                </li>

                <!-- اطلاعات کاربری -->
                <li class="py-2.5 px-1">
                    <a href="<?= site_url('customer/profile') ?>"
                       class="relative flex justify-start items-center py-1 px-5 text-gray-800 dark:text-gray-300 hover:text-primary transition-colors <?= isActive('Profile', null, $simpleController, $methodName) ? 'text-primary font-bold' : '' ?>
                              before:content-[''] before:absolute before:top-0 before:right-0 before:bottom-0 before:w-1 before:rounded before:bg-primary before:scale-y-0 before:origin-center before:transition before:duration-300
                              <?= isActive('Profile', null, $simpleController, $methodName) ? 'before:scale-y-100' : 'hover:before:scale-y-100' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        اطلاعات کاربری
                    </a>
                </li>

                <!-- سفارش‌های من -->
                <li class="py-2.5 px-1">
                    <a href="<?= site_url('customer/orders') ?>"
                       class="relative flex justify-start items-center py-1 px-5 text-gray-800 dark:text-gray-300 hover:text-primary transition-colors <?= isActive('Orders', null, $simpleController, $methodName) ? 'text-primary font-bold' : '' ?>
                              before:content-[''] before:absolute before:top-0 before:right-0 before:bottom-0 before:w-1 before:rounded before:bg-primary before:scale-y-0 before:origin-center before:transition before:duration-300
                              <?= isActive('Orders', null, $simpleController, $methodName) ? 'before:scale-y-100' : 'hover:before:scale-y-100' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2.5">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        سفارش‌های من
                    </a>
                </li>

                <!-- تغییر رمز -->
                <li class="py-2.5 px-1">
                    <a href="<?= site_url('customer/change-password') ?>"
                       class="relative flex justify-start items-center py-1 px-5 text-gray-800 dark:text-gray-300 hover:text-primary transition-colors <?= isActive('Profile', 'changePassword', $simpleController, $methodName) ? 'text-primary font-bold' : '' ?>
                              before:content-[''] before:absolute before:top-0 before:right-0 before:bottom-0 before:w-1 before:rounded before:bg-primary before:scale-y-0 before:origin-center before:transition before:duration-300
                              <?= isActive('Profile', 'changePassword', $simpleController, $methodName) ? 'before:scale-y-100' : 'hover:before:scale-y-100' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2.5">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        تغییر رمز عبور
                    </a>
                </li>

                <li class="py-2.5 px-1">
                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                </li>

                <!-- خروج -->
                <li class="py-2.5 px-1">
                    <a href="<?= site_url('logout') ?>"
                       class="relative flex justify-start items-center pt-2 px-5 text-red-500 hover:text-red-600 transition-colors before:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none" class="me-2.5">
                            <path d="M7.97016 0.5C9.95621 0.5 11.576 2.092 11.576 4.052V7.884H6.69226C6.34226 7.884 6.06551 8.156 6.06551 8.5C6.06551 8.836 6.34226 9.116 6.69226 9.116H11.576V12.94C11.576 14.9 9.95621 16.5 7.95388 16.5H3.98993C1.99574 16.5 0.375977 14.908 0.375977 12.948V4.06C0.375977 2.092 2.00388 0.5 3.99807 0.5H7.97016ZM13.6081 5.74016C13.8481 5.49216 14.2401 5.49216 14.4801 5.73216L16.8161 8.06016C16.9361 8.18016 17.0001 8.33216 17.0001 8.50016C17.0001 8.66016 16.9361 8.82016 16.8161 8.93216L14.4801 11.2602C14.3601 11.3802 14.2001 11.4442 14.0481 11.4442C13.8881 11.4442 13.7281 11.3802 13.6081 11.2602C13.3681 11.0202 13.3681 10.6282 13.6081 10.3882L14.8881 9.11616H11.5761V7.88416H14.8881L13.6081 6.61216C13.3681 6.37216 13.3681 5.98016 13.6081 5.74016Z" fill="currentColor"/>
                        </svg>
                        خروج از حساب
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>


<!-- ====== دکمه سایدبار موبایل ====== -->
<div class="lg:hidden block fixed z-20 bottom-28 start-3">
    <button onclick="toggleOffcanvas('offcanvas-right-customer')"
            class="bg-primary px-3 py-3 rounded-lg drop-shadow-lg hover:bg-primary-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
        </svg>
    </button>
</div>


<!-- ====== سایدبار موبایل (آفلاین) ====== -->
<div id="offcanvas-right-customer"
     class="offcanvas invisible overflow-y-scroll fixed top-0 start-0 sm:w-100 w-[80%] h-full bg-custom-light dark:bg-[#0d1117] text-gray-900 dark:text-gray-100 border-e border-gray-200 dark:border-gray-800 shadow-xl dark:shadow-[0_0_20px_rgba(0,0,0,0.6)] transform -translate-x-full transition-all duration-300 opacity-0 z-50">
    <div class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center justify-between">
        <h2 class="font-bold text-base">پنل کاربری</h2>
        <button onclick="closeOffcanvas()" class="cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-700 dark:text-gray-300 hover:text-primary transition-colors">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="relative p-4 pt-24 my-4 bg-white dark:bg-custom-dark rounded-2xl shadow-[0_4px_30px_#edf0f5] dark:shadow-lg mx-3">

        <div class="absolute top-[-10px] start-0 end-0 mx-auto w-[230px] h-[75px] z-0">
            <svg width="230" height="75" viewBox="0 0 230 75" fill="none" class="absolute top-0 start-0 end-0 bottom-0 z-[-1] fill-custom-light dark:fill-[#0d1117]">
                <path d="M230 0H0V10C26.2258 10.6605 43.6909 20.4901 52.0499 27.9356C60.4088 35.3811 84.5186 61.9259 84.5186 61.9259C101.038 79.219 128.627 79.219 145.146 61.9259C145.146 61.9259 169.146 35.4578 177.549 28.0042C185.953 20.5506 203.675 10.6625 230 10V0Z"/>
            </svg>
            <img class="absolute top-[-10px] start-0 end-0 mx-auto w-[73px] h-[73px] rounded-full object-cover border-4 border-white dark:border-custom-dark"
                 src="<?= $avatar ?>"
                 alt="پروفایل">
        </div>

        <div class="relative z-0 mx-6 mb-5">
            <div class="relative z-10 bg-white dark:bg-custom-dark text-center">
                <div class="text-lg font-bold text-gray-800 dark:text-gray-200">
                    <?= esc($customer['firstname'] ?? '') ?> <?= esc($customer['lastname'] ?? '') ?>
                </div>
                <div class="text-primary-500 py-1 pb-2.5 text-sm">
                    <?= esc($customer['mobile'] ?? '') ?>
                </div>
            </div>
        </div>

        <ul class="space-y-2.5">
            <li class="py-2 px-1">
                <a href="<?= site_url('customer/dashboard') ?>"
                   class="flex items-center py-1 px-4 rounded-lg <?= isActive('Dashboard', null, $simpleController, $methodName) ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1f242c]' ?> transition-colors">
                    پیشخوان
                </a>
            </li>
            <li class="py-2 px-1">
                <a href="<?= site_url('customer/profile') ?>"
                   class="flex items-center py-1 px-4 rounded-lg <?= isActive('Profile', null, $simpleController, $methodName) ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1f242c]' ?> transition-colors">
                    اطلاعات کاربری
                </a>
            </li>
            <li class="py-2 px-1">
                <a href="<?= site_url('customer/orders') ?>"
                   class="flex items-center py-1 px-4 rounded-lg <?= isActive('Orders', null, $simpleController, $methodName) ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1f242c]' ?> transition-colors">
                    سفارش‌های من
                </a>
            </li>
            <li class="py-2 px-1">
                <a href="<?= site_url('customer/change-password') ?>"
                   class="flex items-center py-1 px-4 rounded-lg <?= isActive('Profile', 'changePassword', $simpleController, $methodName) ? 'bg-primary/10 text-primary font-bold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1f242c]' ?> transition-colors">
                    تغییر رمز عبور
                </a>
            </li>
            <li class="py-2 px-1">
                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
            </li>
            <li class="py-2 px-1">
                <a href="<?= site_url('logout') ?>" class="flex items-center py-1 px-4 rounded-lg text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    خروج
                </a>
            </li>
        </ul>
    </div>
</div>
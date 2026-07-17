<!doctype html>
<html lang="FA_IR" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود / ثبت نام</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/images/favicon_io/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/images/favicon_io/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/favicon_io/favicon-16x16.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/js/plugin/swiper/swiper-bundle.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>

<body class="relative bg-gray-100 dark:bg-[#0d1117] text-gray-900 dark:text-gray-100 transition-colors duration-300 min-h-screen flex flex-col">

<!--Main content-->
<main class="flex-grow container mx-auto px-4 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="max-w-md mx-auto min-h-screen justify-center flex items-center">
        <div class="bg-white relative w-full dark:bg-custom-dark rounded-2xl shadow-soft p-8 border border-gray-100 dark:border-gray-700 fade-in">

            <!-- logo -->
            <div class="flex items-center mb-5 justify-center">
                <img class="h-12 dark:invert" src="<?= base_url('assets/images/logo.png') ?>" loading="lazy" alt="">
            </div>

            <!-- Step Indicators -->
            <div class="flex justify-center mb-6" id="stepIndicators">
                <span class="step-indicator active" data-step="1"></span>
                <span class="step-indicator" data-step="2"></span>
                <span class="step-indicator" data-step="3"></span>
            </div>

            <!-- Title -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2" id="step-title">ورود / ثبت نام</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm" id="step-description">برای ثبت نام یا ورود، شماره موبایل خود را وارد کنید</p>
            </div>

            <!-- Step 1: Mobile Number Input -->
            <div class="form-step active" id="step-1">
                <form class="space-y-5" id="authForm" novalidate>
                    <!-- Mobile number -->
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">شماره موبایل</label>
                        <div class="relative">
                            <input
                                    name="mobile"
                                    type="tel"
                                    id="mobile"
                                    inputmode="numeric"
                                    pattern="09[0-9]{9}"
                                    class="w-full ps-12 pe-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent placeholder-gray-400 dark:placeholder-gray-500 transition-colors duration-200"
                                    placeholder="09xxxxxxxxx"
                                    required
                            >
                            <div class="absolute input-icon top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            </div>
                        </div>
                        <p class="error-message text-sm text-red-600 mt-2 hidden" id="mobile-error"></p>
                    </div>

                    <!-- Continue button -->
                    <div>
                        <button type="button" id="checkMobileBtn" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                            <span class="flex items-center">
                                ادامه
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ms-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Social login -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-custom-dark text-gray-500 dark:text-gray-400">یا ورود با</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-3">
                        <div class="col-span-3">
                            <a href="#" class="w-full inline-flex justify-center items-center py-4 px-4 border border-gray-300 dark:border-gray-700 rounded-xl shadow-sm bg-white dark:bg-custom-dark text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-[#1f242c] transition-colors">
                                <span class="me-3">حساب کاربری گوگل</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16"><g fill="none" fill-rule="evenodd" clip-rule="evenodd"><path fill="#F44336" d="M7.209 1.061c.725-.081 1.154-.081 1.933 0a6.57 6.57 0 0 1 3.65 1.82a100 100 0 0 0-1.986 1.93q-1.876-1.59-4.188-.734q-1.696.78-2.362 2.528a78 78 0 0 1-2.148-1.658a.26.26 0 0 0-.16-.027q1.683-3.245 5.26-3.86" opacity=".987"/><path fill="#FFC107" d="M1.946 4.92q.085-.013.161.027a78 78 0 0 0 2.148 1.658A7.6 7.6 0 0 0 4.04 7.99q.037.678.215 1.331L2 11.116Q.527 8.038 1.946 4.92" opacity=".997"/><path fill="#448AFF" d="M12.685 13.29a26 26 0 0 0-2.202-1.74q1.15-.812 1.396-2.228H8.122V6.713q3.25-.027 6.497.055q.616 3.345-1.423 6.032a7 7 0 0 1-.51.49" opacity=".999"/><path fill="#43A047" d="M4.255 9.322q1.23 3.057 4.51 2.854a3.94 3.94 0 0 0 1.718-.626q1.148.812 2.202 1.74a6.62 6.62 0 0 1-4.027 1.684a6.4 6.4 0 0 1-1.02 0Q3.82 14.524 2 11.116z" opacity=".993"/></g></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======== STEP 2: Choose Method ======== -->
            <div class="form-step hidden" id="step-2">
                <div class="space-y-4">
                    <!-- دکمه ورود با کد یکبار مصرف -->
                    <button type="button" id="chooseOtpLogin" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                        ورود با کد یکبار مصرف
                    </button>

                    <!-- دکمه ورود با رمز عبور -->
                    <button type="button" id="choosePasswordLogin" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white dark:bg-custom-dark dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-[#1f242c] transition-colors">
                        ورود با رمز عبور
                    </button>

                    <!-- فرم پسورد (در ابتدا مخفی) -->
                    <div id="passwordLoginForm" class="hidden space-y-5">
                        <div>
                            <label for="passwordInput" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">رمز عبور</label>
                            <div class="relative">
                                <input type="password" id="passwordInput" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="رمز عبور خود را وارد کنید">
                                <button type="button" class="absolute password-toggle top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500" onclick="togglePassword('passwordInput', this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="error-message text-sm text-red-600 mt-2 hidden" id="password-error"></p>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" id="backToMethod" class="flex-1 py-3 px-4 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-custom-dark hover:bg-gray-50 dark:hover:bg-[#1f242c] transition-colors">
                                بازگشت
                            </button>
                            <button type="button" id="loginWithPasswordBtn" class="flex-1 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                                ورود
                            </button>
                        </div>
                    </div>

                    <!-- تغییر شماره موبایل -->
                    <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" id="backToMobile" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                            تغییر شماره موبایل
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: OTP Verification -->
            <div class="form-step" id="step-3">
                <form class="space-y-5" id="otpForm" novalidate>
                    <div class="text-center mb-4">
                        <p class="text-green-600 text-sm mb-3">کد تایید برای <strong style="direction: ltr" id="maskedMobile">09******123</strong> ارسال شد</p>
                        <input
                                name="otp_code"
                                type="tel"
                                id="otpCode"
                                inputmode="numeric"
                                pattern="[0-9]{5}"
                                maxlength="5"
                                class="w-full px-4 text-center text-lg py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="_ _ _ _ _"
                                required
                                autofocus
                        >
                    </div>

                    <p class="error-message text-sm text-red-600 text-center hidden" id="otp-error"></p>

                    <div>
                        <button type="button" id="verifyOtpBtn" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                            تایید کد
                        </button>
                    </div>

                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 mt-2 space-y-2">
                        <div>
                            <button type="button" id="resend-otp-button" class="transition-colors duration-200 text-primary hover:text-primary/90">
                                <span class="text-green-600 font-medium">ارسال دوباره کد</span>
                            </button>
                        </div>
                        <div class="flex justify-center items-center space-x-2">
                            <button type="button" id="cancelOtp" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">برگشت</button>
                        </div>
                    </div>
                </form>
            </div>



        </div>
    </div>
</main>

<script>
    const BASE_URL = '<?= base_url() ?>';
</script>

<script src="<?= base_url('assets/custom/shop.js') ?>"></script>
<script src="<?= base_url('assets/custom/auth.js') ?>"></script>
<script src="<?= base_url('assets/js/dependencies/app.js') ?>"></script>


</body>
</html>
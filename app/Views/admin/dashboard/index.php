<?= $this->extend('admin/_layout_/layout') ?>

<?= $this->section('content') ?>

<!-- START CONTENT -->
<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

            <?= $this->include('admin/_layout_/layout_sidebar') ?>
            <!--Main dashboard content-->
            <div class="lg:col-span-3 space-y-8">

                <!--Dashboard header-->
                <div class=" bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">پنل مدیریت فروشندگان</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">به پنل مدیریت فروشگاه خود خوش آمدید، امیر عزیز</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="flex items-center space-x-3 ">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">درآمد ماه جاری</p>
                                    <p class="font-bold text-lg text-gray-800 dark:text-gray-200">۱۲,۴۵۰,۰۰۰ تومان</p>
                                </div>
                                <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Statistics and figures-->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class=" bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">سفارشات جدید</p>
                                <p class="font-bold text-2xl text-gray-800 dark:text-gray-200 mt-1">۲۳</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <span class="text-xs text-gray-500 dark:text-gray-400">۵ سفارش در انتظار پردازش</span>
                            <a href="#" class="text-xs text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300">مشاهده همه</a>
                        </div>
                    </div>

                    <div class=" bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">محصولات فعال</p>
                                <p class="font-bold text-2xl text-gray-800 dark:text-gray-200 mt-1">۸۷</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-green-600 dark:text-green-400 text-sm flex items-center">
                                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                ۸ محصول جدید این ماه
                            </p>
                        </div>
                    </div>

                    <div class=" bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">درآمد امروز</p>
                                <p class="font-bold text-2xl text-gray-800 dark:text-gray-200 mt-1">۴۵۰K</p>
                            </div>
                            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-green-600 dark:text-green-400 text-sm flex items-center">
                                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                ۱۲٪ افزایش نسبت به دیروز
                            </p>
                        </div>
                    </div>

                    <div class=" bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">رضایت مشتریان</p>
                                <p class="font-bold text-2xl text-gray-800 dark:text-gray-200 mt-1">۴.۸/۵</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-green-600 dark:text-green-400 text-sm flex items-center">
                                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                ۴۲ نظر مثبت این هفته
                            </p>
                        </div>
                    </div>
                </div>

                <!--Recent orders-->
                <div class="bg-white rounded-3xl shadow-xl p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-black text-xl with-highlight dark:text-gray-200">سفارشات اخیر</h2>
                        <a href="#" class="text-xs font-medium bg-primary text-white py-1.5 px-4 rounded-lg hover:bg-primary-600 active:scale-95 transition duration-200 shadow-sm hover:shadow dark:bg-primary-700 dark:hover:bg-primary-600 dark:text-white">
                            مشاهده همه
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
                        <table class="w-full text-sm text-right">
                            <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 sticky top-0">
                            <tr>
                                <th class="px-5 py-4">شماره سفارش</th>
                                <th class="px-5 py-4">مشتری</th>
                                <th class="px-5 py-4">تاریخ</th>
                                <th class="px-5 py-4">مبلغ</th>
                                <th class="px-5 py-4">وضعیت</th>
                                <th class="px-5 py-4">عملیات</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                            <!-- Row -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                <td class="px-5 py-4 font-bold text-gray-900 dark:text-white">#ORD-7842</td>
                                <td class="px-5 py-4">محمد احمدی</td>
                                <td class="px-5 py-4">۱۴۰۲/۱۰/۱۵</td>
                                <td class="px-5 py-4">۱,۲۵۰,۰۰۰ تومان</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs text-nowrap font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                        تحویل شده
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <a href="#" class="text-xs font-medium bg-primary text-white py-1.5 px-4 rounded-lg hover:bg-primary-600 active:scale-95 transition duration-200 shadow-sm hover:shadow dark:bg-primary-700 dark:hover:bg-primary-600 dark:text-white">مشاهده</a>
                                </td>
                            </tr>

                            <!-- Row -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                <td class="px-5 py-4 font-bold text-gray-900 dark:text-white">#ORD-7839</td>
                                <td class="px-5 py-4">فاطمه محمدی</td>
                                <td class="px-5 py-4">۱۴۰۲/۱۰/۱۲</td>
                                <td class="px-5 py-4">۸۵۰,۰۰۰ تومان</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs text-nowrap font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300">
                                        در حال ارسال
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <a href="#" class="text-xs font-medium bg-primary text-white py-1.5 px-4 rounded-lg hover:bg-primary-600 active:scale-95 transition duration-200 shadow-sm hover:shadow dark:bg-primary-700 dark:hover:bg-primary-600 dark:text-white">مشاهده</a>
                                </td>
                            </tr>

                            <!-- Row -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                                <td class="px-5 py-4 font-bold text-gray-900 dark:text-white">#ORD-7835</td>
                                <td class="px-5 py-4">رضا کریمی</td>
                                <td class="px-5 py-4">۱۴۰۲/۱۰/۰۸</td>
                                <td class="px-5 py-4">۲,۳۵۰,۰۰۰ تومان</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs text-nowrap font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                        در حال پردازش
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <a href="#" class="text-xs font-medium bg-primary text-white py-1.5 px-4 rounded-lg hover:bg-primary-600 active:scale-95 transition duration-200 shadow-sm hover:shadow dark:bg-primary-700 dark:hover:bg-primary-600 dark:text-white">مشاهده</a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


                <!--Recent activities and special offers-->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!--Recent activities-->
                    <div class=" bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <h2 class="font-black text-xl with-highlight dark:text-gray-200 mb-6">فعالیت‌های اخیر</h2>

                        <div class="space-y-4">
                            <div class="flex items-start space-x-3 ">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">سفارش جدید ثبت شد</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">سفارش #ORD-7851 توسط کاربر محمدی ثبت شد.</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">۲ ساعت پیش</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 ">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">محصول جدید اضافه شد</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">محصول "هدفون بلوتوث" به فروشگاه اضافه شد.</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">۱ روز پیش</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 ">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">نظر جدید دریافت شد</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">کاربر احمدی برای محصول "لپ تاپ ایسوس" نظر ثبت کرد.</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">۲ روز پیش</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Performance metrics-->
                    <div class=" bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <h2 class="font-black text-xl with-highlight dark:text-gray-200 mb-6">معیارهای عملکرد</h2>

                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">نرخ تبدیل</span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">۴۷٪</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-primary-600 h-2.5 rounded-full" style="width: 47%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">رضایت مشتری</span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">۹۲٪</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: 92%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">سرعت ارسال</span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">۷۸٪</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-amber-500 h-2.5 rounded-full" style="width: 78%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">موجودی کالا</span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">۶۵٪</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-blue-500 h-2.5 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- END CONTENT -->

<?php if (session()->getFlashdata('success')): ?>
    <script>
        showNotification('<?= session()->getFlashdata('success') ?>', 'success');
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        showNotification('<?= session()->getFlashdata('error') ?>', 'error');
    </script>
<?php endif; ?>


<?= $this->endSection(); ?>


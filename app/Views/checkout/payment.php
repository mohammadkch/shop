<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">

            <!-- ====== استپ‌های خرید (timeline) ====== -->
            <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-2 mb-2 sticky top-0">
                <div class="timeline-horizontal mb-0 flex items-center justify-between">
                    <!--Step 1 - Completed-->
                    <div class="timeline-step completed flex flex-col items-center text-center">
                        <div class="timeline-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                            </svg>
                        </div>
                        <div class="timeline-title">سبد خرید</div>
                    </div>

                    <!--Step 2 - Active-->
                    <div class="timeline-step completed flex flex-col items-center text-center">
                        <div class="timeline-icon dark:bg-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <div class="timeline-title dark:text-white">انتخاب آدرس</div>
                    </div>

                    <!--Step 3-->
                    <div class="timeline-step active flex flex-col items-center text-center">
                        <div class="timeline-icon dark:bg-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5m-16.5 6h3m3 0h3m-9 5.25h12a2.25 2.25 0 002.25-2.25V7.5A2.25 2.25 0 0021.75 5.25H5.25A2.25 2.25 0 003 7.5v9.75A2.25 2.25 0 005.25 18.75z" />
                            </svg>
                        </div>
                        <div class="timeline-title dark:text-white">پرداخت</div>
                    </div>

                    <!--Step 4-->
                    <div class="timeline-step flex flex-col items-center text-center">
                        <div class="timeline-icon dark:bg-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <div class="timeline-title dark:text-white">تکمیل</div>
                    </div>
                </div>
            </div>


            <!-- ====== هشدار زمان باقیمانده ====== -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 mb-2">
                <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    این سفارش ثبت نهایی نشده است. برای پرداخت و ثبت نهایی این سفارش تنها <strong><?= $remaining_minutes ?? 60 ?></strong> دقیقه دیگر فرصت دارید
                </p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- ====== ستون اصلی (چپ - 2/3) ====== -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- ====== جزئیات سفارش (جدول) ====== -->
                    <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h1 class="font-black text-lg mb-4 relative pb-4 text-gray-900 dark:text-gray-200
                        before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary
                        after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                            جزئیات سفارش شما
                        </h1>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-right py-2 px-3 font-medium text-gray-600 dark:text-gray-400">نام کالا</th>
                                    <th class="text-center py-2 px-3 font-medium text-gray-600 dark:text-gray-400">تعداد</th>
                                    <th class="text-left py-2 px-3 font-medium text-gray-600 dark:text-gray-400">قیمت واحد</th>
                                    <th class="text-left py-2 px-3 font-medium text-gray-600 dark:text-gray-400">قیمت کل</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                                    <?php if (!empty($item['image_name'])): ?>
                                                        <img src="<?= base_url('images/products/' . $item['image_name']) ?>"
                                                             alt="<?= esc($item['product_name']) ?>"
                                                             class="w-full h-full object-cover">
                                                    <?php else: ?>
                                                        <span class="text-xs text-gray-500">بدون تصویر</span>
                                                    <?php endif; ?>
                                                </div>
                                                <a href="<?= base_url('product/' . $item['product_slug']) ?>"
                                                   target="_blank"
                                                   class="text-gray-800 dark:text-gray-200 font-medium hover:text-primary transition-colors">
                                                    <?= esc($item['product_name']) ?>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-center py-3 px-3 text-gray-800 dark:text-gray-200"><?= $item['quantity'] ?></td>
                                        <td class="text-left py-3 px-3">
                                            <?php if ($item['sale_price'] && $item['sale_price'] < $item['price']): ?>
                                                <del class="text-gray-400 dark:text-gray-500 text-xs block"><?= number_format($item['price']) ?></del>
                                                <span class="text-gray-800 dark:text-gray-200 font-bold"><?= number_format($item['sale_price']) ?></span>
                                            <?php else: ?>
                                                <span class="text-gray-800 dark:text-gray-200"><?= number_format($item['price']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-left py-3 px-3 font-bold text-gray-800 dark:text-gray-200">
                                            <?php
                                            $finalPrice = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
                                            echo number_format($finalPrice * $item['quantity']);
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- خلاصه قیمت‌ها زیر جدول -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">جمع کل:</span>
                                <span class="text-gray-800 dark:text-gray-200 font-medium"><?= number_format($factor['subtotal']) ?> تومان</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">هزینه ارسال:</span>
                                <span class="text-gray-800 dark:text-gray-200 font-medium"><?= number_format($factor['shipping_price']) ?> تومان</span>
                            </div>
                            <div class="border-t border-gray-300 dark:border-gray-700 pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-800 dark:text-white font-bold text-lg">مبلغ قابل پرداخت:</span>
                                    <span class="text-gray-800 dark:text-white font-bold text-lg"><?= number_format($factor['total']) ?> تومان</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ====== ستون راست (1/3 - سایدبار) ====== -->
                <div class="lg:col-span-1">
                    <div class="lg:sticky lg:top-[80px]" style="position: sticky; top: 80px; align-self: flex-start;">

                        <!-- ====== انتخاب روش پرداخت ====== -->
                        <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-4">
                            <h2 class="font-bold text-sm mb-3 text-gray-900 dark:text-gray-200">انتخاب روش پرداخت</h2>

                            <div class="border border-primary-500 rounded-lg p-3 bg-blue-50 dark:bg-zinc-800 selected">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 8.25h19.5m-16.5 6h3m3 0h3m-9 5.25h12a2.25 2.25 0 002.25-2.25V7.5A2.25 2.25 0 0021.75 5.25H5.25A2.25 2.25 0 003 7.5v9.75A2.25 2.25 0 005.25 18.75z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800 dark:text-white text-sm">پرداخت آنلاین</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">پرداخت از طریق درگاه بانکی</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ====== کد تخفیف ====== -->
                        <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="flex-1 min-w-[150px]">
                                    <input type="text" id="discountCode"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                                           placeholder="کد تخفیف خود را وارد نمایید...">
                                </div>
                                <button type="button" id="applyDiscountBtn"
                                        class="bg-primary hover:bg-primary-600 text-white font-medium px-6 py-3 rounded-xl transition-colors duration-200 text-sm whitespace-nowrap">
                                    اعمال کد تخفیف
                                </button>
                            </div>
                            <div id="discountMessage" class="hidden mt-2 text-sm text-red-500"></div>
                        </div>

                        <!-- ====== دکمه پرداخت ====== -->
                        <button type="button" id="paymentSubmitBtn"
                                class="w-full bg-green-500 shadow-green-500/50 hover:bg-green-600 text-white font-semibold rounded-xl px-6 py-4 text-sm transition-all duration-200 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            پرداخت و ثبت نهایی
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
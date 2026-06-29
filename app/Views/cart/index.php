<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
    <section class="py-5">
        <div class="container">
            <!-- عنوان صفحه -->
            <div class="mb-6">
                <h1 class="text-2xl font-black text-gray-900 dark:text-gray-100">سبد خرید</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1" id="cart-page-count">
                    <?= isset($cart['total_items']) && $cart['total_items'] > 0
                            ? number_format($cart['total_items']) . ' کالا در سبد خرید شما'
                            : 'سبد خرید شما خالی است' ?>
                </p>
            </div>

            <?php if (isset($cart['items']) && !empty($cart['items'])): ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- لیست محصولات -->
                    <div class="lg:col-span-2 cart-page-items">
                        <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="space-y-4">
                                <?php foreach ($cart['items'] as $item): ?>
                                    <div class="cart-item flex flex-wrap sm:space-y-0 space-y-5 dark:bg-zinc-800 bg-custom-light items-start gap-4 border border-gray-200 dark:border-gray-700 rounded-xl p-4"
                                         data-item-id="<?= $item['id'] ?>">

                                        <!-- تصویر -->
                                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <?php if (!empty($item['image_name'])): ?>
                                                <img src="<?= base_url('images/products/' . $item['image_name']) ?>"
                                                     alt="<?= esc($item['product_name']) ?>"
                                                     class="w-full h-full object-contain">
                                            <?php else: ?>
                                                <span class="text-xs text-gray-500">بدون تصویر</span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- اطلاعات -->
                                        <div class="flex-1 space-y-3">
                                            <h3 class="font-bold text-gray-800 dark:text-white line-clamp-2">
                                                <a href="<?= base_url('/product/'.$item['slug']) ?>"
                                                   class="hover:text-primary transition-colors">
                                                    <?= esc($item['product_name']) ?>
                                                </a>
                                            </h3>

                                            <!-- گزینه‌ها (رنگ و سایز) -->
                                            <div class="flex flex-wrap gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                <?php if (!empty($item['color_value'])): ?>
                                                    <span class="inline-flex items-center gap-1">
                                                    <span class="inline-block w-3 h-3 rounded-full"
                                                          style="background-color: <?= $item['color_code'] ?? '#ccc' ?>"></span>
                                                    <?= esc($item['color_value']) ?>
                                                </span>
                                                <?php endif; ?>
                                                <?php if (!empty($item['size_value'])): ?>
                                                    <span class="inline-flex items-center gap-1">
                                                    سایز: <?= esc($item['size_value']) ?>
                                                </span>
                                                <?php endif; ?>
                                            </div>

                                            <!-- کنترل‌های تعداد و حذف -->
                                            <div class="flex items-center justify-between flex-wrap gap-2">
                                                <div class="flex items-center gap-3">
                                                    <!-- کنترل تعداد -->
                                                    <div class="flex bg-white dark:bg-zinc-700 items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                                                        <button class="cart-qty-minus w-8 h-8 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-600 rounded-r-lg transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2" d="M20 12H4"/>
                                                            </svg>
                                                        </button>
                                                        <span class="cart-qty-text px-3 py-1 text-gray-800 dark:text-white min-w-[2rem] text-center"><?= $item['quantity'] ?></span>
                                                        <button class="cart-qty-plus w-8 h-8 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-600 rounded-l-lg transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2" d="M12 4v16m8-8H4"/>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- دکمه حذف -->
                                                    <button class="cart-remove-btn text-red-500 hover:text-red-700 transition-colors flex items-center gap-1 text-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        حذف
                                                    </button>
                                                </div>

                                                <!-- قیمت -->
                                                <div class="text-end">
                                                    <?php if (isset($item['has_discount']) && $item['has_discount']): ?>
                                                        <del class="text-sm text-gray-400 dark:text-gray-500 block">
                                                            <?= number_format($item['original_price']) ?>
                                                        </del>
                                                    <?php endif; ?>
                                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                    <?= number_format($item['final_price']) ?>
                                                    <span class="text-xs font-normal text-gray-600 dark:text-gray-400">تومان</span>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- خلاصه سبد خرید -->
                    <div class="lg:col-span-1 col-span-1">
                        <div class="lg:sticky lg:top-[80px]"
                             style="position: sticky; top: 80px; align-self: flex-start;">
                            <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                <h2 class="font-black text-lg mb-4 relative pb-4 text-gray-900 dark:text-gray-200
                                       before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary
                                       after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                                    خلاصه سفارش
                                </h2>

                                <div class="space-y-3 mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">جمع کل:</span>
                                        <span class="text-gray-800 dark:text-white font-medium">
                                            <?= number_format($cart['subtotal']) ?> تومان
                                        </span>
                                    </div>

                                    <?php if (isset($cart['total_discount']) && $cart['total_discount'] > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">تخفیف:</span>
                                            <span class="text-green-600 dark:text-green-400 font-medium">
                                        -<?= number_format($cart['total_discount']) ?> تومان
                                    </span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">هزینه ارسال:</span>
                                        <span class="text-gray-800 dark:text-white font-medium">رایگان</span>
                                    </div>

                                    <div class="border-t border-gray-300 dark:border-gray-700 pt-3 mt-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-800 dark:text-white font-bold">مبلغ قابل پرداخت:</span>
                                            <span class="text-gray-800 dark:text-white font-bold text-lg" id="cart-page-total">
                                        <?= number_format($cart['total_price']) ?> تومان
                                    </span>
                                        </div>
                                    </div>
                                </div>

                                <button class="w-full bg-primary hover:bg-primary-600 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    ادامه فرآیند پرداخت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- سبد خرید خالی -->
                <div class="text-center py-12">
                    <div class="w-32 h-32 mx-auto mb-8 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-32 text-gray-400" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-black text-gray-800 dark:text-gray-300 mb-4">سبد خرید شما خالی است</h2>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-8">
                        هنوز هیچ محصولی به سبد خرید خود اضافه نکرده‌اید. برای مشاهده محصولات و اضافه کردن آنها به سبد
                        خرید، از دکمه زیر استفاده کنید.
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="<?=site_url()?>"
                           class="bg-primary hover:bg-primary-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            بازگشت به صفحه اصلی
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?= $this->endSection() ?>
<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

            <?= $this->include('customer/_partials/sidebar') ?>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-soft p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">لیست علاقه‌مندی‌ها</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">محصولاتی که برای مشاهده دوباره ذخیره کرده‌اید.</p>
                        </div>
                        <span id="wishlistPageCount" class="flex-shrink-0 px-3 py-2 rounded-lg bg-red-50 text-red-500 dark:bg-zinc-800 text-sm font-bold">
                            <?= number_format(count($products)) ?> محصول
                        </span>
                    </div>

                    <div id="wishlistProducts" class="<?= empty($products) ? 'hidden' : '' ?> space-y-3">
                        <?php foreach ($products as $product): ?>
                            <?php
                            $thumbnail = !empty($product['thumbnail'])
                                ? base_url('images/products/' . $product['thumbnail'])
                                : base_url('assets/images/product/placeholder.jpg');
                            ?>
                            <article class="wishlist-product flex items-center gap-3 sm:gap-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-zinc-800 p-3" data-product-id="<?= (int) $product['id'] ?>">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 shrink-0 rounded-lg bg-gray-50 dark:bg-zinc-900 overflow-hidden">
                                    <img src="<?= $thumbnail ?>" alt="<?= esc($product['name']) ?>" class="w-full h-full object-cover" loading="lazy">
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h2 class="font-bold text-sm sm:text-base leading-7 text-gray-800 dark:text-gray-200 line-clamp-2">
                                        <?php if ((int) $product['is_active'] === 1): ?>
                                            <a href="<?= product_url($product) ?>" class="hover:text-primary transition-colors"><?= esc($product['name']) ?></a>
                                        <?php else: ?>
                                            <?= esc($product['name']) ?>
                                        <?php endif; ?>
                                    </h2>

                                    <div class="mt-2">
                                        <?php if (!(int) $product['is_active'] || (int) $product['total_stock'] < 1): ?>
                                            <span class="text-xs sm:text-sm font-bold text-red-500">در حال حاضر در دسترس نیست</span>
                                        <?php elseif ($product['has_discount']): ?>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="font-bold text-xs sm:text-sm text-gray-900 dark:text-gray-200"><?= number_format($product['final_price']) ?> تومان</span>
                                                <del class="text-xs text-gray-400"><?= number_format($product['original_price']) ?></del>
                                                <span class="bg-secondary-500 text-white text-xs font-bold px-2 py-0.5 rounded-xl"><?= (int) $product['discount_percent'] ?>%</span>
                                            </div>
                                        <?php elseif ((float) $product['original_price'] > 0): ?>
                                            <div class="font-bold text-xs sm:text-sm text-gray-900 dark:text-gray-200"><?= number_format($product['original_price']) ?> تومان</div>
                                        <?php else: ?>
                                            <span class="text-xs sm:text-sm text-gray-500">قیمت ثبت نشده است</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="shrink-0 flex flex-col sm:flex-row items-center gap-2">
                                    <?php if ((int) $product['is_active'] === 1): ?>
                                        <a href="<?= product_url($product) ?>" class="hidden sm:inline-flex px-3 py-2 rounded-lg bg-primary/10 text-primary text-xs font-bold hover:bg-primary/20 transition-colors">
                                            مشاهده
                                        </a>
                                    <?php endif; ?>
                                    <button type="button"
                                            class="wishlist-remove-button size-9 flex items-center justify-center rounded-full bg-red-50 dark:bg-zinc-900 text-red-500 transition-colors hover:bg-red-100"
                                            data-product-id="<?= (int) $product['id'] ?>"
                                            data-toggle-url="<?= site_url('wishlist/toggle') ?>"
                                            aria-label="حذف از علاقه‌مندی‌ها"
                                            title="حذف از علاقه‌مندی‌ها">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.5" class="size-5 pointer-events-none">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.687 3.75 5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div id="wishlistEmptyState" class="<?= empty($products) ? '' : 'hidden' ?> text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" class="size-20 mx-auto text-gray-300 dark:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.687 3.75 5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                        </svg>
                        <h2 class="mt-4 font-bold text-gray-800 dark:text-gray-200">لیست علاقه‌مندی‌های شما خالی است</h2>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">محصولات موردعلاقه‌تان را از صفحه محصول ذخیره کنید.</p>
                        <a href="<?= site_url('category') ?>" class="inline-flex mt-5 px-5 py-2.5 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">مشاهده محصولات</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>

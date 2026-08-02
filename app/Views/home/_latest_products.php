<?php if (!empty($latestProducts)): ?>
    <!-- START PRODUCT SLIDER SECTION -->
    <section class="py-5">
        <h2 class="sr-only">جدیدترین محصولات</h2>

        <div class="container">
            <header class="flex flex-wrap mb-2 justify-between items-center">
                <h2 class="font-bold text-lg mb-4 relative pb-4 text-gray-900 dark:text-gray-200
                    before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary
                    after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                    جدیدترین محصولات
                </h2>
                <a href="<?= site_url('category') ?>?sort_field=published_at&amp;sort_type=desc"
                   class="mb-4 text-sm font-bold text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors">
                    مشاهده همه
                </a>
            </header>

            <div class="bg-gradient-to-b from-white dark:from-[#121923] to-transparent rounded-2xl p-5 transition-colors">
                <div class="swiper product-carousel">
                    <div class="swiper-wrapper" style="padding-bottom:0!important;">
                        <?php foreach ($latestProducts as $product): ?>
                            <?php
                            $productUrl = site_url('product/' . $product['slug']);
                            $thumbnail = !empty($product['thumbnail'])
                                ? base_url('images/products/' . $product['thumbnail'])
                                : base_url('assets/images/product/placeholder.jpg');
                            ?>
                            <div class="swiper-slide">
                                <div class="relative dark:border-gray-700 dark:shadow-[0_0_10px_rgba(0,0,0,0.6)] rounded p-3 bg-white dark:bg-custom-dark transition-all duration-200 ease-in-out group">
                                    <div class="w-full overflow-hidden rounded-lg">
                                        <img src="<?= $thumbnail ?>"
                                             alt="<?= esc($product['name']) ?>"
                                             loading="lazy"
                                             class="block w-full aspect-square object-cover transition-transform duration-300 group-hover:scale-105">
                                    </div>

                                    <div class="mt-3">
                                        <h3 class="font-normal text-sm leading-6 max-h-12 min-h-6 mt-2 px-1 overflow-hidden group-hover:text-primary-600 dark:group-hover:text-primary-400 dark:text-gray-200 text-gray-900 transition-colors duration-200">
                                            <a href="<?= $productUrl ?>" class="font-bold">
                                                <?= esc($product['name']) ?>
                                            </a>
                                        </h3>
                                    </div>

                                    <div class="mt-2 flex justify-between items-end gap-3">
                                        <?php if ($product['has_discount'] && $product['discount_percent'] > 0): ?>
                                            <span class="shrink-0 bg-secondary-500 text-white text-xs font-bold px-2 py-1 rounded-xl shadow shadow-red-500/50">
                                                <?= $product['discount_percent'] ?>%
                                            </span>
                                        <?php endif; ?>
                                        <div class="flex flex-col justify-end min-h-10 h-10 w-full">
                                            <?php if ($product['has_discount']): ?>
                                                <span class="text-xs text-gray-400 dark:text-gray-500 line-through tracking-wider text-left">
                                                    <?= number_format($product['original_price']) ?>
                                                </span>
                                                <span class="font-bold text-sm text-gray-900 dark:text-gray-200 tracking-wider text-left">
                                                    <?= number_format($product['final_price']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="font-bold text-sm text-gray-900 dark:text-gray-200 tracking-wider text-left">
                                                    <?= number_format($product['original_price']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <a class="absolute inset-0 w-full h-full" href="<?= $productUrl ?>"></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END PRODUCT SLIDER SECTION -->
<?php endif; ?>

<?php if (!empty($cart['items'])): ?>
    <?php foreach ($cart['items'] as $item): ?>
        <div class="py-3 cart-item" data-item-id="<?= $item['id'] ?>">
            <div class="flex flex-wrap items-center">
                <div class="text-start w-1/3">
                    <?php if (!empty($item['image_name'])): ?>
                        <img class="max-w-full rounded-lg shadow-sm dark:shadow-[0_0_10px_rgba(0,0,0,0.5)]"
                             src="<?= base_url('images/products/' . $item['image_name']) ?>"
                             alt="<?= esc($item['product_name']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-20 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <span class="text-xs text-gray-500">بدون تصویر</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="w-2/3 space-y-2 px-2">
                    <h3 class="font-bold leading-7 text-gray-800 dark:text-gray-100 text-sm line-clamp-2">
                        <a href="/product/<?= $item['slug'] ?>"><?= esc($item['product_name']) ?></a>
                    </h3>

                    <!-- ====== اضافه کردن رنگ و سایز ====== -->
                    <div class="flex flex-wrap gap-2 text-xs text-gray-500 dark:text-gray-400">
                        <?php if (!empty($item['color_value'])): ?>
                            <span class="inline-flex items-center gap-1">
                                <span class="inline-block w-3 h-3 rounded-full" style="background-color: <?= $item['color_code'] ?? '#ccc' ?>"></span>
                                <?= esc($item['color_value']) ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($item['size_value'])): ?>
                            <span class="inline-flex items-center gap-1">سایز: <?= esc($item['size_value']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">تعداد: <?= $item['quantity'] ?></span>
                        <span class="text-sm font-bold text-gray-800 dark:text-white"><?= number_format($item['total_price']) ?> تومان</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <button class="cart-qty-minus w-7 h-7 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-r-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <span class="px-2 py-1 text-sm text-gray-800 dark:text-white cart-qty-text"><?= $item['quantity'] ?></span>
                            <button class="cart-qty-plus w-7 h-7 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-l-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>

                        <button class="cart-remove-btn text-red-500 hover:text-red-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="py-10 text-center">
        <svg class="w-20 h-20 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <p class="text-gray-500 dark:text-gray-400">سبد خرید شما خالی است</p>
        <a href="/" class="text-primary hover:underline text-sm mt-2 inline-block">مشاهده محصولات</a>
    </div>
<?php endif; ?>
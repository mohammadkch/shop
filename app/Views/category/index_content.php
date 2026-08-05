<!-- GRID محصولات -->
<div class="grid mt-6 grid-cols-12 gap-[2px] place-items-center">
    <?php if (empty($products)): ?>
        <?= $this->include('category/_empty_state') ?>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="lg:col-span-3 sm:col-span-6 col-span-12 w-full">
                <div class="relative dark:border-gray-700 dark:shadow-[0_0_10px_rgba(0,0,0,0.6)] rounded p-3 bg-white dark:bg-custom-dark transition-all duration-200 ease-in-out group">
                    <!-- Product Colors -->
                    <ul class="absolute top-4 start-3 space-y-1"></ul>

                    <!-- Thumbnail -->
                    <div class="w-full overflow-hidden rounded-lg">
                        <?php
                        $thumbnail = '';
                        $productImageModel = model('App\Models\ProductImageModel');
                        $image = $productImageModel
                                ->where('product_id', $product['id'])
                                ->where('product_image_type_id', 2)
                                ->where('is_active', 1)
                                ->orderBy('sort_order', 'ASC')
                                ->first();

                        if ($image && !empty($image['image_name'])) {
                            $thumbnail = base_url('images/products/' . $image['image_name']);
                        } else {
                            $thumbnail = base_url('assets/images/product/placeholder.jpg');
                        }
                        ?>
                        <img src="<?= $thumbnail ?>"
                             alt="<?= esc($product['name']) ?>"
                             loading="lazy"
                             class="block w-full aspect-square object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>

                    <!-- Product Body -->
                    <div class="mt-3">
                        <h3 class="font-normal text-sm leading-6 max-h-12 min-h-6 mt-2 px-1 overflow-hidden group-hover:text-primary-600 dark:group-hover:text-primary-400 dark:text-gray-200 text-gray-900 transition-colors duration-200">
                            <a href="<?= product_url($product) ?>" class="font-bold">
                                <?= esc($product['name']) ?>
                            </a>
                        </h3>
                    </div>

                    <!-- Price -->
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

                    <a class="absolute inset-0 w-full h-full" href="<?= product_url($product) ?>"></a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- ====== Pagination (داخل کانتینر) ====== -->
<?= $pagination ?? '' ?>

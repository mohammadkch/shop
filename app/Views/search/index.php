<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
<main class="container py-8 sm:py-10" style="min-height: 60vh;">
    <?php if (mb_strlen($query) < 2): ?>
        <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-gray-100 mb-5">جستجوی محصولات</h1>
        <div class="max-w-2xl mx-auto bg-white dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-xl p-6 text-center text-gray-500 dark:text-gray-400">
            برای جستجو حداقل دو کاراکتر وارد کنید.
        </div>
    <?php else: ?>
        <div class="flex items-center justify-between gap-4 mb-5">
            <h1 class="font-bold text-gray-900 dark:text-gray-100">نتایج جستجوی «<?= esc($query) ?>»</h1>
            <span class="text-sm text-gray-500 dark:text-gray-400"><?= number_format($totalResults) ?> محصول</span>
        </div>

        <?php if (empty($results)): ?>
            <div class="bg-white dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-xl p-8 text-center">
                <p class="font-bold text-gray-800 dark:text-gray-200">محصولی پیدا نشد</p>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">عبارت کوتاه‌تر یا نام دیگری را امتحان کنید.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-12 gap-[2px] place-items-center">
                <?php foreach ($results as $item): ?>
                    <div class="lg:col-span-3 sm:col-span-6 col-span-12 w-full">
                        <article class="relative dark:border-gray-700 dark:shadow-[0_0_10px_rgba(0,0,0,0.6)] rounded p-3 bg-white dark:bg-custom-dark transition-all duration-200 ease-in-out group">
                            <div class="w-full overflow-hidden rounded-lg">
                                <img src="<?= esc($item['image'], 'attr') ?>" alt="<?= esc($item['title']) ?>" loading="lazy"
                                     class="block w-full aspect-square object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <div class="mt-3">
                                <h3 class="font-bold text-sm leading-6 min-h-6 mt-2 px-1 overflow-hidden group-hover:text-primary-600 dark:group-hover:text-primary-400 dark:text-gray-200 text-gray-900 transition-colors duration-200">
                                    <?= esc($item['title']) ?>
                                </h3>
                            </div>
                            <div class="mt-2 flex justify-between items-end gap-3">
                                <?php if ($item['type'] === 'product' && $item['has_discount']): ?>
                                    <span class="shrink-0 bg-secondary-500 text-white text-xs font-bold px-2 py-1 rounded-xl">
                                        <?= (int) round((($item['original_price'] - $item['final_price']) / $item['original_price']) * 100) ?>%
                                    </span>
                                <?php endif; ?>
                                <div class="flex flex-col justify-end min-h-10 h-10 w-full <?= $item['type'] === 'product' ? 'text-left' : '' ?>">
                                    <?php if ($item['type'] !== 'product'): ?>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">
                                            <?= esc($item['subtitle'] ?? '') ?>
                                        </span>
                                    <?php elseif (!$item['is_in_stock']): ?>
                                        <span class="font-bold text-sm text-red-500">ناموجود</span>
                                    <?php elseif ($item['has_discount']): ?>
                                        <span class="text-xs text-gray-400 dark:text-gray-500 line-through"><?= number_format($item['original_price']) ?></span>
                                        <span class="font-bold text-sm text-gray-900 dark:text-gray-200"><?= number_format($item['final_price']) ?> تومان</span>
                                    <?php else: ?>
                                        <span class="font-bold text-sm text-gray-900 dark:text-gray-200"><?= number_format($item['original_price']) ?> تومان</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?= esc($item['url'], 'attr') ?>" class="absolute inset-0" aria-label="مشاهده <?= esc($item['title'], 'attr') ?>"></a>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-8"><?= $pagination ?></div>
        <?php endif; ?>
    <?php endif; ?>
</main>
<?= $this->endSection() ?>

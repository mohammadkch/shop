<?= $this->extend('admin/_layout_/layout') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <div class="min-w-0">
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                تاریخچه Slug - <?= esc($product['name']) ?>
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">
                                Slug فعلی: <span dir="ltr" class="font-mono text-primary break-all"><?= esc($product['slug']) ?></span>
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 shrink-0">
                            <a href="<?= site_url(ADMIN_PATH . '/product/edit/' . $product['id']) ?>"
                               class="bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200 py-2.5 px-4 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition text-sm">
                                ویرایش محصول
                            </a>
                            <a href="<?= site_url(ADMIN_PATH . '/product') ?>"
                               class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition text-sm">
                                بازگشت به محصولات
                            </a>
                        </div>
                    </div>

                    <div class="mb-6 p-4 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-900/20 dark:text-amber-300 dark:border-amber-800 text-sm leading-7">
                        تغییر Slug فقط در این صفحه ثبت می‌شود و به‌صورت خودکار Redirect نمی‌سازد. با دکمه «فعال‌کردن»، Slug قدیمی مستقیماً به URL فعلی محصول Redirect 301 خواهد شد.
                    </div>

                    <?php if (empty($history)): ?>
                        <div class="text-center py-12 text-gray-500 dark:text-gray-400 border border-dashed border-gray-300 dark:border-gray-700 rounded-xl">
                            هنوز تغییری برای Slug این محصول ثبت نشده است.
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="w-full text-sm text-right">
                                <thead class="text-xs bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-3">Slug قدیمی</th>
                                    <th class="px-4 py-3">Slug جدید در آن تغییر</th>
                                    <th class="px-4 py-3">تاریخ</th>
                                    <th class="px-4 py-3">Redirect</th>
                                    <th class="px-4 py-3">عملیات</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <?php foreach ($history as $item): ?>
                                    <?php $isEnabled = !empty($item['redirect_id']); ?>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/60">
                                        <td dir="ltr" class="px-4 py-4 font-mono text-left break-all"><?= esc($item['old_slug']) ?></td>
                                        <td dir="ltr" class="px-4 py-4 font-mono text-left break-all"><?= esc($item['new_slug']) ?></td>
                                        <td class="px-4 py-4 whitespace-nowrap"><?= date('Y/m/d H:i', (int) $item['created_at']) ?></td>
                                        <td class="px-4 py-4">
                                            <?php if ($isEnabled): ?>
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">فعال</span>
                                            <?php else: ?>
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">غیرفعال</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <?php if ($isEnabled): ?>
                                                <form method="post" action="<?= site_url(ADMIN_PATH . '/product-slug/disable/' . $product['id'] . '/' . $item['redirect_id']) ?>">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs">غیرفعال‌کردن</button>
                                                </form>
                                            <?php elseif ($item['old_slug'] === $product['slug']): ?>
                                                <span class="text-xs text-gray-400">Slug فعلی</span>
                                            <?php else: ?>
                                                <form method="post" action="<?= site_url(ADMIN_PATH . '/product-slug/enable/' . $product['id'] . '/' . $item['id']) ?>">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-primary hover:text-primary-800 font-bold text-xs">فعال‌کردن Redirect</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

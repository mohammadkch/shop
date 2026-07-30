<?= $this->extend('admin/_layout_/layout') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                مدیریت قیمت‌های <?= esc($product['name']) ?>
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                شناسه محصول: <?= $product['id'] ?> |
                                <a href="<?= site_url('admin/product/edit/' . $product['id']) ?>" class="text-primary hover:underline">
                                    ویرایش محصول
                                </a>
                                |
                                <?= count($colors) ?> رنگ،
                                <?= count($sizes) ?> سایز،
                                <?= count($combinations) ?> ترکیب
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="<?= site_url('admin/product-option/form/' . $product['id']) ?>"
                               class="bg-purple-500 text-white py-2.5 px-4 rounded-lg hover:bg-purple-600 transition">
                                مدیریت آپشن‌ها
                            </a>
                            <a href="<?= site_url('admin/product') ?>"
                               class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow">
                                بازگشت به لیست محصولات
                            </a>
                        </div>
                    </div>

                    <?php if (!empty($stalePrices)): ?>
                        <div class="border border-red-300 bg-red-50 dark:bg-red-900/20 dark:border-red-800 rounded-xl p-4 mb-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                                <div>
                                    <h2 class="font-bold text-red-800 dark:text-red-300">
                                        <?= count($stalePrices) ?> قیمت نامعتبر پیدا شد
                                    </h2>
                                    <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                                        رنگ یا سایز این رکوردها دیگر در آپشن‌های محصول وجود ندارد.
                                    </p>
                                </div>
                                <form method="post"
                                      action="<?= site_url('admin/product-price/cleanup/' . $product['id']) ?>"
                                      onsubmit="return confirm('همه قیمت‌های نامعتبر حذف شوند؟');">
                                    <button type="submit"
                                            class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition">
                                        پاک‌سازی همه
                                    </button>
                                </form>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-right">
                                    <thead class="text-xs text-red-800 dark:text-red-300">
                                    <tr>
                                        <th class="px-3 py-2">شناسه</th>
                                        <th class="px-3 py-2">رنگ قبلی</th>
                                        <th class="px-3 py-2">سایز قبلی</th>
                                        <th class="px-3 py-2">قیمت</th>
                                        <th class="px-3 py-2">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($stalePrices as $stale): ?>
                                        <tr class="border-t border-red-200 dark:border-red-800">
                                            <td class="px-3 py-2"><?= $stale['id'] ?></td>
                                            <td class="px-3 py-2">
                                                <?= esc($stale['color_name'] ?? 'بدون رنگ') ?>
                                                <?php if (!empty($stale['color_option_id'])): ?>
                                                    <span class="text-xs opacity-70">(#<?= $stale['color_option_id'] ?>)</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-3 py-2">
                                                <?= esc($stale['size_name'] ?? 'بدون سایز') ?>
                                                <?php if (!empty($stale['size_option_id'])): ?>
                                                    <span class="text-xs opacity-70">(#<?= $stale['size_option_id'] ?>)</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-3 py-2"><?= number_format((float) $stale['price']) ?></td>
                                            <td class="px-3 py-2">
                                                <form method="post"
                                                      action="<?= site_url('admin/product-price/delete/' . $product['id'] . '/' . $stale['id']) ?>"
                                                      onsubmit="return confirm('این قیمت نامعتبر حذف شود؟');">
                                                    <button type="submit" class="text-red-600 hover:text-red-800">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="bg-gray-50 dark:bg-gray-800/60 rounded-xl p-4 mb-6">
                        <h2 class="font-bold text-gray-800 dark:text-gray-200 mb-3">اعمال گروهی</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <input type="number" id="bulkPrice" min="0" step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                   placeholder="قیمت اصلی">
                            <input type="number" id="bulkSalePrice" min="0" step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                   placeholder="قیمت فروش">
                            <input type="number" id="bulkStock" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                   placeholder="موجودی">
                            <button type="button" id="applyBulk"
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition">
                                اعمال به همه ردیف‌ها
                            </button>
                        </div>
                    </div>

                    <form method="post" action="<?= site_url($form_action) ?>">
                        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="w-full text-sm text-right min-w-[1050px]">
                                <thead class="text-xs bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-3">پیش‌فرض</th>
                                    <th class="px-4 py-3">رنگ</th>
                                    <th class="px-4 py-3">سایز</th>
                                    <th class="px-4 py-3">قیمت اصلی</th>
                                    <th class="px-4 py-3">قیمت فروش</th>
                                    <th class="px-4 py-3">موجودی</th>
                                    <th class="px-4 py-3">SKU</th>
                                    <th class="px-4 py-3">وضعیت</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <?php foreach ($combinations as $index => $combination): ?>
                                    <?php $price = $combination['price']; ?>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="px-4 py-3 text-center">
                                            <input type="radio"
                                                   name="default_key"
                                                   value="<?= esc($combination['key']) ?>"
                                                <?= $combination['key'] === $defaultKey ? 'checked' : '' ?>>
                                            <input type="hidden"
                                                   name="prices[<?= $index ?>][key]"
                                                   value="<?= esc($combination['key']) ?>">
                                        </td>
                                        <td class="px-4 py-3">
                                            <?php if ($combination['color']): ?>
                                                <div class="flex items-center gap-2">
                                                    <?php if (!empty($combination['color']['color_code'])): ?>
                                                        <span class="inline-block size-5 rounded-full border border-gray-300"
                                                              style="background-color: <?= esc($combination['color']['color_code']) ?>"></span>
                                                    <?php endif; ?>
                                                    <span><?= esc($combination['color']['value']) ?></span>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-gray-400">بدون رنگ</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3">
                                            <?= $combination['size'] ? esc($combination['size']['value']) : '<span class="text-gray-400">بدون سایز</span>' ?>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number"
                                                   name="prices[<?= $index ?>][price]"
                                                   value="<?= $price ? esc($price['price']) : '' ?>"
                                                   min="0.01" step="0.01"
                                                   class="price-input w-36 px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number"
                                                   name="prices[<?= $index ?>][sale_price]"
                                                   value="<?= $price && $price['sale_price'] !== null ? esc($price['sale_price']) : '' ?>"
                                                   min="0" step="0.01"
                                                   class="sale-price-input w-36 px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number"
                                                   name="prices[<?= $index ?>][stock]"
                                                   value="<?= $price ? (int) $price['stock'] : 0 ?>"
                                                   min="0"
                                                   class="stock-input w-24 px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="text"
                                                   name="prices[<?= $index ?>][sku]"
                                                   value="<?= $price ? esc($price['sku'] ?? '') : '' ?>"
                                                   maxlength="100"
                                                   class="w-40 px-3 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                        </td>
                                        <td class="px-4 py-3">
                                            <?php if ($price): ?>
                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">ثبت‌شده</span>
                                            <?php else: ?>
                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300">بدون قیمت</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button type="submit"
                                    class="bg-primary text-white py-2.5 px-6 rounded-lg hover:bg-primary-600 transition">
                                ذخیره قیمت‌ها
                            </button>
                            <a href="<?= site_url('admin/product') ?>"
                               class="bg-gray-200 text-gray-800 py-2.5 px-6 rounded-lg hover:bg-gray-300 transition">
                                انصراف
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const applyButton = document.getElementById('applyBulk');
        if (!applyButton) return;

        applyButton.addEventListener('click', function () {
            const bulkPrice = document.getElementById('bulkPrice').value;
            const bulkSalePrice = document.getElementById('bulkSalePrice').value;
            const bulkStock = document.getElementById('bulkStock').value;

            if (bulkPrice !== '') {
                document.querySelectorAll('.price-input').forEach(input => input.value = bulkPrice);
            }
            if (bulkSalePrice !== '') {
                document.querySelectorAll('.sale-price-input').forEach(input => input.value = bulkSalePrice);
            }
            if (bulkStock !== '') {
                document.querySelectorAll('.stock-input').forEach(input => input.value = bulkStock);
            }
        });
    });
</script>

<?= $this->endSection() ?>

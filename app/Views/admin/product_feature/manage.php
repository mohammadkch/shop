<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('form'); ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <div>
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                مدیریت فیچرهای محصول - <?= esc($product['name']) ?>
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                شناسه محصول: <?= (int) $product['id'] ?> |
                                <a href="<?= site_url(ADMIN_PATH . '/product/edit/' . $product['id']) ?>"
                                   class="text-primary hover:underline">ویرایش محصول</a>
                            </p>
                        </div>
                        <a href="<?= site_url(ADMIN_PATH . '/product') ?>"
                           class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block text-sm">
                            بازگشت به لیست محصولات
                        </a>
                    </div>

                    <?php if (session()->getFlashdata('feature_success')): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                            <?= esc(session()->getFlashdata('feature_success')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('feature_error')): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <?= esc(session()->getFlashdata('feature_error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $isEditing = !empty($editFeature);
                    $formAction = $isEditing
                        ? ADMIN_PATH . '/product-feature/update/' . $product['id'] . '/' . $editFeature['id']
                        : ADMIN_PATH . '/product-feature/store/' . $product['id'];
                    ?>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 mb-8">
                        <h2 class="font-bold text-lg text-gray-900 dark:text-gray-200 mb-4">
                            <?= $isEditing ? 'ویرایش فیچر' : 'افزودن فیچر جدید' ?>
                        </h2>

                        <form method="post" action="<?= site_url($formAction) ?>">
                            <?= csrf_field() ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="feature_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">عنوان ویژگی</label>
                                    <input type="text" id="feature_key" name="feature_key" maxlength="150" required
                                           value="<?= esc(old('feature_key', $editFeature['feature_key'] ?? ''), 'attr') ?>"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="feature_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">مقدار ویژگی</label>
                                    <textarea id="feature_value" name="feature_value" rows="2" required
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white"><?= esc(old('feature_value', $editFeature['feature_value'] ?? '')) ?></textarea>
                                </div>
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ترتیب نمایش</label>
                                    <input type="number" id="sort_order" name="sort_order" min="0" required
                                           value="<?= esc(old('sort_order', $editFeature['sort_order'] ?? 0), 'attr') ?>"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                </div>
                                <div class="flex items-center pt-7">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" id="is_active" name="is_active" value="1"
                                           <?= old('is_active', $editFeature['is_active'] ?? 1) ? 'checked' : '' ?>
                                           class="w-4 h-4 text-primary border-gray-300 rounded">
                                    <label for="is_active" class="ms-2 text-sm font-medium text-gray-700 dark:text-gray-300">فعال باشد</label>
                                </div>
                            </div>

                            <div class="mt-5 flex flex-wrap gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    <?= $isEditing ? 'ذخیره تغییرات' : 'افزودن فیچر' ?>
                                </button>
                                <?php if ($isEditing): ?>
                                    <a href="<?= site_url(ADMIN_PATH . '/product-feature/manage/' . $product['id']) ?>"
                                       class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <?= $this->include('admin/product_feature/manage_table') ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('form'); ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('admin/_layout_/layout_sidebar') ?>

                <div class="lg:col-span-3 space-y-8">

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                    افزودن عکس جدید - <?= esc($product['name']) ?>
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    شناسه محصول: <?= $product['id'] ?> |
                                    <a href="<?= site_url('admin/product/edit/' . $product['id']) ?>" class="text-primary hover:underline">
                                        ویرایش محصول
                                    </a>
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="<?= site_url('admin/product-image/manage/' . $product['id']) ?>"
                                   class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">
                                    بازگشت به مدیریت تصاویر
                                </a>
                            </div>
                        </div>

                        <?php if (isset($validation_errors) && !empty($validation_errors)): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                                <ul class="mb-0">
                                    <?php foreach ($validation_errors as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= site_url($form_action) ?>" enctype="multipart/form-data">
                            <div class="space-y-4">
                                <?php foreach ($imageTypes as $type): ?>
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <?= esc($type['name']) ?>
                                                    <?php if ($type['width'] && $type['height']): ?>
                                                        <span class="text-xs text-gray-500">(<?= $type['width'] ?>x<?= $type['height'] ?>)</span>
                                                    <?php endif; ?>
                                                </label>
                                                <input type="file"
                                                       name="image_<?= $type['id'] ?>"
                                                       accept="image/jpeg,image/png,image/gif,image/webp"
                                                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                                <?php if ($type['file_size_limit']): ?>
                                                    <p class="text-xs text-gray-500 mt-1">حداکثر حجم: <?= $type['file_size_limit'] ?>KB</p>
                                                <?php endif; ?>
                                                <?php if ($type['extension']): ?>
                                                    <p class="text-xs text-gray-500">پسوندهای مجاز: <?= str_replace('|', ' , ', $type['extension']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    متن جایگزین (alt)
                                                </label>
                                                <input type="text"
                                                       name="alt_<?= $type['id'] ?>"
                                                       value="<?= old('alt_' . $type['id']) ?>"
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                                       placeholder="توضیح کوتاه">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    ترتیب (sort)
                                                </label>
                                                <input type="number"
                                                       name="sort_<?= $type['id'] ?>"
                                                       value="<?= old('sort_' . $type['id'], 0) ?>"
                                                       min="0"
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                                       placeholder="عدد بزرگتر = اولویت بیشتر">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    ذخیره
                                </button>
                                <a href="<?= site_url('admin/product-image/manage/' . $product['id']) ?>"
                                   class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">
                                    انصراف
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
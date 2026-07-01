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
                                    مدیریت آپشن‌های محصول - <?= esc($product['name']) ?>
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    شناسه محصول: <?= $product['id'] ?> |
                                    <a href="<?= site_url('admin/product/edit/' . $product['id']) ?>" class="text-primary hover:underline">
                                        ویرایش محصول
                                    </a>
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="<?= site_url('admin/product') ?>"
                                   class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">
                                    بازگشت به لیست محصولات
                                </a>
                            </div>
                        </div>

                        <?php if (session()->getFlashdata('validation_error')): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                                <?= session()->getFlashdata('validation_error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('option_update_success')): ?>
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                                <?= session()->getFlashdata('option_update_success') ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= site_url($form_action) ?>">
                            <div class="space-y-4">
                                <?php foreach ($labels as $label): ?>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <?= esc($label['name']) ?>
                                        </label>
                                        <select name="options[]"
                                                id="label_<?= $label['id'] ?>"
                                                multiple
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white select2">
                                            <?php if (isset($optionsByLabel[$label['id']])): ?>
                                                <?php foreach ($optionsByLabel[$label['id']] as $option): ?>
                                                    <?php
                                                    $isSelected = in_array($option['id'], $existingOptionIds);
                                                    $isActive = $option['is_active'] == 1;
                                                    $labelText = $isActive ? esc($option['value']) : esc($option['value']) . ' (غیرفعال)';
                                                    ?>
                                                    <option value="<?= $option['id'] ?>"
                                                        <?= $isSelected ? 'selected' : '' ?>
                                                        <?= !$isActive ? 'class="text-gray-400"' : '' ?>>
                                                        <?= $labelText ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="" disabled>هیچ آپشنی برای این لیبل یافت نشد</option>
                                            <?php endif; ?>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">برای انتخاب چند گزینه، کلید Ctrl (یا Cmd) را نگه دارید</p>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    ذخیره
                                </button>
                                <a href="<?= site_url('admin/product') ?>"
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
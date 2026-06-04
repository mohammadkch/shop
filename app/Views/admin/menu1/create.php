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
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                <?= isset($edit_row) ? 'ویرایش منو' : 'افزودن منو جدید' ?>
                            </h1>
                            <div class="mt-4 md:mt-0">
                                <a href="<?= site_url('admin/menu1') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">
                                    بازگشت به لیست
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
                                <?php foreach ($inputs as $input_key => $input): ?>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <?= $fields_name[$input_key] ?? $input_key ?>
                                        </label>
                                        <?php
                                        $value = set_value($input_key, isset($edit_row[$input_key]) ? $edit_row[$input_key] : '');

                                        if ($input['input'] == 'form_input'):
                                            echo form_input(array_merge($input['data'], ['value' => $value, 'class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        elseif ($input['input'] == 'form_dropdown'):
                                            echo form_dropdown($input_key, $input['options'], $value, array_merge($input['data'], ['class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        endif;
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <hr class="my-6 border-gray-200 dark:border-gray-700">

                            <div class="space-y-4">
                                <h3 class="font-black text-lg with-highlight dark:text-gray-200">تصاویر منو</h3>

                                <?php foreach ($imageTypes as $type): ?>
                                    <?php
                                    $existingImage = isset($groupedImages[$type['id']]) ? $groupedImages[$type['id']] : null;
                                    ?>
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <?= esc($type['name']) ?>
                                                    <?php if ($type['width'] && $type['height']): ?>
                                                        <span class="text-xs text-gray-500">(<?= $type['width'] ?>x<?= $type['height'] ?>)</span>
                                                    <?php endif; ?>
                                                </label>
                                                <?php if ($existingImage && !empty($existingImage['image_name'])): ?>
                                                    <div class="mb-2">
                                                        <img src="<?= base_url('images/menus/' . $existingImage['image_name']) ?>" class="w-20 h-20 object-cover rounded-lg border">
                                                    </div>
                                                <?php endif; ?>
                                                <input type="file" name="image_<?= $type['id'] ?>" accept="image/jpeg,image/png,image/gif,image/webp" class="w-full text-sm">
                                                <?php if ($type['file_size_limit']): ?>
                                                    <p class="text-xs text-gray-500 mt-1">حداکثر: <?= $type['file_size_limit'] ?>KB</p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="md:col-span-3">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">متن جایگزین (alt)</label>
                                                <input type="text" name="alt_<?= $type['id'] ?>" value="<?= $existingImage ? esc($existingImage['alt']) : '' ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" placeholder="توضیح کوتاه برای تصویر">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    <?= isset($edit_row) ? 'بروزرسانی' : 'ذخیره' ?>
                                </button>
                                <a href="<?= site_url('admin/menu1') ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
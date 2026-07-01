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
                                <?= isset($edit_row) ? 'ویرایش اسلایدر' : 'افزودن اسلایدر جدید' ?>
                            </h1>
                            <div class="mt-4 md:mt-0">
                                <a href="<?= site_url('admin/home-slider') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">
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
                                        $inputType = $input['input'] ?? 'form_input';

                                        if ($inputType == 'form_input'):
                                            // برای فیلدهای فایل
                                            if (isset($input['data']['type']) && $input['data']['type'] == 'file'):
                                                echo form_input(array_merge($input['data'], ['class' => 'w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100']));
                                                // نمایش فایل فعلی
                                                if (isset($edit_row[$input_key]) && !empty($edit_row[$input_key])):
                                                    echo '<p class="text-xs text-gray-500 mt-1">فایل فعلی: ' . esc(basename($edit_row[$input_key])) . '</p>';
                                                    echo '<img src="' . base_url('images/' . $edit_row[$input_key]) . '" class="w-20 h-20 object-cover rounded-lg border mt-2">';
                                                endif;
                                            else:
                                                echo form_input(array_merge($input['data'], ['value' => $value, 'class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                            endif;
                                        elseif ($inputType == 'form_textarea'):
                                            echo form_textarea(array_merge($input['data'], ['value' => $value, 'class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        elseif ($inputType == 'form_dropdown'):
                                            echo form_dropdown($input_key, $input['options'], $value, array_merge($input['data'], ['class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        endif;
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    <?= isset($edit_row) ? 'بروزرسانی' : 'ذخیره' ?>
                                </button>
                                <a href="<?= site_url('admin/home-slider') ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
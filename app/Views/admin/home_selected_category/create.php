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
                                افزودن منو به لیست منتخب
                            </h1>
                            <div class="mt-4 md:mt-0">
                                <a href="<?= site_url('admin/home-selected-category/manage') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">
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

                        <?php if (session()->getFlashdata('validation_error')): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                                <?= session()->getFlashdata('validation_error') ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= site_url($form_action) ?>">
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
                                            echo form_input(array_merge($input['data'], ['value' => $value, 'class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        elseif ($inputType == 'form_dropdown'):
                                            echo form_dropdown($input_key, $input['options'], $value, array_merge($input['data'], ['class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        endif;
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    ذخیره
                                </button>
                                <a href="<?= site_url('admin/home-selected-category/manage') ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menu1Select = document.getElementById('menu_1_id');
            const menu2Select = document.getElementById('menu_2_id');
            const menu3Select = document.getElementById('menu_3_id');

            if (menu1Select && menu2Select && menu3Select) {
                // ========== تغییر منوی 1 ==========
                menu1Select.addEventListener('change', function() {
                    const menu1Id = this.value;

                    menu2Select.innerHTML = '<option value="">در حال بارگذاری...</option>';
                    menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                    menu3Select.disabled = true;

                    if (!menu1Id) {
                        menu2Select.innerHTML = '<option value="">ابتدا منو سطح 1 را انتخاب کنید</option>';
                        menu2Select.disabled = true;
                        return;
                    }

                    menu2Select.disabled = false;

                    fetch('<?= site_url('admin/home-selected-category/getMenu2') ?>/' + menu1Id)
                        .then(response => response.json())
                        .then(data => {
                            menu2Select.innerHTML = '<option value="">انتخاب منو سطح 2</option>';
                            if (data.status === 'success' && data.data.length > 0) {
                                data.data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    option.textContent = item.name;
                                    menu2Select.appendChild(option);
                                });
                                menu2Select.disabled = false;
                            } else {
                                menu2Select.innerHTML = '<option value="">هیچ منوی سطح 2 یافت نشد</option>';
                                menu2Select.disabled = true;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            menu2Select.innerHTML = '<option value="">خطا در بارگذاری</option>';
                            menu2Select.disabled = true;
                        });
                });

                // ========== تغییر منوی 2 ==========
                menu2Select.addEventListener('change', function() {
                    const menu2Id = this.value;

                    menu3Select.innerHTML = '<option value="">در حال بارگذاری...</option>';
                    menu3Select.disabled = true;

                    if (!menu2Id) {
                        menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                        return;
                    }

                    fetch('<?= site_url('admin/home-selected-category/getMenu3') ?>/' + menu2Id)
                        .then(response => response.json())
                        .then(data => {
                            menu3Select.innerHTML = '<option value="">انتخاب منو سطح 3</option>';
                            if (data.status === 'success' && data.data.length > 0) {
                                data.data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    option.textContent = item.name;
                                    menu3Select.appendChild(option);
                                });
                                menu3Select.disabled = false;
                            } else {
                                menu3Select.innerHTML = '<option value="">هیچ منوی سطح 3 یافت نشد</option>';
                                menu3Select.disabled = true;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            menu3Select.innerHTML = '<option value="">خطا در بارگذاری</option>';
                            menu3Select.disabled = true;
                        });
                });

                // ========== مقداردهی اولیه ==========
                // منوی 1 رو تغییر بده تا منوی 2 پر بشه (اگه مقدار اولیه داشته باشه)
                if (menu1Select.value) {
                    menu1Select.dispatchEvent(new Event('change'));
                }
            }
        });
    </script>

<?= $this->endSection() ?>
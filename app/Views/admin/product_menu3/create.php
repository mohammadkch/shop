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
                                    افزودن منو به محصول - <?= esc($product['name']) ?>
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    شناسه محصول: <?= $product['id'] ?> |
                                    <a href="<?= site_url('admin/product/edit/' . $product['id']) ?>" class="text-primary hover:underline">
                                        ویرایش محصول
                                    </a>
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="<?= site_url('admin/product-menu3/manage/' . $product['id']) ?>"
                                   class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">
                                    بازگشت به مدیریت منوها
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

                        <form method="post" action="<?= site_url($form_action) ?>" id="menuForm">
                            <div class="space-y-4">
                                <!-- منو سطح 1 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        منو سطح 1
                                    </label>
                                    <select name="menu_1_id" id="menu_1_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                        <option value="">انتخاب منو سطح 1</option>
                                        <?php foreach ($menu1List as $menu1): ?>
                                            <option value="<?= $menu1['id'] ?>"><?= esc($menu1['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- منو سطح 2 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        منو سطح 2
                                    </label>
                                    <select name="menu_2_id" id="menu_2_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" disabled>
                                        <option value="">ابتدا منو سطح 1 را انتخاب کنید</option>
                                    </select>
                                </div>

                                <!-- منو سطح 3 -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        منو سطح 3
                                    </label>
                                    <select name="menu_3_id" id="menu_3_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" disabled>
                                        <option value="">ابتدا منو سطح 2 را انتخاب کنید</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <button type="submit" id="submitBtn" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition" disabled>
                                    افزودن منو
                                </button>
                                <a href="<?= site_url('admin/product-menu3/manage/' . $product['id']) ?>"
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menu1Select = document.getElementById('menu_1_id');
            const menu2Select = document.getElementById('menu_2_id');
            const menu3Select = document.getElementById('menu_3_id');
            const submitBtn = document.getElementById('submitBtn');

            // ========== تغییر منوی 1 ==========
            menu1Select.addEventListener('change', function() {
                const menu1Id = this.value;

                // ریست منوی 2 و 3
                menu2Select.innerHTML = '<option value="">در حال بارگذاری...</option>';
                menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                menu3Select.disabled = true;
                submitBtn.disabled = true;

                if (!menu1Id) {
                    menu2Select.innerHTML = '<option value="">ابتدا منو سطح 1 را انتخاب کنید</option>';
                    menu2Select.disabled = true;
                    return;
                }

                menu2Select.disabled = false;

                fetch('<?= site_url('admin/product-menu3/getMenu2') ?>/' + menu1Id)
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
                submitBtn.disabled = true;

                if (!menu2Id) {
                    menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                    return;
                }

                fetch('<?= site_url('admin/product-menu3/getMenu3') ?>/' + menu2Id)
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

            // ========== تغییر منوی 3 ==========
            menu3Select.addEventListener('change', function() {
                if (this.value) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            });
        });
    </script>

<?= $this->endSection() ?>
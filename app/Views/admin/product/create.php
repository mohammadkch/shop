<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('form'); ?>

<?= $this->section('styles') ?>
    <link rel="stylesheet" href="<?= base_url('assets/js/plugin/quill/quill.snow.css') ?>">
    <style>
        .product-editor { min-height: 190px; background: #fff; color: #111; direction: rtl; text-align: right; }
        .ql-toolbar.ql-snow { direction: rtl; }
        .ql-editor { min-height: 190px; font-size: 15px; line-height: 2; }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('admin/_layout_/layout_sidebar') ?>

                <div class="lg:col-span-3 space-y-8">

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <h1 class="min-w-0 font-black text-2xl with-highlight dark:text-gray-200">
                                <?= isset($edit_row) ? 'ویرایش محصول' : 'افزودن محصول جدید' ?>
                            </h1>
                            <div class="flex flex-wrap items-center gap-2 shrink-0">
                                <?php if (isset($edit_row)): ?>
                                    <div class="relative" data-product-manage-menu>
                                        <button type="button" data-product-manage-toggle aria-expanded="false"
                                                class="bg-amber-500 text-white py-2.5 px-4 rounded-lg hover:bg-amber-600 transition duration-200 shadow-sm hover:shadow inline-flex items-center text-sm">
                                            <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                            </svg>
                                            مدیریت بخش‌های محصول
                                            <svg class="w-4 h-4 ms-2 transition-transform" data-product-manage-arrow fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div data-product-manage-dropdown class="hidden absolute end-0 mt-2 w-64 p-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg z-50" style="top: 100%;">
                                            <?php
                                            $manageLinks = [
                                                ['url' => 'product-price/manage/', 'title' => 'مدیریت قیمت‌ها', 'icon' => 'تومان'],
                                                ['url' => 'product-image/manage/', 'title' => 'مدیریت تصاویر', 'icon' => 'تصویر'],
                                                ['url' => 'product-option/form/', 'title' => 'مدیریت آپشن‌ها', 'icon' => 'گزینه'],
                                                ['url' => 'product-feature/manage/', 'title' => 'مدیریت ویژگی‌ها', 'icon' => 'ویژگی'],
                                                ['url' => 'product-faq/manage/', 'title' => 'مدیریت سؤال‌ها', 'icon' => 'سؤال'],
                                                ['url' => 'product-slug/manage/', 'title' => 'تاریخچه Slug', 'icon' => 'URL'],
                                                ['url' => 'product-menu3/manage/', 'title' => 'مدیریت منو', 'icon' => 'منو'],
                                            ];
                                            ?>
                                            <?php foreach ($manageLinks as $manageLink): ?>
                                                <a href="<?= site_url(ADMIN_PATH . '/' . $manageLink['url'] . $edit_row['id']) ?>"
                                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 dark:text-gray-200 hover:bg-amber-50 hover:text-amber-700 dark:hover:bg-gray-700 dark:hover:text-amber-400 transition">
                                                    <span class="inline-flex items-center justify-center w-12 h-7 px-2 rounded-md bg-gray-100 dark:bg-gray-700 text-xs text-gray-500 dark:text-gray-300 shrink-0"><?= esc($manageLink['icon']) ?></span>
                                                    <span><?= esc($manageLink['title']) ?></span>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <a href="<?= site_url(ADMIN_PATH . '/product') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block text-sm">
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

                        <form id="productForm" method="post" action="<?= site_url($form_action) ?>" enctype="multipart/form-data">
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
                                        elseif ($inputType == 'form_textarea'):
                                            echo form_textarea(array_merge($input['data'], ['value' => $value, 'class' => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white']));
                                        elseif ($inputType == 'quill'):
                                            ?>
                                            <div id="descriptionEditor" class="product-editor"></div>
                                            <input type="hidden" id="description" name="description" value="<?= esc($value, 'attr') ?>">
                                            <?php
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
                                <a href="<?= site_url(ADMIN_PATH . '/product') ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script src="<?= base_url('assets/js/plugin/quill/quill.js') ?>"></script>
    <script>
        (() => {
            const menu = document.querySelector('[data-product-manage-menu]');
            if (!menu) return;

            const toggle = menu.querySelector('[data-product-manage-toggle]');
            const dropdown = menu.querySelector('[data-product-manage-dropdown]');
            const arrow = menu.querySelector('[data-product-manage-arrow]');

            const closeMenu = () => {
                dropdown.classList.add('hidden');
                arrow.classList.remove('rotate-180');
                toggle.setAttribute('aria-expanded', 'false');
            };

            toggle.addEventListener('click', () => {
                const willOpen = dropdown.classList.contains('hidden');
                dropdown.classList.toggle('hidden', !willOpen);
                arrow.classList.toggle('rotate-180', willOpen);
                toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            });

            document.addEventListener('click', (event) => {
                if (!menu.contains(event.target)) closeMenu();
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') closeMenu();
            });
        })();

        (() => {
            const form = document.getElementById('productForm');
            const input = document.getElementById('description');
            const editorElement = document.getElementById('descriptionEditor');
            if (!form || !input || !editorElement || typeof Quill === 'undefined') return;

            editorElement.innerHTML = input.value;
            const editor = new Quill(editorElement, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{header: [2, 3, 4, false]}],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{list: 'ordered'}, {list: 'bullet'}],
                        ['blockquote', 'link'],
                        [{align: []}],
                        [{direction: 'rtl'}],
                        ['clean']
                    ]
                },
                formats: ['header', 'bold', 'italic', 'underline', 'strike', 'list', 'blockquote', 'link', 'align', 'direction']
            });
            editor.format('direction', 'rtl');
            editor.format('align', 'right');

            form.addEventListener('submit', () => {
                const html = editor.root.innerHTML.trim();
                input.value = html === '<p><br></p>' ? '' : html;
            });
        })();
    </script>
<?= $this->endSection() ?>

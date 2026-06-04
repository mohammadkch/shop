<?= $this->extend('admin/_layout_/layout') ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('admin/_layout_/layout_sidebar') ?>

                <div class="lg:col-span-3 space-y-8">

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت تصاویر منو سطح 1</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">لیست تمام تصاویر منوهای اصلی فروشگاه</p>
                            </div>
                        </div>

                        <!-- فرم جستجو -->
                        <div class="search-filters mb-6">
                            <form id="searchForm" method="post" action="<?= current_url() ?>">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <?php helper('form'); ?>
                                    <?php foreach ($search_fields as $field_name => $field): ?>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <?= $field['label'] ?>
                                            </label>
                                            <?php if ($field['input'] == 'form_input'): ?>
                                                <?= form_input(
                                                    array_merge($field['data'], ['name' => $field_name, 'id' => $field_name, 'value' => '']),
                                                    '',
                                                    ['class' => $field['data']['class']]
                                                ) ?>
                                            <?php elseif ($field['input'] == 'form_dropdown'): ?>
                                                <?= form_dropdown(
                                                    $field_name,
                                                    $field['options'],
                                                    '',
                                                    array_merge($field['data'], ['id' => $field_name])
                                                ) ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" id="searchBtn" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">جستجو</button>
                                    <button type="button" id="resetBtn" class="bg-gray-500 text-white py-2 px-6 rounded-lg hover:bg-gray-600 transition">ریست</button>
                                </div>
                            </form>
                        </div>

                        <!-- نتیجه جستجو -->
                        <div id="search-result">
                            <?= $this->include('admin/menu1_image/index_data_table') ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- مودال حذف -->
    <div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-auto backdrop-blur bg-black/50">
        <div class="relative p-4 w-full max-w-md m-auto flex items-center min-h-screen">
            <div class="bg-white relative w-full dark:bg-custom-dark rounded-2xl shadow-soft p-6">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">آیا اطمینان دارید؟</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">آیا از حذف این تصویر اطمینان دارید؟</p>
                    <div class="flex gap-3 justify-center">
                        <button type="button" id="cancelDeleteBtn" class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-400 transition">خیر</button>
                        <button type="button" id="confirmDeleteBtn" class="bg-red-500 text-white py-2 px-6 rounded-lg hover:bg-red-600 transition">بله، حذف شود</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- مودال تأیید برای تغییر وضعیت -->
    <div id="confirmModal" class="hidden fixed inset-0 z-50 overflow-auto backdrop-blur bg-black/50">
        <div class="relative p-4 w-full max-w-md m-auto flex items-center min-h-screen">
            <div class="bg-white relative w-full dark:bg-custom-dark rounded-2xl shadow-soft p-6">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">تأیید تغییر وضعیت</h3>
                    <p id="confirmMessage" class="text-gray-600 dark:text-gray-400 mb-6"></p>
                    <div class="flex gap-3 justify-center">
                        <button type="button" id="cancelConfirmBtn" class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-400 transition">خیر</button>
                        <button type="button" id="confirmToggleBtn" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">بله</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
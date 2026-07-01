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
                                <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت منوهای منتخب</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">لیست منوهای نمایش داده شده در صفحه اصلی</p>
                            </div>
                            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                                <a href="<?= site_url('admin/home-selected-category/create') ?>" class="bg-amber-500 text-white py-2.5 px-4 rounded-lg hover:bg-amber-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    افزودن منو منتخب
                                </a>
                                <a href="<?= site_url('admin/dashboard') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    بازگشت به داشبورد
                                </a>
                            </div>
                        </div>

                        <!-- فرم جستجوی مخفی (برای AJAX) -->
                        <form id="searchForm" style="display: none;"></form>

                        <!-- نتیجه -->
                        <div id="search-result">
                            <?= $this->include('admin/home_selected_category/manage_table') ?>
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
                    <p class="text-gray-600 dark:text-gray-400 mb-6">آیا از حذف این منو از لیست منتخب اطمینان دارید؟</p>
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
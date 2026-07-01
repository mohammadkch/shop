<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('jalali'); ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <form id="searchForm" style="display: none;"></form>
                <?= $this->include('admin/_layout_/layout_sidebar') ?>

                <div class="lg:col-span-3 space-y-8">

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <div>
                                <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                    مدیریت تصاویر - <?= esc($product['name']) ?>
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    شناسه محصول: <?= $product['id'] ?> |
                                    <a href="<?= site_url('admin/product/edit/' . $product['id']) ?>" class="text-primary hover:underline">
                                        ویرایش محصول
                                    </a>
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                                <a href="<?= site_url('admin/product-image/create/' . $product['id']) ?>"
                                   class="bg-amber-500 text-white py-2.5 px-4 rounded-lg hover:bg-amber-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    افزودن عکس جدید
                                </a>
                                <a href="<?= site_url('admin/product') ?>"
                                   class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    بازگشت به لیست محصولات
                                </a>
                            </div>
                        </div>

                        <!-- نتیجه -->
                        <div id="search-result">
                            <?= $this->include('admin/product_image/manage_table') ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- مودال ویرایش alt -->
    <div id="editAltModal" class="hidden fixed inset-0 z-50 overflow-auto backdrop-blur bg-black/50">
        <div class="relative p-4 w-full max-w-md m-auto flex items-center min-h-screen">
            <div class="bg-white relative w-full dark:bg-custom-dark rounded-2xl shadow-soft p-6">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">ویرایش متن جایگزین</h3>
                    <input type="text" id="editAltInput" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white mb-4" placeholder="متن جایگزین">
                    <input type="hidden" id="editAltId">
                    <div class="flex gap-3 justify-center">
                        <button type="button" id="cancelEditAltBtn" class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-400 transition">انصراف</button>
                        <button type="button" id="saveEditAltBtn" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">ذخیره</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======== مودال حذف ======== -->
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

    <!-- ======== مودال تأیید تغییر وضعیت ======== -->
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

    <!-- مودال‌های حذف و تغییر وضعیت (همون‌هایی که در layout هستن استفاده میشن) -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== ویرایش alt ==========
            const editAltModal = document.getElementById('editAltModal');
            const editAltInput = document.getElementById('editAltInput');
            const editAltId = document.getElementById('editAltId');

            document.querySelectorAll('.edit-alt-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    editAltId.value = this.dataset.id;
                    editAltInput.value = this.dataset.alt || '';
                    editAltModal.classList.remove('hidden');
                });
            });

            document.getElementById('cancelEditAltBtn').addEventListener('click', function() {
                editAltModal.classList.add('hidden');
            });

            document.getElementById('saveEditAltBtn').addEventListener('click', function() {
                const id = editAltId.value;
                const alt = editAltInput.value;

                fetch('<?= site_url('admin/product-image/updateAlt') ?>/' + id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ alt: alt })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showNotification(data.message, 'success');
                            showPage();  // <-- بجای location.reload()
                        } else {
                            showNotification(data.message, 'error');
                        }
                        editAltModal.classList.add('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('خطا در ذخیره', 'error');
                        editAltModal.classList.add('hidden');
                    });
            });

            editAltModal.addEventListener('click', function(e) {
                if (e.target === this) this.classList.add('hidden');
            });
        });
    </script>

<?= $this->endSection() ?>
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
                                    مدیریت منوهای محصول - <?= esc($product['name']) ?>
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    شناسه محصول: <?= $product['id'] ?> |
                                    <a href="<?= site_url('admin/product/edit/' . $product['id']) ?>" class="text-primary hover:underline">
                                        ویرایش محصول
                                    </a>
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                                <a href="<?= site_url('admin/product-menu3/create/' . $product['id']) ?>"
                                   class="bg-amber-500 text-white py-2.5 px-4 rounded-lg hover:bg-amber-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    افزودن منو جدید
                                </a>
                                <a href="<?= site_url('admin/product') ?>"
                                   class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    بازگشت به لیست محصولات
                                </a>
                            </div>
                        </div>

                        <?php if (empty($productMenus)): ?>
                            <div class="alert alert-warning text-center py-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <svg class="w-12 h-12 text-yellow-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200">منویی یافت نشد</h5>
                                <p class="text-gray-600 dark:text-gray-400">این محصول به هیچ منوی سطح ۳ متصل نیست.</p>
                            </div>
                        <?php else: ?>
                            <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
                                <table class="w-full text-sm text-right">
                                    <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 sticky top-0">
                                    <tr>
                                        <th class="px-5 py-4">شناسه</th>
                                        <th class="px-5 py-4">منو سطح 1</th>
                                        <th class="px-5 py-4">منو سطح 2</th>
                                        <th class="px-5 py-4">منو سطح 3</th>
                                        <th class="px-5 py-4">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    <?php foreach ($productMenus as $item): ?>
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all" data-id="<?= $item['id'] ?>" data-menu2-id="<?= $item['menu_2_id'] ?? '' ?>" data-menu3-id="<?= $item['menu_3_id'] ?? '' ?>">

                                            <td class="px-5 py-4 font-bold text-gray-900 dark:text-white"><?= $item['id'] ?></td>
                                            <td class="px-5 py-4">
                                                <select class="menu1-select w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white text-sm"
                                                        data-row-id="<?= $item['id'] ?>">
                                                    <option value="">انتخاب کنید</option>
                                                    <?php foreach ($menu1List as $menu1): ?>
                                                        <option value="<?= $menu1['id'] ?>" <?= ($item['menu_1_id'] ?? '') == $menu1['id'] ? 'selected' : '' ?>>
                                                            <?= esc($menu1['name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td class="px-5 py-4">
                                                <select class="menu2-select w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white text-sm"
                                                        data-row-id="<?= $item['id'] ?>">
                                                    <option value="">انتخاب کنید</option>
                                                    <!-- مقدار فعلی از طریق JS پر میشه -->
                                                </select>
                                            </td>
                                            <td class="px-5 py-4">
                                                <div class="flex items-center gap-2">
                                                    <select class="menu3-select w-full px-3 py-1.5 border-2 border-primary-400 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white text-sm font-bold"
                                                            data-row-id="<?= $item['id'] ?>">
                                                        <option value="">انتخاب کنید</option>
                                                        <!-- مقدار فعلی از طریق JS پر میشه -->
                                                    </select>
                                                    <button type="button"
                                                            class="apply-btn bg-primary text-white px-3 py-1.5 rounded-lg hover:bg-primary-600 transition text-sm"
                                                            data-row-id="<?= $item['id'] ?>">
                                                        اپلای
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4">
                                                <button type="button"
                                                        class="delete-menu-btn text-red-600 hover:text-red-800"
                                                        data-id="<?= $item['id'] ?>"
                                                        data-url="<?= site_url('admin/product-menu3/delete') ?>">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
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
                    <p class="text-gray-600 dark:text-gray-400 mb-6">آیا از حذف این اتصال منو اطمینان دارید؟</p>
                    <div class="flex gap-3 justify-center">
                        <button type="button" id="cancelDeleteBtn" class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-400 transition">خیر</button>
                        <button type="button" id="confirmDeleteMenuBtn" class="bg-red-500 text-white py-2 px-6 rounded-lg hover:bg-red-600 transition">بله، حذف شود</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
// ========== مقداردهی اولیه منوهای 2 و 3 ==========
            document.querySelectorAll('.menu1-select').forEach(function(select) {
                const rowId = select.dataset.rowId;
                const menu1Id = select.value;
                const menu2Select = document.querySelector(`.menu2-select[data-row-id="${rowId}"]`);
                const menu3Select = document.querySelector(`.menu3-select[data-row-id="${rowId}"]`);
                const applyBtn = document.querySelector(`.apply-btn[data-row-id="${rowId}"]`);
                const tr = select.closest('tr');

                // گرفتن منوی 2 و 3 فعلی از دیتای ردیف (که باید توی کنترلر ست بشه)
                const currentMenu2Id = tr.dataset.menu2Id || '';
                const currentMenu3Id = tr.dataset.menu3Id || '';

                if (menu1Id) {
                    // بارگذاری منوهای 2
                    fetch('<?= site_url('admin/product-menu3/getMenu2') ?>/' + menu1Id)
                        .then(response => response.json())
                        .then(data => {
                            menu2Select.innerHTML = '<option value="">انتخاب منو سطح 2</option>';
                            if (data.status === 'success' && data.data.length > 0) {
                                let hasSelected = false;
                                data.data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    option.textContent = item.name;
                                    if (currentMenu2Id == item.id) {
                                        option.selected = true;
                                        hasSelected = true;
                                    }
                                    menu2Select.appendChild(option);
                                });
                                menu2Select.disabled = false;

                                // اگر منوی 2 فعلی داشت، بارگذاری منوهای 3
                                if (currentMenu2Id) {
                                    loadMenu3(rowId, currentMenu2Id, currentMenu3Id);
                                } else {
                                    // اگه منوی 2 نداشت، منوی 3 رو غیرفعال کن
                                    menu3Select.disabled = true;
                                    menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                                    applyBtn.disabled = true;
                                }
                            } else {
                                menu2Select.innerHTML = '<option value="">هیچ منوی سطح 2 یافت نشد</option>';
                                menu2Select.disabled = true;
                                menu3Select.disabled = true;
                                menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                                applyBtn.disabled = true;
                            }
                        });
                } else {
                    // اگه منوی 1 انتخاب نشده
                    menu2Select.disabled = true;
                    menu2Select.innerHTML = '<option value="">ابتدا منو سطح 1 را انتخاب کنید</option>';
                    menu3Select.disabled = true;
                    menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                    applyBtn.disabled = true;
                }
            });

// ========== تابع بارگذاری منوهای 3 ==========
            function loadMenu3(rowId, menu2Id, selectedMenu3Id = null) {
                const menu3Select = document.querySelector(`.menu3-select[data-row-id="${rowId}"]`);
                const applyBtn = document.querySelector(`.apply-btn[data-row-id="${rowId}"]`);

                if (!menu2Id) {
                    menu3Select.disabled = true;
                    menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                    applyBtn.disabled = true;
                    return;
                }

                menu3Select.disabled = false;
                menu3Select.innerHTML = '<option value="">در حال بارگذاری...</option>';
                applyBtn.disabled = true;

                fetch('<?= site_url('admin/product-menu3/getMenu3') ?>/' + menu2Id)
                    .then(response => response.json())
                    .then(data => {
                        menu3Select.innerHTML = '<option value="">انتخاب منو سطح 3</option>';
                        if (data.status === 'success' && data.data.length > 0) {
                            let hasSelected = false;
                            data.data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.name;
                                if (selectedMenu3Id && selectedMenu3Id == item.id) {
                                    option.selected = true;
                                    hasSelected = true;
                                    // برجسته کردن منوی 3 فعلی
                                    menu3Select.style.borderColor = '#10b981';
                                    menu3Select.style.borderWidth = '2px';
                                }
                                menu3Select.appendChild(option);
                            });
                            menu3Select.disabled = false;

                            // اگه منوی 3 سلکت شده بود، دکمه اپلای غیرفعال بمونه (چون الان همون منو انتخاب شده)
                            // اگه منوی 3 سلکت نشده بود، دکمه اپلای فعال بشه
                            if (hasSelected) {
                                applyBtn.disabled = true; // غیرفعال چون همون منو انتخاب شده
                            } else {
                                applyBtn.disabled = false; // فعال چون منوی جدید انتخاب شده
                            }
                        } else {
                            menu3Select.innerHTML = '<option value="">هیچ منوی سطح 3 یافت نشد</option>';
                            menu3Select.disabled = true;
                            applyBtn.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        menu3Select.innerHTML = '<option value="">خطا در بارگذاری</option>';
                        menu3Select.disabled = true;
                        applyBtn.disabled = true;
                    });
            }
            // ========== آپدیت منوی سطح 2 ==========
            document.querySelectorAll('.menu1-select').forEach(select => {
                select.addEventListener('change', function() {
                    const rowId = this.dataset.rowId;
                    const menu1Id = this.value;
                    const menu2Select = document.querySelector(`.menu2-select[data-row-id="${rowId}"]`);
                    const menu3Select = document.querySelector(`.menu3-select[data-row-id="${rowId}"]`);
                    const applyBtn = document.querySelector(`.apply-btn[data-row-id="${rowId}"]`);

                    // غیرفعال کردن منوی 3 و دکمه اپلای
                    menu3Select.disabled = true;
                    menu3Select.innerHTML = '<option value="">در حال بارگذاری...</option>';
                    applyBtn.disabled = true;

                    if (!menu1Id) {
                        menu2Select.disabled = true;
                        menu2Select.innerHTML = '<option value="">ابتدا منو سطح 1 را انتخاب کنید</option>';
                        menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                        return;
                    }

                    // فعال کردن منوی 2 و بارگذاری
                    menu2Select.disabled = false;
                    menu2Select.innerHTML = '<option value="">در حال بارگذاری...</option>';

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
                            // ریست منوی 3
                            menu3Select.disabled = true;
                            menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                            applyBtn.disabled = true;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            menu2Select.innerHTML = '<option value="">خطا در بارگذاری</option>';
                            menu2Select.disabled = true;
                        });
                });
            });

            // ========== آپدیت منوی سطح 3 ==========
            document.querySelectorAll('.menu2-select').forEach(select => {
                select.addEventListener('change', function() {
                    const rowId = this.dataset.rowId;
                    const menu2Id = this.value;
                    const menu3Select = document.querySelector(`.menu3-select[data-row-id="${rowId}"]`);
                    const applyBtn = document.querySelector(`.apply-btn[data-row-id="${rowId}"]`);

                    if (!menu2Id) {
                        menu3Select.disabled = true;
                        menu3Select.innerHTML = '<option value="">ابتدا منو سطح 2 را انتخاب کنید</option>';
                        applyBtn.disabled = true;
                        return;
                    }

                    // بارگذاری منوهای 3
                    menu3Select.disabled = false;
                    menu3Select.innerHTML = '<option value="">در حال بارگذاری...</option>';
                    applyBtn.disabled = true;

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
                                // چون منوی 3 جدید انتخاب نشده، دکمه اپلای غیرفعال بمونه
                                applyBtn.disabled = true;
                            } else {
                                menu3Select.innerHTML = '<option value="">هیچ منوی سطح 3 یافت نشد</option>';
                                menu3Select.disabled = true;
                                applyBtn.disabled = true;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            menu3Select.innerHTML = '<option value="">خطا در بارگذاری</option>';
                            menu3Select.disabled = true;
                            applyBtn.disabled = true;
                        });
                });
            });

            // ========== فعال شدن دکمه اپلای وقتی منوی 3 انتخاب میشه ==========
            document.querySelectorAll('.menu3-select').forEach(select => {
                select.addEventListener('change', function() {
                    const rowId = this.dataset.rowId;
                    const applyBtn = document.querySelector(`.apply-btn[data-row-id="${rowId}"]`);
                    const selectedValue = this.value;

                    if (selectedValue) {
                        applyBtn.disabled = false;
                    } else {
                        applyBtn.disabled = true;
                    }
                });
            });

            // ========== دکمه اپلای ==========
            document.querySelectorAll('.apply-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const rowId = this.dataset.rowId;
                    const menu3Select = document.querySelector(`.menu3-select[data-row-id="${rowId}"]`);
                    const menu3Id = menu3Select.value;

                    if (!menu3Id) {
                        showNotification('لطفاً یک منو انتخاب کنید', 'error');
                        return;
                    }

                    // غیرفعال کردن دکمه تا پایان درخواست
                    this.disabled = true;
                    this.textContent = 'در حال ذخیره...';

                    fetch('<?= site_url('admin/product-menu3/update') ?>/' + rowId, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'menu3_id=' + menu3Id
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                showNotification(data.message, 'success');
                                menu3Select.style.borderColor = '#10b981';
                                menu3Select.style.borderWidth = '2px';
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(data.message, 'error');
                                this.disabled = false;
                                this.textContent = 'اپلای';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('خطا در ارتباط با سرور', 'error');
                            this.disabled = false;
                            this.textContent = 'اپلای';
                        });
                });
            });

            // ========== دکمه حذف ==========
            let currentDeleteId = null;
            let currentDeleteUrl = null;

            document.querySelectorAll('.delete-menu-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentDeleteId = this.dataset.id;
                    currentDeleteUrl = this.dataset.url;
                    document.getElementById('deleteModal').classList.remove('hidden');
                });
            });

            document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
                document.getElementById('deleteModal').classList.add('hidden');
                currentDeleteId = null;
                currentDeleteUrl = null;
            });

            document.getElementById('confirmDeleteMenuBtn').addEventListener('click', function() {
                if (currentDeleteId && currentDeleteUrl) {
                    fetch(currentDeleteUrl + '/' + currentDeleteId, {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                showNotification(data.message, 'success');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(data.message, 'error');
                            }
                            document.getElementById('deleteModal').classList.add('hidden');
                            currentDeleteId = null;
                            currentDeleteUrl = null;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('خطا در حذف', 'error');
                            document.getElementById('deleteModal').classList.add('hidden');
                        });
                }
            });

            // بستن مودال با کلیک روی پس‌زمینه
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    currentDeleteId = null;
                    currentDeleteUrl = null;
                }
            });
        });
    </script>

<?= $this->endSection() ?>
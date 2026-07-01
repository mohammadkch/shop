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
                                <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت منوهای سطح 3</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">لیست تمام منوهای سطح سوم فروشگاه</p>
                            </div>
                            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                                <a href="<?= site_url('admin/menu3-image') ?>"
                                   class="bg-amber-500 text-white py-2.5 px-4 rounded-lg hover:bg-amber-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="2" y="2" width="20" height="20" rx="2" ry="2" stroke="currentColor" stroke-width="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="2.5" stroke="currentColor" stroke-width="2"></circle>
                                        <polyline points="21 15 16 10 5 21" stroke="currentColor" stroke-width="2"></polyline>
                                    </svg>
                                    مدیریت تصاویر منوی 3
                                </a>
                                <a href="<?= site_url('admin/menu3/create') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow flex items-center">
                                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    افزودن منو جدید
                                </a>
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
                            <?= $this->include('admin/menu3/index_data_table') ?>
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
                    <p class="text-gray-600 dark:text-gray-400 mb-6">آیا از حذف این منو اطمینان دارید؟</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menu1Select = document.getElementById('menu_1_id');
            const menu2Select = document.getElementById('menu_2_id');

            if (menu1Select && menu2Select) {
                function getMenu1Name(menu1Id) {
                    const option = menu1Select.querySelector(`option[value="${menu1Id}"]`);
                    return option ? option.textContent : '';
                }

                function loadMenu2(menu1Id) {
                    let url;
                    if (!menu1Id) {
                        url = 'http://127.0.0.1/shop/public/admin/menu3/getAllMenu2';
                    } else {
                        url = 'http://127.0.0.1/shop/public/admin/menu3/getMenu2ByMenu1/' + menu1Id;
                    }

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            menu2Select.innerHTML = '';

                            // ساخت آپشن اول (با یا بدون آیکون)
                            if (menu1Id) {
                                const menu1Name = getMenu1Name(menu1Id);
                                const firstOption = document.createElement('option');
                                firstOption.value = '';
                                firstOption.textContent = `📁 [${menu1Name}] ➡ همه منوهای سطح 2`;
                                menu2Select.appendChild(firstOption);
                            } else {
                                const firstOption = document.createElement('option');
                                firstOption.value = '';
                                firstOption.textContent = 'همه منوهای سطح 2';
                                menu2Select.appendChild(firstOption);
                            }

                            // اضافه کردن بقیه آپشن‌ها - فقط اونایی که id دارند و خالی نیستن
                            if (data.status === 'success' && data.options && data.options.length > 0) {
                                data.options.forEach(option => {
                                    // رد کردن option های خالی (value خالی یا id خالی)
                                    if (option.id && option.id !== '' && option.value !== '') {
                                        const optionEl = document.createElement('option');
                                        optionEl.value = option.id;
                                        optionEl.textContent = option.name;
                                        menu2Select.appendChild(optionEl);
                                    }
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                menu1Select.addEventListener('change', function() {
                    loadMenu2(this.value);
                });

                loadMenu2(menu1Select.value);
            }
        });
    </script>

<?= $this->endSection() ?>
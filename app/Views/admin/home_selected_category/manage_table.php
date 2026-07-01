<?php helper('jalali'); ?>

<?php if (isset($rowset) && !empty($rowset)): ?>
    <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
        <table class="w-full text-sm text-right">
            <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 sticky top-0">
            <tr>
                <th class="px-5 py-4">شناسه</th>
                <th class="px-5 py-4">لایه</th>
                <th class="px-5 py-4">نام منو</th>
                <th class="px-5 py-4">ترتیب</th>
                <th class="px-5 py-4">وضعیت</th>
                <th class="px-5 py-4">تاریخ ایجاد</th>
                <th class="px-5 py-4">عملیات</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php foreach ($rowset as $item): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    <td class="px-5 py-4 font-bold text-gray-900 dark:text-white"><?= $item['id'] ?></td>
                    <td class="px-5 py-4">
                        <?php if ($item['level'] == 3): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300">سطح 3</span>
                        <?php elseif ($item['level'] == 2): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">سطح 2</span>
                        <?php elseif ($item['level'] == 1): ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">سطح 1</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">نامشخص</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4">
                        <?php
                        $menuName = '';
                        if (!empty($item['menu_3_id'])) {
                            // سطح 3 - باید نام منو رو از join بیاریم
                            $menuName = $item['menu_3_name'] ?? 'نامشخص';
                        } elseif (!empty($item['menu_2_id'])) {
                            $menuName = $item['menu_2_name'] ?? 'نامشخص';
                        } elseif (!empty($item['menu_1_id'])) {
                            $menuName = $item['menu_1_name'] ?? 'نامشخص';
                        }
                        echo esc($menuName);
                        ?>
                    </td>
                    <td class="px-5 py-4"><?= $item['sort_order'] ?? 0 ?></td>
                    <td class="px-5 py-4">
                        <?php if ($item['is_active'] == 1): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">فعال</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">غیرفعال</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4"><?= jdate('Y/m/d', $item['created_at']) ?></td>
                    <td class="px-5 py-4">
                        <div class="flex space-x-2 rtl:space-x-reverse">
                            <button type="button" class="toggle-active-btn text-blue-600 hover:text-blue-800" data-id="<?= $item['id'] ?>" data-status="<?= $item['is_active'] ?>">
                                <?php if ($item['is_active'] == 1): ?>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                <?php endif; ?>
                            </button>
                            <button type="button" class="delete-btn text-blue-600 hover:text-blue-800" data-id="<?= $item['id'] ?>" data-url="<?= site_url('admin/home-selected-category/delete') ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($pagination) && $pagination): ?>
        <div class="pagination-wrapper mt-4 d-flex justify-content-center">
            <?= $pagination ?>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="alert alert-warning text-center py-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
        <svg class="w-12 h-12 text-yellow-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200">منویی یافت نشد</h5>
        <p class="text-gray-600 dark:text-gray-400">هیچ منوی منتخبی با جستجوی شما مطابقت ندارد</p>
    </div>
<?php endif; ?>
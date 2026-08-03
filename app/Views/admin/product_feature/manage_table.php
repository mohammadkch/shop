<?php if (!empty($features)): ?>
    <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
        <table class="w-full text-sm text-right">
            <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300">
            <tr>
                <th class="px-5 py-4">عنوان ویژگی</th>
                <th class="px-5 py-4">مقدار ویژگی</th>
                <th class="px-5 py-4">ترتیب نمایش</th>
                <th class="px-5 py-4">وضعیت</th>
                <th class="px-5 py-4">عملیات</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php foreach ($features as $feature): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    <td class="px-5 py-4 font-bold text-gray-900 dark:text-white"><?= esc($feature['feature_key']) ?></td>
                    <td class="px-5 py-4 text-gray-700 dark:text-gray-300 whitespace-pre-line"><?= esc($feature['feature_value']) ?></td>
                    <td class="px-5 py-4"><?= (int) $feature['sort_order'] ?></td>
                    <td class="px-5 py-4">
                        <?php if ((int) $feature['is_active'] === 1): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">فعال</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">غیرفعال</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <a href="<?= site_url(ADMIN_PATH . '/product-feature/manage/' . $product['id']) ?>?edit=<?= (int) $feature['id'] ?>"
                               class="text-primary hover:text-primary-800" title="ویرایش فیچر" aria-label="ویرایش فیچر">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            <form method="post" action="<?= site_url(ADMIN_PATH . '/product-feature/toggle-active/' . $product['id'] . '/' . $feature['id']) ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-blue-600 hover:text-blue-800"
                                        title="<?= (int) $feature['is_active'] === 1 ? 'غیرفعال‌کردن فیچر' : 'فعال‌کردن فیچر' ?>"
                                        aria-label="<?= (int) $feature['is_active'] === 1 ? 'غیرفعال‌کردن فیچر' : 'فعال‌کردن فیچر' ?>">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <?php if ((int) $feature['is_active'] === 1): ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        <?php else: ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        <?php endif; ?>
                                    </svg>
                                </button>
                            </form>

                            <form method="post" action="<?= site_url(ADMIN_PATH . '/product-feature/delete/' . $product['id'] . '/' . $feature['id']) ?>"
                                  onsubmit="return confirm('این فیچر حذف شود؟');">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-red-600 hover:text-red-800" title="حذف فیچر" aria-label="حذف فیچر">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="text-center py-10 bg-gray-50 dark:bg-gray-800/40 rounded-xl">
        <p class="text-gray-600 dark:text-gray-400">هنوز فیچری برای این محصول ثبت نشده است.</p>
    </div>
<?php endif; ?>

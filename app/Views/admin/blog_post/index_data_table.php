<?php helper('jalali'); ?>
<?php if (!empty($rowset)): ?>
<div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
    <table class="w-full text-sm text-right">
        <thead class="text-xs bg-gray-100 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 sticky top-0">
        <tr>
            <th class="px-5 py-4">تصویر</th><th class="px-5 py-4">عنوان</th><th class="px-5 py-4">دسته</th>
            <th class="px-5 py-4">نویسنده</th><th class="px-5 py-4">وضعیت</th><th class="px-5 py-4">بازدید</th>
            <th class="px-5 py-4">انتشار</th><th class="px-5 py-4">عملیات</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
        <?php foreach ($rowset as $item): ?>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                <td class="px-5 py-4">
                    <?php if ($item['featured_image']): ?>
                        <img src="<?= base_url('images/' . $item['featured_image']) ?>" class="w-16 h-12 rounded-lg object-cover" alt="">
                    <?php else: ?><span class="text-gray-400">—</span><?php endif; ?>
                </td>
                <td class="px-5 py-4 font-bold max-w-64"><?= esc($item['title']) ?></td>
                <td class="px-5 py-4"><?= esc($item['category_name']) ?></td>
                <td class="px-5 py-4"><?= esc($item['author_name']) ?></td>
                <td class="px-5 py-4">
                    <?php
                    $colors = ['draft'=>'bg-gray-100 text-gray-700','published'=>'bg-green-100 text-green-700','scheduled'=>'bg-blue-100 text-blue-700','archived'=>'bg-amber-100 text-amber-700'];
                    ?>
                    <span class="px-2.5 py-1 rounded-full text-xs <?= $colors[$item['status']] ?>"><?= $statuses[$item['status']] ?></span>
                </td>
                <td class="px-5 py-4"><?= number_format($item['view_count']) ?></td>
                <td class="px-5 py-4"><?= $item['published_at'] ? jdate('Y/m/d H:i', $item['published_at']) : '—' ?></td>
                <td class="px-5 py-4">
                    <div class="flex space-x-2 rtl:space-x-reverse">
                        <a href="<?= site_url(ADMIN_PATH . '/blog-post/edit/' . $item['id']) ?>"
                           class="text-primary hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300"
                           title="ویرایش مقاله">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <button type="button"
                                class="text-blue-600 hover:text-blue-800"
                                data-toggle="<?= site_url(ADMIN_PATH . '/blog-post/toggle-status/' . $item['id']) ?>"
                                title="<?= $item['status'] === 'published' ? 'تبدیل به پیش‌نویس' : 'انتشار مقاله' ?>">
                            <?php if ($item['status'] === 'published'): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            <?php else: ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            <?php endif; ?>
                        </button>
                        <button type="button"
                                class="text-red-600 hover:text-red-800"
                                data-delete="<?= site_url(ADMIN_PATH . '/blog-post/delete/' . $item['id']) ?>"
                                title="حذف مقاله">
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
<?php if ($pagination): ?><div class="pagination-wrapper mt-4"><?= $pagination ?></div><?php endif; ?>
<?php else: ?>
<div class="bg-yellow-50 text-yellow-800 text-center rounded-xl p-8">مقاله‌ای یافت نشد.</div>
<?php endif; ?>

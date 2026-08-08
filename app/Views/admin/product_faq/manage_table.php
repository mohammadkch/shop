<?php if (!empty($faqs)): ?>
    <div class="space-y-3">
        <?php $lastIndex = count($faqs) - 1; ?>
        <?php foreach ($faqs as $index => $faq): ?>
            <article class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="min-w-0">
                        <h3 class="font-bold text-gray-900 dark:text-white leading-7"><?= esc($faq['question']) ?></h3>
                        <p class="mt-2 text-sm leading-7 text-gray-600 dark:text-gray-300 whitespace-pre-line"><?= esc($faq['answer']) ?></p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <form method="post" action="<?= site_url(ADMIN_PATH . '/product-faq/move/' . $product['id'] . '/' . $faq['id'] . '/up') ?>">
                            <?= csrf_field() ?>
                            <button type="submit" <?= $index === 0 ? 'disabled' : '' ?>
                                    class="inline-flex size-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed"
                                    title="انتقال به بالا" aria-label="انتقال به بالا">↑</button>
                        </form>
                        <form method="post" action="<?= site_url(ADMIN_PATH . '/product-faq/move/' . $product['id'] . '/' . $faq['id'] . '/down') ?>">
                            <?= csrf_field() ?>
                            <button type="submit" <?= $index === $lastIndex ? 'disabled' : '' ?>
                                    class="inline-flex size-9 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed"
                                    title="انتقال به پایین" aria-label="انتقال به پایین">↓</button>
                        </form>
                        <a href="<?= site_url(ADMIN_PATH . '/product-faq/manage/' . $product['id']) ?>?edit=<?= (int) $faq['id'] ?>"
                           class="inline-flex size-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/20"
                           title="ویرایش سؤال" aria-label="ویرایش سؤال">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form method="post" action="<?= site_url(ADMIN_PATH . '/product-faq/delete/' . $product['id'] . '/' . $faq['id']) ?>" onsubmit="return confirm('این سؤال حذف شود؟');">
                            <?= csrf_field() ?>
                            <button type="submit" class="inline-flex size-9 items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/20" title="حذف سؤال" aria-label="حذف سؤال">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="text-center py-10 bg-gray-50 dark:bg-gray-800/40 rounded-xl">
        <p class="text-gray-600 dark:text-gray-400">هنوز سؤالی برای این محصول ثبت نشده است.</p>
    </div>
<?php endif; ?>

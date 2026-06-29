<?php if (isset($pager) && $pager->getPageCount() > 1): ?>
    <nav class="flex flex-wrap justify-center my-6 bg-white dark:bg-custom-dark border border-gray-200 dark:border-gray-700 shadow-sm py-4 rounded-xl items-center gap-2 px-4" aria-label="Pagination">

        <!-- Previous -->
        <?php if ($pager->hasPreviousPage()): ?>
            <a href="<?= $pager->getPreviousPage() ?>" class="pagination-link flex items-center gap-1.5 px-3.5 py-2.5 text-sm rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                قبلی
            </a>
        <?php else: ?>
            <span class="flex items-center gap-1.5 px-3.5 py-2.5 text-sm rounded-lg text-gray-400 dark:text-gray-600 cursor-not-allowed">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            قبلی
        </span>
        <?php endif; ?>

        <!-- Pages -->
        <div class="flex items-center gap-2">
            <?php foreach ($pager->links() as $link): ?>
                <?php if ($link['active']): ?>
                    <span class="flex items-center justify-center px-4 py-2.5 rounded-lg text-sm bg-primary text-white shadow-sm dark:bg-primary/80 dark:text-white">
                    <?= $link['title'] ?>
                </span>
                <?php else: ?>
                    <a href="<?= $link['uri'] ?>" class="pagination-link flex items-center justify-center px-4 py-2.5 rounded-lg text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-white/10 transition">
                        <?= $link['title'] ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Next -->
        <?php if ($pager->hasNextPage()): ?>
            <a href="<?= $pager->getNextPage() ?>" class="pagination-link flex items-center gap-1.5 px-3.5 py-2.5 text-sm rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10">
                بعدی
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
        <?php else: ?>
            <span class="flex items-center gap-1.5 px-3.5 py-2.5 text-sm rounded-lg text-gray-400 dark:text-gray-600 cursor-not-allowed">
            بعدی
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </span>
        <?php endif; ?>

    </nav>
<?php endif; ?>
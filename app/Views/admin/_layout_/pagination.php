<?php $pager->setSurroundCount(2) ?>

<ul class="flex justify-center items-center gap-2 list-none p-0 mt-5">
    <?php if ($pager->hasPreviousPage()) : ?>
        <li>
            <a href="<?= $pager->getFirst() ?>" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition" onclick="showPage(this.href); return false;">
                اولین
            </a>
        </li>
        <li>
            <a href="<?= $pager->getPreviousPage() ?>" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition" onclick="showPage(this.href); return false;">
                قبلی
            </a>
        </li>
    <?php else: ?>
        <li>
            <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 dark:border-gray-600">اولین</span>
        </li>
        <li>
            <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 dark:border-gray-600">قبلی</span>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
        <li>
            <a href="<?= $link['uri'] ?>" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition <?= $link['active'] ? 'bg-primary text-white border-primary' : '' ?>" onclick="showPage(this.href); return false;">
                <?= $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNextPage()) : ?>
        <li>
            <a href="<?= $pager->getNextPage() ?>" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition" onclick="showPage(this.href); return false;">
                بعدی
            </a>
        </li>
        <li>
            <a href="<?= $pager->getLast() ?>" class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700 transition" onclick="showPage(this.href); return false;">
                آخرین
            </a>
        </li>
    <?php else: ?>
        <li>
            <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 dark:border-gray-600">بعدی</span>
        </li>
        <li>
            <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 dark:border-gray-600">آخرین</span>
        </li>
    <?php endif ?>
</ul>
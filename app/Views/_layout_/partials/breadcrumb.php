<?php if (!empty($breadcrumb) && is_array($breadcrumb)): ?>
    <nav class="w-full py-3" aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center text-sm font-medium text-gray-700 dark:text-gray-400">
            <!-- خانه -->
            <li>
                <a href="<?= site_url() ?>" class="flex items-center hover:text-primary transition-colors">
                    <svg class="w-4 h-4 ms-1 me-2 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    فروشگاه
                </a>
            </li>

            <?php foreach ($breadcrumb as $index => $crumb): ?>
                <!-- جداکننده -->
                <li class="flex items-center mx-2 text-gray-400">
                    <svg class="w-3 h-3 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                </li>

                <!-- آیتم -->
                <li <?= ($crumb['is_last'] ?? false) ? 'aria-current="page"' : '' ?>>
                    <?php if ($crumb['is_last'] ?? false): ?>
                        <span class="truncate max-w-[200px] sm:max-w-[300px] md:max-w-none text-gray-500 dark:text-gray-400">
                            <?= esc($crumb['name']) ?>
                        </span>
                    <?php elseif (!empty($crumb['full_slug'])): ?>
                        <a href="<?= site_url('category/' . $crumb['full_slug']) ?>" class="hover:text-primary transition-colors">
                            <?= esc($crumb['name']) ?>
                        </a>
                    <?php else: ?>
                        <span class="text-gray-500 dark:text-gray-400"><?= esc($crumb['name']) ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </nav>
<?php endif; ?>
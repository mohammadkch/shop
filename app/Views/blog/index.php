<?= $this->extend('_layout_/layout') ?>
<?= $this->section('content') ?>
<?php helper('jalali'); ?>
<main class="container py-10">
    <nav class="mb-8 text-sm text-gray-500 dark:text-gray-400" aria-label="breadcrumb">
        <a href="<?= site_url() ?>" class="hover:text-primary transition">خانه</a>
        <span class="mx-2">/</span>
        <span>بلاگ</span>
    </nav>
    <header class="flex flex-wrap mb-8 justify-between items-center">
        <h1 class="font-bold text-lg mb-4 relative pb-4 text-gray-900 dark:text-gray-200
            before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary
            after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
            آخرین مطالب مجله مد و پوشاک
        </h1>
    </header>
    <?php if ($posts): ?>
        <div class="grid xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-4">
            <?php foreach ($posts as $post): ?>
                <article>
                    <a href="<?= site_url('blog/' . $post['slug']) ?>" class="block group">
                        <div class="bg-white dark:bg-custom-dark border border-gray-200 dark:border-neutral-700
                                    space-y-4 p-4 rounded-2xl transition-all duration-300
                                    hover:shadow-lg hover:scale-[1.02] hover:bg-gray-50 dark:hover:bg-[#13171c]">
                            <figure class="overflow-hidden rounded-xl">
                                <img src="<?= $post['featured_image'] ? base_url('images/' . $post['featured_image']) : base_url('assets/images/blog/blog-1.jpg') ?>"
                                     alt="<?= esc($post['featured_image_alt'] ?: $post['title']) ?>"
                                     class="h-40 w-full object-cover rounded-xl transition-transform duration-300 group-hover:scale-105"
                                     loading="lazy">
                            </figure>
                            <h2 class="font-bold text-gray-900 dark:text-gray-100 text-base h-12 leading-6 line-clamp-2">
                                <?= esc($post['title']) ?>
                            </h2>
                            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                                <time class="text-sm" datetime="<?= date(DATE_ATOM, $post['published_at']) ?>">
                                    <?= jdate('Y/m/d', $post['published_at']) ?>
                                </time>
                                <div class="flex items-center gap-1 transition-colors duration-200 group-hover:text-primary dark:group-hover:text-primary-400">
                                    <span class="text-sm">ادامه مطلب</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
        <?php if ($pagination): ?><div class="mt-6"><?= $pagination ?></div><?php endif; ?>
    <?php else: ?>
        <div class="bg-white dark:bg-custom-dark rounded-2xl p-12 text-center text-gray-500">هنوز مقاله‌ای منتشر نشده است.</div>
    <?php endif; ?>
</main>
<?= $this->endSection() ?>

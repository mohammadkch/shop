<section class="bg-white dark:bg-custom-dark rounded-2xl shadow-box p-5">
    <h2 class="text-lg font-black border-r-4 border-primary pr-3 mb-5"><?= esc($heading) ?></h2>
    <?php if ($posts): ?><div class="space-y-4">
        <?php foreach ($posts as $sidePost): ?>
            <article class="flex gap-3 items-center">
                <a href="<?= site_url('blog/'.$sidePost['slug']) ?>" class="shrink-0">
                    <img src="<?= $sidePost['featured_image'] ? base_url('images/'.$sidePost['featured_image']) : base_url('assets/images/blog/blog-1.jpg') ?>"
                         alt="<?= esc($sidePost['featured_image_alt'] ?: $sidePost['title']) ?>" class="w-24 h-20 object-cover rounded-xl" loading="lazy">
                </a>
                <div><h3 class="text-sm font-bold leading-6 line-clamp-2"><a href="<?= site_url('blog/'.$sidePost['slug']) ?>" class="hover:text-primary"><?= esc($sidePost['title']) ?></a></h3><span class="text-xs text-gray-500 mt-1 block"><?= number_format($sidePost['view_count']) ?> بازدید</span></div>
            </article>
        <?php endforeach; ?>
    </div><?php else: ?><p class="text-sm text-gray-500">مقاله دیگری موجود نیست.</p><?php endif; ?>
</section>

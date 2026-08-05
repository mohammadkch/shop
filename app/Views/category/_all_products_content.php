<div class="container mt-8">
    <div class="bg-white dark:bg-custom-dark dark:border-gray-700 rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-8 space-y-9">
        <?php foreach ($contentBlocks as $block): ?>
            <section>
                <?php if (in_array($block['type'], ['text', 'text_image'], true) && !empty($block['content'])): ?>
                    <div class="category-page-content text-neutral-700 dark:text-gray-200">
                        <?= $block['content'] ?>
                    </div>
                <?php endif; ?>

                <?php if (in_array($block['type'], ['image', 'text_image'], true) && !empty($block['image'])): ?>
                    <figure class="<?= $block['type'] === 'text_image' ? 'mt-7' : '' ?> text-center">
                        <img src="<?= base_url('images/' . $block['image']) ?>"
                             alt="<?= esc($block['image_alt'] ?: $pageHeading) ?>"
                             class="mx-auto max-w-full rounded-2xl"
                             loading="lazy">
                        <?php if (!empty($block['caption'])): ?>
                            <figcaption class="text-sm text-gray-500 dark:text-gray-400 mt-3"><?= esc($block['caption']) ?></figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
</div>

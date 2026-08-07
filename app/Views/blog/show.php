<?= $this->extend('_layout_/layout') ?>
<?= $this->section('styles') ?>
<style>
.blog-article{min-width:0}.article-content{font-size:1.05rem;line-height:2.25;overflow-wrap:anywhere}.article-content h2{font-size:1.65rem;font-weight:900;margin:2rem 0 .8rem}.article-content h3{font-size:1.35rem;font-weight:800;margin:1.7rem 0 .7rem}.article-content h4{font-size:1.15rem;font-weight:800;margin:1.4rem 0 .6rem}.article-content p{margin:.8rem 0}.article-content ul{list-style:disc;padding-right:1.5rem}.article-content ol{list-style:decimal;padding-right:1.5rem}.article-content blockquote{border-right:4px solid #6366f1;padding:1rem 1.25rem;margin:1.5rem 0;background:rgba(99,102,241,.07);border-radius:.6rem}.article-content a{color:#4f46e5;text-decoration:underline}.article-content .ql-align-center{text-align:center}.article-content .ql-align-justify{text-align:justify}.article-content .ql-align-left{text-align:left}.dark .article-content h2,.dark .article-content h3,.dark .article-content h4{color:#fff}.dark .article-content h2{border-bottom-color:rgba(148,163,184,.18)}.dark .article-content a{color:#a5b4fc}.dark .article-content blockquote{color:#d1d5db;background:rgba(99,102,241,.12);border-right-color:#818cf8}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php helper('jalali'); ?>
<main class="container py-8 md:py-12">
    <nav class="text-sm text-gray-500 mb-7" aria-label="breadcrumb"><a href="<?= site_url() ?>">خانه</a> / <a href="<?= site_url('blog') ?>">بلاگ</a> / <span><?= esc($post['title']) ?></span></nav>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        <article class="blog-article lg:col-span-3 bg-white dark:bg-custom-dark rounded-2xl shadow-box overflow-hidden">
            <header class="p-6 md:p-9">
                <span class="inline-flex bg-primary/10 text-primary px-3 py-1 rounded-full text-sm"><?= esc($post['category_name']) ?></span>
                <h1 class="text-2xl md:text-4xl font-black leading-relaxed mt-4"><?= esc($post['title']) ?></h1>
                <div class="flex flex-wrap gap-4 text-sm text-gray-500 mt-5">
                    <span>نویسنده: <?= esc($post['author_name']) ?></span>
                    <time datetime="<?= date(DATE_ATOM, $post['published_at']) ?>"><?= jdate('Y/m/d', $post['published_at']) ?></time>
                    <span><?= number_format($post['view_count']) ?> بازدید</span>
                </div>
                <p class="text-gray-600 dark:text-gray-300 leading-8 mt-5"><?= esc($post['excerpt']) ?></p>
            </header>
            <?php if ($post['featured_image']): ?>
                <figure class="px-6 md:px-9"><img src="<?= base_url('images/' . $post['featured_image']) ?>" alt="<?= esc($post['featured_image_alt'] ?: $post['title']) ?>" class="w-full max-h-[520px] object-cover rounded-2xl"></figure>
            <?php endif; ?>
            <div class="p-6 md:p-9 space-y-8">
                <?php foreach ($blocks as $block): ?>
                    <section class="article-block">
                        <?php if (in_array($block['type'], ['text','text_image'], true)): ?>
                            <div class="article-content text-neutral-700 dark:text-gray-300"><?= $block['content'] ?></div>
                        <?php endif; ?>
                        <?php if (in_array($block['type'], ['image','text_image'], true) && $block['image']): ?>
                            <figure class="<?= $block['type']==='text_image' ? 'mt-7' : '' ?> text-center">
                                <img src="<?= base_url('images/' . $block['image']) ?>" alt="<?= esc($block['image_alt'] ?: $post['title']) ?>" class="mx-auto max-w-full rounded-2xl" loading="lazy">
                                <?php if ($block['caption']): ?><figcaption class="text-sm text-gray-500 mt-3"><?= esc($block['caption']) ?></figcaption><?php endif; ?>
                            </figure>
                        <?php endif; ?>
                    </section>
                <?php endforeach; ?>
            </div>
        </article>
        <aside class="space-y-6 lg:sticky lg:top-28">
            <?= view('blog/_sidebar_list', ['heading'=>'پربازدیدترین مقاله‌ها','posts'=>$popularPosts]) ?>
            <?= view('blog/_sidebar_list', ['heading'=>'آخرین مقاله‌ها','posts'=>$latestPosts]) ?>
        </aside>
    </div>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context'=>'https://schema.org','@type'=>'Article','headline'=>$post['title'],
    'description'=>$post['meta_description'] ?: $post['excerpt'],
    'image'=>$post['featured_image'] ? base_url('images/'.$post['featured_image']) : null,
    'datePublished'=>date(DATE_ATOM,$post['published_at']),'dateModified'=>date(DATE_ATOM,$post['updated_at']),
    'author'=>['@type'=>'Person','name'=>$post['author_name']],
    'mainEntityOfPage'=>site_url('blog/'.$post['slug'])
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>
<?= $this->endSection() ?>

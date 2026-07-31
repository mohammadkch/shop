<?= $this->extend('admin/_layout_/layout') ?>
<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/js/plugin/quill/quill.snow.css') ?>">
<style>
.blog-editor{min-height:190px;background:#fff;color:#111;direction:rtl;text-align:right}.ql-toolbar.ql-snow{direction:rtl}.ql-editor{font-size:15px;line-height:2}.block-card.dragging{opacity:.45}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php
$old = static fn($key, $default = '') => set_value($key, $edit_row[$key] ?? $default);
$publishedValue = $edit_row && $edit_row['published_at'] ? date('Y-m-d\TH:i', $edit_row['published_at']) : '';
$labelClass = 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2';
$inputClass = 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white';
$fileClass = 'w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100';
?>
<section class="py-5">
<div class="container"><div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
<?= $this->include('admin/_layout_/layout_sidebar') ?>
<div class="lg:col-span-3">
<form id="blogForm" action="<?= site_url($form_action) ?>" method="post" enctype="multipart/form-data">
    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="font-black text-2xl with-highlight dark:text-gray-200"><?= $edit_row ? 'ویرایش مقاله' : 'افزودن مقاله جدید' ?></h1>
            <div class="mt-4 md:mt-0">
                <a href="<?= site_url(ADMIN_PATH . '/blog-post') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition duration-200 shadow-sm hover:shadow inline-block">بازگشت به لیست</a>
            </div>
        </div>
        <?php if (!empty($validation_errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6"><ul class="mb-0"><?php foreach ($validation_errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-7">
            <label class="block md:col-span-2"><span class="<?= $labelClass ?>">عنوان مقاله *</span><input name="title" value="<?= esc($old('title'), 'attr') ?>" class="<?= $inputClass ?>" required></label>
            <label class="block"><span class="<?= $labelClass ?>">slug</span><input name="slug" dir="ltr" value="<?= esc($old('slug'), 'attr') ?>" placeholder="خالی بگذارید خودکار می‌شود" class="<?= $inputClass ?>"></label>
            <label class="block"><span class="<?= $labelClass ?>">دسته‌بندی *</span><select name="blog_category_id" class="<?= $inputClass ?>" required><?php foreach ($categories as $category): ?><option value="<?= $category['id'] ?>" <?= (string)$old('blog_category_id') === (string)$category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option><?php endforeach; ?></select></label>
            <label class="block"><span class="<?= $labelClass ?>">نویسنده *</span><select name="user_id" class="<?= $inputClass ?>" required><?php foreach ($users as $user): ?><option value="<?= $user['id'] ?>" <?= (string)$old('user_id', session('userID')) === (string)$user['id'] ? 'selected' : '' ?>><?= esc($user['full_name']) ?></option><?php endforeach; ?></select></label>
            <label class="block"><span class="<?= $labelClass ?>">وضعیت *</span><select name="status" class="<?= $inputClass ?>"><?php foreach ($statuses as $value=>$label): ?><option value="<?= $value ?>" <?= $old('status','draft')===$value?'selected':'' ?>><?= $label ?></option><?php endforeach; ?></select></label>
            <label class="block"><span class="<?= $labelClass ?>">زمان انتشار</span><input type="datetime-local" name="published_at" value="<?= esc(set_value('published_at', $publishedValue), 'attr') ?>" class="<?= $inputClass ?>"></label>
            <label class="block"><span class="<?= $labelClass ?>">تصویر شاخص <?= $edit_row ? '(اختیاری)' : '' ?></span><input type="file" name="featured_image" accept=".jpg,.jpeg,.png,.webp" class="<?= $fileClass ?>"></label>
            <label class="block md:col-span-2"><span class="<?= $labelClass ?>">متن جایگزین تصویر شاخص</span><input name="featured_image_alt" value="<?= esc($old('featured_image_alt'), 'attr') ?>" class="<?= $inputClass ?>"></label>
            <?php if (!empty($edit_row['featured_image'])): ?><img src="<?= base_url('images/'.$edit_row['featured_image']) ?>" class="w-40 h-28 object-cover rounded-xl"><?php endif; ?>
            <label class="block md:col-span-2"><span class="<?= $labelClass ?>">خلاصه مقاله *</span><textarea name="excerpt" rows="4" maxlength="1000" class="<?= $inputClass ?>" required><?= esc($old('excerpt')) ?></textarea></label>
        </div>
    </div>

    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700 mt-7">
        <div class="flex flex-wrap justify-between items-center gap-3 mb-5">
            <div><h2 class="font-black text-xl with-highlight dark:text-gray-200">بلاک‌های محتوا</h2><p class="text-gray-500 text-sm mt-1">با دکمه‌های بالا و پایین، ترتیب نمایش را تغییر دهید.</p></div>
            <div class="flex flex-wrap gap-2">
                <button type="button" data-add="text" class="bg-primary text-white px-3 py-2 rounded-lg">+ متن</button>
                <button type="button" data-add="image" class="bg-blue-600 text-white px-3 py-2 rounded-lg">+ تصویر</button>
                <button type="button" data-add="text_image" class="bg-purple-600 text-white px-3 py-2 rounded-lg">+ متن و تصویر</button>
            </div>
        </div>
        <div id="blocks" class="space-y-5"></div>
        <div id="emptyBlocks" class="border-2 border-dashed rounded-xl p-8 text-center text-gray-500">هنوز بلاکی اضافه نشده است.</div>
    </div>

    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700 mt-7">
        <h2 class="font-black text-xl with-highlight dark:text-gray-200 mb-5">تنظیمات SEO</h2>
        <div class="space-y-7">
            <label class="block"><span class="<?= $labelClass ?>">Meta title</span><input name="meta_title" maxlength="255" value="<?= esc($old('meta_title'), 'attr') ?>" class="<?= $inputClass ?>"></label>
            <label class="block"><span class="<?= $labelClass ?>">Meta description</span><textarea name="meta_description" maxlength="320" rows="3" class="<?= $inputClass ?>"><?= esc($old('meta_description')) ?></textarea></label>
            <label class="block"><span class="<?= $labelClass ?>">Canonical URL (اختیاری)</span><input name="canonical_url" dir="ltr" value="<?= esc($old('canonical_url'), 'attr') ?>" class="<?= $inputClass ?>"></label>
        </div>
    </div>
    <div class="mt-6 flex gap-3"><button class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition"><?= $edit_row ? 'بروزرسانی' : 'ذخیره' ?></button><a href="<?= site_url(ADMIN_PATH . '/blog-post') ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a></div>
</form>
</div></div></div>
</section>
<template id="blockTemplate">
<div class="block-card border border-gray-200 dark:border-gray-700 rounded-xl p-4" draggable="true">
    <input type="hidden" name="block_id[]" value=""><input type="hidden" name="block_type[]" value="">
    <div class="flex justify-between items-center mb-4"><strong class="block-title"></strong><div class="flex gap-2"><button type="button" data-move="up" class="px-2 py-1 bg-gray-100 rounded">↑</button><button type="button" data-move="down" class="px-2 py-1 bg-gray-100 rounded">↓</button><button type="button" data-remove class="px-3 py-1 bg-red-100 text-red-700 rounded">حذف</button></div></div>
    <div class="text-part hidden"><div class="blog-editor"></div><input type="hidden" name="block_content[]" class="content-input"></div>
    <div class="image-part hidden grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-6">
        <label><span class="<?= $labelClass ?>">تصویر بلاک</span><input type="file" name="block_image[]" accept=".jpg,.jpeg,.png,.webp" class="<?= $fileClass ?>"></label>
        <label><span class="<?= $labelClass ?>">متن جایگزین (Alt)</span><input name="block_image_alt[]" class="alt-input <?= $inputClass ?>"></label>
        <label class="md:col-span-2"><span class="<?= $labelClass ?>">کپشن تصویر</span><input name="block_caption[]" class="caption-input <?= $inputClass ?>"></label>
        <div class="current-image md:col-span-2"></div>
    </div>
</div>
</template>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/plugin/quill/quill.js') ?>"></script>
<script>
(() => {
    const container = document.getElementById('blocks'), empty = document.getElementById('emptyBlocks'), template = document.getElementById('blockTemplate');
    const initial = <?= json_encode(array_map(static fn($b) => [
        'id'=>$b['id'],'type'=>$b['type'],'content'=>$b['content'],'image'=>$b['image'],
        'image_alt'=>$b['image_alt'],'caption'=>$b['caption']
    ], $blocks), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_TAG|JSON_HEX_AMP) ?>;
    const labels = {text:'بلاک متن',image:'بلاک تصویر',text_image:'بلاک متن و تصویر'};
    function refresh(){ empty.classList.toggle('hidden', container.children.length > 0); }
    function addBlock(type, data = {}) {
        const node = template.content.firstElementChild.cloneNode(true);
        node.querySelector('[name="block_id[]"]').value = data.id || '';
        node.querySelector('[name="block_type[]"]').value = type;
        node.querySelector('.block-title').textContent = labels[type];
        if (type !== 'image') {
            node.querySelector('.text-part').classList.remove('hidden');
            const editor = node.querySelector('.blog-editor');
            editor.innerHTML = data.content || '';
            node._quill = new Quill(editor, {theme:'snow', modules:{toolbar:[
                [{header:[2,3,4,false]}],['bold','italic','underline','strike'],[{list:'ordered'},{list:'bullet'}],
                ['blockquote','link'],[{align:[]}],[{direction:'rtl'}],['clean']
            ]}, formats:['header','bold','italic','underline','strike','list','blockquote','link','align','direction']});
            node._quill.format('direction', 'rtl'); node._quill.format('align', 'right');
        }
        if (type !== 'text') {
            node.querySelector('.image-part').classList.remove('hidden');
            node.querySelector('.alt-input').value = data.image_alt || '';
            node.querySelector('.caption-input').value = data.caption || '';
            if (data.image) node.querySelector('.current-image').innerHTML = `<img src="<?= base_url('images/') ?>${data.image}" class="w-48 h-32 rounded-lg object-cover"><small class="block mt-1 text-gray-500">برای نگه‌داشتن همین تصویر، فایل جدید انتخاب نکنید.</small>`;
        }
        container.appendChild(node); refresh();
    }
    document.querySelectorAll('[data-add]').forEach(button => button.addEventListener('click', () => addBlock(button.dataset.add)));
    container.addEventListener('click', e => {
        const card = e.target.closest('.block-card'); if (!card) return;
        if (e.target.closest('[data-remove]')) { if (confirm('این بلاک حذف شود؟')) card.remove(); }
        const move = e.target.closest('[data-move]');
        if (move?.dataset.move === 'up' && card.previousElementSibling) container.insertBefore(card, card.previousElementSibling);
        if (move?.dataset.move === 'down' && card.nextElementSibling) container.insertBefore(card.nextElementSibling, card);
        refresh();
    });
    let dragged;
    container.addEventListener('dragstart', e => { dragged=e.target.closest('.block-card'); dragged?.classList.add('dragging'); });
    container.addEventListener('dragend', () => { dragged?.classList.remove('dragging'); dragged=null; });
    container.addEventListener('dragover', e => { e.preventDefault(); const over=e.target.closest('.block-card'); if(over && dragged && over!==dragged){ const rect=over.getBoundingClientRect(); container.insertBefore(dragged, e.clientY < rect.top+rect.height/2 ? over : over.nextSibling); }});
    document.getElementById('blogForm').addEventListener('submit', e => {
        container.querySelectorAll('.block-card').forEach(card => {
            if (card._quill) card.querySelector('.content-input').value = card._quill.root.innerHTML;
        });
        if (!container.children.length && !confirm('مقاله بدون بلاک محتوا ذخیره شود؟')) e.preventDefault();
    });
    initial.forEach(block => addBlock(block.type, block)); refresh();
})();
</script>
<?= $this->endSection() ?>

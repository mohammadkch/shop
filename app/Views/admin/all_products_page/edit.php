<?= $this->extend('admin/_layout_/layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/js/plugin/quill/quill.snow.css') ?>">
<style>
    .all-products-editor{min-height:180px;background:#fff;color:#111;direction:rtl;text-align:right}.ql-toolbar.ql-snow{direction:rtl}.ql-editor{min-height:180px;font-size:15px;line-height:2}.content-block.is-dragging{opacity:.5}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$page = $page ?? [];
$fieldValue = static fn(string $key, string $default = '') => set_value($key, (string) ($page[$key] ?? $default));
$labelClass = 'block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2';
$inputClass = 'w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white';
$fileClass = 'w-full text-sm text-gray-600 dark:text-gray-300 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100';
?>
<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3">
                <form id="allProductsPageForm" action="<?= site_url(ADMIN_PATH . '/all-products-page') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">
                            <div>
                                <h1 class="font-black text-2xl with-highlight dark:text-gray-200">صفحه همه محصولات</h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">تنظیمات فقط روی آدرس دقیق /category اعمال می‌شود.</p>
                            </div>
                            <a href="<?= site_url('category') ?>" target="_blank" class="inline-flex items-center justify-center bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200 py-2.5 px-4 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition text-sm">
                                مشاهده صفحه
                            </a>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="h1_title" class="<?= $labelClass ?>">عنوان اصلی صفحه (H1) <span class="text-red-500">*</span></label>
                                <input id="h1_title" name="h1_title" maxlength="255" required value="<?= esc($fieldValue('h1_title', 'همه محصولات'), 'attr') ?>" class="<?= $inputClass ?>" placeholder="همه محصولات">
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h2 class="font-bold text-lg text-gray-900 dark:text-gray-200 mb-5">تنظیمات سئو</h2>
                                <div class="space-y-5">
                                    <div>
                                        <label for="meta_title" class="<?= $labelClass ?>">عنوان سئو</label>
                                        <input id="meta_title" name="meta_title" maxlength="255" value="<?= esc($fieldValue('meta_title'), 'attr') ?>" class="<?= $inputClass ?>" placeholder="عنوان نمایش داده‌شده در تب مرورگر">
                                    </div>
                                    <div>
                                        <label for="meta_description" class="<?= $labelClass ?>">Meta Description</label>
                                        <textarea id="meta_description" name="meta_description" maxlength="320" rows="4" class="<?= $inputClass ?>" placeholder="توضیح کوتاه و مناسب نتایج جستجو"><?= esc($fieldValue('meta_description')) ?></textarea>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">حداکثر ۳۲۰ کاراکتر</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700 mt-7">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h2 class="font-black text-xl with-highlight dark:text-gray-200">محتوای پایین محصولات</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">بلاک‌ها بعد از محصولات و صفحه‌بندی نمایش داده می‌شوند.</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" data-add-block="text" class="bg-primary text-white px-4 py-2.5 rounded-lg hover:bg-primary-600 transition text-sm">+ متن</button>
                                <button type="button" data-add-block="image" class="bg-amber-500 text-white px-4 py-2.5 rounded-lg hover:bg-amber-600 transition text-sm">+ تصویر</button>
                                <button type="button" data-add-block="text_image" class="bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition text-sm">+ متن و تصویر</button>
                            </div>
                        </div>

                        <div id="contentBlocks" class="space-y-5"></div>
                        <div id="emptyBlocks" class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-10 text-center text-gray-500 dark:text-gray-400">
                            هنوز محتوایی برای پایین صفحه ثبت نشده است.
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">بروزرسانی</button>
                        <a href="<?= site_url(ADMIN_PATH . '/dashboard') ?>" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<template id="contentBlockTemplate">
    <article class="content-block border border-gray-200 dark:border-gray-700 rounded-xl p-5" draggable="true">
        <input type="hidden" name="block_id[]" value="">
        <input type="hidden" name="block_type[]" value="">

        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div class="flex items-center gap-2">
                <span class="cursor-move text-gray-400" title="جابجایی">⋮⋮</span>
                <strong class="block-label text-gray-900 dark:text-gray-200"></strong>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" data-move="up" class="size-9 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700" title="انتقال به بالا">↑</button>
                <button type="button" data-move="down" class="size-9 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700" title="انتقال به پایین">↓</button>
                <button type="button" data-remove-block class="px-3 h-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-200" title="حذف بلاک">حذف</button>
            </div>
        </div>

        <div class="block-text hidden">
            <label class="<?= $labelClass ?>">متن بلاک</label>
            <div class="all-products-editor"></div>
            <input type="hidden" name="block_content[]" class="block-content-input">
        </div>

        <div class="block-image hidden grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
            <div>
                <label class="<?= $labelClass ?>">تصویر بلاک</label>
                <input type="file" name="block_image[]" accept=".jpg,.jpeg,.png,.webp" class="<?= $fileClass ?>">
                <p class="text-xs text-gray-500 mt-2">JPG، PNG یا WebP تا ۴ مگابایت</p>
            </div>
            <div>
                <label class="<?= $labelClass ?>">متن جایگزین تصویر (Alt)</label>
                <input name="block_image_alt[]" maxlength="255" class="block-alt <?= $inputClass ?>">
            </div>
            <div class="md:col-span-2">
                <label class="<?= $labelClass ?>">کپشن تصویر</label>
                <input name="block_caption[]" maxlength="500" class="block-caption <?= $inputClass ?>">
            </div>
            <div class="current-image md:col-span-2"></div>
        </div>
    </article>
</template>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/plugin/quill/quill.js') ?>"></script>
<script>
(() => {
    const container = document.getElementById('contentBlocks');
    const emptyState = document.getElementById('emptyBlocks');
    const template = document.getElementById('contentBlockTemplate');
    const form = document.getElementById('allProductsPageForm');
    const initialBlocks = <?= json_encode($blocks ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    const labels = {text: 'بلاک متن', image: 'بلاک تصویر', text_image: 'بلاک متن و تصویر'};

    const refreshEmptyState = () => emptyState.classList.toggle('hidden', container.children.length > 0);

    function addBlock(type, data = {}) {
        const block = template.content.firstElementChild.cloneNode(true);
        block.querySelector('[name="block_id[]"]').value = data.id || '';
        block.querySelector('[name="block_type[]"]').value = type;
        block.querySelector('.block-label').textContent = labels[type];

        if (type !== 'image') {
            const textSection = block.querySelector('.block-text');
            const editorElement = block.querySelector('.all-products-editor');
            textSection.classList.remove('hidden');
            editorElement.innerHTML = data.content || '';
            block._quill = new Quill(editorElement, {
                theme: 'snow',
                modules: {toolbar: [
                    [{header: [2, 3, 4, false]}], ['bold', 'italic', 'underline', 'strike'],
                    [{list: 'ordered'}, {list: 'bullet'}], ['blockquote', 'link'],
                    [{align: []}], [{direction: 'rtl'}], ['clean']
                ]},
                formats: ['header', 'bold', 'italic', 'underline', 'strike', 'list', 'blockquote', 'link', 'align', 'direction']
            });
            block._quill.format('direction', 'rtl');
            block._quill.format('align', 'right');
        }

        if (type !== 'text') {
            block.querySelector('.block-image').classList.remove('hidden');
            block.querySelector('.block-alt').value = data.image_alt || '';
            block.querySelector('.block-caption').value = data.caption || '';
            if (data.image) {
                block.querySelector('.current-image').innerHTML = `<div class="inline-block"><img src="<?= base_url('images/') ?>${data.image}" class="w-56 h-36 object-cover rounded-xl border border-gray-200"><small class="block text-gray-500 mt-2">برای حفظ تصویر فعلی، فایل جدید انتخاب نکنید.</small></div>`;
            }
        }

        container.appendChild(block);
        refreshEmptyState();
    }

    document.querySelectorAll('[data-add-block]').forEach(button => {
        button.addEventListener('click', () => addBlock(button.dataset.addBlock));
    });

    container.addEventListener('click', event => {
        const block = event.target.closest('.content-block');
        if (!block) return;
        if (event.target.closest('[data-remove-block]')) {
            if (confirm('این بلاک حذف شود؟')) block.remove();
        }
        const moveButton = event.target.closest('[data-move]');
        if (moveButton?.dataset.move === 'up' && block.previousElementSibling) {
            container.insertBefore(block, block.previousElementSibling);
        }
        if (moveButton?.dataset.move === 'down' && block.nextElementSibling) {
            container.insertBefore(block, block.nextElementSibling.nextElementSibling);
        }
        refreshEmptyState();
    });

    let draggedBlock = null;
    container.addEventListener('dragstart', event => {
        draggedBlock = event.target.closest('.content-block');
        draggedBlock?.classList.add('is-dragging');
    });
    container.addEventListener('dragend', () => {
        draggedBlock?.classList.remove('is-dragging');
        draggedBlock = null;
    });
    container.addEventListener('dragover', event => {
        event.preventDefault();
        const target = event.target.closest('.content-block');
        if (!target || !draggedBlock || target === draggedBlock) return;
        const rect = target.getBoundingClientRect();
        container.insertBefore(draggedBlock, event.clientY < rect.top + rect.height / 2 ? target : target.nextElementSibling);
    });

    form.addEventListener('submit', () => {
        container.querySelectorAll('.content-block').forEach(block => {
            if (!block._quill) return;
            const html = block._quill.root.innerHTML.trim();
            block.querySelector('.block-content-input').value = html === '<p><br></p>' ? '' : html;
        });
    });

    initialBlocks.forEach(block => addBlock(block.type, block));
    refreshEmptyState();
})();
</script>
<?= $this->endSection() ?>

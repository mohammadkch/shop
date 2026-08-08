<?= $this->extend('admin/_layout_/layout') ?>
<?php helper('form'); ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <div>
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">
                                سؤالات متداول محصول - <?= esc($product['name']) ?>
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                سؤال‌ها با دکمه‌های بالا و پایین مرتب می‌شوند.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="<?= site_url(ADMIN_PATH . '/product/edit/' . $product['id']) ?>"
                               class="bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200 py-2.5 px-4 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition text-sm">
                                ویرایش محصول
                            </a>
                            <a href="<?= site_url(ADMIN_PATH . '/product') ?>"
                               class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition text-sm">
                                بازگشت به محصولات
                            </a>
                        </div>
                    </div>

                    <?php if (session()->getFlashdata('product_faq_success')): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                            <?= esc(session()->getFlashdata('product_faq_success')) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('product_faq_error')): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <?= esc(session()->getFlashdata('product_faq_error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $isEditing = !empty($editFaq);
                    $action = $isEditing
                        ? ADMIN_PATH . '/product-faq/update/' . $product['id'] . '/' . $editFaq['id']
                        : ADMIN_PATH . '/product-faq/store/' . $product['id'];
                    ?>
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 mb-8">
                        <h2 class="font-bold text-lg text-gray-900 dark:text-gray-200 mb-4">
                            <?= $isEditing ? 'ویرایش سؤال' : 'افزودن سؤال جدید' ?>
                        </h2>
                        <form method="post" action="<?= site_url($action) ?>">
                            <?= csrf_field() ?>
                            <div class="space-y-4">
                                <div>
                                    <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">سؤال</label>
                                    <input type="text" id="question" name="question" maxlength="500" required
                                           value="<?= esc(old('question', $editFaq['question'] ?? ''), 'attr') ?>"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">پاسخ</label>
                                    <textarea id="answer" name="answer" rows="5" required
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white"><?= esc(old('answer', $editFaq['answer'] ?? '')) ?></textarea>
                                </div>
                            </div>
                            <div class="mt-5 flex flex-wrap gap-3">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-primary-600 transition">
                                    <?= $isEditing ? 'ذخیره تغییرات' : 'افزودن سؤال' ?>
                                </button>
                                <?php if ($isEditing): ?>
                                    <a href="<?= site_url(ADMIN_PATH . '/product-faq/manage/' . $product['id']) ?>"
                                       class="bg-gray-200 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-300 transition">انصراف</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <?= $this->include('admin/product_faq/manage_table') ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->extend('admin/_layout_/layout') ?>
<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
            <?= $this->include('admin/_layout_/layout_sidebar') ?>
            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <div>
                            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت مقالات بلاگ</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">مقاله‌ها، نویسنده، وضعیت انتشار و بلاک‌های محتوا</p>
                        </div>
                        <a href="<?= site_url(ADMIN_PATH . '/blog-post/create') ?>" class="bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary-600 transition shadow-sm flex items-center">
                            افزودن مقاله جدید
                        </a>
                    </div>
                    <form id="searchForm" method="post" action="<?= current_url() ?>" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <input name="title" id="title" class="search-input w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white" placeholder="عنوان مقاله">
                            <select name="status" id="status" class="search-input w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                <option value="">همه وضعیت‌ها</option>
                                <?php foreach ($statuses as $value => $label): ?><option value="<?= $value ?>"><?= $label ?></option><?php endforeach; ?>
                            </select>
                            <select name="blog_category_id" id="blog_category_id" class="search-input w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                <option value="">همه دسته‌ها</option>
                                <?php foreach ($categories as $category): ?><option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option><?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" id="searchBtn" class="bg-primary text-white py-2 px-6 rounded-lg">جستجو</button>
                            <button type="button" id="resetBtn" class="bg-gray-500 text-white py-2 px-6 rounded-lg">ریست</button>
                        </div>
                    </form>
                    <div id="dataTableContainer"><?= $this->include('admin/blog_post/index_data_table') ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
(() => {
    const container = document.getElementById('dataTableContainer');
    const form = document.getElementById('searchForm');
    async function load(page = 1) {
        const data = new FormData(form);
        data.set('page', page);
        const response = await fetch(form.action, {method: 'POST', headers: {'X-Requested-With': 'XMLHttpRequest'}, body: data});
        container.innerHTML = await response.text();
    }
    document.getElementById('searchBtn').addEventListener('click', () => load());
    document.getElementById('resetBtn').addEventListener('click', () => { form.reset(); load(); });
    container.addEventListener('click', async event => {
        const pageLink = event.target.closest('.pagination-wrapper a');
        if (pageLink) {
            event.preventDefault();
            const url = new URL(pageLink.href);
            load(url.searchParams.get('page') || 1);
            return;
        }
        const toggle = event.target.closest('[data-toggle]');
        if (toggle) {
            if (!confirm('وضعیت انتشار مقاله تغییر کند؟')) return;
            const response = await fetch(toggle.dataset.toggle, {method: 'POST', headers: {'X-Requested-With': 'XMLHttpRequest'}});
            const result = await response.json();
            showNotification(result.message, result.status === 'success' ? 'success' : 'error');
            if (result.status === 'success') load();
            return;
        }
        const remove = event.target.closest('[data-delete]');
        if (remove) {
            if (!confirm('مقاله و تمام بلاک‌ها و تصاویر آن حذف شود؟')) return;
            const response = await fetch(remove.dataset.delete, {method: 'DELETE', headers: {'X-Requested-With': 'XMLHttpRequest'}});
            const result = await response.json();
            showNotification(result.message, result.status === 'success' ? 'success' : 'error');
            if (result.status === 'success') load();
        }
    });
})();
</script>
<?= $this->endSection() ?>

<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('customer/_partials/sidebar') ?>

                <div class="lg:col-span-3 space-y-8">

                    <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-soft p-6 border border-gray-100 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">تغییر رمز عبور</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">برای امنیت بیشتر، رمز عبور خود را تغییر دهید</p>
                    </div>

                    <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-soft p-6 border border-gray-100 dark:border-gray-700">
                        <form>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رمز عبور فعلی</label>
                                    <input type="password" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="رمز عبور فعلی را وارد کنید">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رمز عبور جدید</label>
                                    <input type="password" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="رمز عبور جدید را وارد کنید">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تکرار رمز عبور جدید</label>
                                    <input type="password" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="تکرار رمز عبور جدید">
                                </div>
                                <button type="submit" class="bg-primary hover:bg-primary-600 text-white px-6 py-2 rounded-lg transition-colors">
                                    تغییر رمز عبور
                                </button>
                                <span class="text-sm text-gray-400 dark:text-gray-500 mr-3">(قابل توسعه)</span>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
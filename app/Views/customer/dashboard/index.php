<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('customer/_partials/sidebar') ?>

                <div class="lg:col-span-3 space-y-8">
                    <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-soft p-6 border border-gray-100 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">پیشخوان کاربری</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                            خوش آمدید، <?= esc($customer['firstname'] ?? 'کاربر') ?>!
                        </p>
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-primary/10 dark:bg-primary/20 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-primary"><?= number_format($awaitingOrdersCount) ?></div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">سفارش‌های در انتظار</div>
                            </div>
                            <div class="bg-green-500/10 dark:bg-green-500/20 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-green-500"><?= number_format($deliveredOrdersCount) ?></div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">سفارش‌های تحویل‌شده</div>
                            </div>
                            <div class="bg-yellow-500/10 dark:bg-yellow-500/20 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-yellow-500"><?= number_format($wishlistCount) ?></div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">لیست علاقه‌مندی‌ها</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?= $this->endSection() ?>

<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>

<?php
$statusPresentation = [
    'paid' => [
        'label' => 'پرداخت‌شده؛ منتظر بررسی',
        'class' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400',
    ],
    'confirmed' => [
        'label' => 'تأییدشده؛ در حال آماده‌سازی',
        'class' => 'bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400',
    ],
    'paid_stock_issue' => [
        'label' => 'پرداخت‌شده؛ در حال بررسی موجودی',
        'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400',
    ],
];
?>

<section class="py-5">
    <div class="container">
        <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

            <?= $this->include('customer/_partials/sidebar') ?>

            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-soft p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">سفارش‌های من</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                سفارش‌های پرداخت‌شده و وضعیت بررسی آن‌ها را اینجا می‌بینید.
                            </p>
                        </div>
                        <?php if (!empty($orders)): ?>
                            <span class="flex-shrink-0 px-3 py-2 rounded-lg bg-primary/10 text-primary text-sm font-bold">
                                <?= count($orders) ?> سفارش
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($orders)): ?>
                        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-4 text-right font-medium">شماره سفارش</th>
                                    <th class="px-4 py-4 text-right font-medium">تاریخ ثبت</th>
                                    <th class="px-4 py-4 text-center font-medium">تعداد کالا</th>
                                    <th class="px-4 py-4 text-right font-medium">مبلغ نهایی</th>
                                    <th class="px-4 py-4 text-right font-medium">وضعیت</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <?php $status = $statusPresentation[$order['status']] ?? ['label' => $order['status'], 'class' => 'bg-gray-100 text-gray-700']; ?>
                                    <tr class="border-t border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                                        <td class="px-4 py-5 font-bold text-primary">#<?= (int) $order['id'] ?></td>
                                        <td class="px-4 py-5 whitespace-nowrap">
                                            <?= jdate('Y/m/d', (int) $order['created_at']) ?>
                                            <small class="block mt-1 text-gray-400"><?= jdate('H:i', (int) $order['created_at']) ?></small>
                                        </td>
                                        <td class="px-4 py-5 text-center"><?= (int) $order['items_count'] ?></td>
                                        <td class="px-4 py-5 whitespace-nowrap font-bold"><?= number_format((float) $order['total']) ?> تومان</td>
                                        <td class="px-4 py-5 whitespace-nowrap">
                                            <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-medium <?= $status['class'] ?>">
                                                <?= esc($status['label']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="py-12 px-4 text-center rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            <div class="mx-auto size-16 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386a1.5 1.5 0 0 1 1.455 1.136l.383 1.533m0 0L6.75 10.5h10.5l1.5-4.831H5.474ZM6.75 10.5 5.91 13.02A1.5 1.5 0 0 0 7.333 15h9.917m-9 3.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm9 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </div>
                            <h2 class="font-bold text-gray-800 dark:text-gray-200">هنوز سفارشی ثبت نکرده‌اید</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">پس از پرداخت موفق، سفارش شما در این بخش نمایش داده می‌شود.</p>
                            <a href="<?= site_url('category') ?>" class="inline-flex mt-5 px-5 py-2.5 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                                مشاهده محصولات
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->extend('admin/_layout_/layout') ?>
<?= $this->section('content') ?>
<?php
$labels = [
    'awaiting_payment'=>'در انتظار پرداخت','payment_pending'=>'در حال پرداخت','paid'=>'پرداخت‌شده',
    'paid_stock_issue'=>'نیازمند بررسی موجودی','confirmed'=>'تأییدشده','expired'=>'منقضی','cancelled'=>'لغوشده',
];
?>
<section class="py-5"><div class="container"><div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">
<?= $this->include('admin/_layout_/layout_sidebar') ?>
<div class="lg:col-span-3">
    <div class="bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h1 class="font-black text-2xl with-highlight dark:text-gray-200">مدیریت سفارش‌ها</h1>
            <form method="get"><select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-600">
                <option value="">همه وضعیت‌ها</option>
                <?php foreach ($statuses as $status): ?><option value="<?= $status ?>" <?= $selected_status === $status ? 'selected' : '' ?>><?= $labels[$status] ?></option><?php endforeach; ?>
            </select></form>
        </div>
        <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700"><table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800"><tr><th class="px-4 py-3 text-right">فاکتور</th><th class="px-4 py-3 text-right">مشتری</th><th class="px-4 py-3 text-right">مبلغ</th><th class="px-4 py-3 text-right">وضعیت</th><th class="px-4 py-3">عملیات</th></tr></thead>
            <tbody>
            <?php foreach ($orders as $order): ?><tr class="border-t border-gray-100 dark:border-gray-700">
                <td class="px-4 py-4">#<?= (int)$order['id'] ?></td>
                <td class="px-4 py-4"><?= esc(trim($order['firstname'].' '.$order['lastname'])) ?><small class="block text-gray-500 mt-1" dir="ltr"><?= esc($order['mobile']) ?></small></td>
                <td class="px-4 py-4 font-bold"><?= number_format($order['total']) ?> تومان</td>
                <td class="px-4 py-4"><span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800"><?= $labels[$order['status']] ?? esc($order['status']) ?></span></td>
                <td class="px-4 py-4 text-center"><a class="inline-flex bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-2 rounded-lg" href="<?= site_url(ADMIN_PATH.'/order/'.$order['id']) ?>">مشاهده</a></td>
            </tr><?php endforeach; ?>
            <?php if (!$orders): ?><tr><td colspan="5" class="p-8 text-center text-gray-500">سفارشی وجود ندارد.</td></tr><?php endif; ?>
            </tbody>
        </table></div>
    </div>
</div></div></div></section>
<?= $this->endSection() ?>

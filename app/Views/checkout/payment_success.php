<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
<section class="py-10 md:py-16">
    <div class="container">
        <div class="max-w-xl mx-auto overflow-hidden bg-white dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
            <div class="bg-green-600 px-6 py-8 text-center text-white">
                <div class="size-16 mx-auto mb-4 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="size-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black">پرداخت موفق</h1>
                <p class="text-green-100 mt-2"><?= esc($result['message']) ?></p>
            </div>

            <div class="p-6">
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-xl p-4 space-y-3 text-sm">
                    <?php if ($factor): ?>
                        <div class="flex justify-between gap-4"><span class="text-gray-600 dark:text-gray-400">شماره فاکتور</span><strong><?= (int) $factor['id'] ?></strong></div>
                    <?php endif; ?>
                    <?php if (!empty($payment['ref_number'])): ?>
                        <div class="flex justify-between gap-4"><span class="text-gray-600 dark:text-gray-400">شماره مرجع</span><strong dir="ltr"><?= esc($payment['ref_number']) ?></strong></div>
                    <?php endif; ?>
                    <?php if ($payment): ?>
                        <div class="flex justify-between gap-4"><span class="text-gray-600 dark:text-gray-400">مبلغ پرداختی</span><strong><?= number_format($payment['final_amount']) ?> تومان</strong></div>
                    <?php endif; ?>
                    <?php if (!empty($payment['card_number'])): ?>
                        <div class="flex justify-between gap-4"><span class="text-gray-600 dark:text-gray-400">کارت پرداخت‌کننده</span><strong dir="ltr"><?= esc($payment['card_number']) ?></strong></div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($result['needs_review'])): ?>
                    <p class="mt-5 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl text-yellow-700 dark:text-yellow-400 text-sm leading-7">
                        پرداخت شما ثبت شده است؛ برای بررسی موجودی، سفارش توسط پشتیبانی مومو پیگیری می‌شود.
                    </p>
                <?php else: ?>
                    <p class="mt-5 text-sm leading-7 text-gray-600 dark:text-gray-400">پس از بررسی توسط همکاران ما، شما را در جریان فرآیند آماده‌سازی و ارسال قرار می‌دهیم.</p>
                <?php endif; ?>

                <a href="<?= site_url('/') ?>" class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center transition">بازگشت به فروشگاه</a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
<section class="py-10 md:py-16">
    <div class="container">
        <div class="max-w-xl mx-auto overflow-hidden bg-white dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm">
            <div class="bg-red-600 px-6 py-8 text-center text-white">
                <div class="size-16 mx-auto mb-4 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="size-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black">پرداخت ناموفق</h1>
                <p class="text-red-100 mt-2">پرداخت شما کامل نشد</p>
            </div>

            <div class="p-6">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl p-4 text-red-700 dark:text-red-400 text-sm leading-7">
                    <?= esc($result['message'] ?? 'در فرایند پرداخت مشکلی پیش آمد.') ?>
                </div>

                <div class="mt-6 space-y-3">
                    <?php if ($factor && in_array($factor['status'], ['awaiting_payment', 'payment_pending'], true) && (int) $factor['expires_at'] > time()): ?>
                        <a href="<?= site_url('checkout/payment/' . $factor['id']) ?>" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center transition">تلاش مجدد پرداخت</a>
                    <?php endif; ?>
                    <a href="<?= site_url('cart') ?>" class="w-full border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-lg flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">بازگشت به سبد خرید</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

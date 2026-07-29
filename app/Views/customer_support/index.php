<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
    <section class="py-12 md:py-20">
        <div class="container">
            <div class="max-w-2xl mx-auto bg-white dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg overflow-hidden">
                <div class="h-2 bg-primary"></div>
                <div class="p-8 md:p-12 text-center">
                    <div class="size-16 mx-auto mb-6 rounded-full bg-primary-100 dark:bg-primary-900/80 text-primary flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">پشتیبانی مشتریان مومو</h1>
                    <p class="text-gray-600 dark:text-gray-400 leading-8 mb-8">
                        برای راهنمایی پیش از خرید، پیگیری سفارش، ارسال کالا و سایر سوالات خود با پشتیبانی مومو تماس بگیرید.
                    </p>

                    <a href="tel:09102046144"
                       class="inline-flex items-center justify-center bg-primary hover:bg-primary-600 text-white text-xl font-bold rounded-xl px-8 py-4 transition-colors"
                       dir="ltr">
                        09102046144
                    </a>

                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-wrap justify-center gap-6 text-sm">
                        <a href="<?= site_url('faq') ?>" class="text-gray-600 dark:text-gray-300 hover:text-primary">سوالات پرتکرار</a>
                        <a href="<?= site_url('contact') ?>" class="text-gray-600 dark:text-gray-300 hover:text-primary">تماس با ما</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>

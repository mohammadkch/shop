<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
    <section class="py-5">
        <div class="container">

            <!-- Hero -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">درباره فروشگاه مومو</h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-400">از یک کارگاه کوچک در انزلی تا یک فروشگاه اینترنتی پیشرو</p>
            </div>

            <!-- Story -->
            <div class="flex flex-col lg:flex-row items-center gap-12 mb-20">
                <div class="lg:w-1/2">
                    <img src="<?= $mediaPath ?>about/<?= $story['image'] ?>" alt="داستان مومو" class="w-full rounded-2xl shadow-lg">
                </div>
                <div class="lg:w-1/2">
                    <span class="text-primary font-semibold text-sm">داستان ما</span>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 mb-6">از انزلی تا سراسر ایران</h2>
                    <?= $story['text'] ?>
                </div>
            </div>

            <!-- Focus -->
            <div class="flex flex-col lg:flex-row-reverse items-center gap-12 mb-20">
                <div class="lg:w-1/2">
                    <img src="<?= $mediaPath ?>about/<?= $focus['image'] ?>" alt="تمرکز مومو" class="w-full rounded-2xl shadow-lg">
                </div>
                <div class="lg:w-1/2">
                    <span class="text-primary font-semibold text-sm">تمرکز ما</span>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 mb-6">تولید داخلی + واردات با کیفیت</h2>
                    <?= $focus['text'] ?>
                </div>
            </div>

            <!-- Stores -->
            <div class="mb-20">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">فروشگاه‌های حضوری مومو</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">ما در دو شهر خدمات حضوری ارائه می‌دهیم</p>
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    <?php foreach ($stores as $store): ?>
                        <div class="bg-white dark:bg-custom-dark rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700">
                            <img src="<?= $mediaPath ?>about/<?= $store['image'] ?>" alt="<?= esc($store['title']) ?>" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center mb-3">
                                    <svg class="w-6 h-6 text-primary ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white"><?= esc($store['title']) ?></h3>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400"><?= esc($store['address']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Price Advantage -->
            <div class="bg-gradient-to-l from-primary/10 to-primary/5 dark:from-primary/20 dark:to-primary/5 rounded-2xl p-8 md:p-12 mb-20 border border-primary/20 dark:border-primary/30 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                </div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3"><?= esc($priceAdvantage['title']) ?></h3>
                <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-400"><?= esc($priceAdvantage['text']) ?></p>
            </div>

        </div>
    </section>
<?= $this->endSection() ?>
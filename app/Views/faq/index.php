<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
    <!-- START CONTENT -->
    <section class="py-5">
        <div class="container">

            <!-- Pagination and title -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="font-black text-3xl with-highlight dark:text-gray-200 mb-2">سوالات متداول</h1>
                    <p class="text-gray-600 dark:text-gray-400">پاسخ به پرتکرارترین سوالات شما درباره محصولات و خدمات ما</p>
                </div>
            </div>

            <!-- Categories -->
            <div class="flex flex-wrap gap-3 mb-10">
                <?php foreach ($categories as $key => $label): ?>
                    <button class="filter-btn px-4 py-2 <?= $key === 'all' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' ?> rounded-lg font-medium transition"
                            data-filter="<?= $key ?>">
                        <?= esc($label) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main part of the questions -->
                <div class="lg:col-span-2 space-y-6">

                    <?php foreach ($faqs as $faq): ?>
                        <div class="faq-item bg-white rounded-2xl drop-shadow-lg p-6 dark:bg-custom-dark dark:border dark:border-gray-700"
                             data-category="<?= esc($faq['category']) ?>">
                            <button class="faq-question w-full flex justify-between items-center text-right">
                                <span class="text-lg font-bold text-gray-800 dark:text-gray-200"><?= esc($faq['question']) ?></span>
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 transition-transform duration-300 transform rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="faq-answer mt-4 text-gray-600 dark:text-gray-400 hidden">
                                <?= $faq['answer'] ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- Sidebar -->
                <div class="space-y-8">

                    <!-- Frequently Asked Questions -->
                    <div class="bg-white space-y-4 dark:bg-custom-dark border-gray-200 border dark:border-gray-700 rounded-2xl shadow-lg p-8">
                        <h3 class="font-black text-2xl with-highlight dark:text-gray-200">
                            سوالات پرتکرار
                        </h3>

                        <div class="space-y-4">
                            <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition" data-filter="products">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">شرایط گارانتی محصولات چگونه است؟</span>
                                </div>
                            </a>
                            <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition" data-filter="shipping">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">آیا امکان ارسال به خارج از کشور وجود دارد؟</span>
                                </div>
                            </a>
                            <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition" data-filter="account">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">چگونه می‌توانم از تخفیف‌ها استفاده کنم؟</span>
                                </div>
                            </a>
                            <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition" data-filter="products">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span class="text-gray-700 dark:text-gray-300">آیا امکان خرید عمده وجود دارد؟</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="bg-white space-y-4 dark:bg-custom-dark border-gray-200 border dark:border-gray-700 rounded-2xl shadow-lg p-8">
                        <h3 class="font-black text-2xl with-highlight dark:text-gray-200">
                            پاسخ خود را پیدا نکردید؟
                        </h3>

                        <p class="mb-6 opacity-90">
                            اگر پاسخ سوال خود را در این صفحه پیدا نکردید، با پشتیبانی ما تماس بگیرید.
                        </p>

                        <div class="bg-blue-600 text-white rounded-xl p-4 mb-4 shadow text-center">
                            <div class="text-2xl font-black tracking-wide">
                                <a href="tel:09102046144">09102046144</a>
                            </div>
                        </div>

                        <a href="<?= site_url('contact') ?>" class="block w-full text-center bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition">
                            ارسال تیکت پشتیبانی
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- END CONTENT -->

    <script>
        // Script for opening and closing questions
        document.addEventListener('DOMContentLoaded', function() {
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('svg');

                    // Close other questions
                    faqQuestions.forEach(q => {
                        if (q !== this) {
                            const otherAnswer = q.nextElementSibling;
                            const otherIcon = q.querySelector('svg');
                            otherAnswer.classList.add('hidden');
                            otherIcon.classList.remove('rotate-180');
                            otherIcon.classList.add('rotate-0');
                        }
                    });

                    // Open or close the current question.
                    if (answer.classList.contains('hidden')) {
                        answer.classList.remove('hidden');
                        icon.classList.remove('rotate-0');
                        icon.classList.add('rotate-180');
                    } else {
                        answer.classList.add('hidden');
                        icon.classList.remove('rotate-180');
                        icon.classList.add('rotate-0');
                    }
                });
            });

            // Script to filter questions by category
            const filterBtns = document.querySelectorAll('.filter-btn');
            const sidebarLinks = document.querySelectorAll('[data-filter]');

            const filterItems = [...filterBtns, ...sidebarLinks];

            filterItems.forEach(item => {
                item.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');

                    // Update the style of the main filter buttons
                    filterBtns.forEach(btn => {
                        if (btn.getAttribute('data-filter') === filter) {
                            btn.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                            btn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                        } else {
                            btn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
                            btn.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-300', 'dark:hover:bg-gray-600');
                        }
                    });

                    // Filtering questions
                    const faqItems = document.querySelectorAll('.faq-item');
                    faqItems.forEach(item => {
                        if (filter === 'all') {
                            item.style.display = 'block';
                        } else {
                            if (item.getAttribute('data-category') === filter) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        }
                    });
                });
            });
        });
    </script>

<?= $this->endSection() ?>
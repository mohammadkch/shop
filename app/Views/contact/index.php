<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
    <!-- START CONTENT -->
    <section class="py-5">
        <div class="container">

            <!-- Contact information cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">

                <?php foreach ($contactInfo as $index => $item): ?>
                    <?php
                    // تعیین کلاس آیکون و رنگ بر اساس ایندکس
                    $iconClasses = [
                        'location' => 'w-8 h-8 text-primary-600 dark:text-primary-400',
                        'phone'    => 'w-8 h-8 text-secondary-600 dark:text-secondary-400',
                        'email'    => 'w-8 h-8 text-primary-600 dark:text-primary-400',
                    ];
                    $bgColors = [
                        'location' => 'bg-primary-100 dark:bg-primary-900/80',
                        'phone'    => 'bg-secondary-100 dark:bg-secondary-900/80',
                        'email'    => 'bg-primary-100 dark:bg-primary-900/80',
                    ];
                    $color = $iconClasses[$item['icon']] ?? 'w-8 h-8 text-gray-600';
                    $bg    = $bgColors[$item['icon']] ?? 'bg-gray-100 dark:bg-gray-800';
                    ?>
                    <div class="contact-card bg-white border border-gray-200 rounded-xl p-6 text-center shadow-md hover:shadow-lg transition duration-200 dark:bg-custom-dark dark:border-gray-700 border-s-primary dark:border-s-primary-700 border-s-3">
                        <div class="w-16 h-16 <?= $bg ?> rounded-full flex items-center justify-center mx-auto mb-4">
                            <?php if ($item['icon'] === 'location'): ?>
                                <svg class="<?= $color ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            <?php elseif ($item['icon'] === 'phone'): ?>
                                <svg class="<?= $color ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            <?php elseif ($item['icon'] === 'email'): ?>
                                <svg class="<?= $color ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-2"><?= esc($item['title']) ?></h3>
                        <p class="text-gray-600 dark:text-gray-400"><?= $item['value'] ?></p>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Contact form -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-8 dark:bg-custom-dark dark:border dark:border-gray-700">

                    <div class="flex items-center mb-6">
                        <h2 class="font-black text-2xl with-highlight dark:text-gray-200">ارسال پیام به ما</h2>
                    </div>

                    <form class="space-y-6" id="contact-form">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Name -->
                            <div class="form-group relative">
                                <input type="text" id="lname"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-zinc-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-primary-500"
                                       required>
                                <label for="lname" class="floating-label text-gray-500 dark:text-gray-400">نام و نام خانوادگی</label>
                            </div>

                            <!-- Email -->
                            <div class="form-group relative">
                                <input type="email" id="email"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-zinc-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-primary-500"
                                       required>
                                <label for="email" class="floating-label text-gray-500 dark:text-gray-400">آدرس ایمیل</label>
                            </div>

                        </div>

                        <!-- Subject -->
                        <div class="form-group relative">
                            <input type="text" id="subject"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-zinc-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-primary-500"
                                   required>
                            <label for="subject" class="floating-label text-gray-500 dark:text-gray-400">موضوع پیام</label>
                        </div>

                        <!-- Message -->
                        <div class="form-group relative">
                        <textarea id="message" rows="5"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-zinc-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:border-primary-500"
                                  required></textarea>
                            <label for="message" class="floating-label text-gray-500 dark:text-gray-400">متن پیام</label>
                        </div>

                        <div class="flex items-center">

                            <!-- Button -->
                            <button type="submit"
                                    class="bg-primary text-white font-bold py-3 px-8 rounded-lg flex items-center hover:bg-primary-700 transition">
                                <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                </svg>
                                ارسال پیام
                            </button>

                            <!-- Response time -->
                            <div class="ms-6 text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                میانگین زمان پاسخ‌گویی: ۲۴ ساعت
                            </div>
                        </div>
                    </form>

                    <!-- Success message -->
                    <div id="form-status" class="mt-6 hidden">
                        <div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 flex items-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400 me-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-green-800 dark:text-green-300">پیام شما با موفقیت ارسال شد</h4>
                                <p class="text-green-700 dark:text-green-400 text-sm mt-1">کارشناسان ما در اسرع وقت با شما تماس خواهند گرفت.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Information sidebar -->
                <div class="space-y-8">

                    <!-- Social networks -->
                    <div class="bg-white space-y-4 dark:bg-custom-dark border-gray-200 border dark:border-gray-700 rounded-2xl shadow-lg p-8">
                        <h3 class="font-black text-2xl with-highlight dark:text-gray-200">
                            شبکه‌های اجتماعی
                        </h3>

                        <p class="text-gray-600 dark:text-gray-300">
                            ما را در شبکه‌های اجتماعی دنبال کنید تا از جدیدترین اخبار و تخفیف‌ها مطلع شوید.
                        </p>

                        <div class="p-4">
                            <ul class="flex items-center justify-center space-x-4" role="list">
                                <li role="listitem"><a href="#"><img src="<?= $assetsPath ?>images/social/rubika.png" alt="روبیکا" class="size-7"></a></li>
                                <li role="listitem"><a href="#"><img src="<?= $assetsPath ?>images/social/aparat.png" alt="آپارات" class="size-7"></a></li>
                                <li role="listitem"><a href="#"><img src="<?= $assetsPath ?>images/social/bale.png" alt="بله" class="size-7"></a></li>
                                <li role="listitem"><a href="#"><img src="<?= $assetsPath ?>images/social/eitta.png" alt="ایتا" class="size-7"></a></li>
                                <li role="listitem"><a href="#"><img src="<?= $assetsPath ?>images/social/igap.png" alt="ایگپ" class="size-7"></a></li>
                                <li role="listitem"><a href="#"><img src="<?= $assetsPath ?>images/social/sorush.png" alt="سروش" class="size-7"></a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Support information -->
                    <div class="bg-white space-y-4 dark:bg-custom-dark border-gray-200 border dark:border-gray-700 rounded-2xl shadow-lg p-8">
                        <h3 class="font-black text-2xl with-highlight dark:text-gray-200">
                            پشتیبانی فوری
                        </h3>

                        <p class="mb-6 opacity-90">
                            برای مشکلات فوری و سوالات سریع، با شماره زیر تماس بگیرید:
                        </p>

                        <div class="bg-primary text-white rounded-xl p-4 mb-6 shadow text-center">
                            <div class="text-2xl font-black tracking-wide">
                                <a href="tel:09102046144">۰۹۱۰۲۰۴۶۱۴۴</a>
                            </div>
                        </div>

                        <p class="text-sm opacity-80">
                            این خط در ساعات کاری پاسخگوی شما خواهد بود.
                        </p>
                    </div>

                </div>

            </div>

            <!-- Map -->
            <div class="bg-white dark:bg-custom-dark mt-6 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-black text-2xl with-highlight dark:text-gray-200">موقعیت ما روی نقشه</h3>
                </div>

                <div class="h-[450px] bg-gray-300 relative">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d<?= $mapData['zoom'] ?>!2d<?= $mapData['lng'] ?>!3d<?= $mapData['lat'] ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzXCsDQ2JzQwLjAiTiA1McKwMjgnNDguMiJF!5e0!3m2!1sen!2s!4v1620000000000"
                        class="w-full h-full border-0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>
    </section>
    <!-- END CONTENT -->

    <script>
        // Form management
        document.getElementById('contact-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = 'در حال ارسال...';
            submitBtn.disabled = true;

            setTimeout(() => {
                submitBtn.innerHTML = '<svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> ارسال شد';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');

                document.getElementById('form-status').classList.remove('hidden');
                document.getElementById('form-status').classList.add('success-animation');

                setTimeout(() => {
                    this.reset();
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.add('btn-primary');
                    submitBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                    document.getElementById('form-status').classList.add('hidden');

                    document.querySelectorAll('.form-group').forEach(group => {
                        group.classList.remove('filled');
                    });
                }, 3000);
            }, 1500);
        });

        // Manage floating labels
        const formGroups = document.querySelectorAll('.form-group');

        formGroups.forEach(group => {
            const input = group.querySelector('input, textarea');

            input.addEventListener('focus', () => {
                group.classList.add('filled');
            });

            input.addEventListener('blur', () => {
                if (input.value === '') {
                    group.classList.remove('filled');
                }
            });

            if (input.value !== '') {
                group.classList.add('filled');
            }
        });
    </script>

<?= $this->endSection() ?>
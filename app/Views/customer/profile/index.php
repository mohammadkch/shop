<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="grid my-4 grid-cols-1 lg:grid-cols-4 gap-8">

                <?= $this->include('customer/_partials/sidebar') ?>

                <div class="lg:col-span-3 space-y-8">
                    <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-soft p-6 border border-gray-100 dark:border-gray-700">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-6">اطلاعات کاربری</h2>

                        <!-- ========================================== -->
                        <!-- فرم ۱: تکمیل اطلاعات -->
                        <!-- ========================================== -->
                        <div class="mb-10">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                                اطلاعات شخصی
                            </h3>

                            <form id="profileForm" novalidate>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <!-- نام -->
                                    <div>
                                        <label for="firstname" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            نام <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="firstname" name="firstname"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                               value="<?= old('firstname', $customer['firstname'] ?? '') ?>"
                                               placeholder="نام خود را وارد کنید">
                                        <p class="error-message text-sm text-red-600 mt-1 hidden" id="firstname-error"></p>
                                    </div>

                                    <!-- نام خانوادگی -->
                                    <div>
                                        <label for="lastname" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            نام خانوادگی <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="lastname" name="lastname"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                               value="<?= old('lastname', $customer['lastname'] ?? '') ?>"
                                               placeholder="نام خانوادگی خود را وارد کنید">
                                        <p class="error-message text-sm text-red-600 mt-1 hidden" id="lastname-error"></p>
                                    </div>

                                    <!-- موبایل (غیرفعال) -->
                                    <div>
                                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            شماره موبایل
                                        </label>
                                        <input type="text" id="mobile" name="mobile"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 rounded-xl bg-gray-100 dark:bg-gray-800 cursor-not-allowed"
                                               value="<?= $customer['mobile'] ?? '' ?>"
                                               disabled>
                                    </div>

                                    <!-- جنسیت -->
                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            جنسیت <span class="text-red-500">*</span>
                                        </label>
                                        <select id="gender" name="gender"
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                            <option value="">انتخاب کنید</option>
                                            <option value="1" <?= old('gender', $customer['gender'] ?? '') == '1' ? 'selected' : '' ?>>زن</option>
                                            <option value="2" <?= old('gender', $customer['gender'] ?? '') == '2' ? 'selected' : '' ?>>مرد</option>
                                        </select>
                                        <p class="error-message text-sm text-red-600 mt-1 hidden" id="gender-error"></p>
                                    </div>

                                    <!-- کد ملی (اختیاری) -->
                                    <div>
                                        <label for="national_code" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            کد ملی <span class="text-gray-400 text-xs">(اختیاری)</span>
                                        </label>
                                        <input type="text" id="national_code" name="national_code"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                               value="<?= old('national_code', $customer['national_code'] ?? '') ?>"
                                               placeholder="کد ملی خود را وارد کنید">
                                    </div>

                                    <!-- تاریخ تولد (اختیاری) -->
                                    <div>
                                        <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            تاریخ تولد <span class="text-gray-400 text-xs">(اختیاری)</span>
                                        </label>
                                        <input type="text" id="birthdate" name="birthdate"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                               value="<?= old('birthdate', $customer['birthdate'] ?? '') ?>"
                                               placeholder="مثال: 1372/11/16" dir="ltr">
                                        <p class="text-xs text-gray-400 mt-1">فرمت: سال/ماه/روز (مثال: 1372/11/16)</p>
                                    </div>

                                    <!-- آواتار -->
                                    <div class="md:col-span-2">
                                        <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            آواتار <span class="text-gray-400 text-xs">(اختیاری)</span>
                                        </label>
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <img id="avatarPreview"
                                                     src="<?= !empty($customer['avatar']) ? base_url('images/avatar/' . $customer['avatar']) : base_url('images/user/user.jpg') ?>"
                                                     class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                                            </div>
                                            <div class="flex-1">
                                                <input type="file" id="avatar" name="avatar"
                                                       accept="image/jpeg,image/png,image/webp,image/gif"
                                                       class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 cursor-pointer">
                                                <p class="text-xs text-gray-400 mt-1">حداکثر حجم: ۳۰۰ کیلوبایت - ابعاد: ۴۰۰×۴۰۰</p>
                                                <?php if (!empty($customer['avatar'])): ?>
                                                    <button type="button" id="removeAvatarBtn"
                                                            class="text-sm text-red-500 hover:text-red-600 mt-1">
                                                        حذف آواتار
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-6">
                                    <button type="submit" id="saveProfileBtn"
                                            class="px-6 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors">
                                        ذخیره اطلاعات
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- ========================================== -->
                        <!-- فرم ۲: تغییر پسورد -->
                        <!-- ========================================== -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                                <?= $hasPassword ? 'تغییر رمز عبور' : 'ایجاد رمز عبور' ?>
                            </h3>

                            <?php if (!$isProfileComplete): ?>
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-4">
                                    <p class="text-yellow-700 dark:text-yellow-400 text-sm">
                                        ⚠️ لطفاً ابتدا اطلاعات پروفایل خود را تکمیل کنید (نام، نام خانوادگی و جنسیت)
                                    </p>
                                </div>
                            <?php endif; ?>

                            <form id="passwordForm" novalidate>
                                <?php if ($hasPassword): ?>
                                    <div class="mb-4">
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            رمز عبور فعلی <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="current_password" name="current_password"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?= !$isProfileComplete ? 'bg-gray-100 dark:bg-gray-800 cursor-not-allowed' : '' ?>"
                                               placeholder="رمز عبور فعلی را وارد کنید"
                                                <?= !$isProfileComplete ? 'disabled' : '' ?>>
                                    </div>
                                <?php endif; ?>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            <?= $hasPassword ? 'رمز عبور جدید' : 'رمز عبور' ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="new_password" name="new_password"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?= !$isProfileComplete ? 'bg-gray-100 dark:bg-gray-800 cursor-not-allowed' : '' ?>"
                                               placeholder="رمز عبور جدید را وارد کنید"
                                                <?= !$isProfileComplete ? 'disabled' : '' ?>>
                                        <p class="text-xs text-gray-400 mt-1">حداقل ۸ کاراکتر</p>
                                    </div>

                                    <div>
                                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                            تکرار رمز عبور <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="confirm_password" name="confirm_password"
                                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?= !$isProfileComplete ? 'bg-gray-100 dark:bg-gray-800 cursor-not-allowed' : '' ?>"
                                               placeholder="رمز عبور را تکرار کنید"
                                                <?= !$isProfileComplete ? 'disabled' : '' ?>>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" id="changePasswordBtn"
                                            class="px-6 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors <?= !$isProfileComplete ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                            data-label="<?= $hasPassword ? 'تغییر رمز عبور' : 'ایجاد رمز عبور' ?>"
                                            <?= !$isProfileComplete ? 'disabled' : '' ?>>
                                        <?= $hasPassword ? 'تغییر رمز عبور' : 'ایجاد رمز عبور' ?>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

<?= $this->endSection() ?>
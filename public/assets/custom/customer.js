document.addEventListener('DOMContentLoaded', function() {

    // ==============================================
    // فرم ۱: تکمیل اطلاعات
    // ==============================================

    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const btn = document.getElementById('saveProfileBtn');

            btn.disabled = true;
            btn.textContent = 'در حال ذخیره...';

            // پاک کردن خطاهای قبلی
            document.querySelectorAll('#profileForm .error-message').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            fetch(BASE_URL + '/customer/profile/update', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.textContent = 'ذخیره اطلاعات';

                    if (data.status === 'error') {
                        // نمایش خطاهای فیلدها
                        if (data.errors) {
                            for (let field in data.errors) {
                                const errorEl = document.getElementById(field + '-error');
                                if (errorEl) {
                                    errorEl.textContent = data.errors[field];
                                    errorEl.classList.remove('hidden');
                                }
                            }
                        }
                        showNotification(data.message, 'error');
                        return;
                    }

                    // بروزرسانی آواتار
                    if (data.avatar) {
                        const preview = document.getElementById('avatarPreview');
                        if (preview) {
                            preview.src = BASE_URL + 'images/avatar/' + data.avatar;
                        }
                    }

                    showNotification(data.message, 'success');

                    // ریفرش صفحه بعد از 1.5 ثانیه برای آپدیت سشن
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                })
                .catch(error => {
                    btn.disabled = false;
                    btn.textContent = 'ذخیره اطلاعات';
                    showNotification('خطا در ارتباط با سرور', 'error');
                    console.error(error);
                });
        });
    }

    // ==============================================
    // پیش‌نمایش آواتار
    // ==============================================

    const avatarInput = document.getElementById('avatar');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = this.files[0];
            if (!file) return;

            // بررسی حجم
            if (file.size > 300 * 1024) {
                showNotification('حجم فایل نباید بیشتر از ۳۰۰ کیلوبایت باشد', 'error');
                this.value = '';
                return;
            }

            // بررسی نوع فایل
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                showNotification('فایل تصویر معتبر نیست (jpg, png, webp, gif)', 'error');
                this.value = '';
                return;
            }

            // ====== بررسی ابعاد (500x500) ======
            const img = new Image();
            img.onload = function() {
                if (img.width > 500 || img.height > 500) {
                    showNotification('ابعاد تصویر نباید بیشتر از ۵۰۰×۵۰۰ پیکسل باشد', 'error');
                    avatarInput.value = '';
                    return;
                }
                // نمایش پیش‌نمایش
                const preview = document.getElementById('avatarPreview');
                if (preview) {
                    preview.src = URL.createObjectURL(file);
                }
            };
            img.src = URL.createObjectURL(file);
        });
    }

    // ==============================================
    // حذف آواتار
    // ==============================================

    const removeAvatarBtn = document.getElementById('removeAvatarBtn');
    if (removeAvatarBtn) {
        removeAvatarBtn.addEventListener('click', function() {
            if (!confirm('آیا از حذف آواتار خود اطمینان دارید؟')) return;

            const formData = new FormData();
            formData.append('remove_avatar', '1');

            fetch(BASE_URL + '/customer/profile/update', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('avatarPreview').src = BASE_URL + 'images/user/user.jpg';
                        document.getElementById('avatar').value = '';
                        showNotification('آواتار با موفقیت حذف شد', 'success');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('خطا در حذف آواتار', 'error');
                    console.error(error);
                });
        });
    }

    // ==============================================
    // فرم ۲: تغییر پسورد
    // ==============================================

    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('changePasswordBtn');
            const originalLabel = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'در حال ذخیره...';

            const formData = new FormData(this);

            fetch(BASE_URL + '/customer/profile/change-password', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.textContent = originalLabel;

                    if (data.status === 'error') {
                        showNotification(data.message, 'error');
                        return;
                    }

                    // ====== موفقیت ======
                    showNotification(data.message, 'success');

                    // پاک کردن فیلدها
                    document.getElementById('current_password').value = '';
                    document.getElementById('new_password').value = '';
                    document.getElementById('confirm_password').value = '';

                    // اگر لاگ‌اوت نیاز است
                    if (data.logout) {
                        setTimeout(() => {
                            window.location.href = BASE_URL + 'login';
                        }, 1500);
                    } else {
                        // اگر نه، صفحه ریلود کن (برای آپدیت سشن)
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    btn.textContent = originalLabel;
                    showNotification('خطا در ارتباط با سرور', 'error');
                    console.error(error);
                });
        });
    }

});
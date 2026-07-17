// ==============================================
// لاگین / ثبت نام - کنترل مراحل
// ==============================================

document.addEventListener('DOMContentLoaded', function() {

    // ===== المان‌ها =====
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const step3 = document.getElementById('step-3');
    const stepTitle = document.getElementById('step-title');
    const stepDescription = document.getElementById('step-description');
    const stepIndicators = document.querySelectorAll('.step-indicator');

    const mobileInput = document.getElementById('mobile');
    const checkMobileBtn = document.getElementById('checkMobileBtn');
    const otpCodeInput = document.getElementById('otpCode');
    const verifyOtpBtn = document.getElementById('verifyOtpBtn');
    const resendOtpBtn = document.getElementById('resend-otp-button');
    const cancelOtpBtn = document.getElementById('cancelOtp');
    const maskedMobile = document.getElementById('maskedMobile');

    const chooseOtpLogin = document.getElementById('chooseOtpLogin');
    const choosePasswordLogin = document.getElementById('choosePasswordLogin');
    const backToMobile = document.getElementById('backToMobile');
    const backToMethod = document.getElementById('backToMethod');
    const loginWithPasswordBtn = document.getElementById('loginWithPasswordBtn');
    const passwordInput = document.getElementById('passwordInput');
    const passwordLoginForm = document.getElementById('passwordLoginForm');

    let mobileNumber = '';
    let hasPassword = false;  // ← متغیر جدید

    // ==============================================
    // توابع کمکی
    // ==============================================

    function showStep(step) {
        [step1, step2, step3].forEach(el => {
            if (el) {
                el.classList.remove('active');
                el.style.display = 'none';
            }
        });

        switch(step) {
            case 1: if (step1) { step1.style.display = 'block'; step1.classList.add('active'); } break;
            case 2: if (step2) { step2.style.display = 'block'; step2.classList.add('active'); } break;
            case 3: if (step3) { step3.style.display = 'block'; step3.classList.add('active'); } break;
        }

        stepIndicators.forEach((el, index) => {
            el.classList.toggle('active', index < step);
        });
    }

    function showError(elementId, message) {
        const el = document.getElementById(elementId);
        if (el) {
            el.textContent = message;
            el.classList.remove('hidden');
        }
    }

    function hideError(elementId) {
        const el = document.getElementById(elementId);
        if (el) el.classList.add('hidden');
    }

    function maskMobile(mobile) {
        if (!mobile || mobile.length < 11) return mobile;
        var first = mobile.slice(0, 4);
        var last = mobile.slice(-2);
        return last + '******' + first;
    }

    // ==============================================
    // مرحله ۱: بررسی شماره موبایل
    // ==============================================

    if (checkMobileBtn) {
        checkMobileBtn.addEventListener('click', function() {
            const mobile = mobileInput.value.trim();
            hideError('mobile-error');

            if (!mobile || !/^09[0-9]{9}$/.test(mobile)) {
                showError('mobile-error', 'شماره موبایل معتبر نیست (مثال: 09123456789)');
                showNotification('شماره موبایل معتبر نیست (مثال: 09123456789)', 'error')
                return;
            }

            this.disabled = true;
            this.innerHTML = 'در حال بررسی...';

            fetch(BASE_URL + '/login/check-mobile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'mobile=' + encodeURIComponent(mobile)
            })
                .then(response => response.json())
                .then(data => {
                    this.disabled = false;
                    this.innerHTML = 'ادامه';

                    if (data.status === 'error') {
                        showError('mobile-error', data.message);
                        showNotification(data.message, 'error');
                        return;
                    }

                    mobileNumber = mobile;
                    hasPassword = data.has_password;

                    // ====== اگر کد قبلی هنوز معتبر است ======
                    if (data.is_new_code === false) {
                        showNotification('کد قبلی هنوز معتبر است، لطفاً وارد کنید', 'info');
                        // همچنان به مرحله OTP می‌رویم
                    }

                    if (data.has_password) {
                        // کاربر پسورد دارد → مرحله ۲ (انتخاب روش)
                        stepTitle.textContent = 'انتخاب روش ورود';
                        stepDescription.textContent = 'نحوه ورود خود را انتخاب کنید';
                        showStep(2);
                        if (passwordLoginForm) passwordLoginForm.style.display = 'none';
                        document.querySelectorAll('#step-2 .space-y-4 > button:not(#backToMobile)').forEach(el => el.style.display = 'block');
                    } else {
                        // کاربر پسورد ندارد → مستقیم OTP
                        maskedMobile.textContent = maskMobile(mobileNumber);
                        stepTitle.textContent = 'ورود با کد یکبار مصرف';
                        stepDescription.textContent = 'کد تایید به شماره شما ارسال شد';
                        showStep(3);

                        // اگر کد قبلی معتبر است، تایمر را از زمان باقی‌مانده شروع کن
                        if (data.is_new_code === false && data.expires_at) {
                            var now = Math.floor(Date.now() / 1000);
                            var remaining = data.expires_at - now;
                            if (remaining > 0 && typeof startResendTimer === 'function') {
                                startResendTimer(remaining);
                            }
                        }

                        setTimeout(() => { if (otpCodeInput) otpCodeInput.focus(); }, 300);
                    }
                })
                .catch(error => {
                    this.disabled = false;
                    this.innerHTML = 'ادامه';
                    showError('mobile-error', 'خطا در ارتباط با سرور');
                    showNotification('خطا در ارتباط با سرور', 'error');
                    console.error(error);
                });
        });
    }

    // ==============================================
    // مرحله ۲: انتخاب روش
    // ==============================================

    // ===== دکمه ورود با رمز عبور =====
    if (choosePasswordLogin) {
        choosePasswordLogin.addEventListener('click', function() {
            document.querySelectorAll('#step-2 .space-y-4 > button:not(#backToMobile)').forEach(el => el.style.display = 'none');
            if (passwordLoginForm) passwordLoginForm.style.display = 'block';
            stepTitle.textContent = 'ورود با رمز عبور';
            stepDescription.textContent = 'رمز عبور خود را وارد کنید';
        });
    }

    // ===== برگشت از فرم پسورد =====
    if (backToMethod) {
        backToMethod.addEventListener('click', function() {
            document.querySelectorAll('#step-2 .space-y-4 > button:not(#backToMobile)').forEach(el => el.style.display = 'block');
            if (passwordLoginForm) passwordLoginForm.style.display = 'none';
            hideError('password-error');
            stepTitle.textContent = 'انتخاب روش ورود';
            stepDescription.textContent = 'نحوه ورود خود را انتخاب کنید';
        });
    }

    // برگشت به مرحله ۱
    if (backToMobile) {
        backToMobile.addEventListener('click', function() {
            hideError('otp-error');
            stepTitle.textContent = 'ورود / ثبت نام';
            stepDescription.textContent = 'برای ثبت نام یا ورود، شماره موبایل خود را وارد کنید';
            showStep(1);
            if (passwordLoginForm) passwordLoginForm.style.display = 'none';
            if (passwordInput) passwordInput.value = '';
            hideError('password-error');
        });
    }

    // انتخاب OTP (برای کاربرانی که پسورد دارند و در مرحله ۲ هستند)
    if (chooseOtpLogin) {
        chooseOtpLogin.addEventListener('click', function() {
            fetch(BASE_URL + '/login/check-mobile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'mobile=' + encodeURIComponent(mobileNumber) + '&force_otp=1'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'error') {
                        showError('otp-error', data.message);
                        showNotification(data.message, 'error');
                        return;
                    }
                    maskedMobile.textContent = maskMobile(mobileNumber);
                    stepTitle.textContent = 'ورود با کد یکبار مصرف';
                    stepDescription.textContent = 'کد تایید به شماره شما ارسال شد';
                    showStep(3);
                    setTimeout(() => { if (otpCodeInput) otpCodeInput.focus(); }, 300);
                })
                .catch(error => {
                    showError('otp-error', 'خطا در ارسال مجدد');
                    showNotification('خطا در ارسال مجدد', 'error');
                    console.error(error);
                });
        });
    }

    // ==============================================
    // مرحله ۳: تایید OTP
    // ==============================================

    if (verifyOtpBtn) {
        verifyOtpBtn.addEventListener('click', function() {
            const otpCode = otpCodeInput.value.trim();
            hideError('otp-error');

            if (!otpCode || otpCode.length !== 5 || !/^[0-9]{5}$/.test(otpCode)) {
                showError('otp-error', 'کد تایید ۵ رقمی را وارد کنید');
                showNotification('کد تایید ۵ رقمی را وارد کنید', 'error');
                return;
            }

            this.disabled = true;
            this.textContent = 'در حال بررسی...';

            fetch(BASE_URL + '/login/verify-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'otp_code=' + encodeURIComponent(otpCode)
            })
                .then(response => response.json())
                .then(data => {
                    this.disabled = false;
                    this.textContent = 'تایید کد';

                    if (data.status === 'error') {
                        showError('otp-error', data.message);
                        showNotification(data.message, 'error');
                        return;
                    }

                    window.location.href = data.redirect || '/';
                })
                .catch(error => {
                    this.disabled = false;
                    this.textContent = 'تایید کد';
                    showError('otp-error', 'خطا در ارتباط با سرور');
                    showNotification('خطا در ارتباط با سرور', 'error');
                    console.error(error);
                });
        });
    }

    // ==============================================
    // ارسال مجدد کد OTP
    // ==============================================

    if (resendOtpBtn) {
        let resendTimer = null;
        let remainingSeconds = 0;

        function startResendTimer(seconds) {
            if (resendTimer) {
                clearInterval(resendTimer);
            }

            remainingSeconds = seconds || 120;
            resendOtpBtn.disabled = true;
            updateResendButtonText();

            resendTimer = setInterval(function() {
                remainingSeconds--;
                if (remainingSeconds <= 0) {
                    clearInterval(resendTimer);
                    resendTimer = null;
                    resendOtpBtn.disabled = false;
                    resendOtpBtn.innerHTML = 'ارسال دوباره کد';
                } else {
                    updateResendButtonText();
                }
            }, 1000);
        }

        function updateResendButtonText() {
            resendOtpBtn.innerHTML = 'ارسال مجدد پس از ' + remainingSeconds + ' ثانیه';
        }

        resendOtpBtn.addEventListener('click', function() {
            if (resendTimer) {
                showNotification('لطفاً صبر کنید تا تایمر تمام شود', 'warning');
                return;
            }

            this.disabled = true;
            this.innerHTML = 'در حال ارسال...';

            fetch(BASE_URL + '/login/check-mobile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'mobile=' + encodeURIComponent(mobileNumber) + '&resend=1'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'error') {
                        this.disabled = false;
                        this.innerHTML = 'ارسال دوباره کد';
                        showError('otp-error', data.message);
                        showNotification(data.message, 'error');
                        return;
                    }

                    // ====== اگر کد قبلی هنوز معتبر است ======
                    if (data.status === 'info' || (data.is_new_code === false)) {
                        this.disabled = false;
                        this.innerHTML = 'ارسال دوباره کد';
                        showError('otp-error', 'کد قبلی هنوز معتبر است، لطفاً صبر کنید');
                        showNotification('کد قبلی هنوز معتبر است', 'info');

                        if (data.expires_at) {
                            var now = Math.floor(Date.now() / 1000);
                            var remaining = data.expires_at - now;
                            if (remaining > 0) {
                                startResendTimer(remaining);
                            }
                        }
                        return;
                    }

                    // ====== کد جدید ارسال شده ======
                    if (data.status === 'success') {
                        showError('otp-error', 'کد جدید ارسال شد');
                        showNotification('کد جدید ارسال شد', 'success');

                        startResendTimer(120);

                        setTimeout(function() {
                            var el = document.getElementById('otp-error');
                            if (el) el.classList.add('hidden');
                        }, 3000);
                    }
                })
                .catch(error => {
                    this.disabled = false;
                    this.innerHTML = 'ارسال دوباره کد';
                    showError('otp-error', 'خطا در ارسال مجدد');
                    showNotification('خطا در ارسال مجدد', 'error');
                    console.error(error);
                });
        });
    }

    // ==============================================
    // دکمه بازگشت (لغو OTP)
    // ==============================================

    if (cancelOtpBtn) {
        cancelOtpBtn.addEventListener('click', function() {
            hideError('otp-error');
            if (hasPassword === true) {
                // کاربر پسورد دارد → برگشت به مرحله ۲
                stepTitle.textContent = 'انتخاب روش ورود';
                stepDescription.textContent = 'نحوه ورود خود را انتخاب کنید';
                showStep(2);
                if (passwordLoginForm) passwordLoginForm.style.display = 'none';
                document.querySelectorAll('#step-2 .space-y-4 > button:not(#backToMobile)').forEach(el => el.style.display = 'block');
            } else {
                // کاربر پسورد ندارد → برگشت به مرحله ۱
                stepTitle.textContent = 'ورود / ثبت نام';
                stepDescription.textContent = 'برای ثبت نام یا ورود، شماره موبایل خود را وارد کنید';
                showStep(1);
                if (passwordLoginForm) passwordLoginForm.style.display = 'none';
                if (passwordInput) passwordInput.value = '';
                hideError('password-error');
            }
        });
    }

    // ==============================================
    // ورود با پسورد
    // ==============================================

    if (loginWithPasswordBtn && passwordInput) {
        loginWithPasswordBtn.addEventListener('click', function() {
            const password = passwordInput.value.trim();

            if (!password) {
                showError('password-error', 'رمز عبور را وارد کنید');
                showNotification('رمز عبور را وارد کنید', 'error');
                return;
            }

            this.disabled = true;
            this.textContent = 'در حال بررسی...';

            fetch(BASE_URL + '/login/password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'password=' + encodeURIComponent(password)
            })
                .then(response => response.json())
                .then(data => {
                    this.disabled = false;
                    this.textContent = 'ورود';

                    if (data.status === 'error') {
                        showError('password-error', data.message);
                        showNotification( data.message, 'error');
                        return;
                    }

                    window.location.href = data.redirect || '/';
                })
                .catch(function() {
                    this.disabled = false;
                    this.textContent = 'ورود';
                    showError('password-error', 'خطا در ارتباط با سرور');
                    showNotification( 'خطا در ارتباط با سرور', 'error');
                });
        });
    }

    // ==============================================
    // Enter key support
    // ==============================================

    if (mobileInput) {
        mobileInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (checkMobileBtn) checkMobileBtn.click();
            }
        });
    }

    if (otpCodeInput) {
        otpCodeInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (verifyOtpBtn) verifyOtpBtn.click();
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (loginWithPasswordBtn) loginWithPasswordBtn.click();
            }
        });
    }

});
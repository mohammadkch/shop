<?php helper('session'); ?>
<!doctype html>
<html lang="FA_IR" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>ورود به پنل مدیریت</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $assetsPath ?>images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $assetsPath ?>images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $assetsPath ?>images/favicon_io/favicon-16x16.png">
    <link rel="stylesheet" href="<?= $assetsPath ?>css/app.css">
</head>
<script>
    function showNotification(message, type = 'success') {
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };

        const bgColor = colors[type] || colors.success;

        const notification = document.createElement('div');
        notification.className = `fixed top-5 left-1/2 transform -translate-x-1/2 z-50 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-300 opacity-0 translate-y-[-20px]`;
        notification.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="text-sm font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('opacity-0', '-translate-y-[20px]');
            notification.classList.add('opacity-100', 'translate-y-0');
        }, 10);

        setTimeout(() => {
            notification.classList.remove('opacity-100', 'translate-y-0');
            notification.classList.add('opacity-0', '-translate-y-[20px]');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>
<body class="bg-gray-100 dark:bg-[#0d1117]">
    <div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white dark:bg-custom-dark rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">

        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="<?= $assetsPath ?>images/logo.png" class="h-12 mx-auto dark:invert" alt="Logo">
            <h2 class="mt-4 text-2xl font-bold text-gray-800 dark:text-gray-200">پنل مدیریت</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">لطفاً اطلاعات خود را وارد کنید</p>
        </div>

        <!-- پیام خطا -->
        <?php if (isset($msg_text) && $msg_text): ?>
            <div class="mb-4 p-3 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-xl text-sm text-center">
                <?= $msg_text ?>
            </div>
        <?php endif; ?>

        <!-- فرم لاگین -->
        <form method="post" action="<?= site_url('admin/login/authenticate') ?>">
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">نام کاربری</label>
                    <input type="text" name="username"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-xl
                                  bg-white dark:bg-custom-dark text-gray-900 dark:text-gray-100
                                  focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="نام کاربری خود را وارد کنید"
                           value="<?= old('username') ?>"
                           required autofocus>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رمز عبور</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-xl
                                  bg-white dark:bg-custom-dark text-gray-900 dark:text-gray-100
                                  focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="رمز عبور خود را وارد کنید" required>
                </div>

                <button type="submit"
                        class="w-full bg-primary hover:bg-primary/90 text-white font-medium py-3 px-4 rounded-xl
                               transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    ورود به پنل
                </button>
            </div>
        </form>

    </div>
</div>
</body>
<?= showFlash() ?>
</html>
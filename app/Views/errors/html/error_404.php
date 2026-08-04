<?php
$appBaseUrl = rtrim(config('App')->baseURL, '/');
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">
    <title>صفحه پیدا نشد | فروشگاه مومو</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= esc($appBaseUrl, 'attr') ?>/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/svg+xml" href="<?= esc($appBaseUrl, 'attr') ?>/images/favicon/favicon.svg">
    <link rel="icon" type="image/x-icon" href="<?= esc($appBaseUrl, 'attr') ?>/favicon.ico">
    <link rel="stylesheet" href="<?= esc($appBaseUrl, 'attr') ?>/assets/css/app.css">
    <style>
        * { box-sizing: border-box; }
        html, body { min-height: 100%; }
        body { margin: 0; background: #f5f7ff; color: #111827; }
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            background-image: radial-gradient(circle at 1px 1px, rgba(79, 70, 229, .12) 1px, transparent 0);
            background-size: 24px 24px;
        }
        .error-wrap { width: 100%; max-width: 896px; }
        .error-logo {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 8px; margin-bottom: 22px; color: #111827; text-decoration: none;
        }
        .error-logo img { display: block; width: auto; height: 114px; }
        .error-brand-name { font-size: 18px; font-weight: 900; }
        .error-card {
            overflow: hidden; border-radius: 16px; background: #fff;
            box-shadow: 0 20px 45px rgba(30, 41, 59, .14);
        }
        .error-grid { display: flex; }
        .error-code-panel {
            width: 40%; padding: 48px 32px; min-height: 430px; display: flex;
            align-items: center; justify-content: center; text-align: center; color: #fff;
            background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);
        }
        .error-code { margin-bottom: 18px; font-size: 88px; font-weight: 900; line-height: 1; }
        .error-code-label { font-size: 20px; font-weight: 700; }
        .error-content { width: 60%; padding: 48px; display: flex; flex-direction: column; justify-content: center; }
        .error-title { margin: 0 0 14px; font-size: 29px; line-height: 1.55; font-weight: 900; }
        .error-description { margin: 0 0 32px; color: #4b5563; font-size: 15px; line-height: 2; }
        .error-actions { display: flex; gap: 12px; }
        .error-button {
            min-height: 48px; flex: 1; display: inline-flex; align-items: center; justify-content: center;
            gap: 8px; padding: 10px 16px; border: 1px solid #d1d5db; border-radius: 9px;
            color: #374151; background: #fff; font-size: 14px; font-weight: 700; text-decoration: none;
            transition: background-color .2s, border-color .2s;
        }
        .error-button:hover { background: #f9fafb; }
        .error-button-primary { color: #fff; border-color: #2563eb; background: #2563eb; }
        .error-button-primary:hover { border-color: #1d4ed8; background: #1d4ed8; }
        .error-button svg { width: 20px; height: 20px; }
        @media (max-width: 767px) {
            .error-page { align-items: flex-start; padding: 24px 12px; }
            .error-logo img { height: 96px; }
            .error-grid { display: block; }
            .error-code-panel { width: 100%; min-height: 163px; padding: 25px 20px; }
            .error-code { margin-bottom: 12px; font-size: 74px; }
            .error-code-label { font-size: 16px; }
            .error-content { width: 100%; padding: 28px 25px; }
            .error-title { font-size: 24px; text-align: center; }
            .error-description { font-size: 13px; text-align: center; }
            .error-actions { flex-direction: column; }
        }
    </style>
</head>
<body>
<main class="error-page">
    <div class="error-wrap">
        <a href="<?= esc($appBaseUrl, 'attr') ?>/" class="error-logo" aria-label="فروشگاه مومو">
            <img src="<?= esc($appBaseUrl, 'attr') ?>/images/logo/logo-header-transparent.png" alt="لوگوی فروشگاه مومو">
            <span class="error-brand-name">فروشگاه اینترنتی مومو</span>
        </a>

        <section class="error-card">
            <div class="error-grid">
                <div class="error-code-panel">
                    <div>
                        <div class="error-code">۴۰۴</div>
                        <div class="error-code-label">صفحه یافت نشد</div>
                    </div>
                </div>

                <div class="error-content">
                    <h1 class="error-title">اوپس! به نظر می‌رسد گم شده‌اید</h1>
                    <p class="error-description">
                        متأسفانه صفحه‌ای که به دنبال آن هستید وجود ندارد، حذف شده یا آدرس آن تغییر کرده است. آدرس را دوباره بررسی کنید یا از مسیرهای زیر ادامه دهید.
                    </p>

                    <div class="error-actions">
                        <a href="<?= esc($appBaseUrl, 'attr') ?>/"
                           class="error-button error-button-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875C9.75 15.504 10.254 15 10.875 15h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                            </svg>
                            صفحه اصلی
                        </a>
                        <a href="<?= esc($appBaseUrl, 'attr') ?>/contact"
                           class="error-button">
                            تماس با پشتیبانی
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
</body>
</html>

<!doctype html>
<html lang="FA_IR" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <title><?= esc($title ?? 'فروشگاه لباس') ?></title>
    <meta name="description" content="<?= esc($metaDescription ?? 'فروشگاه اینترنتی پوشاک') ?>">
    <meta name="keywords" content="قالب فروشگاهی, قالب دیارا, فروشگاه اینترنتی, طراحی واکنش‌گرا">
    <meta name="robots" content="<?= esc($robots ?? 'index, follow') ?>">
    <meta name="author" content="امیر رضایی">
    <meta name="copyright" content="All rights belong to diara.">
    <link rel="icon" href="<?= base_url('images/favicon/favicon.ico') ?>" sizes="any">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('images/favicon/favicon.svg') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('images/favicon/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('images/favicon/icon-192.png') ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= base_url('images/favicon/icon-512.png') ?>">
    <link rel="canonical" href="<?= esc($canonicalUrl ?? current_url(), 'attr') ?>">
    <?php if (!empty($ogImage)): ?>
        <meta property="og:image" content="<?= esc($ogImage, 'attr') ?>">
    <?php endif; ?>
    <meta property="og:title" content="<?= esc($title ?? 'فروشگاه لباس', 'attr') ?>">
    <meta property="og:description" content="<?= esc($metaDescription ?? '', 'attr') ?>">
    <meta property="og:url" content="<?= esc($canonicalUrl ?? current_url(), 'attr') ?>">
    <link rel="stylesheet" href="<?= $assetsPath ?>js/plugin/story-player/styles.css">
    <link rel="stylesheet" href="<?= $assetsPath ?>js/plugin/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= $assetsPath ?>css/app.css">

    <!-- ====== فایل‌های داخل custom ====== -->
    <script src="<?= $assetsPath ?>custom/shop.js"></script>
    <?= $this->renderSection('styles') ?>
</head>

<body class="relative bg-custom-light dark:bg-[#0d1117] text-gray-900 dark:text-gray-100 transition-colors duration-300" >
<?= showFlash() ?>
<?= $this->include('_layout_/layout_header') ?>

<?= $this->renderSection('content') ?>

<?= $this->include('_layout_/layout_footer') ?>

<?= $this->include('_layout_/partials/cart_offcanvas') ?>

<?= $this->include('_layout_/partials/menu_offcanvas') ?>

<?php //= $this->include('_layout_/partials/login_modal') ?>

<?= $this->include('_layout_/partials/nav_mobile') ?>

<?= $this->include('_layout_/partials/overlay') ?>

<?= $this->include('_layout_/partials/scripts') ?>
<?= $this->renderSection('scripts') ?>

</body>

</html>

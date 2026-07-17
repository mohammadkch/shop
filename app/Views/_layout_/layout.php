<!doctype html>
<html lang="FA_IR" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <meta name="description"
          content="قالب فرشگاهی دیارا، بهترین قالب برای فروشگاه‌های اینترنتی با طراحی مدرن و واکنش‌گرا.">
    <meta name="keywords" content="قالب فروشگاهی, قالب دیارا, فروشگاه اینترنتی, طراحی واکنش‌گرا">
    <meta name="robots" content="index, follow">
    <meta name="author" content="امیر رضایی">
    <meta name="copyright" content="All rights belong to diara.">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $assetsPath ?>images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $assetsPath ?>images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $assetsPath ?>images/favicon_io/favicon-16x16.png">
    <link rel="canonical" href="https://example.com/your-page-url">
    <link rel="stylesheet" href="<?= $assetsPath ?>js/plugin/story-player/styles.css">
    <link rel="stylesheet" href="<?= $assetsPath ?>js/plugin/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= $assetsPath ?>css/app.css">

    <!-- ====== فایل‌های داخل custom ====== -->
    <script src="<?= $assetsPath ?>custom/shop.js"></script>
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

</body>

</html>

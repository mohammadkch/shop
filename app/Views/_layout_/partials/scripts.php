<script>
    const BASE_URL = '<?= base_url() ?>';
</script>

<!-- ====== پلاگین‌های مورد نیاز هر صفحه ====== -->
<?php if (!empty($usesStoryPlayer)): ?>
    <script src="<?= $assetsPath ?>js/plugin/story-player/story-player.js"></script>
<?php endif; ?>
<?php if (!empty($usesSwiper)): ?>
    <script src="<?= $assetsPath ?>js/plugin/swiper/swiper-bundle.min.js"></script>
    <script src="<?= $assetsPath ?>js/dependencies/swiper-script.js"></script>
<?php endif; ?>

<!-- ====== فایل‌های داخل dependencies ====== -->
<script src="<?= $assetsPath ?>js/dependencies/app.js"></script>

<!-- ====== دیتای استوری‌ها برای صفحه خانه (داینامیک) ====== -->
<?php if (!empty($stories)): ?>
    <script>
        window.storiesData = <?= json_encode($stories, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    </script>
<?php endif; ?>

<?php
// ====== اسکریپت‌های مخصوص کنترلر ======
if (!empty($controllerScripts)):
    foreach ($controllerScripts as $script):
        $filePath = FCPATH . 'assets/custom/' . $script . '.js';
        if (file_exists($filePath)):
            ?>
            <script src="<?= vite_asset($script) ?>"></script>
        <?php
        endif;
    endforeach;
endif;
?>


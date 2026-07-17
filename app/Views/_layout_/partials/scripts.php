<script>
    const BASE_URL = '<?= base_url() ?>';
</script>

<!-- ====== فایل‌های داخل plugin ====== -->
<script src="<?= $assetsPath ?>js/plugin/story-player/story-player.js"></script>
<script src="<?= $assetsPath ?>js/plugin/swiper/swiper-bundle.min.js"></script>

<!-- ====== فایل‌های داخل dependencies ====== -->
<script src="<?= $assetsPath ?>js/dependencies/swiper-script.js"></script>
<!--<script src="--><?php //= $assetsPath ?><!--js/dependencies/auth.js"></script>-->
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
            <script src="<?= $assetsPath ?>custom/<?= $script ?>.js"></script>
        <?php
        endif;
    endforeach;
endif;
?>


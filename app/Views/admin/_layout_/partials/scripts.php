<!--<script src="--><?php //= $assetsPath ?><!--js/plugin/story-player/story-player.js"></script>--> <!-- by mammad -->
<script src="<?= $assetsPath ?>js/plugin/swiper/swiper-bundle.min.js"></script>
<script src="<?= $assetsPath ?>js/dependencies/swiper-script.js"></script>
<script src="<?= $assetsPath ?>js/dependencies/auth.js"></script>
<script src="<?= $assetsPath ?>js/dependencies/app.js"></script>

<!-- INITIAL STORY SECTION -->
<script>
    const stories = [
        {
            type: 'image',
            user: 'استوری ۱',
            avatar: '<?= $assetsPath ?>images/story/1.jpg',
            url: '<?= $assetsPath ?>images/story/1.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 2',
            avatar: '<?= $assetsPath ?>images/story/2.jpg',
            url: '<?= $assetsPath ?>images/story/2.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 3',
            avatar: '<?= $assetsPath ?>images/story/3.jpg',
            url: '<?= $assetsPath ?>images/story/3.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 4',
            avatar: '<?= $assetsPath ?>images/story/5.jpg',
            url: '<?= $assetsPath ?>images/story/5.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 5',
            avatar: '<?= $assetsPath ?>images/story/6.jpg',
            url: '<?= $assetsPath ?>images/story/6.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 6',
            avatar: '<?= $assetsPath ?>images/story/7.jpg',
            url: '<?= $assetsPath ?>images/story/7.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 7',
            avatar: '<?= $assetsPath ?>images/story/8.jpg',
            url: '<?= $assetsPath ?>images/story/8.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'video',
            user: 'استوری 8',
            avatar: '<?= $assetsPath ?>images/story/4.jpg',
            url: '<?= $assetsPath ?>images/story/video/1.mp4',
            duration: null,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری ۱',
            avatar: '<?= $assetsPath ?>images/story/1.jpg',
            url: '<?= $assetsPath ?>images/story/1.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 2',
            avatar: '<?= $assetsPath ?>images/story/2.jpg',
            url: '<?= $assetsPath ?>images/story/2.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 3',
            avatar: '<?= $assetsPath ?>images/story/3.jpg',
            url: '<?= $assetsPath ?>images/story/3.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 4',
            avatar: '<?= $assetsPath ?>images/story/5.jpg',
            url: '<?= $assetsPath ?>images/story/5.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
        {
            type: 'image',
            user: 'استوری 5',
            avatar: '<?= $assetsPath ?>images/story/6.jpg',
            url: '<?= $assetsPath ?>images/story/6.jpg',
            duration: 5000,
            link: 'https://www.rtl-theme.com/author/amir_rezaii/products/'
        },
    ];
    // if (document.getElementById('stories-container')) {
    //     new StoryPlayer('stories-container', stories);
    // }

    // new StoryPlayer('stories-container', stories); #comment by mammad
</script>

// ==============================================
// استوری‌های صفحه اصلی (داینامیک)
// ==============================================
(function () {
    'use strict';

    const container = document.getElementById('stories-container');
    if (!container) return;

    // دیتای استوری‌ها از PHP میاد (تعریف شده در scripts.php)
    if (typeof window.storiesData !== 'undefined' && Array.isArray(window.storiesData) && window.storiesData.length > 0) {
        new StoryPlayer('stories-container', window.storiesData);
    }
})();

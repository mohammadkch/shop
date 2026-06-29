// ==============================================
// توابع موجود برای پجینیشن
// ==============================================
function showCategoryPage(url = null, containerId = 'product-container', resetPage = false) {
    if (!url) {
        url = window.location.href;
    }

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            const container = document.getElementById(containerId);
            if (container) {
                container.innerHTML = html;
            }

            window.history.pushState({}, '', url);

            // bind کردن مجدد
            bindCategoryPaginationLinks(containerId);
            bindSortButtons();
            syncCheckboxes();
            bindFilterCheckboxes();  // ← اضافه کن

            // ====== reset flags بعد از بارگذاری ======
            isFiltering = false;
            isSorting = false;
        })
        .catch(error => console.error('Error in showCategoryPage:', error));
}

function handlePaginationClick(e) {
    e.preventDefault();
    e.stopPropagation();
    const url = this.getAttribute('href');
    if (url) {
        showCategoryPage(url);
    }
    return false;
}

function bindCategoryPaginationLinks(containerId = 'product-container') {
    const container = document.getElementById(containerId);
    if (!container) return;

    const links = container.querySelectorAll('.pagination-link');
    links.forEach(link => {
        link.removeEventListener('click', handlePaginationClick);
        link.addEventListener('click', handlePaginationClick);
    });
}

// ==============================================
// مدیریت فیلترها + سورت
// ==============================================
let filterTimeout;

// متغیر برای تشخیص نوع درخواست
let isSorting = false;
let isFiltering = false;

function applyCategoryFilters() {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(() => {
        const url = new URL(window.location.href);

        // ۱. پاک کردن پارامترهای قبلی فیلتر
        const paramsToRemove = [];
        url.searchParams.forEach((value, key) => {
            if (key.startsWith('filter_')) {
                paramsToRemove.push(key);
            }
        });
        paramsToRemove.forEach(key => url.searchParams.delete(key));

        // ۲. جمع‌آوری چک‌باکس‌های تیک‌خورده (فقط دسکتاپ)
        const checkedBoxes = document.querySelectorAll('.filter-checkbox:checked:not([id^="mobile_"])');
        const filterGroups = {};
        checkedBoxes.forEach(checkbox => {
            const labelId = checkbox.dataset.labelId;
            const optionId = checkbox.dataset.optionId;
            if (!filterGroups[labelId]) {
                filterGroups[labelId] = [];
            }
            filterGroups[labelId].push(optionId);
        });

        Object.keys(filterGroups).forEach(labelId => {
            const key = `filter_${labelId}`;
            const value = filterGroups[labelId].join(',');
            url.searchParams.set(key, value);
        });

        // ۳. سورت (از دکمه‌های فعال)
        const activeSortBtn = document.querySelector('.sort-btn.bg-gray-900, .sort-btn.dark\\:bg-gray-800');
        if (activeSortBtn) {
            url.searchParams.set('sort_field', activeSortBtn.dataset.sortField);
            url.searchParams.set('sort_type', activeSortBtn.dataset.sortType);
        }

        // ۴. صفحه به ۱ برمی‌گردد
        url.searchParams.set('page', 1);

        // ۵. ارسال درخواست AJAX
        showCategoryPage(url.toString());

        // ====== ۶. نوتیفیکیشن هوشمند ======
        // تعداد کل آپشن‌های انتخاب‌شده (فقط دسکتاپ)
        const totalOptions = document.querySelectorAll('.filter-checkbox:checked:not([id^="mobile_"])').length;

        if (isFiltering && !isSorting) {
            // فقط فیلتر تغییر کرده
            if (totalOptions > 0) {
                showNotification(`${totalOptions} فیلتر اعمال شد`, 'success');
            } else {
                showNotification('همه فیلترها حذف شدند', 'info');
            }
        } else if (isSorting && !isFiltering) {
            // فقط سورت تغییر کرده
            const sortText = activeSortBtn ? activeSortBtn.textContent.trim() : 'جدیدترین';
            showNotification(`مرتب‌سازی بر اساس ${sortText}`, 'success');
        } else if (isFiltering && isSorting) {
            // هر دو تغییر کرده
            const sortText = activeSortBtn ? activeSortBtn.textContent.trim() : 'جدیدترین';
            if (totalOptions > 0) {
                showNotification(`${totalOptions} فیلتر اعمال شد و مرتب‌سازی بر اساس ${sortText}`, 'success');
            } else {
                showNotification(`مرتب‌سازی بر اساس ${sortText}`, 'success');
            }
        }

        // reset flags
        isFiltering = false;
        isSorting = false;

    }, 300);
}

// ==============================================
// مدیریت کلیک روی دکمه‌های سورت
// ==============================================
function bindSortButtons() {
    const sortBtns = document.querySelectorAll('.sort-btn');
    sortBtns.forEach(btn => {
        btn.removeEventListener('click', handleSortClick);
        btn.addEventListener('click', handleSortClick);
    });
}

function handleSortClick(e) {
    e.preventDefault();

    // ====== تنظیم flag سورت ======
    isSorting = true;

    // حذف کلاس active از همه دکمه‌ها
    document.querySelectorAll('.sort-btn').forEach(b => {
        b.classList.remove('bg-gray-900', 'text-white', 'dark:bg-gray-800', 'dark:text-white');
        b.classList.add('hover:text-gray-900', 'dark:hover:text-white');
    });

    // اضافه کردن کلاس active به دکمه clicked
    const btn = e.currentTarget;
    btn.classList.remove('hover:text-gray-900', 'dark:hover:text-white');
    btn.classList.add('bg-gray-900', 'text-white', 'dark:bg-gray-800', 'dark:text-white');

    // اعمال فیلترها (که سورت رو هم شامل میشه)
    applyCategoryFilters();
}

// ==============================================
// مدیریت چک‌باکس‌های فیلتر
// ==============================================
function bindFilterCheckboxes() {
    const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
    filterCheckboxes.forEach(checkbox => {
        checkbox.removeEventListener('change', handleFilterChange);
        checkbox.addEventListener('change', handleFilterChange);
    });
}

function handleFilterChange(e) {
    // ====== تنظیم flag فیلتر ======
    isFiltering = true;
    applyCategoryFilters();
}

// ==============================================
// همگام‌سازی چک‌باکس‌های دسکتاپ و موبایل
// ==============================================
function syncCheckboxes() {
    const allCheckboxes = document.querySelectorAll('.filter-checkbox');

    allCheckboxes.forEach(checkbox => {
        checkbox.removeEventListener('change', syncCheckboxHandler);
        checkbox.addEventListener('change', syncCheckboxHandler);
    });
}

function syncCheckboxHandler(e) {
    const current = e.target;
    const labelId = current.dataset.labelId;
    const optionId = current.dataset.optionId;
    const isChecked = current.checked;

    // پیدا کردن چک‌باکس متناظر
    const siblings = document.querySelectorAll(
        `.filter-checkbox[data-label-id="${labelId}"][data-option-id="${optionId}"]`
    );

    siblings.forEach(sibling => {
        if (sibling !== current) {
            sibling.checked = isChecked;
        }
    });
}

// ==============================================
// بایند کردن رویدادها
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    // پجینیشن
    bindCategoryPaginationLinks();

    // همگام‌سازی چک‌باکس‌ها
    syncCheckboxes();

    // ====== جدید: فیلترها با handleFilterChange ======
    bindFilterCheckboxes();

    // دکمه‌های سورت
    bindSortButtons();
});
/**
 * custom.js
 * توابع عمومی و مشترک کل سایت ادمین
 */

// ==================== Notification ====================

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

// ==================== Sidebar Functions ====================

function closeSidebarOffcanvas() {
    var offcanvas = document.getElementById('offcanvas-sidebar');
    var overlay = document.querySelector('.overlay');
    if (offcanvas) {
        offcanvas.classList.add('invisible', 'opacity-0', '-translate-x-full');
        offcanvas.classList.remove('visible', 'opacity-100', 'translate-x-0');
    }
    if (overlay) {
        overlay.classList.add('hidden');
    }
}

function openOffcanvas(id) {
    const offcanvas = document.getElementById(id);
    const overlay = document.querySelector('.overlay');
    if (offcanvas) {
        offcanvas.classList.remove('invisible', 'opacity-0', '-translate-x-full', 'translate-x-full');
        offcanvas.classList.add('visible', 'opacity-100', 'translate-x-0');
    }
    if (overlay) {
        overlay.classList.remove('hidden');
    }
}

function closeOffcanvas() {
    const offcanvases = document.querySelectorAll('.offcanvas');
    const overlay = document.querySelector('.overlay');
    offcanvases.forEach(offcanvas => {
        offcanvas.classList.add('invisible', 'opacity-0', '-translate-x-full', 'translate-x-full');
        offcanvas.classList.remove('visible', 'opacity-100', 'translate-x-0');
    });
    if (overlay) {
        overlay.classList.add('hidden');
    }
}

// ==================== CRUD Common Functions ====================

/**
 * صفحه‌بندی و جستجوی AJAX
 */
function showPage(url = null, searchFormId = 'searchForm', resultContainerId = 'search-result') {
    if (!url) {
        url = window.location.href;
    }

    let baseUrl = url.split('?')[0];
    let urlParams = new URLSearchParams(url.split('?')[1] || '');
    let page = urlParams.get('page');

    const formElement = document.getElementById(searchFormId);
    const formData = new FormData(formElement);

    // فقط فیلدهایی که مقدار دارند رو نگه دار
    const filteredData = new FormData();
    for (let pair of formData.entries()) {
        if (pair[1].trim() !== '') {
            filteredData.append(pair[0], pair[1]);
        }
    }

    if (page) {
        filteredData.append('page', page);
    }

    fetch(baseUrl, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: filteredData
    })
        .then(response => response.text())
        .then(html => {
            document.getElementById(resultContainerId).innerHTML = html;
            window.history.pushState({}, '', url);
            bindDeleteButtons();
            bindToggleActiveButtons();
        })
        .catch(error => console.error('Error:', error));
}
function resetFilters(searchFormId = 'searchForm') {
    document.querySelectorAll(`#${searchFormId} input, #${searchFormId} select`).forEach(input => {
        input.value = '';
    });
    showPage();
}

// ==================== Delete Modal Functions ====================

let currentDeleteId = null;
let currentDeleteUrl = null;

function bindDeleteButtons() {
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.removeEventListener('click', handleDeleteClick);
        btn.addEventListener('click', handleDeleteClick);
    });
}

function handleDeleteClick(e) {
    currentDeleteId = e.currentTarget.dataset.id;
    currentDeleteUrl = e.currentTarget.dataset.url;
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.classList.remove('hidden');
    }
}

function confirmDelete() {
    if (currentDeleteId && currentDeleteUrl) {
        fetch(currentDeleteUrl + '/' + currentDeleteId, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showNotification(data.message, 'success');
                    showPage();
                } else {
                    showNotification(data.message, 'error');
                }
                closeDeleteModal();
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('خطا در حذف رکورد', 'error');
                closeDeleteModal();
            });
    }
}

function closeDeleteModal() {
    currentDeleteId = null;
    currentDeleteUrl = null;
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.classList.add('hidden');
    }
}

// ==================== Image Preview ====================

function previewImage(input, previewContainerId = null) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();

        let previewContainer;
        if (previewContainerId) {
            previewContainer = document.getElementById(previewContainerId);
        } else {
            previewContainer = input.closest('.border')?.querySelector('.preview-img, img');
        }

        reader.onload = function(e) {
            if (previewContainer && previewContainer.tagName === 'IMG') {
                previewContainer.src = e.target.result;
            } else if (previewContainer) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-20 h-20 object-cover rounded-lg border';
                const oldImg = previewContainer.querySelector('img');
                if (oldImg) oldImg.remove();
                previewContainer.appendChild(img);
            } else {
                const imgDiv = document.createElement('div');
                imgDiv.className = 'mb-2';
                imgDiv.innerHTML = `<img src="${e.target.result}" class="w-20 h-20 object-cover rounded-lg border">`;
                input.parentNode.insertBefore(imgDiv, input);
            }
        };
        reader.readAsDataURL(file);
    }
}

// ==================== Dropdown / Accordion ====================

function toggleDropdown(id) {
    const element = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    if (element) {
        element.classList.toggle('hidden');
        if (icon) {
            icon.classList.toggle('rotate-180');
        }
    }
}

// ==================== Dark Mode ====================

function toggleDarkMode() {
    if (localStorage.theme === 'dark') {
        localStorage.theme = 'light';
        document.documentElement.classList.remove('dark');
    } else {
        localStorage.theme = 'dark';
        document.documentElement.classList.add('dark');
    }
}

function initDarkMode() {
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        localStorage.theme = 'dark';
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';
    }
}

// ==================== Scroll to Top ====================

function scrollToTop(event) {
    if (event) event.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ==================== Initialization ====================

document.addEventListener('DOMContentLoaded', function() {
    // دارک مود
    initDarkMode();
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', toggleDarkMode);
    }

    // دکمه‌های جستجو
    const searchBtn = document.getElementById('searchBtn');
    const resetBtn = document.getElementById('resetBtn');
    if (searchBtn) searchBtn.addEventListener('click', () => showPage());
    if (resetBtn) resetBtn.addEventListener('click', () => resetFilters());

    // اینتر در فیلدهای جستجو
    document.querySelectorAll('.search-input').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                showPage();
            }
        });
    });

    // مودال حذف
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const cancelBtn = document.getElementById('cancelDeleteBtn');
    const deleteModal = document.getElementById('deleteModal');
    if (confirmBtn) confirmBtn.addEventListener('click', confirmDelete);
    if (cancelBtn) cancelBtn.addEventListener('click', closeDeleteModal);
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    }

    // مودال تأیید تغییر وضعیت
    const confirmToggleBtn = document.getElementById('confirmToggleBtn');
    const cancelConfirmBtn = document.getElementById('cancelConfirmBtn');
    const confirmModal = document.getElementById('confirmModal');
    if (confirmToggleBtn) {
        confirmToggleBtn.addEventListener('click', confirmToggleActive);
    }
    if (cancelConfirmBtn) {
        cancelConfirmBtn.addEventListener('click', closeConfirmModal);
    }
    if (confirmModal) {
        confirmModal.addEventListener('click', function(e) {
            if (e.target === this) closeConfirmModal();
        });
    }

    // بایند اولیه دکمه‌های حذف و toggle
    bindDeleteButtons();
    bindToggleActiveButtons();
});

// ==================== Toggle Active ====================

let currentToggleId = null;
let currentToggleStatus = null;

function bindToggleActiveButtons() {
    document.querySelectorAll('.toggle-active-btn').forEach(btn => {
        btn.removeEventListener('click', handleToggleClick);
        btn.addEventListener('click', handleToggleClick);
    });
}

function handleToggleClick(e) {
    const btn = e.currentTarget;
    currentToggleId = btn.getAttribute('data-id');
    currentToggleStatus = btn.getAttribute('data-status');

    const newStatusText = currentToggleStatus == '1' ? 'غیرفعال' : 'فعال';
    const message = 'آیا از ' + newStatusText + ' کردن این آیتم اطمینان دارید؟';

    const confirmMessage = document.getElementById('confirmMessage');
    if (confirmMessage) {
        confirmMessage.textContent = message;
    }
    const confirmModal = document.getElementById('confirmModal');
    if (confirmModal) {
        confirmModal.classList.remove('hidden');
    }
}
function confirmToggleActive() {
    if (!currentToggleId) return;

    const newStatus = currentToggleStatus == '1' ? 0 : 1;

    // تشخیص کنترلر از URL فعلی صفحه
    let currentUrl = window.location.pathname;
    let controller = '';

    if (currentUrl.includes('/menu1-image')) {
        controller = 'menu1-image';
    } else if (currentUrl.includes('/menu1')) {
        controller = 'menu1';
    } else if (currentUrl.includes('/menu2-image')) {
        controller = 'menu2-image';
    } else if (currentUrl.includes('/menu2')) {
        controller = 'menu2';
    } else if (currentUrl.includes('/menu3-image')) {
        controller = 'menu3-image';
    } else if (currentUrl.includes('/menu3')) {
        controller = 'menu3';
    }

    let url = '/shop/public/admin/' + controller + '/toggleActive/' + currentToggleId;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ is_active: newStatus })
    })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.status === 'success') {
                showNotification(data.message, 'success');
                showPage();
            } else {
                showNotification(data.message, 'error');
            }
            closeConfirmModal();
        })
        .catch(function(error) {
            console.error('Error:', error);
            showNotification('خطا در تغییر وضعیت', 'error');
            closeConfirmModal();
        });
}

function closeConfirmModal() {
    currentToggleId = null;
    currentToggleStatus = null;
    const confirmModal = document.getElementById('confirmModal');
    if (confirmModal) {
        confirmModal.classList.add('hidden');
    }
}
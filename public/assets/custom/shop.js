// ==============================================
// لودینگ عمومی درخواست‌های Ajax
// ==============================================
(function() {
    if (!window.fetch) return;

    var originalFetch = window.fetch.bind(window);
    var activeRequests = 0;
    var showTimer = null;
    var shownAt = 0;

    function getLoader() {
        return document.getElementById('shopAjaxLoader');
    }

    function showLoader() {
        clearTimeout(showTimer);
        showTimer = setTimeout(function() {
            if (activeRequests < 1) return;
            var loader = getLoader();
            if (!loader) return;
            shownAt = Date.now();
            loader.classList.add('is-active');
            loader.setAttribute('aria-hidden', 'false');
        }, 120);
    }

    function hideLoader() {
        clearTimeout(showTimer);
        if (activeRequests > 0) return;
        var loader = getLoader();
        if (!loader) return;
        var remaining = Math.max(0, 250 - (Date.now() - shownAt));
        setTimeout(function() {
            if (activeRequests > 0) return;
            loader.classList.remove('is-active');
            loader.setAttribute('aria-hidden', 'true');
        }, remaining);
    }

    window.fetch = function() {
        activeRequests++;
        showLoader();

        var request;
        try {
            request = originalFetch.apply(null, arguments);
        } catch (error) {
            activeRequests = Math.max(0, activeRequests - 1);
            hideLoader();
            throw error;
        }

        return request.finally(function() {
            activeRequests = Math.max(0, activeRequests - 1);
            hideLoader();
        });
    };
})();

// ==============================================
// جستجوی عمومی فروشگاه
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    var forms = document.querySelectorAll('[data-shop-search]');

    forms.forEach(function(form) {
    var input = form.querySelector('[data-search-input]');
    var results = form.querySelector('[data-search-results]');
    if (!input || !results) return;
    var debounceTimer = null;
    var activeRequest = null;

    function closeResults() {
        results.classList.add('hidden');
        input.setAttribute('aria-expanded', 'false');
    }

    function openResults() {
        results.classList.remove('hidden');
        input.setAttribute('aria-expanded', 'true');
    }

    function addMessage(message) {
        results.replaceChildren();
        var element = document.createElement('p');
        element.className = 'p-4 text-sm text-gray-500 dark:text-gray-400 text-center';
        element.textContent = message;
        results.appendChild(element);
        openResults();
    }

    function addSuggestion(item) {
        var link = document.createElement('a');
        link.href = item.url;
        link.className = 'flex items-center gap-3 p-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors';
        link.setAttribute('role', 'option');

        var image = document.createElement('img');
        image.src = item.image;
        image.alt = '';
        image.loading = 'lazy';
        image.className = 'w-12 h-12 object-cover rounded-lg shrink-0 bg-gray-100 dark:bg-gray-800';

        var content = document.createElement('div');
        content.className = 'min-w-0 flex-1';
        var type = document.createElement('span');
        type.className = item.type === 'product'
            ? 'text-xs text-primary-600 dark:text-primary-400'
            : 'text-xs text-gray-500 dark:text-gray-400';
        type.textContent = item.type === 'category' ? 'دسته‌بندی' : (item.type === 'article' ? 'مقاله' : 'محصول');
        var title = document.createElement('p');
        title.className = 'text-sm font-bold text-gray-800 dark:text-gray-100 truncate';
        title.textContent = item.title;
        var price = document.createElement('p');
        if (item.type === 'product') {
            price.className = item.is_in_stock
                ? 'mt-1 text-xs text-gray-600 dark:text-gray-300'
                : 'mt-1 text-xs text-red-500';
            price.textContent = item.is_in_stock
                ? Number(item.final_price).toLocaleString('fa-IR') + ' تومان'
                : 'ناموجود';
        } else {
            price.className = 'mt-1 text-xs text-gray-500 dark:text-gray-400 truncate';
            price.textContent = item.subtitle || '';
        }

        content.append(type, title, price);
        link.append(image, content);
        results.appendChild(link);
    }

    function renderSuggestions(data) {
        results.replaceChildren();
        if (!data.items.length) {
            addMessage('محصولی پیدا نشد');
            return;
        }

        var currentType = null;
        var typeLabels = {product: 'محصولات', article: 'مقالات', category: 'دسته‌بندی‌ها'};
        data.items.forEach(function(item) {
            if (item.type !== currentType) {
                currentType = item.type;
                var heading = document.createElement('p');
                heading.className = 'px-3 py-2 text-xs font-bold text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800';
                heading.textContent = typeLabels[item.type] || 'نتایج';
                results.appendChild(heading);
            }
            addSuggestion(item);
        });

        var allResults = document.createElement('a');
        var url = new URL(form.action, window.location.href);
        url.searchParams.set('q', data.query);
        allResults.href = url.toString();
        allResults.className = 'flex items-center justify-center gap-1 p-3 text-center text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors';

        var allResultsLabel = document.createElement('span');
        allResultsLabel.className = 'text-primary-600 dark:text-primary-400';
        allResultsLabel.textContent = 'مشاهده همه';

        var allResultsCount = document.createElement('span');
        allResultsCount.className = 'text-gray-500 dark:text-gray-400';
        allResultsCount.textContent = Number(data.total).toLocaleString('fa-IR') + ' نتیجه';

        allResults.append(allResultsLabel, allResultsCount);
        results.appendChild(allResults);
        openResults();
    }

    function loadSuggestions(query) {
        if (activeRequest) activeRequest.abort();
        activeRequest = new AbortController();

        var endpoint = new URL(form.action.replace(/\/?$/, '/suggestions'), window.location.href);
        endpoint.searchParams.set('q', query);

        fetch(endpoint.toString(), {
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            signal: activeRequest.signal
        })
            .then(function(response) {
                if (!response.ok) throw new Error('Search request failed');
                return response.json();
            })
            .then(renderSuggestions)
            .catch(function(error) {
                if (error.name !== 'AbortError') addMessage('خطا در دریافت نتایج جستجو');
            });
    }

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        var query = input.value.trim();
        if (query.length < 2) {
            if (activeRequest) activeRequest.abort();
            closeResults();
            return;
        }
        debounceTimer = setTimeout(function() { loadSuggestions(query); }, 300);
    });

    input.addEventListener('focus', function() {
        if (results.childElementCount && input.value.trim().length >= 2) openResults();
    });

    document.addEventListener('click', function(event) {
        if (!form.contains(event.target)) closeResults();
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeResults();
    });
    });

    var mobileSearchTrigger = document.querySelector('[data-modal-target="SearchModal"]');
    var mobileSearchInput = document.getElementById('mobileShopSearchInput');
    if (mobileSearchTrigger && mobileSearchInput) {
        mobileSearchTrigger.addEventListener('click', function() {
            setTimeout(function() { mobileSearchInput.focus(); }, 50);
        });
    }
});

// ==============================================
// نمایش نوتیفیکیشن
// ==============================================
function showNotification(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };

    const bgColor = colors[type] || colors.info;

    const notification = document.createElement('div');
    notification.className = `fixed top-4 end-4 z-50 ${bgColor} text-white p-4 rounded-lg shadow-lg transform transition-all duration-300 opacity-0 translate-y-4`;
    notification.innerHTML = `
        <div class="flex items-center justify-between">
            <span>${message}</span>
            <button class="ms-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    requestAnimationFrame(() => {
        notification.classList.remove('opacity-0', 'translate-y-4');
        notification.classList.add('opacity-100', 'translate-y-0');
    });

    setTimeout(() => {
        notification.classList.remove('opacity-100', 'translate-y-0');
        notification.classList.add('opacity-0', 'translate-y-4');
        setTimeout(() => {
            if (notification.parentNode) notification.remove();
        }, 300);
    }, 4000);
}

// Public API used by inline scripts and page-specific bundles.
window.showNotification = showNotification;

// ==============================================
// عملیات سبد خرید (مشترک بین همه صفحه‌ها)
// ==============================================
const Cart = {
    add: function(productId, colorOptionId, sizeOptionId, quantity) {
        var formData = new FormData();
        formData.append('product_id', productId);
        if (colorOptionId) formData.append('color_option_id', colorOptionId);
        if (sizeOptionId) formData.append('size_option_id', sizeOptionId);
        formData.append('quantity', quantity || 1);

        return fetch(BASE_URL + 'cart/add', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
            .then(r => r.json())
            .then(function(data) {
                if (data.status === 'success') {
                    window.showNotification(data.message || 'به سبد خرید اضافه شد', 'success');
                    window.ShopCart.updateBadge();
                    window.ShopCart.loadOffcanvas();
                } else {
                    window.showNotification(data.message || 'افزودن به سبد خرید انجام نشد', 'error');
                }
                return data;
            })
            .catch(function(error) {
                console.error('Error adding item to cart:', error);
                window.showNotification('خطا در افزودن به سبد خرید', 'error');
            });
    },

    updateQuantity: function(itemId, quantity) {
        var formData = new FormData();
        formData.append('item_id', itemId);
        formData.append('quantity', quantity);

        return fetch(BASE_URL + 'cart/update', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
            .then(r => r.json())
            .then(function(data) {
                if (data.status === 'success') {
                    window.ShopCart.updateBadge();
                    window.ShopCart.loadOffcanvas();
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
                return data;
            })
            .catch(function() {
                showNotification('خطا در آپدیت تعداد', 'error');
            });
    },

    remove: function(itemId) {
        var formData = new FormData();
        formData.append('item_id', itemId);

        return fetch(BASE_URL + 'cart/remove', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
            .then(r => r.json())
            .then(function(data) {
                if (data.status === 'success') {
                    window.ShopCart.updateBadge();
                    window.ShopCart.loadOffcanvas();
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
                return data;
            })
            .catch(function() {
                showNotification('خطا در حذف از سبد خرید', 'error');
            });
    }
};

// ==============================================
// مدیریت کانواس و بج (مشترک بین همه صفحه‌ها)
// ==============================================
const ShopCart = {
    // تشخیص اینکه در صفحه سبد خرید هستیم یا نه
    isCartPage: function() {
        return document.querySelector('.cart-page-items') !== null;
    },

    updateBadge: function() {
        fetch(BASE_URL + 'cart/count')
            .then(r => r.json())
            .then(function(data) {
                var count = data.count || 0;

                var badge = document.getElementById('cart-badge');
                if (badge) badge.textContent = count;

                var badgeMobile = document.getElementById('cart-badge-mobile');
                if (badgeMobile) badgeMobile.textContent = count;
            })
            .catch(function(error) {
                console.error('Error updating badge:', error);
            });
    },

    loadOffcanvas: function() {
        // اگر در صفحه سبد خرید هستیم، کاری نکن
        if (this.isCartPage()) return;

        fetch(BASE_URL + 'cart/offcanvas')
            .then(r => r.json())
            .then(function(data) {
                var container = document.querySelector('#offcanvas-left main');
                if (container) {
                    container.innerHTML = data.html;
                    window.ShopCart.bindOffcanvasEvents();
                }

                // آپدیت جمع کل
                var totalEl = document.getElementById('offcanvas-total');
                var subtotalContainer = document.getElementById('offcanvas-subtotal-container');
                var subtotalValueEl = document.getElementById('offcanvas-subtotal-value');
                var discountBadge = document.getElementById('offcanvas-discount-badge');
                var discountPercentEl = document.getElementById('offcanvas-discount-percent');

                if (totalEl && data.total_price !== undefined) {
                    totalEl.textContent = data.total_price.toLocaleString('fa-IR') + ' تومان';
                }

                if (data.total_discount > 0) {
                    if (subtotalContainer && subtotalValueEl) {
                        subtotalValueEl.textContent = data.subtotal.toLocaleString('fa-IR');
                        subtotalContainer.style.display = 'flex';
                    }

                    if (discountBadge && discountPercentEl && data.discount_percent > 0) {
                        discountPercentEl.textContent = data.discount_percent;
                        discountBadge.style.display = 'inline-block';
                    }
                } else {
                    if (subtotalContainer) subtotalContainer.style.display = 'none';
                    if (discountBadge) discountBadge.style.display = 'none';
                }
            })
            .catch(function(error) {
                console.error('Error loading offcanvas:', error);
            });
    },

    // فقط دکمه‌های داخل کانواس
    bindOffcanvasEvents: function() {
        var offcanvas = document.getElementById('offcanvas-left');
        if (!offcanvas) return;

        offcanvas.querySelectorAll('.cart-qty-plus').forEach(function(btn) {
            btn.onclick = function(e) {
                e.preventDefault();
                var item = this.closest('.cart-item');
                if (!item) return;
                var qty = parseInt(item.querySelector('.cart-qty-text').textContent) + 1;
                Cart.updateQuantity(item.dataset.itemId, qty);
            };
        });

        offcanvas.querySelectorAll('.cart-qty-minus').forEach(function(btn) {
            btn.onclick = function(e) {
                e.preventDefault();
                var item = this.closest('.cart-item');
                if (!item) return;
                var qtyEl = item.querySelector('.cart-qty-text');
                var oldQty = parseInt(qtyEl.textContent);

                // اگر تعداد 1 است، کاری نکن
                if (oldQty <= 1) return;

                var qty = oldQty - 1;
                qtyEl.textContent = qty;
                Cart.updateQuantity(item.dataset.itemId, qty);
            };
        });

        offcanvas.querySelectorAll('.cart-remove-btn').forEach(function(btn) {
            btn.onclick = function(e) {
                e.preventDefault();
                var item = this.closest('.cart-item');
                if (!item) return;
                if (confirm('آیا از حذف این آیتم اطمینان دارید؟')) {
                    Cart.remove(item.dataset.itemId);
                }
            };
        });
    }
};

// Public API used by cart.js and dynamically rendered cart controls.
window.Cart = Cart;
window.ShopCart = ShopCart;

// ==============================================
// اجرا در DOM ready
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    window.ShopCart.updateBadge();
    window.ShopCart.loadOffcanvas();
});

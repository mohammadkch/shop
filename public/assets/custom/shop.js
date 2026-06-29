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
                    ShopCart.updateBadge();
                    ShopCart.loadOffcanvas();
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
                return data;
            })
            .catch(function() {
                showNotification('خطا در افزودن به سبد خرید', 'error');
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
                    ShopCart.updateBadge();
                    ShopCart.loadOffcanvas();
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
                    ShopCart.updateBadge();
                    ShopCart.loadOffcanvas();
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
        fetch(BASE_URL + 'cart/offcanvas')
            .then(r => r.text())
            .then(function(html) {
                var container = document.querySelector('#offcanvas-left main');
                if (container) {
                    container.innerHTML = html;
                    ShopCart.bindOffcanvasEvents();
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
                var qty = parseInt(item.querySelector('.cart-qty-text').textContent) - 1;
                if (qty < 1) qty = 1;
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

// ==============================================
// اجرا در DOM ready
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    ShopCart.updateBadge();
    ShopCart.loadOffcanvas();
});
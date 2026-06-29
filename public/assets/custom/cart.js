// ==============================================
// افزودن به سبد خرید (مخصوص صفحه محصول)
// ==============================================
window.addToCart = function(productId, colorOptionId, sizeOptionId) {
    var quantityInput = document.getElementById('count11');
    var quantity = quantityInput ? parseInt(quantityInput.textContent) || 1 : 1;

    var btn = document.getElementById('addToCartBtn');
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'در حال افزودن...';
    }

    Cart.add(productId, colorOptionId, sizeOptionId, quantity)
        .finally(function() {
            if (btn) {
                btn.disabled = false;
                btn.textContent = 'افزودن به سبد خرید';
            }
        });
};

document.addEventListener('DOMContentLoaded', function() {

    // ==============================================
    // دکمه افزودن به سبد (صفحه محصول)
    // ==============================================
    var addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault();

            var productId = parseInt(this.dataset.productId) || 0;
            var selectedColor = document.querySelector('.color-radio:checked');
            var selectedSize = document.querySelector('.size-radio:checked');

            var colorOptionId = selectedColor ? parseInt(selectedColor.dataset.optionId) : null;
            var sizeOptionId = selectedSize ? parseInt(selectedSize.dataset.optionId) : null;

            if (!colorOptionId || !sizeOptionId) {
                showNotification('لطفاً رنگ و سایز را انتخاب کنید', 'warning');
                return;
            }

            if (!productId) {
                showNotification('محصول یافت نشد', 'error');
                return;
            }

            window.addToCart(productId, colorOptionId, sizeOptionId);
        });
    }

    // ==============================================
    // دکمه‌های + و - و حذف در صفحه cart/index
    // ==============================================
    var cartPage = document.querySelector('.cart-page-items');
    if (!cartPage) return;

    function bindCartPageEvents() {
        cartPage.querySelectorAll('.cart-qty-plus').forEach(function(btn) {
            btn.onclick = function(e) {
                e.preventDefault();
                var item = this.closest('.cart-item');
                if (!item) return;
                var qtyEl = item.querySelector('.cart-qty-text');
                var qty = parseInt(qtyEl.textContent) + 1;
                qtyEl.textContent = qty;
                Cart.updateQuantity(item.dataset.itemId, qty).then(function(data) {
                    if (data && data.status === 'success') {
                        updateCartPageSummary(data);
                    }
                });
            };
        });

        cartPage.querySelectorAll('.cart-qty-minus').forEach(function(btn) {
            btn.onclick = function(e) {
                e.preventDefault();
                var item = this.closest('.cart-item');
                if (!item) return;
                var qtyEl = item.querySelector('.cart-qty-text');
                var qty = parseInt(qtyEl.textContent) - 1;
                if (qty < 1) qty = 1;
                qtyEl.textContent = qty;
                Cart.updateQuantity(item.dataset.itemId, qty).then(function(data) {
                    if (data && data.status === 'success') {
                        updateCartPageSummary(data);
                    }
                });
            };
        });

        cartPage.querySelectorAll('.cart-remove-btn').forEach(function(btn) {
            btn.onclick = function(e) {
                e.preventDefault();
                var item = this.closest('.cart-item');
                if (!item) return;
                if (confirm('آیا از حذف این آیتم اطمینان دارید؟')) {
                    Cart.remove(item.dataset.itemId).then(function(data) {
                        if (data && data.status === 'success') {
                            item.remove();
                            updateCartPageSummary(data);
                        }
                    });
                }
            };
        });
    }

    // آپدیت قیمت کل در صفحه cart/index بدون reload
    function updateCartPageSummary(data) {
        if (data.total_price !== undefined) {
            var totalEl = document.getElementById('cart-page-total');
            if (totalEl) totalEl.textContent = Number(data.total_price).toLocaleString('fa-IR') + ' تومان';
        }
        if (data.total_items !== undefined) {
            var countEl = document.getElementById('cart-page-count');
            if (countEl) countEl.textContent = data.total_items + ' کالا در سبد خرید شما';
        }
    }

    bindCartPageEvents();
});
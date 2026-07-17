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
                var oldQty = parseInt(qtyEl.textContent);
                var qty = oldQty + 1;
                qtyEl.textContent = qty;

                Cart.updateQuantity(item.dataset.itemId, qty).then(function(data) {
                    if (data && data.status === 'success') {
                        updateCartPageSummary(data);
                    } else {
                        qtyEl.textContent = oldQty;
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
                var oldQty = parseInt(qtyEl.textContent);

                // اگر تعداد 1 است، کاری نکن
                if (oldQty <= 1) return;

                var qty = oldQty - 1;
                qtyEl.textContent = qty;

                Cart.updateQuantity(item.dataset.itemId, qty).then(function(data) {
                    if (data && data.status === 'success') {
                        updateCartPageSummary(data);
                    } else {
                        qtyEl.textContent = oldQty;
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
                            // اگر سبد خالی شد، مستقیم ریلود کن
                            if (data.total_items === 0) {
                                location.reload();
                                return;
                            }
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
        // اگر سبد خالی شد، ریلود کن
        if (data.total_items !== undefined && data.total_items === 0) {
            location.reload();
            return;
        }

        // آپدیت مبلغ قابل پرداخت
        if (data.total_price !== undefined) {
            var totalEl = document.getElementById('cart-page-total');
            if (totalEl) totalEl.textContent = Number(data.total_price).toLocaleString('fa-IR') + ' تومان';
        }

        // آپدیت تعداد
        if (data.total_items !== undefined) {
            var countEl = document.getElementById('cart-page-count');
            if (countEl) {
                countEl.textContent = data.total_items + ' کالا در سبد خرید شما';
            }
        }

        // آپدیت جمع کل با id مستقیم
        if (data.subtotal !== undefined) {
            var subtotalEl = document.getElementById('cart-subtotal');
            if (subtotalEl) {
                subtotalEl.textContent = Number(data.subtotal).toLocaleString('fa-IR') + ' تومان';
            }
        }

        // آپدیت تخفیف با id مستقیم
        if (data.total_discount !== undefined) {
            var discountEl = document.getElementById('cart-discount');
            var discountRow = document.getElementById('cart-discount-row');
            if (discountEl && discountRow) {
                if (data.total_discount > 0) {
                    discountEl.textContent = '-' + Number(data.total_discount).toLocaleString('fa-IR') + ' تومان';
                    discountRow.style.display = 'flex';
                } else {
                    discountRow.style.display = 'none';
                }
            }
        }
    }

    bindCartPageEvents();
});
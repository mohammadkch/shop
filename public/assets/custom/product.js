// ==============================================
// متغیرهای سراسری
// ==============================================
window.selectedColorId = null;
window.selectedSizeId = null;

// ==============================================
// تابع کمکی برای به‌روزرسانی استایل‌های یک گروه (رنگ یا سایز)
// ==============================================
function updateRadioGroupStyles(selector, selectedId) {
    const radios = document.querySelectorAll(selector);
    radios.forEach(radio => {
        const label = radio.nextElementSibling;
        const isChecked = (parseInt(radio.dataset.optionId) === selectedId);

        // بروزرسانی وضعیت checked
        radio.checked = isChecked;

        if (label) {
            if (isChecked) {
                // اضافه کردن کلاس‌های active (همانند حالت :checked)
                label.classList.add('peer-checked:text-gray-900', 'peer-checked:border-primary-500');
                if (selector === '.size-radio') {
                    label.classList.add('peer-checked:text-white', 'peer-checked:bg-primary-500', 'peer-checked:border-primary-500');
                } else {
                    label.classList.add('peer-checked:text-gray-900', 'peer-checked:border-primary-500');
                }
                // حذف کلاس‌های غیرفعال (در صورت وجود)
                label.classList.remove('opacity-50', 'cursor-not-allowed', 'border-gray-300', 'dark:border-gray-600');
                label.classList.add('border-gray-200', 'dark:border-gray-600');
            } else {
                // حذف کلاس‌های active
                label.classList.remove('peer-checked:text-gray-900', 'peer-checked:border-primary-500', 'peer-checked:text-white', 'peer-checked:bg-primary-500');
            }
        }
    });
}

// ==============================================
// تابع اصلی بروزرسانی
// ==============================================
function updateProduct() {
    // ۱. اگر شناسه‌ها تعیین نشده‌اند، از رادیوهای checked یا اولین گزینه استفاده کن
    if (window.selectedColorId === null || window.selectedSizeId === null) {
        const checkedColor = document.querySelector('.color-radio:checked');
        const checkedSize = document.querySelector('.size-radio:checked');
        if (checkedColor && checkedSize) {
            window.selectedColorId = parseInt(checkedColor.dataset.optionId);
            window.selectedSizeId = parseInt(checkedSize.dataset.optionId);
        } else {
            const firstColor = document.querySelector('.color-radio');
            const firstSize = document.querySelector('.size-radio');
            if (firstColor && firstSize) {
                window.selectedColorId = parseInt(firstColor.dataset.optionId);
                window.selectedSizeId = parseInt(firstSize.dataset.optionId);
            } else {
                return;
            }
        }
    }

    // ۲. پیدا کردن رادیوهای مربوطه
    let colorRadio = document.querySelector(`.color-radio[data-option-id="${window.selectedColorId}"]`);
    let sizeRadio = document.querySelector(`.size-radio[data-option-id="${window.selectedSizeId}"]`);

    if (!colorRadio || !sizeRadio) {
        const checkedColor = document.querySelector('.color-radio:checked');
        const checkedSize = document.querySelector('.size-radio:checked');
        if (checkedColor && checkedSize) {
            window.selectedColorId = parseInt(checkedColor.dataset.optionId);
            window.selectedSizeId = parseInt(checkedSize.dataset.optionId);
            colorRadio = checkedColor;
            sizeRadio = checkedSize;
        } else {
            return;
        }
    }

    const colorId = window.selectedColorId;
    const sizeId = window.selectedSizeId;
    const key = colorId + '_' + sizeId;
    let stock = (window.stockMap && window.stockMap[key] !== undefined) ? window.stockMap[key] : 0;

    // ۳. اگر موجودی صفر است، برای همان رنگ یک سایز موجود پیدا کن
    if (stock <= 0) {
        const sizeRadios = document.querySelectorAll('.size-radio');
        let foundSizeId = null;
        for (const radio of sizeRadios) {
            const candidateSizeId = parseInt(radio.dataset.optionId);
            const candidateKey = colorId + '_' + candidateSizeId;
            if (window.stockMap && window.stockMap[candidateKey] > 0) {
                foundSizeId = candidateSizeId;
                break;
            }
        }
        if (foundSizeId !== null) {
            window.selectedSizeId = foundSizeId;
            updateProduct();
            return;
        } else {
            updatePriceAndStock(colorRadio, sizeRadio);
            updateOptions();
            updateRadioGroupStyles('.color-radio', window.selectedColorId);
            updateRadioGroupStyles('.size-radio', window.selectedSizeId);
            return;
        }
    }

    // ۴. ترکیب موجود است → رادیوها را انتخاب کن و استایل‌ها را به‌روز کن
    updateRadioGroupStyles('.color-radio', window.selectedColorId);
    updateRadioGroupStyles('.size-radio', window.selectedSizeId);

    // ۵. اول آپشن‌ها رو به‌روز کن تا data-price و data-sale-price سایزها درست بشن
    updateOptions();

    // ۶. حالا قیمت و موجودی رو بروزرسانی کن
    updatePriceAndStock(colorRadio, sizeRadio);

    // ۷. دوباره مطمئن شو که سایز انتخاب‌شده استایل active دارد
    updateRadioGroupStyles('.size-radio', window.selectedSizeId);
}

// ==============================================
// تابع بروزرسانی قیمت و موجودی
// ==============================================
function updatePriceAndStock(colorRadio, sizeRadio) {
    const colorId = parseInt(colorRadio.dataset.optionId);
    const sizeId = parseInt(sizeRadio.dataset.optionId);
    const key = colorId + '_' + sizeId;
    let stock = (window.stockMap && window.stockMap[key] !== undefined) ? window.stockMap[key] : 0;

    let price = parseFloat(colorRadio.dataset.price) || 0;
    let salePrice = parseFloat(colorRadio.dataset.salePrice) || 0;
    const sizePrice = parseFloat(sizeRadio.dataset.price) || 0;
    const sizeSalePrice = parseFloat(sizeRadio.dataset.salePrice) || 0;
    if (sizePrice > 0) {
        price = sizePrice;
        salePrice = sizeSalePrice;
    }

    let finalPrice = price;
    let originalPrice = price;
    let hasDiscount = false;
    let discountPercent = 0;
    if (salePrice > 0 && salePrice < price) {
        finalPrice = salePrice;
        originalPrice = price;
        hasDiscount = true;
        discountPercent = Math.round(((price - salePrice) / price) * 100);
    }

    const finalDisplay = document.getElementById('finalPriceDisplay');
    const originalDisplay = document.getElementById('originalPriceDisplay');
    const discountBadge = document.getElementById('discountBadge');
    if (finalDisplay) finalDisplay.textContent = finalPrice.toLocaleString('fa-IR');
    if (originalDisplay) {
        const del = originalDisplay.closest('del');
        if (hasDiscount) {
            originalDisplay.textContent = originalPrice.toLocaleString('fa-IR');
            if (del) del.style.display = 'inline';
        } else {
            if (del) del.style.display = 'none';
        }
    }
    if (discountBadge) {
        if (hasDiscount && discountPercent > 0) {
            discountBadge.textContent = discountPercent + '%';
            discountBadge.style.display = 'inline-block';
        } else {
            discountBadge.style.display = 'none';
        }
    }

    const stockDisplay = document.getElementById('stockDisplay');
    if (stockDisplay) {
        if (stock > 0) {
            stockDisplay.textContent = stock.toLocaleString('fa-IR') + ' عدد';
            stockDisplay.className = 'text-sm font-bold text-green-600';
        } else {
            stockDisplay.textContent = 'ناموجود';
            stockDisplay.className = 'text-sm font-bold text-red-600';
        }
    }

    const addBtn = document.getElementById('addToCartBtn');
    if (addBtn) {
        if (stock > 0) {
            addBtn.disabled = false;
            addBtn.className = 'bg-primary shadow-primary-500 w-full mt-3 hover:bg-primary-600 text-white font-semibold rounded-xl px-6 py-4 text-sm';
            addBtn.textContent = 'افزودن به سبد خرید';
        } else {
            addBtn.disabled = true;
            addBtn.className = 'bg-gray-300 dark:bg-zinc-700 w-full mt-3 text-gray-500 dark:text-gray-400 font-semibold rounded-xl px-6 py-4 text-sm cursor-not-allowed';
            addBtn.textContent = 'ناموجود';
        }
    }


}

// ==============================================
// تابع به‌روزرسانی وضعیت رنگ‌ها و سایزها (فعال/غیرفعال)
// ==============================================
function updateOptions() {
    const colorRadios = document.querySelectorAll('.color-radio');
    const sizeRadios = document.querySelectorAll('.size-radio');

    // ۱. بروزرسانی رنگ‌ها: غیرفعال کردن رنگ‌هایی که هیچ سایزی برای آنها موجود نیست
    colorRadios.forEach(colorRadio => {
        const colorId = parseInt(colorRadio.dataset.optionId);
        let hasAnyStock = false;
        if (window.stockMap) {
            for (const [key, stock] of Object.entries(window.stockMap)) {
                const [cId, sId] = key.split('_').map(Number);
                if (cId === colorId && stock > 0) {
                    hasAnyStock = true;
                    break;
                }
            }
        }
        const label = colorRadio.nextElementSibling;
        if (hasAnyStock) {
            colorRadio.disabled = false;
            if (label) {
                label.classList.remove('opacity-50', 'cursor-not-allowed', 'border-gray-300', 'dark:border-gray-600');
                label.classList.add('border-gray-200', 'dark:border-gray-600');
                const outOfStockSpan = label.querySelector('.text-red-500');
                if (outOfStockSpan) outOfStockSpan.remove();
            }
        } else {
            colorRadio.disabled = true;
            if (label) {
                label.classList.add('opacity-50', 'cursor-not-allowed', 'border-gray-300', 'dark:border-gray-600');
                label.classList.remove('border-gray-200', 'dark:border-gray-600');
                label.classList.remove('peer-checked:text-gray-900', 'peer-checked:border-primary-500', 'peer-checked:text-white', 'peer-checked:bg-primary-500');
                if (!label.querySelector('.text-red-500')) {
                    const span = document.createElement('span');
                    span.className = 'text-xs text-red-500 ms-1';
                    span.textContent = '(ناموجود)';
                    label.appendChild(span);
                }
            }
        }
    });

    // ۲. بروزرسانی سایزها بر اساس رنگ انتخاب‌شده
    const selectedColorRadio = document.querySelector(`.color-radio[data-option-id="${window.selectedColorId}"]`);
    if (!selectedColorRadio) return;
    const selectedColorId = parseInt(selectedColorRadio.dataset.optionId);

    sizeRadios.forEach(sizeRadio => {
        const sizeId = parseInt(sizeRadio.dataset.optionId);
        const key = selectedColorId + '_' + sizeId;
        const stock = (window.stockMap && window.stockMap[key] !== undefined) ? window.stockMap[key] : 0;
        const label = sizeRadio.nextElementSibling;

        if (stock > 0) {
            sizeRadio.disabled = false;
            sizeRadio.dataset.stock = stock;
            if (label) {
                label.classList.remove('opacity-50', 'cursor-not-allowed', 'border-gray-300', 'dark:border-gray-600');
                label.classList.add('border-gray-200', 'dark:border-gray-600');
                const outOfStockSpan = label.querySelector('.text-red-500');
                if (outOfStockSpan) outOfStockSpan.remove();
            }
        } else {
            sizeRadio.disabled = true;
            sizeRadio.dataset.stock = 0;
            if (label) {
                label.classList.add('opacity-50', 'cursor-not-allowed', 'border-gray-300', 'dark:border-gray-600');
                label.classList.remove('border-gray-200', 'dark:border-gray-600');
                label.classList.remove('peer-checked:text-gray-900', 'peer-checked:border-primary-500', 'peer-checked:text-white', 'peer-checked:bg-primary-500');
                if (!label.querySelector('.text-red-500')) {
                    const span = document.createElement('span');
                    span.className = 'text-xs text-red-500 ms-1';
                    span.textContent = '(ناموجود)';
                    label.appendChild(span);
                }
            }
        }

        // *** اضافه کردن بخش جدید: به‌روزرسانی داده‌های قیمت سایزها ***
        if (window.priceMap && window.priceMap[key]) {
            const priceData = window.priceMap[key];
            sizeRadio.dataset.price = priceData.price;
            sizeRadio.dataset.salePrice = priceData.sale_price;
        } else {
            sizeRadio.dataset.price = 0;
            sizeRadio.dataset.salePrice = 0;
        }
    });
}
// ==============================================
// اتصال رویدادها و مقداردهی اولیه
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    const initialColor = document.querySelector('.color-radio:checked');
    const initialSize = document.querySelector('.size-radio:checked');
    if (initialColor && initialSize) {
        window.selectedColorId = parseInt(initialColor.dataset.optionId);
        window.selectedSizeId = parseInt(initialSize.dataset.optionId);
    } else {
        const firstColor = document.querySelector('.color-radio');
        const firstSize = document.querySelector('.size-radio');
        if (firstColor && firstSize) {
            window.selectedColorId = parseInt(firstColor.dataset.optionId);
            window.selectedSizeId = parseInt(firstSize.dataset.optionId);
        }
    }

    updateProduct();

    document.querySelectorAll('.color-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            // فقط در صورتی که غیرفعال نباشد، اجازه تغییر بده
            if (!this.disabled) {
                window.selectedColorId = parseInt(this.dataset.optionId);
                updateProduct();
            }
        });
    });

    document.querySelectorAll('.size-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (!this.disabled) {
                window.selectedSizeId = parseInt(this.dataset.optionId);
                updateProduct();
            }
        });
    });

});
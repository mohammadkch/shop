// ==============================================
// انتخاب آدرس (بدون رادیو باتن)
// ==============================================
function selectAddress(addressId, cityId) {
    // کلاس selected رو از همه کارت‌ها بردار
    document.querySelectorAll('.address-item').forEach(card => {
        card.classList.remove('border-primary-500', 'bg-blue-50', 'dark:bg-zinc-800');
        card.classList.add('border-gray-200', 'dark:border-gray-600');
    });

    // کلاس selected رو به کارت انتخاب شده اضافه کن
    const selectedCard = document.querySelector(`.address-item[data-address-id="${addressId}"]`);
    if (selectedCard) {
        selectedCard.classList.remove('border-gray-200', 'dark:border-gray-600');
        selectedCard.classList.add('border-primary-500', 'bg-blue-50', 'dark:bg-zinc-800');
    }

    // ذخیره آیدی آدرس انتخاب شده در یه hidden input
    const hiddenInput = document.getElementById('selected_address_id_input');
    if (hiddenInput) {
        hiddenInput.value = addressId;
    }

    // دریافت قیمت ارسال
    fetchShippingPrices(addressId);
}

// ==============================================
// دریافت قیمت ارسال بر اساس آدرس
// ==============================================
function fetchShippingPrices(addressId) {
    const formData = new FormData();
    formData.append('address_id', addressId);

    fetch(BASE_URL + 'checkout/get-shipping-prices', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                updateShippingPrices(data.shipping_prices);
            }
        })
        .catch(error => {
            console.error('Error fetching shipping prices:', error);
        });
}

// ==============================================
// بروزرسانی قیمت ارسال
// ==============================================
function updateShippingPrices(prices) {
    document.querySelectorAll('.shipping-method').forEach(item => {
        const typeId = item.dataset.shippingId;
        const priceSpan = item.querySelector('.shipping-price-text');
        const statusText = item.querySelector('.shipping-status-text');

        if (typeId && prices[typeId]) {
            // قیمت رو بروز کن
            if (priceSpan) {
                priceSpan.textContent = Number(prices[typeId].price).toLocaleString('fa-IR') + ' تومان';
            }
            // متن وضعیت رو عوض کن
            if (statusText) {
                statusText.textContent = 'ارسال به آدرس انتخاب شده';
            }
            // فعال کن
            item.classList.remove('opacity-50', 'cursor-not-allowed');
            item.style.pointerEvents = 'auto';
            item.onclick = function() {
                selectShippingMethod(this, typeId, prices[typeId].price);
            };
            item.dataset.shippingPrice = prices[typeId].price;
        } else if (typeId) {
            // غیرفعال کن
            if (priceSpan) {
                priceSpan.textContent = 'ناموجود';
            }
            if (statusText) {
                statusText.textContent = 'این روش برای این شهر موجود نیست';
            }
            item.classList.add('opacity-50', 'cursor-not-allowed');
            item.style.pointerEvents = 'none';
            item.onclick = null;
            item.dataset.shippingPrice = 0;
        }
    });

    updateShippingCost();

}

// ==============================================
// بروزرسانی هزینه ارسال در خلاصه
// ==============================================
function updateShippingCost() {
    const selectedMethod = document.querySelector('.shipping-method.border-primary-500');
    const addressCard = document.querySelector('.address-item.border-primary-500');

    if (!selectedMethod || !addressCard) {
        document.getElementById('shippingCostDisplay').textContent = 'انتخاب آدرس و روش ارسال';
        return;
    }

    const price = parseInt(selectedMethod.dataset.shippingPrice) || 0;
    if (price > 0) {
        document.getElementById('shippingCostDisplay').textContent = Number(price).toLocaleString('fa-IR') + ' تومان';
        updateTotalPayable(price);
    } else {
        document.getElementById('shippingCostDisplay').textContent = 'ناموجود';
    }
}


// ==============================================
// انتخاب زمان ارسال
// ==============================================
function selectTime(element, value) {
    document.querySelectorAll('.time-option').forEach(opt => {
        opt.classList.remove('border-primary-500', 'bg-blue-50', 'dark:bg-zinc-800');
        opt.classList.add('border-gray-300', 'dark:border-gray-600');
    });
    element.classList.remove('border-gray-300', 'dark:border-gray-600');
    element.classList.add('border-primary-500', 'bg-blue-50', 'dark:bg-zinc-800');
    document.getElementById('selected_time_input').value = value;
}

// ==============================================
// انتخاب روش ارسال
// ==============================================
function selectShippingMethod(element, typeId, price) {
    if (!price || price <= 0) {
        showNotification('این روش ارسال برای شهر انتخاب شده موجود نیست', 'warning');
        return;
    }

    document.querySelectorAll('.shipping-method').forEach(method => {
        method.classList.remove('border-primary-500', 'bg-blue-50', 'dark:bg-zinc-800');
        method.classList.add('border-gray-300', 'dark:border-gray-600');
    });
    element.classList.remove('border-gray-300', 'dark:border-gray-600');
    element.classList.add('border-primary-500', 'bg-blue-50', 'dark:bg-zinc-800');
    document.getElementById('selected_shipping_type_input').value = typeId;

    updateShippingCostDisplay(price);
}

// ==============================================
// بروزرسانی نمایش هزینه ارسال
// ==============================================
function updateShippingCostDisplay(price) {
    const costDisplay = document.getElementById('shippingCostDisplay');
    if (costDisplay) {
        costDisplay.textContent = Number(price).toLocaleString('fa-IR') + ' تومان';
    }
    updateTotalPayable(price);
}

// ==============================================
// بروزرسانی مبلغ قابل پرداخت
// ==============================================
function updateTotalPayable(shippingPrice) {
    // دریافت مبلغ کل از صفحه (از مقدار موجود در viewData)
    const subtotalElement = document.querySelector('.cart-subtotal-value');
    if (subtotalElement) {
        const subtotal = parseInt(subtotalElement.dataset.subtotal) || 0;
        const total = subtotal + shippingPrice;
        const totalElement = document.getElementById('totalPayable');
        if (totalElement) {
            totalElement.textContent = Number(total).toLocaleString('fa-IR') + ' تومان';
        }
    }
}

// ==============================================
// دکمه افزودن آدرس جدید - نمایش مدال
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    const addAddressBtn = document.getElementById('addAddressBtn');
    if (addAddressBtn) {
        addAddressBtn.addEventListener('click', function() {
            document.getElementById('addressModal').classList.remove('hidden');
        });
    }

    // ====== بستن مدال با کلیک خارج ======
    const addressModal = document.getElementById('addressModal');
    if (addressModal) {
        addressModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddressModal();
            }
        });
    }
});

function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
    document.getElementById('addAddressForm').reset();
    document.getElementById('addressFormError').classList.add('hidden');
}

// ==============================================
// فرم افزودن آدرس جدید - سابمیت
// ==============================================
// فرم افزودن آدرس جدید - سابمیت
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addAddressForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('saveAddressBtn');
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'در حال افزودن...';

            const formData = new FormData(this);

            fetch(BASE_URL + 'checkout/add-address', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.textContent = originalText;

                    if (data.status === 'error') {
                        const errorEl = document.getElementById('addressFormError');
                        errorEl.textContent = data.message;
                        errorEl.classList.remove('hidden');
                        return;
                    }

                    if (data.status === 'success') {
                        // بستن مدال
                        closeAddressModal();

                        // آدرس جدید رو سلکت کن
                        if (data.address_id) {
                            // ریلود نکن! با AJAX آدرس رو به لیست اضافه کن
                            // فعلاً ریلود میکنیم چون ساده‌تره
                            window.location.reload();
                        } else {
                            window.location.reload();
                        }
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    btn.textContent = originalText;
                    console.error('Error adding address:', error);
                });
        });
    }
});

// ==============================================
// تغییر استان - بارگذاری شهرها
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('addressState');
    const citySelect = document.getElementById('addressCity');

    if (stateSelect && citySelect) {
        stateSelect.addEventListener('change', function() {
            const stateId = this.value;
            if (!stateId) {
                citySelect.innerHTML = '<option value="">ابتدا استان را انتخاب کنید</option>';
                return;
            }

            fetch(BASE_URL + 'checkout/get-cities/' + stateId, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">انتخاب شهر</option>';
                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                });
        });
    }
});

// ==============================================
// حذف آدرس
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-address-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const addressId = this.dataset.addressId;

            if (!confirm('آیا از حذف این آدرس اطمینان دارید؟')) {
                return;
            }

            const formData = new FormData();
            formData.append('address_id', addressId);

            fetch(BASE_URL + 'checkout/delete-address', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload();
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error deleting address:', error);
                });
        });
    });
});

// ==============================================
// تغییر روش ارسال - بروزرسانی هزینه
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.shipping-type-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            // کلاس active رو به آیتم اضافه کن
            document.querySelectorAll('.shipping-type-item').forEach(item => {
                item.classList.remove('border-primary', 'bg-primary/5', 'dark:bg-primary/10');
            });
            this.closest('.shipping-type-item').classList.add('border-primary', 'bg-primary/5', 'dark:bg-primary/10');

            updateShippingCost();
        });
    });
});

// ==============================================
// سابمیت فرم shipping (غیر AJAX)
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('shippingForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // ====== جلوگیری از سابمیت چندباره ======
            const btn = document.getElementById('submitShippingBtn');
            if (btn.disabled) {
                e.preventDefault();
                return;
            }

            // ====== اعتبارسنجی قبل از سابمیت ======
            const selectedAddress = document.querySelector('.address-item.border-primary-500');
            const addressId = selectedAddress ? selectedAddress.dataset.addressId : null;

            const selectedShipping = document.querySelector('.shipping-method.border-primary-500');
            const shippingTypeId = selectedShipping ? selectedShipping.dataset.shippingId : null;

            if (!addressId) {
                e.preventDefault();
                showNotification('لطفاً یک آدرس انتخاب کنید', 'warning');
                return;
            }

            if (!shippingTypeId) {
                e.preventDefault();
                showNotification('لطفاً روش ارسال را انتخاب کنید', 'warning');
                return;
            }

            // ====== ست کردن hidden inputs ======
            document.getElementById('selected_address_id_input').value = addressId;
            document.getElementById('selected_shipping_type_input').value = shippingTypeId;

            // ====== غیرفعال کردن دکمه برای جلوگیری از دابل کلیک ======
            btn.disabled = true;
            btn.textContent = 'در حال پردازش...';

            // ====== اجازه بده فرم به صورت معمولی سابمیت بشه ======
            // (کاری نمیکنیم، فرم خودش میره)
        });
    }
});

// ==============================================
// در زمان لود صفحه، اگه آدرسی سلکت شده، قیمت ارسال رو بگیر
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    const selectedAddress = document.querySelector('.address-item.border-primary-500');
    if (selectedAddress) {
        const addressId = selectedAddress.dataset.addressId;
        if (addressId) {
            fetchShippingPrices(addressId);
        }
    }
});

// ==============================================
// کد تخفیف - صفحه payment
// ==============================================
document.addEventListener('DOMContentLoaded', function() {
    const applyBtn = document.getElementById('applyDiscountBtn');
    const discountInput = document.getElementById('discountCode');

    if (applyBtn && discountInput) {
        applyBtn.addEventListener('click', function() {
            const code = discountInput.value.trim();
            if (code) {
                showNotification('کد تخفیف نامعتبر است', 'error');
                discountInput.value = '';
            } else {
                showNotification('لطفاً کد تخفیف را وارد کنید', 'warning');
            }
        });

        discountInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyBtn.click();
            }
        });
    }
});
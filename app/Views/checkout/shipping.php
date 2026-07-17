<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">

            <!-- ====== استپ‌های خرید (timeline) ====== -->
            <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-2 mb-2 sticky top-0">
                <div class="timeline-horizontal mb-0 flex items-center justify-between">
                    <!--Step 1 - Completed-->
                    <div class="timeline-step completed flex flex-col items-center text-center">
                        <div class="timeline-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                            </svg>
                        </div>
                        <div class="timeline-title">سبد خرید</div>
                    </div>

                    <!--Step 2 - Active-->
                    <div class="timeline-step active flex flex-col items-center text-center">
                        <div class="timeline-icon dark:bg-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <div class="timeline-title dark:text-white">انتخاب آدرس</div>
                    </div>

                    <!--Step 3-->
                    <div class="timeline-step flex flex-col items-center text-center">
                        <div class="timeline-icon dark:bg-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5m-16.5 6h3m3 0h3m-9 5.25h12a2.25 2.25 0 002.25-2.25V7.5A2.25 2.25 0 0021.75 5.25H5.25A2.25 2.25 0 003 7.5v9.75A2.25 2.25 0 005.25 18.75z" />
                            </svg>
                        </div>
                        <div class="timeline-title dark:text-white">پرداخت</div>
                    </div>

                    <!--Step 4-->
                    <div class="timeline-step flex flex-col items-center text-center">
                        <div class="timeline-icon dark:bg-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <div class="timeline-title dark:text-white">تکمیل</div>
                    </div>
                </div>
            </div>


            <!-- ====== فرم اصلی ====== -->
            <form id="shippingForm" method="POST" action="<?= base_url('checkout/save-shipping') ?>">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- ====== ستون اصلی (آدرس‌ها + روش ارسال) ====== -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- ====== بخش آدرس‌ها ====== -->
                        <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="font-bold text-lg mb-4 relative pb-4 text-gray-900 dark:text-gray-200
                                before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary
                                after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">انتخاب آدرس</h2>



                                <button type="button" id="addAddressBtn" class="text-primary hover:text-primary-600 text-sm font-medium flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    افزودن آدرس جدید
                                </button>
                            </div>

                            <!-- لیست آدرس‌ها -->
                            <div id="addressList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php if (!empty($addresses)): ?>
                                    <?php foreach ($addresses as $address): ?>
                                        <div class="address-item border rounded-lg p-4 cursor-pointer transition-all
                                            <?= ($selected_address_id ?? 0) == $address['id'] ? 'border-primary-500 bg-blue-50 dark:bg-zinc-800' : 'border-gray-200 dark:border-gray-600 hover:border-primary-300' ?>"
                                             data-address-id="<?= $address['id'] ?>"
                                             data-city-id="<?= $address['city_id'] ?>"
                                             onclick="selectAddress(<?= $address['id'] ?>, <?= $address['city_id'] ?>)">

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-start gap-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                    </svg>
                                                    <div>
                                                        <h4 class="font-medium text-gray-800 dark:text-white">
                                                            <?= esc($address['title'] ?? 'آدرس') ?>
                                                        </h4>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                            <?= esc($address['recipient_name']) ?> - <?= esc($address['recipient_mobile']) ?>
                                                        </p>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                            <?= esc($address['address']) ?>
                                                        </p>
                                                        <div class="flex flex-wrap gap-2 text-xs text-gray-500 dark:text-gray-500 mt-1">
                                                            <span><?= esc($address['state_name']) ?></span>
                                                            <span>|</span>
                                                            <span><?= esc($address['city_name']) ?></span>
                                                            <span>|</span>
                                                            <span><?= esc($address['postal_code']) ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- دکمه انتخاب -->
                                                <button class="select-address-btn text-primary-500 hover:text-primary-700 text-sm dark:text-gray-400 font-medium"
                                                        data-address-id="<?= $address['id'] ?>"
                                                        onclick="event.stopPropagation(); selectAddress(<?= $address['id'] ?>, <?= $address['city_id'] ?>)">
                                                    انتخاب
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-span-1 md:col-span-2 flex justify-center">
                                        <div class="border border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center w-full max-w-md bg-gray-50 dark:bg-gray-800/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">هیچ آدرسی ثبت نشده است</p>
                                            <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">برای افزودن آدرس جدید، روی دکمه زیر کلیک کنید</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                        <!-- ====== بخش روش ارسال ====== -->
                        <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 <?= empty($addresses) ? 'opacity-50 pointer-events-none' : '' ?>"
                             id="shippingSection">
                            <h2 class="font-bold text-lg mb-4 relative pb-4 text-gray-900 dark:text-gray-200
                                before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary
                                after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">انتخاب روش ارسال</h2>

                            <!-- ====== زمان ارسال ====== -->
                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-sm mb-3">زمان ارسال</h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <!-- گزینه ۱: سریع‌ترین زمان ممکن -->
                                    <div class="time-option border rounded-lg p-3 cursor-pointer hover:border-primary-500 transition-all border-primary-500 bg-blue-50 dark:bg-zinc-800 selected"
                                         data-time-value="ASAP" onclick="selectTime(this, 'ASAP')">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/20 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-white text-sm">سریع‌ترین زمان ممکن</h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">ارسال در اسرع وقت</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- گزینه ۲: رزرو تا ۷۲ ساعت -->
                                    <div class="time-option border border-gray-300 dark:border-gray-600 rounded-lg p-3 cursor-pointer hover:border-primary-500 transition-all"
                                         data-time-value="RESERVE" onclick="selectTime(this, 'RESERVE')">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/20 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-white text-sm">رزرو تا ۷۲ ساعت</h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">در صورت پرداخت، سفارش رزرو می‌شود</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden input برای ذخیره مقدار انتخاب شده -->
                                <input type="hidden" name="shipping_time" id="selected_time_input" value="ASAP">
                            </div>

                            <!-- ====== روش ارسال ====== -->
                            <div id="shippingTypesContainer">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-sm mb-3">انتخاب روش ارسال</h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <?php if (!empty($shipping_types)): ?>
                                        <?php foreach ($shipping_types as $type): ?>
                                            <?php
                                            $price = isset($shipping_prices[$type['id']]) ? $shipping_prices[$type['id']]['price'] : null;
                                            $hasPrice = $price !== null;
                                            $isSelected = ($selected_shipping_type_id ?? 0) == $type['id'];
                                            ?>
                                            <div class="shipping-method border rounded-lg p-4 cursor-pointer transition-all
                <?= $isSelected && $hasPrice ? 'border-primary-500 bg-blue-50 dark:bg-zinc-800' : 'border-gray-300 dark:border-gray-600 hover:border-primary-500' ?>
                <?= !$hasPrice ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                                 data-shipping-id="<?= $type['id'] ?>"
                                                 data-shipping-price="<?= $price ?? 0 ?>"
                                                 onclick="<?= $hasPrice ? "selectShippingMethod(this, {$type['id']}, {$price})" : '' ?>">

                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center
            <?= $isSelected && $hasPrice ? 'bg-primary-100 dark:bg-zinc-700' : 'bg-green-100 dark:bg-green-900/20' ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?= $isSelected && $hasPrice ? 'text-primary-600 dark:text-primary-400' : 'text-green-600 dark:text-green-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-medium text-gray-800 dark:text-white text-sm">
                                                                <?= esc($type['name']) ?>
                                                            </h4>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 shipping-status-text">
                                                                <?= $hasPrice ? 'ارسال به آدرس انتخاب شده' : 'این روش برای این شهر موجود نیست' ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="text-left">
                                                        <div class="font-bold text-gray-800 dark:text-white text-sm shipping-price-text">
                                                            <?= $hasPrice ? number_format($price) . ' تومان' : 'ناموجود' ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm col-span-2">روش ارسالی تعریف نشده است</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Hidden input برای ذخیره روش ارسال انتخاب شده -->
                                <input type="hidden" name="shipping_type_id" id="selected_shipping_type_input" value="<?= $selected_shipping_type_id ?? '' ?>">
                            </div>
                        </div>

                    </div>

                    <!-- ====== ستون خلاصه سبد خرید ====== -->
                    <div class="lg:col-span-1">
                        <div class="lg:sticky lg:top-[80px]" style="position: sticky; top: 80px; align-self: flex-start;">
                            <div class="bg-white dark:bg-custom-dark rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                <h2 class="font-bold text-lg mb-4 relative pb-4 text-gray-900 dark:text-gray-200
                                before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary
                                after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                                    خلاصه سفارش
                                </h2>

                                <div class="space-y-3 mb-4">
                                    <!-- آیتم‌های سبد خرید (خلاصه) -->
                                    <?php if (!empty($cart['items'])): ?>
                                        <div class="max-h-60 overflow-y-auto space-y-3">
                                            <?php foreach ($cart['items'] as $item): ?>
                                                <div class="flex items-start gap-3 border-b border-gray-100 dark:border-gray-700 pb-3">
                                                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                                        <?php if (!empty($item['image_name'])): ?>
                                                            <img src="<?= base_url('images/products/' . $item['image_name']) ?>"
                                                                 alt="<?= esc($item['product_name']) ?>"
                                                                 class="w-full h-full object-contain">
                                                        <?php else: ?>
                                                            <span class="text-xs text-gray-500">بدون تصویر</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 line-clamp-2">
                                                            <?= esc($item['product_name']) ?>
                                                        </p>
                                                        <div class="flex items-center justify-between mt-1">
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">تعداد: <?= $item['quantity'] ?></span>
                                                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                                            <?= number_format($item['final_price']) ?>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                                        <div class="flex justify-between py-1">
                                            <span class="text-gray-600 dark:text-gray-400 text-sm">جمع کل:</span>
                                            <span class="text-gray-800 dark:text-gray-200 text-sm font-medium">
                                            <?= number_format($cart['subtotal']) ?> تومان
                                        </span>
                                        </div>

                                        <?php if (isset($cart['total_discount']) && $cart['total_discount'] > 0): ?>
                                            <div class="flex justify-between py-1">
                                                <span class="text-gray-600 dark:text-gray-400 text-sm">تخفیف:</span>
                                                <span class="text-green-600 dark:text-green-400 text-sm font-medium">
                                                -<?= number_format($cart['total_discount']) ?> تومان
                                            </span>
                                            </div>
                                        <?php endif; ?>

                                        <div class="flex justify-between py-1" id="shippingCostRow">
                                            <span class="text-gray-600 dark:text-gray-400 text-sm">هزینه ارسال:</span>
                                            <span class="text-gray-800 dark:text-gray-200 text-sm font-medium" id="shippingCostDisplay">
                                            <?php if (!empty($selected_address_id) && !empty($selected_shipping_type_id)): ?>
                                                <?php
                                                $price = $shipping_prices[$selected_shipping_type_id]['price'] ?? 0;
                                                echo number_format($price) . ' تومان';
                                                ?>
                                            <?php else: ?>
                                                انتخاب آدرس و روش ارسال
                                            <?php endif; ?>
                                        </span>
                                        </div>

                                        <div class="border-t border-gray-300 dark:border-gray-700 pt-3 mt-3">
                                            <div class="flex justify-between">
                                                <span class="text-gray-800 dark:text-white font-bold">مبلغ قابل پرداخت:</span>
                                                <span class="text-gray-800 dark:text-white font-bold text-lg" id="totalPayable">
                                                <?php
                                                $shippingCost = 0;
                                                if (!empty($selected_address_id) && !empty($selected_shipping_type_id) && isset($shipping_prices[$selected_shipping_type_id])) {
                                                    $shippingCost = $shipping_prices[$selected_shipping_type_id]['price'];
                                                }
                                                echo number_format($cart['total_price'] + $shippingCost);
                                                ?> تومان
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- تو فرم shipping قبل از دکمه سابمیت -->
                                <input type="hidden" name="address_id" id="selected_address_id_input" value="<?= $selected_address_id ?? '' ?>">

                                <button type="submit" id="submitShippingBtn"
                                        class="w-full bg-primary shadow-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl px-6 py-4 text-sm transition-all duration-200 flex items-center justify-center gap-2
        <?= empty($addresses) ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                        <?= empty($addresses) ? 'disabled' : '' ?>>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    ادامه / پرداخت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- ====== مدال افزودن آدرس جدید ====== -->
    <div id="addressModal" class="modal hidden fixed inset-0 z-50 overflow-auto backdrop-blur bg-opacity-50">
        <div class="relative p-4 w-full max-w-lg m-auto flex items-center min-h-screen">
            <div class="bg-white relative w-full dark:bg-custom-dark rounded-2xl shadow-soft p-8 border border-gray-100 dark:border-gray-700">
                <!-- دکمه بستن -->
                <button class="absolute p-4 top-0 end-0" onclick="closeAddressModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>

                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-6">افزودن آدرس جدید</h3>

                <form id="addAddressForm">
                    <div class="space-y-4">
                        <!-- عنوان آدرس -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">عنوان آدرس</label>
                            <input type="text" name="title" id="addressTitle"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="خانه، محل کار، ...">
                        </div>

                        <!-- استان -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">استان</label>
                            <select name="state_id" id="addressState"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">انتخاب استان</option>
                                <?php if (!empty($states)): ?>
                                    <?php foreach ($states as $state): ?>
                                        <option value="<?= $state['id'] ?>"><?= esc($state['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- شهر -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">شهر</label>
                            <select name="city_id" id="addressCity"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">ابتدا استان را انتخاب کنید</option>
                            </select>
                        </div>

                        <!-- کد پستی -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">کد پستی</label>
                            <input type="text" name="postal_code" id="addressPostalCode"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="۱۰ رقم" maxlength="10">
                        </div>

                        <!-- آدرس کامل -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">آدرس پستی</label>
                            <textarea name="address" id="addressFull"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                      rows="3" placeholder="آدرس کامل خود را وارد کنید"></textarea>
                        </div>

                        <!-- نام گیرنده -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">نام گیرنده</label>
                            <input type="text" name="recipient_name" id="addressRecipientName"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="نام کامل گیرنده">
                        </div>

                        <!-- موبایل گیرنده -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">موبایل گیرنده</label>
                            <input type="text" name="recipient_mobile" id="addressRecipientMobile"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-custom-dark dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   placeholder="۰۹۱۲xxxxxxx" maxlength="11">
                        </div>

                        <div id="addressFormError" class="text-red-500 text-sm hidden"></div>

                        <button type="submit" id="saveAddressBtn"
                                class="w-full py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 transition-colors">
                            افزودن آدرس
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
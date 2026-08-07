<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
    <!-- START CONTENT -->
    <section class="py-5">
        <div class="container">

            <?= $this->include('_layout_/partials/breadcrumb') ?>

            <!-- ====== GRID اصلی ====== -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mt-4">

                <!-- ====== ستون محتوا ====== -->
                <div class="lg:col-span-3 col-span-1">
                    <div class="bg-white dark:bg-custom-dark dark:text-gray-200 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl px-4 sm:px-6 py-4">

                        <!-- ====== گالری و توضیحات کنار هم ====== -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                            <!-- ====== گالری ====== -->
                            <div class="col-span-1">
                                <section class="mt-7 pb-10 w-full">

                                    <?php if ($priceInfo['has_discount'] && !empty($priceInfo['sale_end_date'])): ?>
                                        <div class="bg-secondary-200 dark:bg-custom-dark dark:text-gray-200 shadow-sm border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-2xl flex items-center justify-between mb-4 transition-all duration-200">
                                            <h3 class="font-black text-gray-800 dark:text-gray-100">فروش ویژه</h3>
                                            <div class="countdown text-gray-700 dark:text-gray-300" style="direction: ltr;" data-date="<?= date('Y-m-d', $priceInfo['sale_end_date']) ?>" data-time="<?= date('H:i', $priceInfo['sale_end_date']) ?>"></div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Large gallery -->
                                    <p class="mb-2 text-center text-xs text-gray-500 dark:text-gray-400">
                                        برای بزرگ‌نمایی، روی تصویر دو بار بزنید یا با دو انگشت زوم کنید.
                                    </p>
                                    <div class="bg-primary relative mb-12 rounded-[15px] h-[350px] pt-5 px-[15px] pb-[33px] dark:bg-custom-dark dark:border dark:border-gray-700">
                                        <?php /*
                                        <div class="flex rounded-2xl px-2 bg-gray-100 dark:bg-custom-dark gap-2 absolute top-3 end-1/2 -translate-x-1/2 z-10 mt-4">
                                            <button data-modal-target="shareModal" class="modal-trigger flex z-10 group relative items-center justify-center w-full p-2 transition dark:border-gray-700 drop-shadow rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z"/>
                                                </svg>
                                                <span class="absolute text-nowrap z-50 end-1/2 ms-2 -top-7 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-xs py-1 px-2 rounded-md shadow-lg">
                                            <span class="absolute end-1/2 -bottom-[10px] rotate-[90deg] -translate-y-1/2 w-0 h-0 border-y-4 border-y-transparent border-e-4 border-e-gray-900"></span>
                                            اشتراک گذاری
                                        </span>
                                            </button>
                                            <button class="flex z-10 group relative items-center justify-center w-full p-2 transition dark:border-gray-700 drop-shadow rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
                                                </svg>
                                                <span class="absolute text-nowrap z-50 end-1/2 ms-2 -top-7 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-xs py-1 px-2 rounded-md shadow-lg">
                                            <span class="absolute end-1/2 -bottom-[10px] rotate-[90deg] -translate-y-1/2 w-0 h-0 border-y-4 border-y-transparent border-e-4 border-e-gray-900"></span>
                                            مقایسه
                                        </span>
                                            </button>
                                            <button class="flex z-10 group relative items-center justify-center w-full p-2 transition dark:border-gray-700 drop-shadow rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                                </svg>
                                                <span class="absolute text-nowrap z-50 end-1/2 ms-2 -top-7 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-xs py-1 px-2 rounded-md shadow-lg">
                                            <span class="absolute end-1/2 -bottom-[10px] rotate-[90deg] -translate-y-1/2 w-0 h-0 border-y-4 border-y-transparent border-e-4 border-e-gray-900"></span>
                                            افزودن به علاقه‌مندی‌ها
                                        </span>
                                            </button>
                                            <button data-modal-target="chartModal" class="modal-trigger flex z-10 group relative items-center justify-center w-full p-2 transition dark:border-gray-700 drop-shadow rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605"/>
                                                </svg>
                                                <span class="absolute text-nowrap z-50 end-1/2 ms-2 -top-7 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-xs py-1 px-2 rounded-md shadow-lg">
                                            <span class="absolute end-1/2 -bottom-[10px] rotate-[90deg] -translate-y-1/2 w-0 h-0 border-y-4 border-y-transparent border-e-4 border-e-gray-900"></span>
                                            نمودار قیمت
                                        </span>
                                            </button>
                                        </div>
                                        */ ?>

                                        <div class="swiper" id="productGalleryTwo">
                                            <div class="swiper-wrapper" style="padding-bottom: 20px !important;">
                                                <?php if ($images['main']): ?>
                                                    <div class="swiper-slide">
                                                        <div class="border h-90 border-gray-300 rounded-2xl overflow-hidden bg-white dark:bg-zinc-800 dark:border-gray-700">
                                                            <div class="swiper-zoom-container">
                                                                <img src="<?= base_url('images/products/' . $images['main']['image_name']) ?>" alt="<?= esc($images['main']['alt'] ?? $product['name']) ?>" class="relative -top-2 rounded-2xl w-full h-80 object-contain mx-auto">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php foreach ($images['gallery'] as $image): ?>
                                                    <div class="swiper-slide">
                                                        <div class="border h-90 border-gray-300 rounded-2xl overflow-hidden bg-white dark:bg-zinc-800 dark:border-gray-700">
                                                            <div class="swiper-zoom-container">
                                                                <img src="<?= base_url('images/products/' . $image['image_name']) ?>" alt="<?= esc($image['alt'] ?? $product['name']) ?>" class="relative -top-2 rounded-2xl w-full h-80 object-contain mx-auto">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="swiper-button-prev xl:flex hidden bg-gray-100 rounded-xl dark:bg-zinc-800 border border-gray-200 dark:border-gray-700 !size-12 after:!text-xl px-3 after:text-primary"></div>
                                            <div class="swiper-button-next xl:flex hidden bg-gray-100 rounded-xl dark:bg-zinc-800 border border-gray-200 dark:border-gray-700 !size-12 after:!text-xl px-3 after:text-primary"></div>
                                            <div class="swiper-pagination !bottom-7"></div>
                                        </div>
                                    </div>

                                    <!-- Thumbnail gallery -->
                                    <div id="productGalleryOne" class="swiper">
                                        <div class="swiper-wrapper" style="padding-bottom: 0 !important;">
                                            <?php if ($images['main']): ?>
                                                <div class="swiper-slide">
                                                    <div class="rounded-lg flex justify-center cursor-pointer border border-gray-300 sm:h-30 h-20 dark:border-gray-700 p-2 dark:bg-zinc-800">
                                                        <img src="<?= base_url('images/products/' . $images['main']['image_name']) ?>" alt="<?= esc($images['main']['alt'] ?? $product['name']) ?>" class="h-full">
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php foreach ($images['gallery'] as $image): ?>
                                                <div class="swiper-slide">
                                                    <div class="rounded-lg flex justify-center cursor-pointer border border-gray-300 sm:h-30 h-20 dark:border-gray-700 p-2 dark:bg-zinc-800">
                                                        <img src="<?= base_url('images/products/' . $image['image_name']) ?>" alt="<?= esc($image['alt'] ?? $product['name']) ?>" class="h-full">
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                </section>
                            </div>

                            <!-- ====== توضیحات ====== -->
                            <div class="col-span-1">
                                <section class="mt-7 pb-10 w-full dark:text-gray-200">

                                    <ul class="space-x-2 flex items-center">
                                        <?php if (isset($product['category'])): ?>
                                            <li><a href="/category/<?= $product['category']['slug'] ?>" class="text-primary"><?= esc($product['category']['name']) ?></a></li>
                                        <?php endif; ?>
                                    </ul>

                                    <div class="space-y-2 mt-2 pb-2 border-b border-b-gray-300 dark:border-b-gray-700">
                                        <div class="flex items-start justify-between gap-3">
                                            <h1 class="min-w-0 flex-1 font-black leading-8 break-words"><?= esc($product['name']) ?></h1>
                                            <button type="button"
                                                    id="productWishlistButton"
                                                    data-product-id="<?= (int) $product['id'] ?>"
                                                    data-toggle-url="<?= site_url('wishlist/toggle') ?>"
                                                    data-login-url="<?= site_url('login') ?>"
                                                    class="shrink-0 size-10 -mt-1 rounded-full flex items-center justify-center bg-gray-100 dark:bg-zinc-800 transition-colors <?= $isWishlisted ? 'text-red-500' : 'text-gray-400 hover:text-red-500 dark:text-gray-400' ?>"
                                                    aria-label="<?= $isWishlisted ? 'حذف از علاقه‌مندی‌ها' : 'افزودن به علاقه‌مندی‌ها' ?>"
                                                    aria-pressed="<?= $isWishlisted ? 'true' : 'false' ?>"
                                                    title="<?= $isWishlisted ? 'حذف از علاقه‌مندی‌ها' : 'افزودن به علاقه‌مندی‌ها' ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 24 24"
                                                     fill="<?= $isWishlisted ? 'currentColor' : 'none' ?>"
                                                     stroke="currentColor"
                                                     stroke-width="1.8"
                                                     class="size-7 pointer-events-none">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.687 3.75 5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <?php if (!empty($product['name_en'])): ?>
                                            <h2 class="text-gray-400 dark:text-gray-500 text-sm leading-8"><?= esc($product['name_en']) ?></h2>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex flex-wrap items-center pt-2 mt-2 space-x-2">
                                        <div class="flex items-center space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="text-amber-400 size-5">
                                                <path fill="currentColor" d="m12 17.27l4.15 2.51c.76.46 1.69-.22 1.49-1.08l-1.1-4.72l3.67-3.18c.67-.58.31-1.68-.57-1.75l-4.83-.41l-1.89-4.46c-.34-.81-1.5-.81-1.84 0L9.19 8.63l-4.83.41c-.88.07-1.24 1.17-.57 1.75l3.67 3.18l-1.1 4.72c-.2.86.73 1.54 1.49 1.08z"/>
                                            </svg>
                                            <h4 class="text-sm font-bold">4.6</h4>
                                            <span class="text-xs text-gray-400 dark:text-gray-500">(امتیاز ۳۰۸ خریدار)</span>
                                        </div>
                                        <div>
                                            <a href="#comments" class="bg-gray-200 hover:bg-primary/20 transition dark:bg-zinc-800 dark:text-gray-200 px-2 py-1 space-x-1 rounded-full flex items-center">
                                                <span class="text-xs">185 دیدگاه </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="#question" class="bg-gray-200 hover:bg-primary/20 transition dark:bg-zinc-800 dark:text-gray-200 px-2 py-1 space-x-1 rounded-full flex items-center">
                                                <span class="text-xs">265 پرسش </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- ====== رنگ‌ها ====== -->
                                    <?php if (!empty($options['color'])): ?>
                                        <div class="mt-8 space-y-3">
                                            <div class="flex items-center space-x-2">
                                                <h4 class="font-bold text-lg">رنگ:</h4>
                                                <p id="selectedColor" class="text-lg font-medium"></p>
                                            </div>
                                            <div class="flex my-4 flex-wrap items-center gap-3">
                                                <?php foreach ($options['color'] as $index => $option):
                                                    $isChecked = ($options['selected_color'] == $option['option_id']);
                                                    $isOutOfStock = ($option['stock'] ?? 0) <= 0;
                                                    ?>
                                                    <div class="flex items-center">
                                                        <input type="radio" name="color" id="color_<?= $option['option_id'] ?>"
                                                               value="<?= $option['option_id'] ?>"
                                                                <?= $isChecked ? 'checked' : '' ?>
                                                               class="hidden peer color-radio"
                                                               data-price="<?= $option['price'] ?? 0 ?>"
                                                               data-sale-price="<?= $option['sale_price'] ?? 0 ?>"
                                                               data-stock="<?= $option['stock'] ?? 0 ?>"
                                                               data-option-id="<?= $option['option_id'] ?>">
                                                        <label for="color_<?= $option['option_id'] ?>"
                                                               class="select-none dark:!text-white cursor-pointer flex items-center justify-center rounded-full border-2 <?= $isOutOfStock ? 'border-gray-300 dark:border-gray-600 opacity-50 cursor-not-allowed' : 'border-gray-200 dark:border-gray-600' ?> py-1 px-2 text-gray-700 transition-colors duration-200 ease-in-out
                              <?= !$isOutOfStock ? 'peer-checked:text-gray-900 peer-checked:border-primary-500' : '' ?>
                              <?= $isOutOfStock ? 'peer-disabled:opacity-50 peer-disabled:cursor-not-allowed' : '' ?>">
                                                            <span class="size-4 rounded-full inline-block" style="background-color: <?= $option['color_code'] ?? '#ccc' ?>;"></span>
                                                            <span class="dir-ltr ms-2"><?= esc($option['option_value']) ?></span>
                                                            <?php if ($isOutOfStock): ?>
                                                                <span class="text-xs text-red-500 ms-1">(ناموجود)</span>
                                                            <?php endif; ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- ====== سایزها ====== -->
                                    <?php if (!empty($options['size'])): ?>
                                        <div class="mt-6 space-y-3">
                                            <div class="flex items-center space-x-2">
                                                <h4 class="font-bold text-lg">سایز:</h4>
                                                <p id="selectedSize" class="text-lg font-medium"></p>
                                            </div>
                                            <div class="flex my-4 flex-wrap items-center gap-3">
                                                <?php foreach ($options['size'] as $index => $option):
                                                    $isChecked = ($options['selected_size'] == $option['option_id']);
                                                    $isOutOfStock = ($option['stock'] ?? 0) <= 0;
                                                    ?>
                                                    <div class="flex items-center">
                                                        <input type="radio" name="size" id="size_<?= $option['option_id'] ?>"
                                                               value="<?= $option['option_id'] ?>"
                                                                <?= $isChecked ? 'checked' : '' ?>
                                                               class="hidden peer size-radio"
                                                               data-price="<?= $option['price'] ?? 0 ?>"
                                                               data-sale-price="<?= $option['sale_price'] ?? 0 ?>"
                                                               data-stock="<?= $option['stock'] ?? 0 ?>"
                                                               data-option-id="<?= $option['option_id'] ?>">
                                                        <label for="size_<?= $option['option_id'] ?>"
                                                               class="select-none dark:!text-white cursor-pointer flex items-center justify-center rounded-lg border-2 <?= $isOutOfStock ? 'border-gray-300 dark:border-gray-600 opacity-50 cursor-not-allowed' : 'border-gray-200 dark:border-gray-600' ?> py-2 px-4 text-sm font-medium text-gray-700 transition-colors duration-200 ease-in-out
                              <?= !$isOutOfStock ? 'peer-checked:text-white peer-checked:bg-primary-500 peer-checked:border-primary-500' : '' ?>
                              <?= $isOutOfStock ? 'peer-disabled:opacity-50 peer-disabled:cursor-not-allowed' : '' ?>">
                                                            <?= esc($option['option_value']) ?>
                                                            <?php if ($isOutOfStock): ?>
                                                                <span class="text-xs text-red-500 ms-1">(ناموجود)</span>
                                                            <?php endif; ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- ====== ویژگی‌ها (بقیه آپشن‌ها) ====== -->
                                    <?php if (!empty($options['features'])): ?>
                                        <div class="mt-8 space-y-3">
                                            <div class="flex items-center space-x-2">
                                                <h4 class="font-bold text-lg">ویژگی‌ها</h4>
                                            </div>
                                            <div class="grid gap-3 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1">
                                                <?php foreach ($options['features'] as $feature): ?>
                                                    <div class="p-3 bg-gray-200 dark:bg-zinc-800 rounded-lg relative group">
                                                        <h5 class="line-clamp-1 text-xs text-gray-600 dark:text-gray-300"><?= esc($feature['label_name']) ?></h5>
                                                        <h6 class="line-clamp-1 mt-3 text-xs"><?= esc($feature['option_value']) ?></h6>
                                                        <span class="absolute text-nowrap z-50 end-1/2 ms-2 -top-3 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-xs py-1 px-2 rounded-md shadow-lg">
                                                        <span class="absolute end-1/2 -bottom-[10px] rotate-[90deg] -translate-y-1/2 w-0 h-0 border-y-4 border-y-transparent border-e-4 border-e-gray-900"></span>
                                                        <?= esc($feature['option_value']) ?>
                                                    </span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="rounded my-3 mx-5 lg:mx-0">
                                        <div class="flex">
                                            <div class="flex mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="size-5 text-gray-500 dark:text-gray-400">
                                                    <path fill="currentColor" fill-rule="evenodd" d="M1.25 12C1.25 6.063 6.063 1.25 12 1.25S22.75 6.063 22.75 12S17.937 22.75 12 22.75S1.25 17.937 1.25 12M12 6.25a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0V7a.75.75 0 0 1 .75-.75m.568 11.25a.75.75 0 0 0-1.115-1.003l-.01.011a.75.75 0 0 0 1.114 1.004z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="ms-2 text-xs leading-6 text-justify text-neutral-500 dark:text-neutral-400">
                                                با توجه به تفاوت رنگ در صفحه نمایش و واقعیت، ممکن است رنگ محصولات تا ۲۰٪ متغیر باشد
                                            </span>
                                        </div>
                                    </div>

                                </section>
                            </div>

                        </div><!-- end grid گالری + توضیحات -->
                    </div>
                </div>

                <!-- ====== سایدبار (ستون چهارم) ====== -->
                <div class="lg:col-span-1 col-span-1">
                    <div id="proAction" class="xl:sticky fixed xl:top-[80px] bottom-0 end-0 start-0 xl:z-0 z-40 bg-white dark:bg-custom-dark dark:text-gray-200 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl xl:rounded-2xl rounded-t-2xl px-3 sm:px-4 py-2 xl:py-4" style="align-self: flex-start;">

                        <!-- دکمه بستن (فقط موبایل) -->
                        <div class="xl:hidden block text-end">
                            <button class="text-red-600" onclick="document.getElementById('proAction').style.display='none'">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- ====== قیمت و شمارنده (چیدمان افقی مانند قالب) ====== -->
                        <div class="flex items-center justify-between mt-1 mb-1 xl:flex-col xl:items-center xl:gap-4 xl:mt-4 xl:mb-2">

                            <!-- شمارنده (چپ) - بدون تغییر ساختار -->
                            <div class="inline-flex items-center space-x-2 border border-gray-200 dark:border-zinc-700 rounded-lg px-3 bg-white dark:bg-zinc-800 shadow xl:w-full xl:justify-center">
                                <button class="size-8 rounded-full flex items-center justify-center text-lg dark:text-white" onclick="increment('count11')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                </button>
                                <span id="count11" class="text-lg px-3 inline-block dark:text-white">1</span>
                                <button class="size-8 rounded-full flex items-center justify-center text-lg dark:text-white" onclick="decrement('count11')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- قیمت (راست، ستونی) - اضافه کردن space-y-1 -->
                            <div id="productPriceBox" class="product-price-box flex items-center xl:items-center" aria-live="polite">
                                <div class="text-gray-700 dark:text-zinc-300 flex flex-col items-end xl:items-center space-y-1">
                                    <div class="flex items-center gap-2"> <!-- gap-2 به جای gap-1 -->
                                        <del class="text-zinc-400 dark:text-zinc-500 text-xs" id="priceDel">
                                            <span id="originalPriceDisplay"><?= number_format($priceInfo['original_price']) ?></span>
                                        </del>
                                        <div class="bg-secondary-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-xl rounded-bl-md shadow shadow-red-500/50" id="discountBadge">
                                            <?= $priceInfo['discount_percent'] ?>%
                                        </div>
                                    </div>
                                    <span class="text-base font-bold dark:text-white" id="finalPriceDisplayContainer">
                                        <span id="finalPriceDisplay"><?= number_format($priceInfo['final_price']) ?></span>
                                        <span class="text-[10px] font-bold dark:text-zinc-300 inline-block">تومان</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- دکمه افزودن به سبد خرید - با کلاس‌هایی که product.js می‌تواند مدیریت کند -->
                        <div class="flex items-center justify-center mt-1 mb-1 xl:mt-3">
                            <?php if ($totalStock > 0): ?>
                                <button id="addToCartBtn"
                                        data-product-id="<?= $product['id'] ?>"
                                        class="bg-primary shadow-primary-500 w-full hover:bg-primary-600 text-white font-semibold rounded-xl px-3 py-1.5 text-xs xl:px-6 xl:py-4 xl:text-sm">
                                    افزودن به سبد خرید
                                </button>
                            <?php else: ?>
                                <button disabled class="bg-gray-300 dark:bg-zinc-700 w-full text-gray-500 dark:text-gray-400 font-semibold rounded-xl px-3 py-1.5 text-xs xl:px-6 xl:py-4 xl:text-sm cursor-not-allowed">
                                    ناموجود
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- موجودی -->
                        <div class="flex items-center justify-between pt-1 xl:pt-2">
                            <span class="text-xs text-gray-600 dark:text-gray-300 xl:text-sm">موجودی:</span>
                            <span id="stockDisplay" class="text-xs font-bold <?= $selectedStock > 0 ? 'text-green-600' : 'text-red-600' ?> xl:text-sm">
                <?= $selectedStock > 0 ? number_format($selectedStock) . ' عدد' : 'ناموجود' ?>
            </span>
                        </div>

                        <!-- امتیاز (فقط دسکتاپ) -->
                        <div class="hidden xl:flex items-center mt-2 justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
            <span class="text-sm text-gray-600 dark:text-gray-300 flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-amber-400 me-1 size-5" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m12 17.27l4.15 2.51c.76.46 1.69-.22 1.49-1.08l-1.1-4.72l3.67-3.18c.67-.58.31-1.68-.57-1.75l-4.83-.41l-1.89-4.46c-.34-.81-1.5-.81-1.84 0L9.19 8.63l-4.83.41c-.88.07-1.24 1.17-.57 1.75l3.67 3.18l-1.1 4.72c-.2.86.73 1.54 1.49 1.08z"/>
                </svg>
                امتیاز باشگاه مشتریان
            </span>
                            <div class="flex items-center space-x-2">
                                <span class="font-black text-sm dark:text-white">350</span>
                                <span class="text-gray-600 dark:text-gray-300 text-sm">امتیاز</span>
                            </div>
                        </div>

                    </div>
                </div>


            </div><!-- end grid اصلی -->

            <!-- ====== توضیحات و ویژگی‌های محصول ====== -->
            <div class="mt-8">
                <nav id="topBar"
                     class="lg:sticky border border-gray-200 shadow-sm dark:border-gray-700 z-10 px-5 bg-white dark:bg-zinc-800 rounded-2xl mb-6"
                     style="z-index: 39; top: 75px">
                    <ul class="flex space-x-1 min-w-48 overflow-x-auto py-4 hide-scrollbar" id="tabContainer">
                        <li>
                            <button type="button" class="tab-btn whitespace-nowrap px-6 py-3 rounded-xl transition-all" data-tab="desc">
                                توضیحات محصول
                            </button>
                        </li>
                        <?php if (!empty($features)): ?>
                            <li>
                                <button type="button" class="tab-btn whitespace-nowrap px-6 py-3 rounded-xl transition-all" data-tab="features">
                                    ویژگی‌های محصول
                                </button>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <div class="space-y-8">
                    <section id="desc"
                             class="tab-section p-5 sm:p-8 bg-white dark:bg-custom-dark dark:border-gray-700 rounded-2xl shadow-md border border-gray-200"
                             style="scroll-margin-top: 9rem">
                        <h2 class="text-xl sm:text-2xl pb-3 mb-5 font-black text-zinc-800 relative before:absolute before:bottom-0 before:right-0 before:h-1 before:w-22 before:bg-secondary-500 before:rounded dark:text-white">
                            توضیحات محصول
                        </h2>
                        <div class="prose dark:prose-invert max-w-none text-neutral-700 leading-9 text-justify dark:text-white">
                            <?= !empty($product['description']) ? $product['description'] : '<p class="text-gray-500 dark:text-gray-400">توضیحاتی برای این محصول ثبت نشده است.</p>' ?>
                        </div>
                    </section>

                    <?php if (!empty($features)): ?>
                        <section id="features"
                                 class="tab-section p-5 sm:p-8 bg-white dark:bg-custom-dark dark:border-gray-700 rounded-2xl shadow-md border border-gray-200"
                                 style="scroll-margin-top: 9rem">
                            <h2 class="text-xl sm:text-2xl pb-3 mb-5 font-black text-zinc-800 relative before:absolute before:bottom-0 before:right-0 before:h-1 before:w-22 before:bg-secondary-500 before:rounded dark:text-white">
                                ویژگی‌های محصول
                            </h2>

                            <div class="grid grid-cols-2 gap-3 sm:gap-4 text-right">
                                <?php foreach ($features as $feature): ?>
                                    <div class="col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                                        <div class="bg-gray-200 border border-gray-300 dark:border-gray-700 px-4 rounded text-gray-900 text-sm py-4 flex items-center dark:bg-[#1e232a] dark:text-white">
                                            <?= esc($feature['feature_key']) ?>
                                        </div>
                                        <div class="bg-gray-100 border border-gray-200 px-4 py-4 text-sm text-gray-900 flex items-center dark:bg-[#252b33] dark:border-gray-700 rounded dark:text-white"
                                             style="white-space: pre-line"><?= esc($feature['feature_value']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
    <!-- END CONTENT -->

    <script>
        window.stockMap = <?= json_encode($options['stock_map']) ?>;
        window.priceMap = <?= json_encode($priceMap) ?>;
    </script>

    <!-- ====== استایل‌های اضافه ====== -->
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
<?= $this->endSection() ?>

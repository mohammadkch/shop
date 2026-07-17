<?= $this->extend('_layout_/layout') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">

        <!-- Breadcrumb -->
        <?= $this->include('_layout_/partials/breadcrumb') ?>

        <!-- Title -->
        <div class="py-5">
            <h2 class="font-black text-2xl mb-4 relative pb-4 text-gray-900 dark:text-gray-200
                before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary
                after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                <?= esc($menu['name']) ?>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                <?= count($products) ?> محصول
            </p>
        </div>

        <!-- Categories Swiper -->
        <?php if (!empty($subMenus)): ?>
            <div class="swiper free-mode">
                <div class="swiper-wrapper" style="padding: 0 0 20px 0 !important;">
                    <?php foreach ($subMenus as $sub): ?>
                        <div class="swiper-slide !size-40">
                            <a href="<?= site_url('category/' . $sub['path']) ?>">
                                <div class="bg-white dark:bg-custom-dark dark:border-gray-700 dark:text-gray-200 space-y-3 shadow-sm border border-gray-200 p-3 rounded-2xl flex flex-col items-center justify-center duration-200 hover:shadow-md hover:scale-[1.02] transition-all">
                                    <figure>
                                        <?php if (!empty($sub['image']['image_name'])): ?>
                                            <img src="<?= base_url('images/menus/' . $sub['image']['image_name']) ?>"
                                                 alt="<?= esc($sub['name']) ?>"
                                                 class="w-20 h-20 object-contain dark:invert-0">
                                        <?php else: ?>
                                            <img src="<?= $assetsPath ?>images/category/default.png"
                                                 alt="<?= esc($sub['name']) ?>"
                                                 class="w-20 h-20 object-contain dark:invert-0">
                                        <?php endif; ?>
                                    </figure>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-200 text-center"><?= esc($sub['name']) ?></h3>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Filter And Products -->
        <div class="grid gap-4 grid-cols-4">
            <!-- ====== فیلتر (سایدبار) ====== -->
            <aside class="lg:col-span-1 lg:block hidden relative space-y-4 col-span-4 w-full">
                <!-- Filter applied -->
                <section>
                    <div class="dark:bg-custom-dark bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">

                        <!-- Title -->
                        <h2 class="font-bold text-lg mb-4 relative pb-4
                                before:absolute before:start-0 before:bottom-0 before:w-2 before:h-2 before:bg-primary before:rounded-full
                                after:absolute after:start-4 after:bottom-0 after:w-32 after:h-1.5 after:bg-primary/70 after:rounded-lg">
                            فیلترهای فعال
                        </h2>

                        <!--Selected filters-->
                        <div class="flex flex-wrap items-center gap-2">

                            <!--Any filter-->
                            <a href="#"
                               class="flex items-center gap-1 px-3 py-1.5 bg-gray-100 dark:bg-gray-800 border border-gray-300
                                       dark:border-gray-600 rounded-xl text-xs text-gray-700 dark:text-gray-200
                                       hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">
                                <span>موجودی</span>

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.8" stroke="currentColor"
                                     class="w-3.5 h-3.5 opacity-70">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </a>

                            <a href="#" class="filter-tag">تخفیف‌خورده</a>
                            <a href="#" class="filter-tag">قرمز</a>
                            <a href="#" class="filter-tag">سبز</a>
                            <a href="#" class="filter-tag">آبی</a>

                        </div>
                    </div>
                </section>
                <section class="space-y-5 sticky top-0">

                    <?php if (!empty($filterData)): ?>
                        <?php foreach ($filterData as $item): ?>
                            <div class="dark:bg-custom-dark dark:border-gray-700 dark:text-white bg-white rounded-lg drop-shadow-lg border-gray-300 border-1 p-4">
                                <h2 class="font-bold text-base mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                                    <?= esc($item['label']['name']) ?>
                                </h2>
                                <div class="relative flex-wrap flex items-center gap-2 w-full">
                                    <?php foreach ($item['options'] as $option): ?>
                                        <?php
                                        $isChecked = isset($selectedFilters[$item['label']['id']]) && in_array($option['id'], $selectedFilters[$item['label']['id']]);
                                        ?>
                                        <div class="flex items-center">
                                            <input type="checkbox"
                                                   name="filter_<?= $item['label']['id'] ?>[]"
                                                   value="<?= $option['id'] ?>"
                                                   id="filter_<?= $item['label']['id'] ?>_<?= $option['id'] ?>"
                                                   class="hidden peer filter-checkbox"
                                                   data-label-id="<?= $item['label']['id'] ?>"
                                                   data-option-id="<?= $option['id'] ?>"
                                                    <?= $isChecked ? 'checked' : '' ?>>
                                            <label for="filter_<?= $item['label']['id'] ?>_<?= $option['id'] ?>"
                                                   class="select-none dark:!text-white cursor-pointer flex items-center justify-center rounded-full border-2 border-gray-200 py-1 px-3 text-gray-700 transition-colors duration-200 ease-in-out peer-checked:text-gray-900 peer-checked:border-primary-500">
                                                <?php if ($item['label']['type'] === 'color' && !empty($option['color_code'])): ?>
                                                    <span class="size-4 rounded-full ms-1" style="background-color: <?= $option['color_code'] ?>"></span>
                                                <?php endif; ?>
                                                <span class="text-sm"><?= esc($option['value']) ?></span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="dark:bg-custom-dark dark:border-gray-700 dark:text-white bg-white rounded-lg drop-shadow-lg border-gray-300 border-1 p-4">
                            <p class="text-gray-400 text-sm">هیچ فیلتری موجود نیست</p>
                        </div>
                    <?php endif; ?>

                </section>
            </aside>

            <!-- ====== محصولات ====== -->
            <section class="lg:col-span-3 col-span-4 w-full">

                <!-- Quick Filter (بیرون از کانتینر) -->
                <div class="flex flex-wrap items-center sm:space-y-0 space-y-3 space-x-3">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 dark:text-white text-gray-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                        <span class="text-gray-700 dark:text-gray-200">مرتب سازی بر اساس:</span>
                    </div>
                    <div class="flex items-center overflow-x-scroll max-sm:hide-scrollbar gap-6 text-gray-600 dark:text-gray-300 text-sm">
                        <button class="sort-btn <?= ($sortField === 'published_at' && $sortType === 'desc') ? 'dark:bg-gray-800 dark:text-white bg-gray-900 text-white' : 'hover:text-gray-900 dark:hover:text-white' ?> px-4 py-1 rounded-full transition"
                                data-sort-field="published_at" data-sort-type="desc">
                            جدیدترین
                        </button>
                        <button class="sort-btn <?= ($sortField === 'price' && $sortType === 'desc') ? 'dark:bg-gray-800 dark:text-white bg-gray-900 text-white' : 'hover:text-gray-900 dark:hover:text-white' ?> px-4 py-1 rounded-full transition"
                                data-sort-field="price" data-sort-type="desc">
                            گران‌ترین
                        </button>
                        <button class="sort-btn <?= ($sortField === 'price' && $sortType === 'asc') ? 'dark:bg-gray-800 dark:text-white bg-gray-900 text-white' : 'hover:text-gray-900 dark:hover:text-white' ?> px-4 py-1 rounded-full transition"
                                data-sort-field="price" data-sort-type="asc">
                            ارزان‌ترین
                        </button>
                        <button class="sort-btn <?= ($sortField === 'visit_count' && $sortType === 'desc') ? 'dark:bg-gray-800 dark:text-white bg-gray-900 text-white' : 'hover:text-gray-900 dark:hover:text-white' ?> px-4 py-1 rounded-full transition"
                                data-sort-field="visit_count" data-sort-type="desc">
                            محبوب‌ترین
                        </button>
                    </div>
                </div>

                <!-- ====== کانتینر محصولات + پجینیشن ====== -->
                <div id="product-container">
                    <!-- GRID محصولات -->
                    <div class="grid mt-6 grid-cols-12 gap-[2px] place-items-center">
                        <?php if (empty($products)): ?>
                            <div class="col-span-12 text-center py-10">
                                <p class="text-gray-500 dark:text-gray-400">محصولی در این دسته‌بندی یافت نشد</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <div class="lg:col-span-3 sm:col-span-6 col-span-12 w-full">
                                    <div class="relative dark:border-gray-700 dark:shadow-[0_0_10px_rgba(0,0,0,0.6)] rounded p-3 bg-white dark:bg-custom-dark transition-all duration-200 ease-in-out group">
                                        <!-- Product Colors -->
                                        <ul class="absolute top-4 start-3 space-y-1"></ul>

                                        <!-- Thumbnail -->
                                        <div class="text-center flex items-center justify-center overflow-hidden">
                                            <?php
                                            $thumbnail = '';
                                            $productImageModel = model('App\Models\ProductImageModel');
                                            $image = $productImageModel
                                                    ->where('product_id', $product['id'])
                                                    ->where('product_image_type_id', 1)
                                                    ->orderBy('sort_order', 'ASC')
                                                    ->first();

                                            if ($image && !empty($image['image_name'])) {
                                                $thumbnail = base_url('images/products/' . $image['image_name']);
                                            } else {
                                                $thumbnail = base_url('assets/images/product/placeholder.jpg');
                                            }
                                            ?>
                                            <img src="<?= $thumbnail ?>"
                                                 alt="<?= esc($product['name']) ?>"
                                                 loading="lazy"
                                                 class="block h-40 object-contain transition-transform duration-300 group-hover:scale-105">
                                        </div>

                                        <!-- Discount Badge -->
                                        <?php if ($product['has_discount'] && $product['discount_percent'] > 0): ?>
                                            <div class="absolute end-3 top-3 bg-secondary-500 text-white text-xs font-bold px-2 py-1 rounded-xl rounded-bl-md shadow shadow-red-500/50 z-10">
                                                <?= $product['discount_percent'] ?>%
                                            </div>
                                        <?php endif; ?>

                                        <!-- Product Body -->
                                        <div class="mt-3">
                                            <h3 class="font-normal text-sm leading-6 max-h-12 min-h-12 mt-2 px-1 overflow-hidden group-hover:text-primary-600 dark:group-hover:text-primary-400 dark:text-gray-200 text-gray-900 transition-colors duration-200">
                                                <a href="<?= site_url('product/' . $product['slug']) ?>" class="font-bold">
                                                    <?= esc($product['name']) ?>
                                                </a>
                                            </h3>
                                        </div>

                                        <!-- Price -->
                                        <div class="mt-2 flex justify-between items-end">
                                            <div class="flex flex-col justify-end min-h-10 h-10 w-full">
                                                <?php if ($product['has_discount']): ?>
                                                    <span class="text-xs text-gray-400 dark:text-gray-500 line-through tracking-wider text-left">
                                            <?= number_format($product['original_price']) ?>
                                        </span>
                                                    <span class="font-bold text-sm text-gray-900 dark:text-gray-200 tracking-wider text-left">
                                            <?= number_format($product['final_price']) ?>
                                        </span>
                                                <?php else: ?>
                                                    <span class="font-bold text-sm text-gray-900 dark:text-gray-200 tracking-wider text-left">
                                            <?= number_format($product['original_price']) ?>
                                        </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <a class="absolute inset-0 w-full h-full" href="<?= site_url('product/' . $product['slug']) ?>"></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- ====== Pagination (داخل کانتینر) ====== -->
                    <?= $pagination ?? '' ?>
                </div>
            </section>
            </div>
        </div>

    <!-- Filter show in responsive break point lg -->
    <div class="lg:hidden block">
        <div class="fixed z-20 bottom-28 start-3">
            <button onclick="toggleOffcanvas('offcanvas-right-filter')" class="bg-primary px-3 py-3 rounded-lg drop-shadow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                </svg>
            </button>
        </div>

        <!-- Filters -->
        <div id="offcanvas-right-filter"
             class="offcanvas invisible overflow-y-scroll fixed top-0 start-0 sm:w-100 w-[80%] h-full bg-white dark:bg-[#0d1117] text-gray-900 dark:text-gray-100 border-e border-gray-200 dark:border-gray-800 shadow-xl dark:shadow-[0_0_20px_rgba(0,0,0,0.6)] transform -translate-x-full transition-all duration-300 opacity-0 z-50"
             role="navigation" aria-labelledby="store-menu-title" aria-modal="true">

            <!-- header -->
            <div class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center justify-between">
                <h2 class="font-bold text-base">فیلتر ها</h2>
                <button onclick="closeOffcanvas()" class="cursor-pointer" aria-label="بستن">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor"
                         class="size-8 text-gray-700 dark:text-gray-300 hover:text-primary-500 transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- محتوای فیلترها -->
            <section class="space-y-5 p-3 my-5 sticky top-0">
                <?php if (!empty($filterData)): ?>
                    <?php foreach ($filterData as $item): ?>
                        <div class="dark:bg-custom-dark dark:border-gray-700 dark:text-white bg-white rounded-lg drop-shadow-lg border-gray-300 border-1 p-4">
                            <h2 class="font-bold text-base mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                                <?= esc($item['label']['name']) ?>
                            </h2>
                            <div class="relative flex-wrap flex items-center gap-2 w-full">
                                <?php foreach ($item['options'] as $option): ?>
                                    <?php
                                    $isChecked = isset($selectedFilters[$item['label']['id']]) && in_array($option['id'], $selectedFilters[$item['label']['id']]);
                                    ?>
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="filter_<?= $item['label']['id'] ?>[]"
                                               value="<?= $option['id'] ?>"
                                               id="mobile_filter_<?= $item['label']['id'] ?>_<?= $option['id'] ?>"
                                               class="hidden peer filter-checkbox"
                                               data-label-id="<?= $item['label']['id'] ?>"
                                               data-option-id="<?= $option['id'] ?>"
                                                <?= $isChecked ? 'checked' : '' ?>>
                                        <label for="mobile_filter_<?= $item['label']['id'] ?>_<?= $option['id'] ?>"
                                               class="select-none dark:!text-white cursor-pointer flex items-center justify-center rounded-full border-2 border-gray-200 py-1 px-3 text-gray-700 transition-colors duration-200 ease-in-out peer-checked:text-gray-900 peer-checked:border-primary-500">
                                            <?php if ($item['label']['type'] === 'color' && !empty($option['color_code'])): ?>
                                                <span class="size-4 rounded-full ms-1" style="background-color: <?= $option['color_code'] ?>"></span>
                                            <?php endif; ?>
                                            <span class="text-sm"><?= esc($option['value']) ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="dark:bg-custom-dark dark:border-gray-700 dark:text-white bg-white rounded-lg drop-shadow-lg border-gray-300 border-1 p-4">
                        <p class="text-gray-400 text-sm">هیچ فیلتری موجود نیست</p>
                    </div>
                <?php endif; ?>
            </section>

        </div>
        <!-- End Filters -->
    </div>

    <!-- ====== توضیحات پایین (داینامیک) ====== -->
    <?php if (!empty($menu['description'])): ?>
        <div class="p-5 mt-5 bg-white dark:bg-custom-dark dark:border-gray-700 dark:text-gray-200 rounded-xl tab-content border border-gray-300 drop-shadow">
            <div class="space-y-5">
                <h2 class="text-lg pb-3 font-black text-zinc-800 relative before:absolute before:bottom-0 before:start-0 before:h-1 before:w-22 before:bg-primary-500 before:rounded dark:text-white">
                    دسته بندی <?= esc($menu['name']) ?>
                </h2>
                <div class="text-neutral-700 leading-9 text-justify text-base dark:text-white">
                    <?= nl2br(esc($menu['description'])) ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</section>

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




<!-- MOBILE SEARCH MODAL -->
<div id="SearchModal" role="dialog" aria-modal="true" aria-labelledby="SearchModalTitle" data-modal-id="SearchModal"
     class="modal hidden fixed inset-0 z-50 overflow-auto backdrop-blur bg-opacity-50">
    <div class="relative p-4 w-full max-w-lg m-auto flex items-center min-h-screen">
        <div class="bg-white relative w-full dark:bg-custom-dark rounded-2xl shadow-soft p-5 border border-gray-100 dark:border-gray-700 fade-in">
            <button type="button" class="absolute p-4 top-0 end-0 text-gray-600 dark:text-gray-300" data-modal-close aria-label="بستن جستجو">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            <h2 id="SearchModalTitle" class="font-black text-xl text-gray-900 dark:text-gray-100 mb-5 pe-10">جستجو در مومو</h2>

            <form action="<?= site_url('search') ?>" method="get" data-shop-search>
                <div class="relative flex items-center">
                    <input type="search" id="mobileShopSearchInput" data-search-input name="q" autocomplete="off"
                           minlength="2" maxlength="100" aria-label="جستجوی محصولات"
                           aria-controls="mobileShopSearchResults" aria-expanded="false"
                           class="w-full appearance-none rounded-xl border border-gray-300 dark:border-gray-700 py-3 ps-4 pe-10 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                           placeholder="نام محصول یا دسته‌بندی...">
                    <button type="submit" class="p-2 rounded-3xl absolute end-1" aria-label="جستجو">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </div>

                <div id="mobileShopSearchResults" data-search-results role="listbox" aria-label="پیشنهادهای جستجو"
                     class="mt-3 bg-white dark:bg-custom-dark border border-gray-200 dark:border-gray-700 rounded-xl overflow-y-auto hidden"
                     style="max-height: 55vh;"></div>
            </form>
        </div>
    </div>
</div>
<!-- END MOBILE SEARCH MODAL -->

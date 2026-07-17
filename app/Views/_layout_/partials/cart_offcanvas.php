<!-- CART CANVAS -->
<div id="offcanvas-left"
     class="offcanvas invisible fixed top-0 end-0 sm:w-100 w-[80%] h-full bg-white dark:bg-[#0d1117] text-gray-900 dark:text-gray-100 border-s border-gray-200 dark:border-gray-800 shadow-xl dark:shadow-[0_0_20px_rgba(0,0,0,0.6)] transform translate-x-full transition-all duration-300 opacity-0 z-50 flex flex-col"
     role="dialog" aria-labelledby="cart-title" aria-modal="true">

    <header class="border-b border-gray-200 dark:border-gray-700 p-3 flex items-center justify-between flex-shrink-0">
        <h2 id="cart-title" class="font-bold text-base">سبد خرید شما</h2>
        <button onclick="closeOffcanvas()" class="cursor-pointer" aria-label="بستن سبد خرید">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-700 dark:text-gray-300 hover:text-primary-500 transition-colors">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </header>

    <main class="relative space-y-4 divide-y divide-gray-200 dark:divide-gray-800 p-3 overflow-y-auto flex-1">
        <div id="cart-items-container">
            <div class="py-10 text-center">
                <p class="text-gray-500 dark:text-gray-400">در حال بارگذاری...</p>
            </div>
        </div>
    </main>

    <footer class="p-3 flex-shrink-0 bg-white dark:bg-custom-dark border-t border-gray-200 dark:border-gray-700">
        <div class="mb-1">
            <span class="text-sm text-gray-600 dark:text-gray-400">جمع کل</span>
        </div>

        <div class="flex items-center justify-between mb-2" id="offcanvas-price-row">
            <div class="flex items-center gap-2" id="offcanvas-subtotal-container" style="display: none;">
                <del class="text-xs text-gray-400 dark:text-gray-500" id="offcanvas-subtotal">
                    <span id="offcanvas-subtotal-value">0</span> تومان
                </del>
                <span class="bg-secondary-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-xl rounded-bl-md shadow shadow-red-500/50"
                      id="offcanvas-discount-badge" style="display: none;">
                    <span id="offcanvas-discount-percent">0</span>%
                </span>
            </div>
            <h3 class="font-bold text-xl text-gray-900 dark:text-white" id="offcanvas-total">
                0 تومان
            </h3>
        </div>

        <div class="mt-1">
            <a href="<?= site_url('cart') ?>"
               class="w-full block text-center bg-primary dark:bg-primary-500 hover:bg-primary-600 dark:hover:bg-primary-400 text-white py-2 px-4 rounded-lg shadow-sm transition-colors duration-200">
                مشاهده سبد خرید
            </a>
        </div>
    </footer>
</div>
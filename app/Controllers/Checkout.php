<?php

namespace App\Controllers;

class Checkout extends BaseController
{
    protected $cartService;
    protected $addressService;
    protected $shippingService;

    public function __construct()
    {
        helper(['menu']);
        $this->cartService = service('cartService');
        $this->addressService = service('addressService');
        $this->shippingService = service('shippingService');
    }

    private function redirectForIncompleteProfile(string $returnUrl)
    {
        if ($this->auth->hasMinimunProfile()) {
            return null;
        }

        session()->set('redirect_login_url', $returnUrl);
        $this->flash('complete_minumum_profile');

        return redirect()->to('customer/profile');
    }

    public function shipping($factorId = null)
    {
        $returnUrl = $factorId
            ? site_url('checkout/shipping/' . $factorId)
            : site_url('checkout/shipping');
        if ($redirect = $this->redirectForIncompleteProfile($returnUrl)) {
            return $redirect;
        }

        $customerId = service('customerAuth')->getCustomerId();

        // ====== ۱. دریافت سبد خرید ======
        $cart = $this->cartService->getCart();
        if (!$cart) {
            $this->flash('cart_not_found');
            return redirect()->to('cart');
        }

        // ====== ۲. چک کردن خالی نبودن سبد خرید ======
        $items = $this->cartService->getItems();
        if (empty($items)) {
            $this->flash('empty_cart');
            return redirect()->to('cart');
        }

        $totalWeight = $this->calculateCartWeight($items);
        if ($totalWeight < 1 || $totalWeight > 4000) {
            $this->flash('shipping_weight_not_supported');
            return redirect()->to('cart');
        }

        // ====== ۳. اگر factorId داده شده، چک کن که معتبر باشه ======
        $factor = null;
        if ($factorId) {
            $factorModel = model('App\Models\FactorModel');
            $factor = $factorModel->find($factorId);

            // چک کن فاکتور متعلق به این کاربره و awaiting_payment هست
            if ($factor
                && $factor['customer_id'] == $customerId
                && $factor['status'] == 'awaiting_payment'
                && $factor['expires_at'] > time()) {
                $selectedAddressId = $factor['address_id'];
                $selectedShippingTypeId = $factor['shipping_type_id'];
            } else {
                if ($factor
                    && $factor['customer_id'] == $customerId
                    && $factor['status'] == 'awaiting_payment'
                    && $factor['expires_at'] <= time()) {
                    $factorModel->update($factorId, ['status' => 'expired']);
                    model('App\Models\PaymentModel')->where('factor_id', $factorId)
                        ->whereIn('status', ['created', 'pending'])
                        ->set(['status' => 'expired'])
                        ->update();
                    $this->flash('invoice_expired', 'زمان این فاکتور به پایان رسیده است. لطفاً دوباره از سبد خرید ادامه دهید.');
                    return redirect()->to('cart');
                }
                $factor = null;
                $selectedAddressId = null;
                $selectedShippingTypeId = null;
            }
        } else {
            $selectedAddressId = null;
            $selectedShippingTypeId = null;
        }

        // ====== ۴. دریافت اطلاعات مورد نیاز ======
        $addresses = $this->addressService->getCustomerAddresses($customerId);
        $shippingTypes = $this->shippingService->getShippingTypes();
        $cartSummary = $this->cartService->getCartSummary();
        $states = $this->addressService->getStatesWithCities();

        // ====== ۵. دریافت قیمت ارسال برای آدرس انتخاب شده ======
        $shippingPrices = [];
        $selectedCityId = null;

        if ($selectedAddressId) {
            $address = $this->addressService->getAddressDetails($selectedAddressId);
            if ($address) {
                $selectedCityId = $address['city_id'];
                $shippingPrices = $this->shippingService->getShippingPricesByCity($selectedCityId, $totalWeight);
            }
        }

        // ====== ۶. نمایش ویو ======
        $this->viewData['addresses'] = $addresses;
        $this->viewData['states'] = $states;
        $this->viewData['shipping_types'] = $shippingTypes;
        $this->viewData['cart'] = $cartSummary;
        $this->viewData['selected_address_id'] = $selectedAddressId;
        $this->viewData['selected_shipping_type_id'] = $selectedShippingTypeId;
        $this->viewData['shipping_prices'] = $shippingPrices;
        $this->viewData['selected_city_id'] = $selectedCityId;
        $this->viewData['factor_id'] = $factorId;
        $this->viewData['title'] = 'آدرس و روش ارسال';
        $this->viewData['robots'] = 'noindex, nofollow';

        return view('checkout/shipping', $this->viewData);
    }

    public function getCities($stateId)
    {
        if ($redirect = $this->redirectForIncompleteProfile(site_url('checkout/shipping'))) {
            return $redirect;
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $cities = $this->addressService->getCitiesByState($stateId);
        return $this->response->setJSON($cities);
    }

    public function addAddress()
    {
        if ($redirect = $this->redirectForIncompleteProfile(site_url('checkout/shipping'))) {
            return $redirect;
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $customerId = service('customerAuth')->getCustomerId();
        if (!$customerId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'لطفاً وارد حساب کاربری خود شوید']);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'state_id' => $this->request->getPost('state_id'),
            'city_id' => $this->request->getPost('city_id'),
            'postal_code' => $this->request->getPost('postal_code'),
            'address' => $this->request->getPost('address'),
            'recipient_name' => $this->request->getPost('recipient_name'),
            'recipient_mobile' => $this->request->getPost('recipient_mobile')
        ];

        $result = $this->addressService->addAddress($customerId, $data);

        if ($result['status'] === 'success') {
            $address = $result['address'];
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'آدرس با موفقیت افزوده شد',
                'address' => $address, // کل اطلاعات آدرس رو برگردون
            ]);
        }

        return $this->response->setJSON($result);
    }

    public function saveShipping()
    {
        if ($redirect = $this->redirectForIncompleteProfile(site_url('checkout/shipping'))) {
            return $redirect;
        }

        // ====== ۱. دریافت داده‌ها از فرم ======
        $addressId = (int) $this->request->getPost('address_id');
        $shippingTypeId = (int) $this->request->getPost('shipping_type_id');

        // ====== ۲. اعتبارسنجی ======
        if (!$addressId) {
            $this->flash('select_an_address');
            return redirect()->back()->with('error', '');
        }

        if (!$shippingTypeId) {
            $this->flash('select_shipping_address');
            return redirect()->back();
        }

        // ====== ۳. بررسی آدرس ======
        $customerId = (int) service('customerAuth')->getCustomerId();
        $address = $this->addressService->getAddressDetails($addressId);
        if (!$address || (int) $address['customer_id'] !== $customerId) {
            $this->flash('invalid_address');
            return redirect()->back();
        }

        // ====== ۵. دریافت سبد خرید ======
        $cart = $this->cartService->getCart();
        if (!$cart) {
            $this->flash('cart_not_found');
            return redirect()->back();
        }

        $cartItems = $this->cartService->getItems();
        if (empty($cartItems)) {
            $this->flash('empty_cart');
            return redirect()->back();
        }

        $totalWeight = $this->calculateCartWeight($cartItems);
        if ($totalWeight < 1 || $totalWeight > 4000) {
            $this->flash('shipping_weight_not_supported');
            return redirect()->to('cart');
        }

        // قیمت ارسال فقط از ستون وزن متناظر در دیتابیس خوانده می‌شود.
        $shippingPrice = $this->shippingService->getShippingPrice($address['city_id'], $shippingTypeId, $totalWeight);
        if (!$shippingPrice) {
            $this->flash('not_available_shipping_type');
            return redirect()->back();
        }

        // قیمت و موجودی فقط در نقاط صریح Cart/Checkout با منبع اصلی همگام می‌شوند.
        $refresh = $this->cartService->refreshPricesAndAvailability();
        if ($refresh['has_unavailable_items']) {
            $this->flash('cart_stock_changed', 'موجودی یک یا چند محصول کافی نیست. لطفاً سبد خرید را بررسی کنید.');
            return redirect()->to('cart');
        }
        if ($refresh['price_changed']) {
            $this->flash('cart_price_changed', 'قیمت یک یا چند محصول تغییر کرده است. لطفاً سبد خرید را مجدداً بررسی و تأیید کنید.');
            return redirect()->to('cart');
        }

        // پس از همگام‌سازی، داده‌ای که Snapshot می‌شود دوباره خوانده می‌شود.
        $cartItems = $this->cartService->getItems();

        // ====== ۶. محاسبه مبالغ از آیتم‌های سبد ======
        $subtotal = 0;
        foreach ($cartItems as $item) {
            // قیمت نهایی: اگه sale_price وجود داره ازش استفاده کن، وگرنه price
            $finalPrice = isset($item['sale_price']) && $item['sale_price'] > 0 && $item['sale_price'] < $item['price']
                ? (float) $item['sale_price']
                : (float) $item['price'];
            $subtotal += $finalPrice * $item['quantity'];
        }
        $total = $subtotal + (float) $shippingPrice['price'];

        // ====== ۷. ساخت یا آپدیت فاکتور ======
        $factorModel = model('App\Models\FactorModel');
        $factorItemModel = model('App\Models\FactorItemModel');

        // فاکتورهای رهاشده حذف نمی‌شوند؛ فقط برای حفظ سابقه منقضی می‌شوند.
        $expiredFactors = $factorModel->where('cart_id', $cart['id'])
            ->where('customer_id', $customerId)
            ->where('status', 'awaiting_payment')
            ->where('expires_at <=', time())
            ->findAll();
        if ($expiredFactors) {
            $expiredFactorIds = array_column($expiredFactors, 'id');
            $factorModel->whereIn('id', $expiredFactorIds)->set(['status' => 'expired'])->update();
            model('App\Models\PaymentModel')->whereIn('factor_id', $expiredFactorIds)
                ->whereIn('status', ['created', 'pending'])
                ->set(['status' => 'expired'])
                ->update();
        }

        $existingFactor = $factorModel->where('cart_id', $cart['id'])
            ->where('customer_id', $customerId)
            ->where('status', 'awaiting_payment')
            ->where('expires_at >', time())
            ->first();

        $db = db_connect();
        $db->transStart();

        if ($existingFactor) {
            $factorId = $existingFactor['id'];
            // هر Payment ساخته‌شده ولی شروع‌نشده به مبلغ Snapshot قبلی وابسته است.
            model('App\Models\PaymentModel')->where('factor_id', $factorId)
                ->where('status', 'created')
                ->set(['status' => 'cancelled'])
                ->update();
            $factorModel->update($factorId, [
                'address_id' => $addressId,
                'shipping_type_id' => $shippingTypeId,
                'shipping_price' => $shippingPrice['price'],
                'subtotal' => $subtotal,
                'total' => $total
            ]);
            $factorItemModel->where('factor_id', $factorId)->delete();
        } else {
            $factorId = $factorModel->insert([
                'customer_id' => $customerId,
                'cart_id' => $cart['id'],
                'address_id' => $addressId,
                'shipping_type_id' => $shippingTypeId,
                'shipping_price' => $shippingPrice['price'],
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => 'awaiting_payment',
                'expires_at' => time() + (60 * 60)
            ]);
        }

        // ====== ۸. کپی آیتم‌های سبد خرید به فاکتور ======
        $factorItemModel->copyFromCartItems($factorId, $cartItems);

        $db->transComplete();
        if (!$db->transStatus()) {
            $this->flash('invoice_create_error');
            return redirect()->back();
        }

        // Payment در این مرحله ساخته نمی‌شود؛ هر تلاش پرداخت رکورد مستقل خود را دارد.
        return redirect()->to('checkout/payment/' . $factorId);
    }

    /**
     * دریافت قیمت ارسال بر اساس آدرس انتخاب شده (AJAX)
     */
    public function getShippingPrices()
    {
        if ($redirect = $this->redirectForIncompleteProfile(site_url('checkout/shipping'))) {
            return $redirect;
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $addressId = (int) $this->request->getPost('address_id');

        if (!$addressId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'آدرس یافت نشد']);
        }

        $address = $this->addressService->getAddressDetails($addressId);
        if (!$address) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'آدرس معتبر نیست']);
        }

        $cartItems = $this->cartService->getItems();
        $totalWeight = $this->calculateCartWeight($cartItems);
        if ($totalWeight < 1 || $totalWeight > 4000) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'وزن سفارش باید بین ۱ گرم تا ۴ کیلوگرم باشد.'
            ]);
        }

        $shippingPrices = $this->shippingService->getShippingPricesByCity($address['city_id'], $totalWeight);

        // تبدیل به فرمت key-value برای راحتی در JS
        $formattedPrices = [];
        foreach ($shippingPrices as $price) {
            $formattedPrices[$price['shipping_type_id']] = [
                'price' => $price['price'],
                'shipping_type_name' => $price['shipping_type_name']
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'city_id' => $address['city_id'],
            'city_name' => $address['city_name'],
            'shipping_prices' => $formattedPrices
        ]);
    }

    private function calculateCartWeight(array $items): int
    {
        $totalWeight = 0;
        foreach ($items as $item) {
            $totalWeight += (int) $item['weight'] * (int) $item['quantity'];
        }

        return $totalWeight;
    }

    /**
     * حذف آدرس (AJAX)
     */
    public function deleteAddress()
    {
        if ($redirect = $this->redirectForIncompleteProfile(site_url('checkout/shipping'))) {
            return $redirect;
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $addressId = (int) $this->request->getPost('address_id');
        $customerId = session()->get('customer_id');

        if (!$addressId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'آدرس یافت نشد']);
        }

        $result = $this->addressService->deleteAddress($addressId, $customerId);
        return $this->response->setJSON($result);
    }

    public function payment($factorId)
    {
        if ($redirect = $this->redirectForIncompleteProfile(site_url('checkout/payment/' . $factorId))) {
            return $redirect;
        }

        // ====== ۱. دریافت فاکتور ======
        $factorModel = model('App\Models\FactorModel');
        $factor = $factorModel->getData([
            'id' => $factorId,
            'customer_id' => session()->get('customer_id')
        ]);

        if (empty($factor)) {
            return redirect()->to('cart')->with('error', 'فاکتور یافت نشد');
        }
        $factor = $factor[0];

        // ====== ۲. چک کردن وضعیت فاکتور ======
        if (!in_array($factor['status'], ['awaiting_payment', 'payment_pending'], true)) {
            return redirect()->to('cart')->with('error', 'این فاکتور قابل پرداخت نیست');
        }

        // ====== ۳. چک کردن انقضا ======
        if ($factor['status'] === 'awaiting_payment' && $factor['expires_at'] < time()) {
            $factorModel->update($factorId, ['status' => 'expired']);
            // payment رو هم expire کن
            $paymentModel = model('App\Models\PaymentModel');
            $paymentModel->where('factor_id', $factorId)
                ->whereIn('status', ['created', 'pending'])
                ->set(['status' => 'expired'])
                ->update();
            return redirect()->to('cart')->with('error', 'زمان ثبت سفارش به پایان رسیده. لطفاً مجدداً اقدام کنید.');
        }

        // ====== ۴. دریافت آیتم‌های فاکتور ======
        $factorItemModel = model('App\Models\FactorItemModel');
        $items = $factorItemModel->getItemsByFactorId($factorId);

        // ====== ۵. دریافت پرداخت ======
        $paymentModel = model('App\Models\PaymentModel');
        $payment = $paymentModel->getActivePaymentByFactor($factorId);

        // ====== ۶. دریافت روش‌های پرداخت ======
        $paymentMethodModel = model('App\Models\PaymentMethodModel');
        $paymentMethods = $paymentMethodModel->where('is_active', 1)->findAll();

        // ====== ۷. محاسبه زمان باقیمانده ======
        $remainingMinutes = max(0, ceil(($factor['expires_at'] - time()) / 60));

        // ====== ۸. نمایش ویو ======
        $this->viewData['factor'] = $factor;
        $this->viewData['items'] = $items;
        $this->viewData['payment'] = $payment;
        $this->viewData['payment_methods'] = $paymentMethods;
        $this->viewData['remaining_minutes'] = $remainingMinutes;
        $this->viewData['title'] = 'پرداخت';
        $this->viewData['robots'] = 'noindex, nofollow';

        return view('checkout/payment', $this->viewData);
    }
}

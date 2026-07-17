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

    public function shipping($factorId = null)
    {
        // ====== ۱. دریافت سبد خرید ======
        $cart = $this->cartService->getCart();
        if (!$cart) {
            return redirect()->to('cart')->with('error', 'سبد خرید یافت نشد');
        }

        // ====== ۲. چک کردن خالی نبودن سبد خرید ======
        $items = $this->cartService->getItems();
        if (empty($items)) {
            return redirect()->to('cart')->with('error', 'سبد خرید شما خالی است');
        }

        // ====== ۳. اگر factorId داده شده، چک کن که معتبر باشه ======
        $factor = null;
        if ($factorId) {
            $factorModel = model('App\Models\FactorModel');
            $factor = $factorModel->find($factorId);

            // چک کن فاکتور متعلق به این کاربره و awaiting_payment هست
            if ($factor && $factor['customer_id'] == session()->get('customer_id') && $factor['status'] == 'awaiting_payment') {
                $selectedAddressId = $factor['address_id'];
                $selectedShippingTypeId = $factor['shipping_type_id'];
            } else {
                $factor = null;
                $selectedAddressId = null;
                $selectedShippingTypeId = null;
            }
        } else {
            $selectedAddressId = null;
            $selectedShippingTypeId = null;
        }

        // ====== ۴. دریافت اطلاعات مورد نیاز ======
        $customerId = session()->get('customer_id');
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
                $shippingPrices = $this->shippingService->getShippingPricesByCity($selectedCityId);
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

        return view('checkout/shipping', $this->viewData);
    }

    public function getCities($stateId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $cities = $this->addressService->getCitiesByState($stateId);
        return $this->response->setJSON($cities);
    }

    public function addAddress()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $customerId = session()->get('customer_id');
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

        // اگر موفقیت آمیز بود، آدرس جدید رو به همراه city_id برگردون
        if ($result['status'] === 'success') {
            $address = $result['address'];
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'آدرس با موفقیت افزوده شد',
                'address_id' => $address['id'],
                'city_id' => $address['city_id']
            ]);
        }

        return $this->response->setJSON($result);
    }

    public function saveShipping()
    {
        // ====== ۱. دریافت داده‌ها از فرم ======
        $addressId = (int) $this->request->getPost('address_id');
        $shippingTypeId = (int) $this->request->getPost('shipping_type_id');

        // ====== ۲. اعتبارسنجی ======
        if (!$addressId) {
            return redirect()->back()->with('error', 'لطفاً یک آدرس انتخاب کنید');
        }

        if (!$shippingTypeId) {
            return redirect()->back()->with('error', 'لطفاً روش ارسال را انتخاب کنید');
        }

        // ====== ۳. بررسی آدرس ======
        $address = $this->addressService->getAddressDetails($addressId);
        if (!$address) {
            return redirect()->back()->with('error', 'آدرس انتخاب شده معتبر نیست');
        }

        // ====== ۴. بررسی قیمت ارسال ======
        $shippingPrice = $this->shippingService->getShippingPrice($address['city_id'], $shippingTypeId);
        if (!$shippingPrice) {
            return redirect()->back()->with('error', 'روش ارسال برای این شهر موجود نیست');
        }

        // ====== ۵. دریافت سبد خرید ======
        $cart = $this->cartService->getCart();
        if (!$cart) {
            return redirect()->back()->with('error', 'سبد خرید یافت نشد');
        }

        $cartItems = $this->cartService->getItems();
        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'سبد خرید شما خالی است');
        }

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

        $existingFactor = $factorModel->where('cart_id', $cart['id'])
            ->where('status', 'awaiting_payment')
            ->where('expires_at >', time())
            ->first();

        if ($existingFactor) {
            $factorId = $existingFactor['id'];
            $factorModel->update($factorId, [
                'address_id' => $addressId,
                'shipping_type_id' => $shippingTypeId,
                'shipping_price' => $shippingPrice['price'],
                'subtotal' => $subtotal,
                'total' => $total,
                'expires_at' => time() + (60 * 60)
            ]);
            $factorItemModel->where('factor_id', $factorId)->delete();
        } else {
            $factorId = $factorModel->insert([
                'customer_id' => session()->get('customer_id'),
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

        // ====== ۹. ساخت یا آپدیت رکورد payment ======
        $paymentModel = model('App\Models\PaymentModel');
        $existingPayment = $paymentModel->where('factor_id', $factorId)
            ->where('status', 'awaiting_payment')
            ->where('expires_at >', time())
            ->first();

        if ($existingPayment) {
            $paymentModel->update($existingPayment['id'], [
                'final_amount' => $total,
                'expires_at' => time() + (60 * 60)
            ]);
        } else {
            $paymentModel->insert([
                'factor_id' => $factorId,
                'customer_id' => session()->get('customer_id'),
                'payment_method_id' => 1,
                'final_amount' => $total,
                'status' => 'awaiting_payment',
                'expires_at' => time() + (60 * 60)
            ]);
        }

        // ====== ۱۰. ریدایرکت به صفحه payment ======
        return redirect()->to('checkout/payment/' . $factorId);
    }

    /**
     * دریافت قیمت ارسال بر اساس آدرس انتخاب شده (AJAX)
     */
    public function getShippingPrices()
    {
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

        $shippingPrices = $this->shippingService->getShippingPricesByCity($address['city_id']);

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

    /**
     * حذف آدرس (AJAX)
     */
    public function deleteAddress()
    {
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
        if ($factor['status'] !== 'awaiting_payment') {
            return redirect()->to('cart')->with('error', 'این فاکتور قابل پرداخت نیست');
        }

        // ====== ۳. چک کردن انقضا ======
        if ($factor['expires_at'] < time()) {
            $factorModel->update($factorId, ['status' => 'expired']);
            // payment رو هم expire کن
            $paymentModel = model('App\Models\PaymentModel');
            $paymentModel->where('factor_id', $factorId)
                ->where('status', 'awaiting_payment')
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
        $remainingMinutes = ceil(($factor['expires_at'] - time()) / 60);

        // ====== ۸. نمایش ویو ======
        $this->viewData['factor'] = $factor;
        $this->viewData['items'] = $items;
        $this->viewData['payment'] = $payment;
        $this->viewData['payment_methods'] = $paymentMethods;
        $this->viewData['remaining_minutes'] = $remainingMinutes;
        $this->viewData['title'] = 'پرداخت';

        return view('checkout/payment', $this->viewData);
    }
}
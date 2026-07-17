<?php

namespace App\Controllers;

class Cart extends BaseController
{
    protected $cartService;

    public function __construct()
    {
        helper(['menu']);
        $this->cartService = service('cartService');
    }

    public function index()
    {
        $summary = $this->cartService->getCartSummary();

        $this->viewData['cart'] = $summary;
        $this->viewData['title'] = 'سبد خرید';

        return view('cart/index', $this->viewData);
    }

    public function add()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $productId = (int) $this->request->getPost('product_id');
        $colorOptionId = (int) $this->request->getPost('color_option_id') ?: null;
        $sizeOptionId = (int) $this->request->getPost('size_option_id') ?: null;
        $quantity = (int) $this->request->getPost('quantity') ?: 1;

        if (!$productId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'محصول یافت نشد']);
        }

        // ====== بررسی اینکه محصول چه آپشن‌هایی داره ======
        $productService = service('productService');
        $options = $productService->getProductOptions($productId);

        $hasColor = $options['has_color'] ?? false;
        $hasSize = $options['has_size'] ?? false;

        // ====== شرط‌های افزودن به سبد ======
        if ($hasColor && $hasSize) {
            // هم رنگ و هم سایز داره → هر دو باید انتخاب بشن
            if (!$colorOptionId || !$sizeOptionId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'لطفاً رنگ و سایز را انتخاب کنید']);
            }
        } elseif ($hasColor && !$hasSize) {
            // فقط رنگ داره → فقط رنگ باید انتخاب بشه
            if (!$colorOptionId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'لطفاً رنگ را انتخاب کنید']);
            }
        } elseif (!$hasColor && $hasSize) {
            // فقط سایز داره → فقط سایز باید انتخاب بشه
            if (!$sizeOptionId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'لطفاً سایز را انتخاب کنید']);
            }
        }
        // اگر هیچکدوم رو نداره → بدون آپشن هم قابل اضافه‌ست (چیزی چک نمیکنیم)

        $result = $this->cartService->addItem($productId, $colorOptionId, $sizeOptionId, $quantity);

        if ($result['status'] === 'success') {
            $result['total_items'] = $this->cartService->getTotalItems();
        }

        return $this->response->setJSON($result);
    }

    public function remove()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $itemId = (int) $this->request->getPost('item_id');

        if (!$itemId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'آیتم یافت نشد']);
        }

        $result = $this->cartService->removeItem($itemId);

        if ($result['status'] === 'success') {
            $summary = $this->cartService->getCartSummary();
            $result['total_items'] = $summary['total_items'];
            $result['total_price'] = $summary['total_price'];
            $result['subtotal'] = $summary['subtotal'];
            $result['total_discount'] = $summary['total_discount'];
        }

        return $this->response->setJSON($result);
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $itemId = (int) $this->request->getPost('item_id');
        $quantity = (int) $this->request->getPost('quantity') ?: 1;

        if (!$itemId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'آیتم یافت نشد']);
        }

        $result = $this->cartService->updateQuantity($itemId, $quantity);

        if ($result['status'] === 'success') {
            $summary = $this->cartService->getCartSummary();
            $result['total_items'] = $summary['total_items'];
            $result['total_price'] = $summary['total_price'];
            $result['subtotal'] = $summary['subtotal'];
            $result['total_discount'] = $summary['total_discount'];
        }

        return $this->response->setJSON($result);
    }

    public function count()
    {
        $count = $this->cartService->getTotalItems();
        return $this->response->setJSON(['count' => $count]);
    }

    public function offcanvas()
    {
        $summary = $this->cartService->getCartSummary();
        $html = view('cart/cart_offcanvas_items', ['cart' => $summary]);

        $discountPercent = 0;
        if ($summary['subtotal'] > 0 && $summary['total_discount'] > 0) {
            $discountPercent = round(($summary['total_discount'] / $summary['subtotal']) * 100);
        }

        return $this->response->setJSON([
            'html' => $html,
            'subtotal' => $summary['subtotal'],
            'total_price' => $summary['total_price'],
            'total_discount' => $summary['total_discount'],
            'discount_percent' => $discountPercent
        ]);
    }

    public function proceedToCheckout()
    {
        // ====== ۱. چک کردن لاگین بودن ======
        $auth = service('customerAuth');
        if (!$auth->isLoggedIn()) {
            return redirect()->to('login')->with('redirect', 'cart/proceed-to-checkout');
        }

        // ====== ۲. دریافت سبد خرید ======
        $items = $this->cartService->getItems();
        if (empty($items)) {
            $this->flash('empty_cart');
            return redirect()->to('cart');
        }

        // ====== ۳. چک کردن فاکتور awaiting_payment فعال ======
        $cart = $this->cartService->getCart();
        $factorModel = model('App\Models\FactorModel');

        $existingFactor = $factorModel->where('cart_id', $cart['id'])
            ->where('status', 'awaiting_payment')
            ->where('expires_at >', time())
            ->first();

        if ($existingFactor) {
            return redirect()->to('checkout/shipping/' . $existingFactor['id']);
        }

        // ====== ۴. رفتن به صفحه shipping ======
        return redirect()->to('checkout/shipping');
    }
}
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

        // اجباری کردن انتخاب رنگ و سایز
        if (!$colorOptionId && !$sizeOptionId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'لطفاً رنگ و سایز را انتخاب کنید']);
        }

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
        return view('cart/cart_offcanvas_items', ['cart' => $summary]);
    }
}
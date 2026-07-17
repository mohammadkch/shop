<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\ProductModel;
use App\Models\ProductPriceModel;

class CartService
{
    protected $cartModel;
    protected $cartItemModel;
    protected $productModel;
    protected $productPriceModel;
    protected $session;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->productModel = new ProductModel();
        $this->productPriceModel = new ProductPriceModel();
        $this->session = \Config\Services::session();
    }

    public function getCart()
    {
        $userId = $this->session->get('user_id');
        $sessionId = $this->session->get('session_id');

        if (!$sessionId) {
            $sessionId = session_id();
            $this->session->set('session_id', $sessionId);
        }

        $cart = $this->cartModel->getOrCreateCart($userId, $sessionId);

        if ($userId) {
            $guestCart = $this->cartModel->getCartBySessionId($sessionId);
            if ($guestCart && $guestCart['id'] != $cart['id']) {
                $this->mergeGuestCart($guestCart['id'], $cart['id']);
            }
        }

        return $cart;
    }

    protected function mergeGuestCart($guestCartId, $userCartId)
    {
        $guestItems = $this->cartItemModel->where('cart_id', $guestCartId)->findAll();

        foreach ($guestItems as $item) {
            $existing = $this->cartItemModel->getItemByProductAndOptions(
                $userCartId,
                $item['product_id'],
                $item['color_option_id'],
                $item['size_option_id']
            );

            if ($existing) {
                $this->cartItemModel->update($existing['id'], [
                    'quantity' => $existing['quantity'] + $item['quantity']
                ]);
            } else {
                $item['cart_id'] = $userCartId;
                unset($item['id']);
                $this->cartItemModel->insert($item);
            }
        }

        $this->cartModel->delete($guestCartId);
    }

    public function getStock($productId, $colorOptionId = null, $sizeOptionId = null)
    {
        // ۱. اگه رنگ یا سایز مشخص شده، اول رکورد خاص رو چک کن
        if ($colorOptionId || $sizeOptionId) {
            $specificRecord = $this->productPriceModel->getPriceForCombination($productId, $colorOptionId, $sizeOptionId);
            if ($specificRecord) {
                return (int) $specificRecord['stock'];
            }
            // اگه رکورد خاص پیدا نشد → موجودی ۰
            return 0;
        }

        // ۲. اگه رنگ و سایز مشخص نشده، موجودی کل رو جمع کن
        $records = $this->productPriceModel
            ->where('product_id', $productId)
            ->findAll();
        $total = 0;
        foreach ($records as $record) {
            $total += (int) $record['stock'];
        }
        return $total;
    }

    public function calculatePrice($productId, $colorOptionId = null, $sizeOptionId = null)
    {
        $price = 0;
        $salePrice = null;

        // ۱. اگه رنگ یا سایز مشخص شده، رکورد خاص رو پیدا کن
        if ($colorOptionId || $sizeOptionId) {
            $specificRecord = $this->productPriceModel->getPriceForCombination($productId, $colorOptionId, $sizeOptionId);
            if ($specificRecord) {
                $price = (float) $specificRecord['price'];
                $salePrice = isset($specificRecord['sale_price']) && $specificRecord['sale_price'] > 0
                    ? (float) $specificRecord['sale_price']
                    : null;

                // اگه sale_price وجود داره و از price کمتره، اون رو برگردون (بدون چک تاریخ)
                if ($salePrice !== null && $salePrice < $price) {
                    return $salePrice;
                }
                return $price;
            }
        }

        // ۲. اگه رکورد خاص نبود یا رنگ/سایز مشخص نشده، از رکورد پیش‌فرض استفاده کن
        $defaultRecord = $this->productPriceModel
            ->where('product_id', $productId)
            ->where('is_default', 1)
            ->first();

        if ($defaultRecord) {
            $price = (float) $defaultRecord['price'];
            $salePrice = isset($defaultRecord['sale_price']) && $defaultRecord['sale_price'] > 0
                ? (float) $defaultRecord['sale_price']
                : null;

            if ($salePrice !== null && $salePrice < $price) {
                return $salePrice;
            }
            return $price;
        }

        return 0;
    }

    public function addItem($productId, $colorOptionId = null, $sizeOptionId = null, $quantity = 1)
    {
        $cart = $this->getCart();

        // ۱. موجودی
        $stock = $this->getStock($productId, $colorOptionId, $sizeOptionId);
        if ($stock < $quantity) {
            return ['status' => 'error', 'message' => 'موجودی کافی نیست'];
        }

        // ۲. دریافت قیمت‌ها
        $originalPrice = $this->getOriginalPrice($productId, $colorOptionId, $sizeOptionId);
        $finalPrice = $this->calculatePrice($productId, $colorOptionId, $sizeOptionId);

        // ۳. sale_price: اگه قیمت نهایی از قیمت اصلی کمتره، sale_price رو ست کن
//        $salePrice = ($finalPrice < $originalPrice) ? $finalPrice : null;
        $salePrice = $finalPrice;

        // ۴. بررسی آیتم موجود
        $existing = $this->cartItemModel->getItemByProductAndOptions(
            $cart['id'],
            $productId,
            $colorOptionId,
            $sizeOptionId
        );

        if ($existing) {
            $newQuantity = $existing['quantity'] + $quantity;
            if ($stock < $newQuantity) {
                return ['status' => 'error', 'message' => 'موجودی کافی نیست'];
            }
            $this->cartItemModel->update($existing['id'], [
                'quantity' => $newQuantity,
                'price' => $originalPrice,
                'sale_price' => $salePrice
            ]);
        } else {
            $this->cartItemModel->insert([
                'cart_id' => $cart['id'],
                'product_id' => $productId,
                'color_option_id' => $colorOptionId,
                'size_option_id' => $sizeOptionId,
                'quantity' => $quantity,
                'price' => $originalPrice,
                'sale_price' => $salePrice
            ]);
        }

        return ['status' => 'success', 'message' => 'به سبد خرید اضافه شد'];
    }

    /**
     * دریافت قیمت اصلی (بدون تخفیف)
     */
    private function getOriginalPrice($productId, $colorOptionId = null, $sizeOptionId = null)
    {
        // اگه رنگ یا سایز مشخص شده، رکورد خاص رو پیدا کن
        if ($colorOptionId || $sizeOptionId) {
            $specificRecord = $this->productPriceModel->getPriceForCombination($productId, $colorOptionId, $sizeOptionId);
            if ($specificRecord) {
                return (float) $specificRecord['price'];
            }
        }

        // اگه رکورد خاص نبود یا رنگ/سایز مشخص نشده، از رکورد پیش‌فرض استفاده کن
        $defaultRecord = $this->productPriceModel
            ->where('product_id', $productId)
            ->where('is_default', 1)
            ->first();

        return $defaultRecord ? (float) $defaultRecord['price'] : 0;
    }

    public function removeItem($itemId)
    {
        $cart = $this->getCart();
        $item = $this->cartItemModel->where('id', $itemId)->where('cart_id', $cart['id'])->first();

        if (!$item) {
            return ['status' => 'error', 'message' => 'آیتم یافت نشد'];
        }

        $this->cartItemModel->delete($itemId);
        return ['status' => 'success', 'message' => 'حذف شد'];
    }

    public function updateQuantity($itemId, $quantity)
    {
        if ($quantity < 1) {
            return $this->removeItem($itemId);
        }

        $cart = $this->getCart();
        $item = $this->cartItemModel->where('id', $itemId)->where('cart_id', $cart['id'])->first();

        if (!$item) {
            return ['status' => 'error', 'message' => 'آیتم یافت نشد'];
        }

        // بررسی موجودی
        $stock = $this->getStock($item['product_id'], $item['color_option_id'], $item['size_option_id']);
        if ($stock < $quantity) {
            return ['status' => 'error', 'message' => 'موجودی کافی نیست'];
        }

        $this->cartItemModel->update($itemId, ['quantity' => $quantity]);
        return ['status' => 'success', 'message' => 'تعداد آپدیت شد'];
    }

    public function clear()
    {
        $cart = $this->getCart();
        $this->cartItemModel->where('cart_id', $cart['id'])->delete();
        return ['status' => 'success', 'message' => 'سبد خرید خالی شد'];
    }

    public function getItems()
    {
        $cart = $this->getCart();
        $items = $this->cartItemModel->getItemsWithProduct($cart['id']);

        foreach ($items as &$item) {
            $item['total_price'] = $item['price'] * $item['quantity'];
        }

        return $items;
    }

    public function getTotalItems()
    {
        $cart = $this->getCart();
        return $this->cartItemModel->getTotalItems($cart['id']);
    }

    public function getTotalPrice()
    {
        $cart = $this->getCart();
        return $this->cartItemModel->getTotalPrice($cart['id']);
    }

    public function getCartSummary()
    {
        $cart = $this->getCart();
        if (!$cart) {
            return [
                'items' => [],
                'subtotal' => 0,
                'total_discount' => 0,
                'total_price' => 0,
                'total_items' => 0
            ];
        }

        $items = $this->cartItemModel->getItemsWithProduct($cart['id']);
        $subtotal = 0;
        $totalDiscount = 0;
        $totalItems = 0;

        foreach ($items as &$item) {
            // قیمت اصلی (price) و قیمت تخفیفی (sale_price)
            $originalPrice = (float) $item['price'];
            $salePrice = isset($item['sale_price']) && $item['sale_price'] > 0 ? (float) $item['sale_price'] : null;

            // قیمت نهایی: اگه sale_price وجود داره و از price کمتره، از sale_price استفاده کن
            $finalPrice = ($salePrice !== null && $salePrice < $originalPrice) ? $salePrice : $originalPrice;
            $hasDiscount = ($finalPrice < $originalPrice);

            $itemTotal = $finalPrice * $item['quantity'];
            $itemOriginalTotal = $originalPrice * $item['quantity'];

            $item['original_price'] = $originalPrice;
            $item['final_price'] = $finalPrice;
            $item['sale_price'] = $salePrice;
            $item['has_discount'] = $hasDiscount;
            $item['total_price'] = $itemTotal;
            $item['original_total'] = $itemOriginalTotal;

            if (!empty($item['color_value'])) {
                $optionModel = model('App\Models\OptionModel');
                $colorOption = $optionModel->find($item['color_option_id']);
                $item['color_code'] = $colorOption['color_code'] ?? null;
            }

            $subtotal += $itemOriginalTotal;
            $totalDiscount += ($originalPrice - $finalPrice) * $item['quantity'];
            $totalItems += $item['quantity'];
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'total_discount' => $totalDiscount,
            'total_price' => $subtotal - $totalDiscount,
            'total_items' => $totalItems
        ];
    }
}
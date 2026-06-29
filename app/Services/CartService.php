<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\ProductOptionModel;
use App\Models\ProductModel;

class CartService
{
    protected $cartModel;
    protected $cartItemModel;
    protected $productOptionModel;
    protected $productModel;
    protected $session;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->productOptionModel = new ProductOptionModel();
        $this->productModel = new ProductModel();
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

    /**
     * محاسبه قیمت نهایی محصول با تخفیف
     */
    public function calculatePrice($productId, $colorOptionId = null, $sizeOptionId = null)
    {
        $option = $this->productOptionModel
            ->where('product_id', $productId)
            ->whereIn('option_id', [$colorOptionId, $sizeOptionId])
            ->first();

        // ۲. دریافت محصول
        $product = $this->productModel->find($productId);

        // ۳. قیمت پایه
        if ($option && $option['price'] > 0) {
            $basePrice = $option['price'];
        } else {
            $basePrice = $product['price'] ?? 0;
        }

        // ۴. تخفیف روی محصول
        $now = time();
        if ($product['sale_price'] && $product['sale_price'] > 0 &&
            $product['sale_start_date'] <= $now &&
            $product['sale_end_date'] >= $now) {
            return $product['sale_price'];
        }

        return $basePrice;
    }

    /**
     * محاسبه موجودی برای ترکیب رنگ و سایز
     */
    public function getStock($productId, $colorOptionId = null, $sizeOptionId = null)
    {
        if (!$colorOptionId && !$sizeOptionId) {
            // اگر هیچ آپشنی انتخاب نشده، مجموع موجودی همه آپشن‌ها
            $options = $this->productOptionModel
                ->where('product_id', $productId)
                ->findAll();
            $total = 0;
            foreach ($options as $opt) {
                $total += $opt['stock'];
            }
            return $total;
        }

        $option = $this->productOptionModel
            ->where('product_id', $productId)
            ->whereIn('option_id', [$colorOptionId, $sizeOptionId])
            ->first();

        return $option ? $option['stock'] : 0;
    }

    public function addItem($productId, $colorOptionId = null, $sizeOptionId = null, $quantity = 1)
    {
        $cart = $this->getCart();

        // ۱. اعتبارسنجی موجودی
        $stock = $this->getStock($productId, $colorOptionId, $sizeOptionId);
        if ($stock < $quantity) {
            return ['status' => 'error', 'message' => 'موجودی کافی نیست'];
        }

        // ۲. محاسبه قیمت
        $price = $this->calculatePrice($productId, $colorOptionId, $sizeOptionId);

        // ۳. بررسی آیا این ترکیب قبلاً در سبد هست
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
                'price' => $price
            ]);
        } else {
            $this->cartItemModel->insert([
                'cart_id' => $cart['id'],
                'product_id' => $productId,
                'color_option_id' => $colorOptionId,
                'size_option_id' => $sizeOptionId,
                'quantity' => $quantity,
                'price' => $price
            ]);
        }

        return ['status' => 'success', 'message' => 'به سبد خرید اضافه شد'];
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

    // app/Services/CartService.php

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
            // محاسبه قیمت اصلی (قیمت پایه محصول)
            $originalPrice = $item['price'];

            // دریافت اطلاعات محصول برای بررسی تخفیف
            $productModel = model('App\Models\ProductModel');
            $product = $productModel->find($item['product_id']);

            // محاسبه قیمت نهایی با تخفیف
            $finalPrice = $originalPrice;
            $hasDiscount = false;

            if ($product && !empty($product['sale_price']) && $product['sale_price'] > 0) {
                // بررسی تاریخ تخفیف
                $now = time();
                $saleStart = $product['sale_start_date'] ?? null;
                $saleEnd = $product['sale_end_date'] ?? null;

                $isSaleActive = true;
                if ($saleStart && $saleStart > $now) {
                    $isSaleActive = false;
                }
                if ($saleEnd && $saleEnd < $now) {
                    $isSaleActive = false;
                }

                if ($isSaleActive && $product['sale_price'] < $originalPrice) {
                    $finalPrice = $product['sale_price'];
                    $hasDiscount = true;
                }
            }

            // محاسبه قیمت کل آیتم
            $itemTotal = $finalPrice * $item['quantity'];
            $itemOriginalTotal = $originalPrice * $item['quantity'];

            // اضافه کردن اطلاعات به آیتم
            $item['original_price'] = $originalPrice;
            $item['final_price'] = $finalPrice;
            $item['has_discount'] = $hasDiscount;
            $item['total_price'] = $itemTotal;
            $item['original_total'] = $itemOriginalTotal;

            // اضافه کردن اطلاعات رنگ و سایز
            if (!empty($item['color_value'])) {
                // دریافت کد رنگ از جدول option
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
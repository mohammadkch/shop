<?php

namespace App\Controllers;

use App\Models\CustomerWishlistModel;
use App\Models\ProductModel;

class Wishlist extends BaseController
{
    public function toggle()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'درخواست نامعتبر است.',
            ]);
        }

        $productId = (int) $this->request->getPost('product_id');
        $product = (new ProductModel())
            ->where('id', $productId)
            ->where('is_active', 1)
            ->first();

        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'محصول موردنظر یافت نشد.',
            ]);
        }

        if (!$this->auth->isLoggedIn()) {
            session()->set('redirect_login_url', product_url($product));

            return $this->response->setJSON([
                'status' => 'login_required',
                'message' => 'برای افزودن محصول به علاقه‌مندی‌ها وارد حساب خود شوید.',
                'login_url' => site_url('login'),
            ]);
        }

        $customerId = (int) $this->auth->getCustomerId();
        $wishlistModel = new CustomerWishlistModel();
        $existing = $wishlistModel->findForCustomerAndProduct($customerId, $productId);

        if ($existing) {
            if (!$wishlistModel->delete($existing['id'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'حذف محصول از علاقه‌مندی‌ها انجام نشد.',
                ]);
            }
            $isWishlisted = false;
            $message = 'محصول از لیست علاقه‌مندی‌ها حذف شد.';
        } else {
            $insertId = $wishlistModel->insert([
                'customer_id' => $customerId,
                'product_id' => $productId,
                'created_at' => time(),
            ]);
            if (!$insertId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'افزودن محصول به علاقه‌مندی‌ها انجام نشد.',
                ]);
            }
            $isWishlisted = true;
            $message = 'محصول به لیست علاقه‌مندی‌ها اضافه شد.';
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => $message,
            'is_wishlisted' => $isWishlisted,
            'count' => $wishlistModel->countForCustomer($customerId),
        ]);
    }
}

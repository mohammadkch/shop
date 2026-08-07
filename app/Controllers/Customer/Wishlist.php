<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\CustomerWishlistModel;

class Wishlist extends BaseController
{
    public function index()
    {
        helper('menu');

        $customerId = (int) $this->auth->getCustomerId();
        $customer = (new CustomerModel())->find($customerId);

        if (!$customer) {
            return redirect()->to('/logout');
        }

        $products = (new CustomerWishlistModel())->getProductsForCustomer($customerId);
        $productService = service('productService');

        foreach ($products as &$product) {
            $priceInfo = $productService->getFinalPrice($product);
            $product['original_price'] = $priceInfo['original_price'];
            $product['final_price'] = $priceInfo['final_price'];
            $product['has_discount'] = $priceInfo['has_discount'];
            $product['discount_percent'] = $priceInfo['discount_percent'];
            $product['total_stock'] = $productService->getStock((int) $product['id']);
        }
        unset($product);

        $this->viewData['customer'] = $customer;
        $this->viewData['products'] = $products;
        $this->viewData['title'] = 'لیست علاقه‌مندی‌ها';
        $this->viewData['robots'] = 'noindex, nofollow';

        return view('customer/wishlist/index', $this->viewData);
    }
}

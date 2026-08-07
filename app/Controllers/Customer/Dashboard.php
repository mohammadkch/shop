<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\CustomerWishlistModel;
use App\Models\FactorModel;

class Dashboard extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        helper(['menu']);
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {

        $customer = $this->customerModel->find($this->auth->getCustomerId());

        if (!$customer) {
            return redirect()->to('/logout');
        }

        $customerId = (int) $customer['id'];
        $factorModel = new FactorModel();
        $wishlistModel = new CustomerWishlistModel();

        $awaitingOrdersCount = $factorModel
            ->where('customer_id', $customerId)
            ->whereIn('status', ['paid', 'paid_stock_issue', 'confirmed'])
            ->countAllResults();

        // وضعیت delivered در چرخه سفارش فعلی هنوز اضافه نشده است.
        $deliveredOrdersCount = 0;

        $this->viewData['customer'] = $customer;
        $this->viewData['awaitingOrdersCount'] = $awaitingOrdersCount;
        $this->viewData['deliveredOrdersCount'] = $deliveredOrdersCount;
        $this->viewData['wishlistCount'] = $wishlistModel->countForCustomer($customerId);
        $this->viewData['title'] = 'پیشخوان کاربری';
        $this->viewData['robots'] = 'noindex, nofollow';

        return view('customer/dashboard/index', $this->viewData);
    }
}

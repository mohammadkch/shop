<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

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

        $this->viewData['customer'] = $customer;
        $this->viewData['title'] = 'پیشخوان کاربری';
        $this->viewData['robots'] = 'noindex, nofollow';

        return view('customer/dashboard/index', $this->viewData);
    }
}

<?php

namespace App\Controllers\Customer;

use App\Controllers\Customer\CustomerController;
use App\Models\CustomerModel;

class Dashboard extends CustomerController
{
    protected $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {

        $customerId = session()->get('customer_id');
        $customer = $this->customerModel->find($customerId);

        if (!$customer) {
            return redirect()->to('/logout');
        }

        $this->viewData['customer'] = $customer;
        $this->viewData['title'] = 'پیشخوان کاربری';

        return view('customer/dashboard/index', $this->viewData);
    }
}
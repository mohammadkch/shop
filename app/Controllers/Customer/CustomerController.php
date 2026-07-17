<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;

class CustomerController extends BaseController
{
    protected $auth;
    protected $customer;

    public function __construct()
    {
        helper('menu');
        $this->viewData = $this->viewData ?? [];
        $this->viewData['controllerScripts'][] = 'customer';
    }
}
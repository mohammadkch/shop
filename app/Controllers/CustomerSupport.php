<?php

namespace App\Controllers;

class CustomerSupport extends BaseController
{
    public function __construct()
    {
        helper(['menu']);
    }

    public function index()
    {
        $this->viewData['title'] = 'پشتیبانی مشتریان | مومو';

        return view('customer_support/index', $this->viewData);
    }
}

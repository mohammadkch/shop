<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        helper(['menu']);
        return view('home/index', $this->viewData);
    }
}

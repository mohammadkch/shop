<?php

namespace App\Controllers\Admin;

class Test extends BaseController
{
    public function index()
    {
        return view($this->viewPath.'test', $this->viewData);
    }
}
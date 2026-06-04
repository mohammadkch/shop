<?php

namespace App\Controllers\Admin;

class Dashboard extends BaseController
{
    public function index(): string
    {
//        $this->print_mine($this->viewData);
        return view($this->viewPath.'dashboard/index', $this->viewData);
    }
}

<?php

namespace App\Controllers\Admin;

class Logout extends BaseController
{
    public function index()
    {
        $this->authLib->logout();
        $this->flash('logout_success');
        return redirect()->to('admin/login');
    }
}
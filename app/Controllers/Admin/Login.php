<?php

namespace App\Controllers\Admin;

class Login extends BaseController
{
    public function index()
    {
        if ($this->authLib->isLoggedIn()) {
            return redirect()->to('/admin/dashboard');
        }

        $msg = (int)$this->request->getVar("msg", FILTER_VALIDATE_INT);
        $msg_text = [
            '1' => 'نام کاربری یا گذرواژه نادرست است.',
            '2' => 'هنگام ورود خطایی رخ داده است.',
            '3' => 'حساب کاربری شما غیرفعال است.',
        ];

        $this->viewData['msg_text'] = isset($msg_text[$msg]) ? $msg_text[$msg] : null;

        return view($this->viewPath . 'login/index', $this->viewData);
    }

    public function authenticate()
    {
        helper('sanitize');

        $rules = [
            'username' => [
                'label' => 'نام کاربری',
                'rules' => 'required|min_length[3]|max_length[50]'
            ],
            'password' => [
                'label' => 'رمز عبور',
                'rules' => 'required|min_length[3]'
            ]
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            $errors = $validation->getErrors();
            $this->flash('validation_error');
            return redirect()->to('/admin/login?msg=1');
        }

        $userModel = model('App\Models\Admin\UserModel');

        $username = $this->request->getPost('username', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $password = $this->request->getPost('password', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);

        $user = $userModel->where('username', $username)
            ->where('password', $password)
            ->where('is_active', 1)
            ->first();

        if ($user === null) {
            $this->flash('user_not_found');
            return redirect()->to('/admin/login?msg=1');
        }

        $user_id = (int)$user['id'];

        if ($user_id < 1) {
            $this->flash('user_not_found');
            return redirect()->to('/admin/login?msg=1');
        }

        $userModel->updateLastLogin($user_id);

        $login_result = $this->authLib->login($user_id, [
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'avatar' => $user['avatar']
        ]);

        if ($login_result) {
            $this->flash('login_success');
            return redirect()->to('/admin/dashboard');
        }

        $this->flash('login_success');
        return redirect()->to('/admin/login?msg=2');
    }

    public function logout()
    {
        service('adminAuth')->logout();
        session()->setFlashdata('success', 'با موفقیت وارد شدید');
        return redirect()->to('/admin/login');
    }
}
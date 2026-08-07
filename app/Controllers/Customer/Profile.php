<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class Profile extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        helper(['menu']);
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {

        $customerId = $this->auth->getCustomerId();
        $customer = $this->customerModel->find($customerId);

        if (!$customer) {
            $this->flash('customer_not_found');
            return redirect()->to('/logout');
        }

        $hasPassword = !empty($customer['password']);

        $this->viewData['customer'] = $customer;
        $this->viewData['isProfileComplete'] = $this->auth->hasMinimunProfile();
        $this->viewData['hasPassword'] = $hasPassword;
        $this->viewData['title'] = 'اطلاعات کاربری';

        return view('customer/profile/index', $this->viewData);
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $customerId = $this->auth->getCustomerId();
        if (!$customerId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'لطفاً وارد شوید']);
        }

        $firstname = trim($this->request->getPost('firstname'));
        $lastname = trim($this->request->getPost('lastname'));
        $gender = $this->request->getPost('gender');
        $nationalCode = trim($this->request->getPost('national_code'));
        $birthdate = trim($this->request->getPost('birthdate'));

        // اعتبارسنجی
        $errors = [];
        if (empty($firstname)) {
            $errors['firstname'] = 'نام خود را وارد کنید';
        }
        if (empty($lastname)) {
            $errors['lastname'] = 'نام خانوادگی خود را وارد کنید';
        }
        if (empty($gender) || !in_array($gender, ['1', '2'])) {
            $errors['gender'] = 'جنسیت خود را انتخاب کنید';
        }

        if (!empty($errors)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'لطفاً اطلاعات را کامل کنید',
                'errors' => $errors
            ]);
        }

        // ذخیره اطلاعات
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'gender' => $gender,
            'updated_at' => time()
        ];

        if ($nationalCode) $data['national_code'] = $nationalCode;
        if ($birthdate) $data['birthdate'] = $birthdate;

        // ====== پردازش آواتار ======
        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile && $avatarFile->isValid() && !$avatarFile->hasMoved()) {
            // بررسی حجم (300KB)
            if ($avatarFile->getSize() > 300 * 1024) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'حجم فایل نباید بیشتر از ۳۰۰ کیلوبایت باشد'
                ]);
            }

            // بررسی پسوند
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (!in_array($avatarFile->getMimeType(), $allowedTypes)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'فایل تصویر معتبر نیست (jpg, png, webp, gif)'
                ]);
            }

            // ====== بررسی ابعاد (500x500) ======
            $imageInfo = getimagesize($avatarFile->getTempName());
            if ($imageInfo !== false) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];

                if ($width > 500 || $height > 500) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'ابعاد تصویر نباید بیشتر از ۵۰۰×۵۰۰ پیکسل باشد'
                    ]);
                }
            }

            // حذف آواتار قبلی
            $oldCustomer = $this->customerModel->find($customerId);
            if ($oldCustomer && !empty($oldCustomer['avatar'])) {
                $oldPath = FCPATH . 'images/avatar/' . $oldCustomer['avatar'];
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // ذخیره فایل جدید
            $newName = 'customer_' . $customerId . '_' . time() . '.' . $avatarFile->getExtension();
            $avatarFile->move(FCPATH . 'images/avatar', $newName);
            $data['avatar'] = $newName;
        }

        $this->customerModel->update($customerId, $data);

        $this->auth->setData('firstname', $firstname);
        $this->auth->setData('lastname', $lastname);
        $this->auth->setData('gender', $gender);
        if (isset($data['avatar'])) {
            $this->auth->setData('avatar', $data['avatar']);
        }

        $redirectUrl = session()->get('redirect_login_url');
        if ($redirectUrl) {
            session()->remove('redirect_login_url');
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'اطلاعات با موفقیت بروزرسانی شد',
            'avatar' => $data['avatar'] ?? null,
            'redirect_url' => $redirectUrl ?? null
        ]);
    }

    public function removeAvatar()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'درخواست نامعتبر',
            ]);
        }

        $customerId = (int) $this->auth->getCustomerId();
        $customer = $this->customerModel->find($customerId);

        if (!$customer) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'کاربر یافت نشد',
            ]);
        }

        if (empty($customer['avatar'])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'آواتاری برای حذف وجود ندارد',
            ]);
        }

        $avatarPath = FCPATH . 'images/avatar/' . basename((string) $customer['avatar']);
        if (!$this->customerModel->update($customerId, ['avatar' => null])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'حذف آواتار ذخیره نشد',
            ]);
        }

        $this->auth->setData('avatar', null);

        if (is_file($avatarPath) && !unlink($avatarPath)) {
            log_message('warning', 'Avatar file could not be removed for customer ID {customerId}.', [
                'customerId' => $customerId,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'آواتار با موفقیت حذف شد',
        ]);
    }

    public function changePassword()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $customerId = $this->auth->getCustomerId();
        if (!$customerId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'لطفاً وارد شوید']);
        }

        $customer = $this->customerModel->find($customerId);
        if (!$customer) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'کاربر یافت نشد']);
        }

        // چک کردن کامل بودن پروفایل

        if (!$this->auth->hasMinimumProfile()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'لطفاً ابتدا اطلاعات پروفایل خود را تکمیل کنید'
            ]);
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // اعتبارسنجی
        if (empty($newPassword) || mb_strlen($newPassword) < 8) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'رمز عبور جدید باید حداقل ۸ کاراکتر باشد'
            ]);
        }

        if ($newPassword !== $confirmPassword) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'رمز عبور جدید و تکرار آن مطابقت ندارند'
            ]);
        }

        $hasPassword = !empty($customer['password']);

        // اگر کاربر قبلاً پسورد داشته، چک کن رمز فعلی درست است
        if ($hasPassword) {
            if (empty($currentPassword)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'رمز عبور فعلی را وارد کنید'
                ]);
            }

            if ($customer['password'] !== $currentPassword) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'رمز عبور فعلی اشتباه است'
                ]);
            }
        }

        // ذخیره پسورد جدید
        $this->customerModel->update($customerId, [
            'password' => $newPassword,
            'updated_at' => time()
        ]);

        service('customerAuth')->logout();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'رمز عبور با موفقیت تغییر یافت',
            'logout' => true
        ]);
    }
}

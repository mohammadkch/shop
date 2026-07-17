<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Services\OtpService;

class Login extends BaseController
{
    protected $customerModel;
    protected $otpService;
    protected $auth;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->otpService = service('otpService');
        $this->auth = service('customerAuth');
    }

    /**
     * نمایش صفحه لاگین
     */
    public function index()
    {
        // اگه کاربر لاگین کرده، بره پیشخوان
        if (session()->get('customer_id')) {
            return redirect()->to('/customer/dashboard');
        }

        $this->viewData['title'] = 'ورود / ثبت نام';
        return view('auth/login', $this->viewData);
    }

    public function checkMobile()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $mobile = $this->request->getPost('mobile');
        $isResend = $this->request->getPost('resend') === '1';

        if (!$mobile || !preg_match('/^09[0-9]{9}$/', $mobile)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'شماره موبایل نامعتبر است']);
        }

        $customer = $this->customerModel->findByMobile($mobile);
        $hasPassword = ($customer !== null && !empty($customer['password']));
        $forceOtp = $this->request->getPost('force_otp') === '1';

        // ====== اگر درخواست ارسال مجدد است ======
        if ($isResend) {
            $otpResult = $this->otpService->resend($mobile);

            if (!$otpResult) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'خطا در ارسال کد']);
            }

            // اگر کد قبلی هنوز معتبر است
            if (isset($otpResult['is_new_code']) && $otpResult['is_new_code'] === false) {
                return $this->response->setJSON([
                    'status' => 'info',
                    'message' => $otpResult['message'],
                    'is_new_code' => false,
                    'expires_at' => $otpResult['expires_at']
                ]);
            }

            // اگر کد جدید ساخته شده
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'کد جدید ارسال شد',
                'is_new_code' => true,
                'expires_at' => $otpResult['expires_at']
            ]);
        }

        // ====== درخواست معمولی (غیر ارسال مجدد) ======
        if (!$hasPassword || $forceOtp) {
            // اول چک کن کد قبلی معتبر هست یا نه
            $existingOtp = $this->otpService->getValidOtp($mobile);

            if ($existingOtp && $existingOtp['expires_at'] > time()) {
                // کد قبلی هنوز معتبر است → همان را برگردان
                $otpResult = [
                    'otp_id' => $existingOtp['id'],
                    'otp_code' => $existingOtp['otp_code'],
                    'expires_at' => $existingOtp['expires_at'],
                    'is_new_code' => false
                ];
            } else {
                // کد قبلی منقضی شده یا وجود ندارد → کد جدید بساز
                $otpResult = $this->otpService->store($mobile);
                if (!$otpResult) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'خطا در ارسال کد تایید']);
                }
                $otpResult['is_new_code'] = true;
            }
        } else {
            $otpResult = null;
        }

        session()->set([
            'otp_mobile' => $mobile,
            'otp_expires' => $otpResult ? $otpResult['expires_at'] : null,
            'has_password' => $hasPassword
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => $hasPassword ? 'لطفاً روش ورود را انتخاب کنید' : 'کد تایید ارسال شد',
            'has_password' => $hasPassword,
            'expires_at' => $otpResult ? $otpResult['expires_at'] : null,
            'is_new_code' => $otpResult ? $otpResult['is_new_code'] : null,
        ]);
    }

    public function verifyOtp()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $otpCode = $this->request->getPost('otp_code');
        $mobile = session()->get('otp_mobile');

        if (!$mobile || !$otpCode) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'اطلاعات ناقص']);
        }

        $validOtp = $this->otpService->verify($mobile, $otpCode);

        if (!$validOtp) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'کد تایید نامعتبر یا منقضی شده است']);
        }

        $customer = $this->customerModel->findByMobile($mobile);

        if ($customer) {
            $this->auth->login($customer['id'], [
                'firstname' => $customer['firstname'],
                'lastname' => $customer['lastname'],
                'mobile' => $customer['mobile'],
                'email' => $customer['email'] ?? '',
                'avatar' => $customer['avatar'] ?? '',
                'national_code' => $customer['national_code'] ?? '',
                'is_active' => $customer['is_active'] ?? 1,
                'has_password' => !empty($customer['password'])
            ]);

            $this->customerModel->updateLastLogin($customer['id']);
        } else {
            $customerId = $this->customerModel->insert([
                'mobile' => $mobile,
                'firstname' => '',
                'lastname' => '',
                'is_active' => 1,
                'created_at' => time(),
                'updated_at' => time()
            ]);

            $this->auth->login($customerId, [
                'firstname' => '',
                'lastname' => '',
                'mobile' => $mobile,
                'has_password' => false
            ]);
        }

        session()->remove(['otp_mobile', 'otp_expires', 'has_password']);

        $isComplete = (
            !empty($customer['firstname']) &&
            !empty($customer['lastname']) &&
            !empty($customer['gender'])
        );
        $redirectUrl = $isComplete ? $this->getRedirectUrl() : site_url('customer/profile');

        $this->flash('login_success');

        return $this->response->setJSON([
            'status' => 'success',
            'is_new_user' => ($customer === null),
            'redirect' => $redirectUrl
        ]);
    }

    public function loginWithPassword()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $mobile = session()->get('otp_mobile');
        $password = $this->request->getPost('password');

        if (!$mobile || !$password) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'اطلاعات ناقص']);
        }

        $customer = $this->customerModel->findByMobile($mobile);

        if (!$customer) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'کاربر یافت نشد']);
        }

        // ====== مقایسه مستقیم ======
        if ($customer['password'] !== $password) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'رمز عبور اشتباه است']);
        }

        // لاگین
        $this->auth->login($customer['id'], [
            'firstname' => $customer['firstname'],
            'lastname' => $customer['lastname'],
            'mobile' => $customer['mobile'],
            'email' => $customer['email'] ?? '',
            'avatar' => $customer['avatar'] ?? '',
            'national_code' => $customer['national_code'] ?? '',
            'is_active' => $customer['is_active'] ?? 1,
            'has_password' => true
        ]);

        $this->customerModel->updateLastLogin($customer['id']);
        session()->remove(['otp_mobile', 'otp_expires', 'has_password']);

        $isComplete = (
            !empty($customer['firstname']) &&
            !empty($customer['lastname']) &&
            !empty($customer['gender'])
        );
        $redirectUrl = $isComplete ? $this->getRedirectUrl() : site_url('customer/profile');

        $this->flash('login_success');

        return $this->response->setJSON([
            'status' => 'success',
            'redirect' => $redirectUrl
        ]);
    }

    public function completeProfile()
    {
        // چک کن که آیا کاربر از مرحله OTP عبور کرده
        $mobile = session()->get('otp_mobile');
        if (!$mobile) {
            return redirect()->to('/login');
        }

        // اگه قبلاً لاگین کرده، بره داشبورد
        if (session()->get('customer_id')) {
            return redirect()->to('/customer/dashboard');
        }

        $this->viewData['mobile'] = $mobile;
        $this->viewData['title'] = 'تکمیل اطلاعات';

        return view('auth/complete_profile', $this->viewData);
    }

    /**
     * ذخیره اطلاعات کاربر جدید
     */
    public function saveProfile()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'درخواست نامعتبر']);
        }

        $mobile = session()->get('otp_mobile');
        if (!$mobile) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'جلسه نامعتبر']);
        }

        $firstname = trim($this->request->getPost('firstname'));
        $lastname = trim($this->request->getPost('lastname'));
        $password = $this->request->getPost('password');
        $email = trim($this->request->getPost('email'));
        $nationalCode = trim($this->request->getPost('national_code'));

        // اعتبارسنجی
        if (empty($firstname) || empty($lastname)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'نام و نام خانوادگی الزامی است']);
        }

        if (empty($password) || mb_strlen($password) < 8) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'رمز عبور باید حداقل ۸ کاراکتر باشد']);
        }

        // پیدا کردن کاربر موجود
        $customer = $this->customerModel->findByMobile($mobile);

        if ($customer) {
            // بروزرسانی کاربر موجود
            $data = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'password' => $password, // ذخیره مستقیم (همونطور که گفتی)
                'updated_at' => time()
            ];

            if ($email) $data['email'] = $email;
            if ($nationalCode) $data['national_code'] = $nationalCode;

            $this->customerModel->update($customer['id'], $data);
            $customerId = $customer['id'];
        } else {
            // ایجاد کاربر جدید (امنیت)
            $data = [
                'mobile' => $mobile,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'password' => $password,
                'is_active' => 1,
                'created_at' => time(),
                'updated_at' => time()
            ];

            if ($email) $data['email'] = $email;
            if ($nationalCode) $data['national_code'] = $nationalCode;

            $customerId = $this->customerModel->insert($data);
        }

        if (!$customerId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'خطا در ثبت نام']);
        }

        // لاگین کردن کاربر
        session()->set('customer_id', $customerId);
        $this->customerModel->updateLastLogin($customerId);

        // پاک کردن سشن موقت
        session()->remove(['otp_mobile', 'otp_expires', 'has_password']);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'ثبت نام با موفقیت انجام شد',
            'redirect' => $this->getRedirectUrl()
        ]);
    }

    /**
     * خروج از حساب کاربری
     */
    public function logout()
    {
        session()->remove('customer_id');
        session()->destroy();

        return redirect()->to('/');
    }

    protected function getRedirectUrl()
    {
        $returnUrl = session()->get('return_url');
        if ($returnUrl) {
            session()->remove('return_url');
            return $returnUrl;
        }

        return site_url('customer/dashboard');
    }

    public function setReturnUrl()
    {
        $url = $this->request->getGet('return') ?? $this->request->getServer('HTTP_REFERER');
        if ($url) {
            session()->set('return_url', $url);
        }
        return redirect()->to('/login');
    }
}
<?php

namespace App\Libraries;

use App\Models\CustomerModel;

class CustomerAuthLib
{
    protected $session;
    protected $customerModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->customerModel = new CustomerModel();
    }

    /**
     * لاگین کردن کاربر
     */
    public function login($customerId, $data = [])
    {
        $this->session->set('customer_id', $customerId);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->session->set('customer_' . $key, $value);
            }
        }

        return true;
    }

    /**
     * خروج از حساب
     */
    public function logout()
    {
        $this->session->remove('customer_id');

        // حذف همه کلیدهای customer_*
        foreach ($_SESSION as $key => $value) {
            if (strpos($key, 'customer_') === 0) {
                $this->session->remove($key);
            }
        }

        return true;
    }

    /**
     * چک کردن لاگین بودن
     */
    public function isLoggedIn()
    {
        return $this->session->get('customer_id') !== null;
    }

    /**
     * گرفتن ID کاربر
     */
    public function getCustomerId()
    {
        return $this->session->get('customer_id');
    }

    /**
     * گرفتن اطلاعات کامل کاربر از دیتابیس
     */
    public function getCustomer()
    {
        $customerId = $this->getCustomerId();
        if (!$customerId) {
            return null;
        }

        return [
            'id' => $customerId,
            'firstname' => $this->getData('firstname'),
            'lastname' => $this->getData('lastname'),
            'mobile' => $this->getData('mobile'),
            'email' => $this->getData('email'),
            'avatar' => $this->getData('avatar'),
            'national_code' => $this->getData('national_code'),
            'is_active' => $this->getData('is_active') ?? 1,
        ];
    }

    /**
     * گرفتن نام کامل کاربر
     */
    public function getName()
    {
        $customer = $this->getCustomer();
        if (!$customer) {
            return '';
        }

        return trim($customer['firstname'] . ' ' . $customer['lastname']);
    }

    /**
     * گرفتن یک مقدار خاص از سشن
     */
    public function getData($key)
    {
        return $this->session->get('customer_' . $key);
    }

    /**
     * ذخیره یک مقدار در سشن
     */
    public function setData($key, $value)
    {
        $this->session->set('customer_' . $key, $value);
        return true;
    }
}
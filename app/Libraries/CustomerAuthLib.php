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

    public function login($customerId, $data = [])
    {
        $this->session->set('customer_id', $customerId);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->session->set('customer_' . $key, $value);
            }
        }

        // مالکیت/ادغام سبد همان لحظه ورود قطعی شود؛ منتظر لود صفحه بعد نمی‌مانیم.
        service('cartService')->getCart();

        return true;
    }

    public function logout()
    {
        $this->session->remove('customer_id');
        // بعد از خروج، مرورگر باید یک سبد مهمان کاملاً مستقل بگیرد.
        $this->session->remove('session_id');

        // حذف همه کلیدهای customer_*
        foreach ($_SESSION as $key => $value) {
            if (strpos($key, 'customer_') === 0) {
                $this->session->remove($key);
            }
        }

        return true;
    }

    public function isLoggedIn()
    {
        return $this->session->get('customer_id') !== null;
    }

    public function hasMinimunProfile()
    {
        $customer = $this->getCustomer();
        return ( !empty($customer['firstname']) && !empty($customer['lastname']) && !empty($customer['gender']) );
    }

    public function getCustomerId()
    {
        return $this->session->get('customer_id');
    }

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
            'gender' => $this->getData('gender'),
            'mobile' => $this->getData('mobile'),
            'email' => $this->getData('email'),
            'avatar' => $this->getData('avatar'),
            'national_code' => $this->getData('national_code'),
            'is_active' => $this->getData('is_active') ?? 1,
        ];
    }

    public function getName()
    {
        $customer = $this->getCustomer();
        if (!$customer) {
            return '';
        }

        return trim($customer['firstname'] . ' ' . $customer['lastname']);
    }

    public function getData($key)
    {
        return $this->session->get('customer_' . $key);
    }

    public function setData($key, $value)
    {
        $this->session->set('customer_' . $key, $value);
        return true;
    }
}

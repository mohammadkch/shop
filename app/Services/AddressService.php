<?php

namespace App\Services;

use App\Models\CustomerAddressModel;
use App\Models\CityModel;

class AddressService
{
    protected $addressModel;
    protected $cityModel;

    public function __construct()
    {
        $this->addressModel = new CustomerAddressModel();
        $this->cityModel = new CityModel();
    }

    /**
     * دریافت آدرس‌های یک مشتری
     */
    public function getCustomerAddresses($customerId)
    {
        if (!$customerId) {
            return [];
        }

        $addresses = $this->addressModel->getData([
            'customer_id' => $customerId
        ]);

        return $addresses;
    }

    /**
     * دریافت یک آدرس به همراه جزئیات کامل
     */
    public function getAddressDetails($addressId)
    {
        if (!$addressId) {
            return null;
        }

        $address = $this->addressModel->getAddressWithDetails($addressId);

        return $address;
    }

    /**
     * افزودن آدرس جدید
     */
    public function addAddress($customerId, $data)
    {
        if (!$customerId) {
            return ['status' => 'error', 'message' => 'کاربر یافت نشد'];
        }

        // اعتبارسنجی اولیه
        if (empty($data['city_id'])) {
            return ['status' => 'error', 'message' => 'لطفاً شهر را انتخاب کنید'];
        }

        if (empty($data['recipient_name'])) {
            return ['status' => 'error', 'message' => 'لطفاً نام گیرنده را وارد کنید'];
        }

        if (empty($data['recipient_mobile']) || !preg_match('/^09[0-9]{9}$/', $data['recipient_mobile'])) {
            return ['status' => 'error', 'message' => 'شماره موبایل گیرنده معتبر نیست'];
        }

        if (empty($data['address'])) {
            return ['status' => 'error', 'message' => 'لطفاً آدرس کامل را وارد کنید'];
        }

        if (empty($data['postal_code']) || !preg_match('/^[0-9]{10}$/', $data['postal_code'])) {
            return ['status' => 'error', 'message' => 'کد پستی معتبر نیست (۱۰ رقم)'];
        }

        // بررسی وجود شهر
        $city = $this->cityModel->find($data['city_id']);
        if (!$city) {
            return ['status' => 'error', 'message' => 'شهر انتخاب شده معتبر نیست'];
        }

        // ذخیره آدرس
        $insertData = [
            'customer_id' => $customerId,
            'city_id' => $data['city_id'],
            'title' => $data['title'] ?? 'خانه',
            'recipient_name' => $data['recipient_name'],
            'recipient_mobile' => $data['recipient_mobile'],
            'address' => $data['address'],
            'postal_code' => $data['postal_code']
        ];

        $this->addressModel->insert($insertData);
        $addressId = $this->addressModel->getInsertID();

        // دریافت آدرس ایجاد شده با جزئیات کامل
        $address = $this->getAddressDetails($addressId);

        return [
            'status' => 'success',
            'message' => 'آدرس با موفقیت افزوده شد',
            'address' => $address
        ];
    }

    /**
     * حذف آدرس
     */
    public function deleteAddress($addressId, $customerId)
    {
        if (!$addressId || !$customerId) {
            return ['status' => 'error', 'message' => 'اطلاعات ناقص'];
        }

        // بررسی تعلق آدرس به کاربر
        $address = $this->addressModel->where('id', $addressId)
            ->where('customer_id', $customerId)
            ->first();

        if (!$address) {
            return ['status' => 'error', 'message' => 'آدرس یافت نشد'];
        }

        $this->addressModel->delete($addressId);

        return [
            'status' => 'success',
            'message' => 'آدرس با موفقیت حذف شد'
        ];
    }

    /**
     * دریافت استان‌ها با شهرهایشان
     */
    public function getStatesWithCities()
    {
        $stateModel = model('App\Models\StateModel');
        $states = $stateModel->orderBy('sort_order', 'ASC')->findAll();

        foreach ($states as &$state) {
            $cities = $this->cityModel->where('state_id', $state['id'])
                ->orderBy('sort_order', 'ASC')
                ->findAll();
            $state['cities'] = $cities;
        }

        return $states;
    }

    /**
     * دریافت شهرهای یک استان
     */
    public function getCitiesByState($stateId)
    {
        if (!$stateId) {
            return [];
        }

        $cityModel = model('App\Models\CityModel');
        return $cityModel->where('state_id', $stateId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }
}
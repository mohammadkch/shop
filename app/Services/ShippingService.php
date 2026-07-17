<?php

namespace App\Services;

use App\Models\ShippingTypeModel;
use App\Models\ShippingPriceModel;
use App\Models\CityModel;

class ShippingService
{
    protected $shippingTypeModel;
    protected $shippingPriceModel;
    protected $cityModel;

    public function __construct()
    {
        $this->shippingTypeModel = new ShippingTypeModel();
        $this->shippingPriceModel = new ShippingPriceModel();
        $this->cityModel = new CityModel();
    }

    /**
     * دریافت همه روش‌های ارسال فعال
     */
    public function getShippingTypes()
    {
        return $this->shippingTypeModel->orderBy('sort_order', 'ASC')->findAll();
    }

    /**
     * دریافت قیمت ارسال بر اساس شهر و نوع ارسال
     */
    public function getShippingPrice($cityId, $shippingTypeId)
    {
        if (!$cityId || !$shippingTypeId) {
            return null;
        }

        $price = $this->shippingPriceModel->where('city_id', $cityId)
            ->where('shipping_type_id', $shippingTypeId)
            ->first();

        return $price;
    }

    /**
     * دریافت همه قیمت‌های ارسال یک شهر
     */
    public function getShippingPricesByCity($cityId)
    {
        if (!$cityId) {
            return [];
        }

        $prices = $this->shippingPriceModel->getData([
            'city_id' => $cityId
        ]);

        return $prices;
    }

    /**
     * دریافت قیمت‌های ارسال با فرمت مناسب برای نمایش در ویو
     * کلید: shipping_type_id => قیمت
     */
    public function getShippingPricesFormatted($cityId)
    {
        if (!$cityId) {
            return [];
        }

        $prices = $this->getShippingPricesByCity($cityId);
        $result = [];

        foreach ($prices as $price) {
            $result[$price['shipping_type_id']] = [
                'price' => $price['price'],
                'shipping_type_name' => $price['shipping_type_name']
            ];
        }

        return $result;
    }

    /**
     * دریافت اطلاعات کامل یک روش ارسال با قیمت برای شهر مشخص
     */
    public function getShippingTypeWithPrice($shippingTypeId, $cityId)
    {
        $type = $this->shippingTypeModel->find($shippingTypeId);
        if (!$type) {
            return null;
        }

        $price = $this->getShippingPrice($cityId, $shippingTypeId);

        return [
            'id' => $type['id'],
            'name' => $type['name'],
            'price' => $price ? $price['price'] : null,
            'has_price' => $price ? true : false
        ];
    }

    /**
     * بررسی وجود قیمت ارسال برای یک شهر
     */
    public function hasShippingPrice($cityId)
    {
        if (!$cityId) {
            return false;
        }

        $count = $this->shippingPriceModel->where('city_id', $cityId)->countAllResults();
        return $count > 0;
    }

    /**
     * دریافت حداقل قیمت ارسال برای یک شهر
     */
    public function getMinShippingPrice($cityId)
    {
        if (!$cityId) {
            return 0;
        }

        $price = $this->shippingPriceModel->select('MIN(price) as min_price')
            ->where('city_id', $cityId)
            ->first();

        return $price ? (float) $price['min_price'] : 0;
    }
}
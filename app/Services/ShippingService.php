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
    public function getShippingPrice($cityId, $shippingTypeId, int $totalWeight)
    {
        if (!$cityId || !$shippingTypeId || $totalWeight < 1 || $totalWeight > 4000) {
            return null;
        }

        $price = $this->shippingPriceModel->where('city_id', $cityId)
            ->where('shipping_type_id', $shippingTypeId)
            ->first();

        return $this->attachPriceForWeight($price, $totalWeight);
    }

    /**
     * دریافت همه قیمت‌های ارسال یک شهر
     */
    public function getShippingPricesByCity($cityId, int $totalWeight)
    {
        if (!$cityId || $totalWeight < 1 || $totalWeight > 4000) {
            return [];
        }

        $prices = $this->shippingPriceModel->getData([
            'city_id' => $cityId
        ]);

        return array_map(fn (array $price) => $this->attachPriceForWeight($price, $totalWeight), $prices);
    }

    /**
     * دریافت قیمت‌های ارسال با فرمت مناسب برای نمایش در ویو
     * کلید: shipping_type_id => قیمت
     */
    public function getShippingPricesFormatted($cityId, int $totalWeight)
    {
        if (!$cityId) {
            return [];
        }

        $prices = $this->getShippingPricesByCity($cityId, $totalWeight);
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
    public function getShippingTypeWithPrice($shippingTypeId, $cityId, int $totalWeight)
    {
        $type = $this->shippingTypeModel->find($shippingTypeId);
        if (!$type) {
            return null;
        }

        $price = $this->getShippingPrice($cityId, $shippingTypeId, $totalWeight);

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

        $price = $this->shippingPriceModel->select('MIN(price_one_kilogram) as min_price')
            ->where('city_id', $cityId)
            ->first();

        return $price ? (float) $price['min_price'] : 0;
    }

    private function attachPriceForWeight(?array $price, int $totalWeight): ?array
    {
        if (!$price) {
            return null;
        }

        $field = [
            1 => 'price_one_kilogram',
            2 => 'price_two_kilogram',
            3 => 'price_three_kilogram',
            4 => 'price_four_kilogram',
        ][(int) ceil($totalWeight / 1000)] ?? null;

        if (!$field || $price[$field] === null) {
            return null;
        }

        $price['price'] = $price[$field];
        return $price;
    }
}

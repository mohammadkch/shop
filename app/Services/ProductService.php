<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\ProductMenuModel;
use App\Models\Menu3Model;
use App\Models\ProductPriceModel;

class ProductService
{
    protected $productModel;
    protected $productImageModel;
    protected $productMenuModel;
    protected $menu3Model;
    protected $productPriceModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->productImageModel = new ProductImageModel();
        $this->productMenuModel = new ProductMenuModel();
        $this->menu3Model = new Menu3Model();
        $this->productPriceModel = new ProductPriceModel();
    }

    public function getProductBySlug($slug)
    {
        $product = $this->productModel
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        if (!$product) {
            return null;
        }

        $productMenu = $this->productMenuModel
            ->where('product_id', $product['id'])
            ->first();

        if ($productMenu) {
            $menu3 = $this->menu3Model
                ->select('menu_3.*, menu_2.name as menu_2_name, menu_2.slug as menu_2_slug, menu_1.name as menu_1_name, menu_1.slug as menu_1_slug')
                ->join('menu_2', 'menu_2.id = menu_3.menu_2_id')
                ->join('menu_1', 'menu_1.id = menu_2.menu_1_id')
                ->where('menu_3.id', $productMenu['menu_3_id'])
                ->first();

            $product['category'] = $menu3;
        }

        return $product;
    }

    public function getProductImages($productId)
    {
        $images = $this->productImageModel
            ->where('product_id', $productId)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        $result = [
            'main' => null,
            'gallery' => []
        ];

        if (empty($images)) {
            return $result;
        }

        $type1 = [];
        $type2 = [];

        foreach ($images as $image) {
            if ($image['product_image_type_id'] == 1) {
                $type1[] = $image;
            } else {
                $type2[] = $image;
            }
        }

        if (!empty($type2)) {
            $result['main'] = $type2[0];
            for ($i = 1; $i < count($type2); $i++) {
                $result['gallery'][] = $type2[$i];
            }
        } else if (!empty($type1)) {
            $result['main'] = $type1[0];
            for ($i = 1; $i < count($type1); $i++) {
                $result['gallery'][] = $type1[$i];
            }
        }

        if (empty($result['main']) && !empty($images)) {
            $result['main'] = $images[0];
            for ($i = 1; $i < count($images); $i++) {
                $result['gallery'][] = $images[$i];
            }
        }

        return $result;
    }

    public function getProductOptions($productId)
    {
        // ۱. دریافت همه آپشن‌های محصول از product_option
        $productOptionModel = model('App\Models\ProductOptionModel');
        $productOptions = $productOptionModel
            ->where('product_id', $productId)
            ->findAll();

        // ۲. دریافت همه رکوردهای قیمت برای این محصول
        $priceRecords = $this->productPriceModel
            ->where('product_id', $productId)
            ->findAll();

        // ۳. استخراج option_id ها از product_option
        $optionIdsFromPO = array_column($productOptions, 'option_id');

        // ۴. استخراج option_id های color و size از priceRecords (که توی product_option نیستن)
        $colorIdsFromPrice = [];
        $sizeIdsFromPrice = [];
        foreach ($priceRecords as $record) {
            if ($record['color_option_id'] && !in_array($record['color_option_id'], $optionIdsFromPO)) {
                $colorIdsFromPrice[] = $record['color_option_id'];
            }
            if ($record['size_option_id'] && !in_array($record['size_option_id'], $optionIdsFromPO)) {
                $sizeIdsFromPrice[] = $record['size_option_id'];
            }
        }

        // ۵. ترکیب همه option_id ها
        $allOptionIds = array_merge($optionIdsFromPO, $colorIdsFromPrice, $sizeIdsFromPrice);
        $allOptionIds = array_unique($allOptionIds);

        // ۶. دریافت اطلاعات کامل option ها با label
        $optionModel = model('App\Models\OptionModel');
        $options = $optionModel
            ->select('option.*, label.type as label_type, label.name as label_name')
            ->join('label', 'label.id = option.label_id')
            ->whereIn('option.id', $allOptionIds)
            ->where('option.is_active', 1)
            ->orderBy('label.sort_order', 'ASC')
            ->orderBy('option.sort_order', 'ASC')
            ->findAll();

        // ====== تعریف $result ======
        $result = [
            'color' => [],
            'size' => [],
            'features' => [],
            'color_size_map' => [],
            'has_color' => false,
            'has_size' => false
        ];

        // ۷. پیدا کردن رکورد پیش‌فرض (is_default = 1)
        $defaultRecord = null;
        foreach ($priceRecords as $record) {
            if ($record['is_default'] == 1) {
                $defaultRecord = $record;
                break;
            }
        }

        // ۸. دسته‌بندی آپشن‌ها بر اساس نوع
        foreach ($options as $option) {
            $labelType = $option['label_type'] ?? 'feature';

            // پیدا کردن رکورد قیمت برای این آپشن خاص
            $priceRecord = null;
            foreach ($priceRecords as $record) {
                if ($labelType == 'color' && $record['color_option_id'] == $option['id']) {
                    $priceRecord = $record;
                    break;
                }
                if ($labelType == 'size' && $record['size_option_id'] == $option['id']) {
                    $priceRecord = $record;
                    break;
                }
            }

            // اگه رکورد قیمت خاص وجود نداشت، از رکورد پیش‌فرض استفاده کن
            if (!$priceRecord && $defaultRecord) {
                $priceRecord = $defaultRecord;
            }

            // ====== محاسبه stock برای رنگ ======
            $totalStock = 0;
            if ($labelType == 'color') {
                foreach ($priceRecords as $record) {
                    if ($record['color_option_id'] == $option['id']) {
                        $totalStock += (int) $record['stock'];
                    }
                }
            } elseif ($labelType == 'size') {
                foreach ($priceRecords as $record) {
                    if ($record['size_option_id'] == $option['id']) {
                        $totalStock += (int) $record['stock'];
                    }
                }
            } else {
                $totalStock = $priceRecord ? (int) $priceRecord['stock'] : 0;
            }

            // آماده‌سازی داده آپشن
            $optionData = [
                'option_id' => $option['id'],
                'option_value' => $option['value'],
                'label_name' => $option['label_name'],
                'label_id' => $option['label_id'],
                'label_type' => $labelType,
                'color_code' => $option['color_code'] ?? null,
                'price' => $priceRecord ? (float) $priceRecord['price'] : 0,
                'sale_price' => $priceRecord ? (float) $priceRecord['sale_price'] : 0,
                'stock' => $totalStock,
                'has_specific_price' => ($priceRecord && $priceRecord['is_default'] == 0)
            ];

            // اضافه کردن به دسته مربوطه
            if ($labelType == 'color') {
                $result['color'][] = $optionData;
                $result['has_color'] = true;
            } elseif ($labelType == 'size') {
                $result['size'][] = $optionData;
                $result['has_size'] = true;
            } else {
                $result['features'][] = $optionData;
            }
        }

        // ۹. ساختن color_size_map: برای هر رنگ، لیست سایزهای موجود (با stock > 0)
        $colorSizeMap = [];
        foreach ($priceRecords as $record) {
            if ($record['color_option_id'] && $record['size_option_id'] && $record['stock'] > 0) {
                $colorId = $record['color_option_id'];
                $sizeId = $record['size_option_id'];
                if (!isset($colorSizeMap[$colorId])) {
                    $colorSizeMap[$colorId] = [];
                }
                if (!in_array($sizeId, $colorSizeMap[$colorId])) {
                    $colorSizeMap[$colorId][] = $sizeId;
                }
            }
        }

        $result['color_size_map'] = $colorSizeMap;

        return $result;
    }

    public function getFinalPrice($product, $colorOptionId = null, $sizeOptionId = null)
    {
        // ۱. دریافت رکورد قیمت
        $priceRecord = $this->productPriceModel->getPriceForCombination(
            $product['id'],
            $colorOptionId,
            $sizeOptionId
        );

        if (!$priceRecord) {
            return [
                'original_price' => 0,
                'final_price' => 0,
                'discount_percent' => 0,
                'has_discount' => false,
                'sale_end_date' => null
            ];
        }

        $basePrice = (float) $priceRecord['price'];

        // ۲. بررسی تخفیف
        $now = time();
        $hasDiscount = false;
        $finalPrice = $basePrice;

        if (!empty($priceRecord['sale_price']) &&
            $priceRecord['sale_price'] > 0 &&
            !empty($priceRecord['sale_start_date']) &&
            !empty($priceRecord['sale_end_date']) &&
            $priceRecord['sale_start_date'] <= $now &&
            $priceRecord['sale_end_date'] >= $now) {

            $finalPrice = (float) $priceRecord['sale_price'];
            $hasDiscount = true;
        }

        return [
            'original_price' => $basePrice,
            'final_price' => $finalPrice,
            'discount_percent' => $hasDiscount ? $this->calculateDiscountPercent($basePrice, $finalPrice) : 0,
            'has_discount' => $hasDiscount,
            'sale_end_date' => $hasDiscount ? $priceRecord['sale_end_date'] : null
        ];
    }

    private function calculateDiscountPercent($originalPrice, $salePrice)
    {
        if ($originalPrice <= 0) {
            return 0;
        }
        return round((($originalPrice - $salePrice) / $originalPrice) * 100);
    }

    /**
     * دریافت موجودی کل یا موجودی یک ترکیب خاص
     */
    public function getStock($productId, $colorOptionId = null, $sizeOptionId = null)
    {
        if ($colorOptionId || $sizeOptionId) {
            // موجودی ترکیب خاص
            return $this->productPriceModel->getStockForCombination($productId, $colorOptionId, $sizeOptionId);
        }

        // موجودی کل: جمع همه رکوردها
        $records = $this->productPriceModel
            ->where('product_id', $productId)
            ->findAll();

        $total = 0;
        foreach ($records as $record) {
            $total += (int) $record['stock'];
        }

        return $total;
    }

    public function getRelatedProducts($productId, $menu3Id, $limit = 4)
    {
        $productMenuModel = new ProductMenuModel();
        $productIds = $productMenuModel
            ->where('menu_3_id', $menu3Id)
            ->where('product_id !=', $productId)
            ->findColumn('product_id');

        if (empty($productIds)) {
            return [];
        }

        $products = $this->productModel
            ->whereIn('id', $productIds)
            ->where('is_active', 1)
            ->limit($limit)
            ->findAll();

        foreach ($products as &$product) {
            $priceInfo = $this->getFinalPrice($product);
            $product['final_price'] = $priceInfo['final_price'];
            $product['original_price'] = $priceInfo['original_price'];
            $product['has_discount'] = $priceInfo['has_discount'];
            $product['discount_percent'] = $priceInfo['discount_percent'];
        }

        return $products;
    }

    public function getPriceRecord($productId, $colorOptionId, $sizeOptionId)
    {
        return $this->productPriceModel
            ->where('product_id', $productId)
            ->where('color_option_id', $colorOptionId)
            ->where('size_option_id', $sizeOptionId)
            ->first();
    }

    public function getDefaultPriceRecord($productId)
    {
        return $this->productPriceModel
            ->where('product_id', $productId)
            ->where('is_default', 1)
            ->first();
    }

    /**
     * پیدا کردن اولین ترکیب موجود (رنگ و سایز) از آرایه options
     * @param array $options خروجی متد getProductOptions
     * @return array ['color_id' => int|null, 'size_id' => int|null]
     */
    public function getFirstAvailableCombination(array $options): array
    {
        $selectedColorId = null;
        $selectedSizeId = null;

        if ($options['has_color'] && $options['has_size']) {
            $colorSizeMap = $options['color_size_map'] ?? [];

            foreach ($colorSizeMap as $colorId => $sizeIds) {
                if (!empty($sizeIds)) {
                    $selectedColorId = $colorId;
                    $selectedSizeId = $sizeIds[0];
                    break;
                }
            }

            if (!$selectedColorId) {
                // اول رنگ رو پیدا کن که stock > 0 داره
                foreach ($options['color'] as $color) {
                    if ($color['stock'] > 0) {
                        $selectedColorId = $color['option_id'];
                        break;
                    }
                }
                foreach ($options['size'] as $size) {
                    if ($size['stock'] > 0) {
                        $selectedSizeId = $size['option_id'];
                        break;
                    }
                }
                if (!$selectedColorId) {
                    $selectedColorId = $options['color'][0]['option_id'] ?? null;
                }
                if (!$selectedSizeId) {
                    $selectedSizeId = $options['size'][0]['option_id'] ?? null;
                }
            }
        } elseif ($options['has_color'] && !$options['has_size']) {
            foreach ($options['color'] as $color) {
                if ($color['stock'] > 0) {
                    $selectedColorId = $color['option_id'];
                    break;
                }
            }
            if (!$selectedColorId) {
                $selectedColorId = $options['color'][0]['option_id'] ?? null;
            }
        } elseif (!$options['has_color'] && $options['has_size']) {
            foreach ($options['size'] as $size) {
                if ($size['stock'] > 0) {
                    $selectedSizeId = $size['option_id'];
                    break;
                }
            }
            if (!$selectedSizeId) {
                $selectedSizeId = $options['size'][0]['option_id'] ?? null;
            }
        }

        return [
            'color_id' => $selectedColorId,
            'size_id'  => $selectedSizeId,
        ];
    }

    /**
     * آماده‌سازی تمام داده‌های مورد نیاز برای صفحه نمایش محصول
     * @param string $slug
     * @return array|null
     */
    public function prepareProductShowData(string $slug)
    {
        $product = $this->getProductBySlug($slug);
        if (!$product) {
            return null;
        }

        $images = $this->getProductImages($product['id']);
        $options = $this->getProductOptions($product['id']);

        // ۱. پیدا کردن اولین ترکیب موجود
        $selected = $this->getFirstAvailableCombination($options);
        $selectedColorId = $selected['color_id'];
        $selectedSizeId = $selected['size_id'];

        // ۲. قیمت برای ترکیب انتخاب‌شده
        $priceInfo = $this->getFinalPrice($product, $selectedColorId, $selectedSizeId);

        // ۳. موجودی کل
        $totalStock = $this->getStock($product['id']);

        // ۴. اضافه کردن selected_id به options
        $options['selected_color'] = $selectedColorId;
        $options['selected_size'] = $selectedSizeId;

        // ۵. ساخت stockMap و priceMap برای همه ترکیب‌های رنگ و سایز
        $stockMap = [];
        $priceMap = [];
        foreach ($options['color'] as $color) {
            foreach ($options['size'] as $size) {
                $record = $this->getPriceRecord(
                    $product['id'],
                    $color['option_id'],
                    $size['option_id']
                );
                $key = $color['option_id'] . '_' . $size['option_id'];
                $stockMap[$key] = $record ? (int) $record['stock'] : 0;
                $priceMap[$key] = [
                    'price' => $record ? (float) $record['price'] : 0,
                    'sale_price' => $record ? (float) $record['sale_price'] : 0,
                ];
            }
        }
        $options['stock_map'] = $stockMap;

        // ۶. به‌روزرسانی stock, price, sale_price برای سایزها بر اساس رنگ انتخاب‌شده
        if ($selectedColorId && !empty($options['size'])) {
            foreach ($options['size'] as &$size) {
                $priceRecord = $this->getPriceRecord(
                    $product['id'],
                    $selectedColorId,
                    $size['option_id']
                );
                if ($priceRecord) {
                    $size['stock'] = (int) $priceRecord['stock'];
                    $size['price'] = (float) $priceRecord['price'];
                    $size['sale_price'] = (float) $priceRecord['sale_price'];
                } else {
                    $size['stock'] = 0;
                    $size['price'] = 0;
                    $size['sale_price'] = 0;
                }
            }
            unset($size);
        }

        // ۷. موجودی ترکیب انتخاب‌شده
        $selectedStock = 0;
        if ($selectedColorId && $selectedSizeId) {
            $priceRecord = $this->getPriceRecord(
                $product['id'],
                $selectedColorId,
                $selectedSizeId
            );
            $selectedStock = $priceRecord ? (int) $priceRecord['stock'] : 0;
        }

        // ۸. محصولات مرتبط
        $relatedProducts = [];
        if (!empty($product['category']) && isset($product['category']['id'])) {
            $relatedProducts = $this->getRelatedProducts(
                $product['id'],
                $product['category']['id']
            );
        }

        return [
            'product'        => $product,
            'images'         => $images,
            'options'        => $options,
            'priceInfo'      => $priceInfo,
            'totalStock'     => $totalStock,
            'selectedStock'  => $selectedStock,
            'relatedProducts'=> $relatedProducts,
            'priceMap'       => $priceMap, // اضافه شد
            'selectedColorId'=> $selectedColorId,
            'selectedSizeId' => $selectedSizeId,
        ];
    }
}
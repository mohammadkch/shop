<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\ProductOptionModel;
use App\Models\ProductMenuModel;
use App\Models\Menu3Model;

class ProductService
{
    protected $productModel;
    protected $productImageModel;
    protected $productOptionModel;
    protected $productMenuModel;
    protected $menu3Model;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->productImageModel = new ProductImageModel();
        $this->productOptionModel = new ProductOptionModel();
        $this->productMenuModel = new ProductMenuModel();
        $this->menu3Model = new Menu3Model();
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
            ->orderBy('is_main', 'DESC')
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        $result = [
            'main' => null,
            'gallery' => []
        ];

        foreach ($images as $image) {
            if ($image['is_main'] == 1) {
                $result['main'] = $image;
            } else {
                $result['gallery'][] = $image;
            }
        }

        if (!$result['main'] && !empty($images)) {
            $result['main'] = $images[0];
            $result['gallery'] = array_filter($result['gallery'], function($img) use ($images) {
                return $img['id'] != $images[0]['id'];
            });
        }

        return $result;
    }

    // ====== متد جدید برای دسته‌بندی آپشن‌ها ======
    public function getProductOptions($productId)
    {
        $options = $this->productOptionModel
            ->select('
            product_option.*, 
            option.value as option_value, 
            option.sort_order, 
            option.color_code,
            label.name as label_name, 
            label.id as label_id,
            label.type as label_type
        ')
            ->join('option', 'option.id = product_option.option_id')
            ->join('label', 'label.id = option.label_id')
            ->where('product_option.product_id', $productId)
            ->where('option.is_active', 1)
            ->where('label.is_active', 1)
            ->orderBy('label.sort_order', 'ASC')
            ->orderBy('option.sort_order', 'ASC')
            ->findAll();

        // دیباگ: ببین چی میاد
        // echo '<pre>'; print_r($options); exit;

        $result = [
            'color' => [],
            'size' => [],
            'features' => []
        ];

        $colorMap = [];

        foreach ($options as $option) {
            $labelType = $option['label_type'] ?? 'feature';

            // اگه label_type ست نشده بود، بر اساس اسم لیبل تشخیص بده
            if (empty($labelType) || $labelType == 'feature') {
                if (in_array($option['label_name'], ['رنگ', 'color'])) {
                    $labelType = 'color';
                } elseif (in_array($option['label_name'], ['سایز', 'size', 'اندازه'])) {
                    $labelType = 'size';
                }
            }

            if ($labelType == 'color') {
                $key = $option['option_id'];
                if (!isset($colorMap[$key])) {
                    $colorMap[$key] = true;
                    $result['color'][] = $option;
                }
            } elseif ($labelType == 'size') {
                $result['size'][] = $option;
            } else {
                $result['features'][] = $option;
            }
        }

        // دیباگ: ببین چی برگشت داده میشه
        // echo '<pre>'; print_r($result); exit;

        return $result;
    }

    public function getFinalPrice($product, $optionId = null)
    {
        $basePrice = $product['price'] ?? 0;

        if ($optionId) {
            $option = $this->productOptionModel
                ->where('product_id', $product['id'])
                ->where('option_id', $optionId)
                ->first();

            if ($option && isset($option['price']) && $option['price'] !== null && $option['price'] > 0) {
                $basePrice = $option['price'];
            }
        }

        $now = time();
        if (!empty($product['sale_price']) &&
            $product['sale_price'] > 0 &&
            !empty($product['sale_start_date']) &&
            !empty($product['sale_end_date']) &&
            $product['sale_start_date'] <= $now &&
            $product['sale_end_date'] >= $now) {
            return [
                'original_price' => $basePrice,
                'final_price' => $product['sale_price'],
                'discount_percent' => $this->calculateDiscountPercent($basePrice, $product['sale_price']),
                'has_discount' => true,
                'sale_end_date' => $product['sale_end_date']
            ];
        }

        return [
            'original_price' => $basePrice,
            'final_price' => $basePrice,
            'discount_percent' => 0,
            'has_discount' => false,
            'sale_end_date' => null
        ];
    }

    private function calculateDiscountPercent($originalPrice, $salePrice)
    {
        if ($originalPrice <= 0) {
            return 0;
        }
        return round((($originalPrice - $salePrice) / $originalPrice) * 100);
    }

    public function getStock($productId, $optionId = null)
    {
        if ($optionId) {
            $option = $this->productOptionModel
                ->where('product_id', $productId)
                ->where('option_id', $optionId)
                ->first();

            return $option ? $option['stock'] : 0;
        }

        $options = $this->productOptionModel
            ->where('product_id', $productId)
            ->findAll();

        $totalStock = 0;
        foreach ($options as $option) {
            $totalStock += $option['stock'];
        }

        return $totalStock;
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
}
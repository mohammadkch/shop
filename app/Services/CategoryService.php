<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\ProductMenuModel;

class CategoryService
{
    protected $productModel;
    protected $productMenuModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->productMenuModel = new ProductMenuModel();
    }

    public function getFilterData(array $menu3Ids)
    {
        if (empty($menu3Ids)) {
            return [];
        }

        $db = \Config\Database::connect();

        // ۱. دریافت تمام لیبل‌های فعال
        $labels = $db->table('label')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->getResultArray();

        if (empty($labels)) {
            return [];
        }

        $result = [];

        foreach ($labels as $label) {
            // ۲. استفاده از کوئری خام برای جدول option
            $sql = "SELECT DISTINCT o.id, o.value, o.color_code, o.sort_order
                FROM `option` o
                JOIN product_option po ON po.option_id = o.id
                JOIN product_menu pm ON pm.product_id = po.product_id
                WHERE o.label_id = ?
                AND o.is_active = 1
                AND pm.menu_3_id IN (" . implode(',', array_map('intval', $menu3Ids)) . ")
                ORDER BY o.sort_order ASC";

            $options = $db->query($sql, [$label['id']])->getResultArray();

            // فقط اگه آپشنی داشت، اضافه کن
            if (!empty($options)) {
                $result[] = [
                    'label' => $label,
                    'options' => $options
                ];
            }
        }

        return $result;
    }

    public function getProductsWithFilters(array $menu3Ids, array $filters = [], $limit = null, $offset = 0, $sortField = 'published_at', $sortType = 'desc')
    {
        if (empty($menu3Ids)) {
            return [];
        }

        $db = \Config\Database::connect();

        // ابتدا product_id های مورد نظر رو پیدا کن
        $subQuery = $db->table('product_menu pm');
        $subQuery->select('pm.product_id');
        $subQuery->whereIn('pm.menu_3_id', $menu3Ids);

        // اعمال فیلترها روی ساب‌کوئری
        foreach ($filters as $labelId => $optionIds) {
            if (!empty($optionIds)) {
                $alias = 'po_' . $labelId;
                $subQuery->join("product_option {$alias}", "{$alias}.product_id = pm.product_id");
                $subQuery->whereIn("{$alias}.option_id", $optionIds);
            }
        }

        $subQuery->groupBy('pm.product_id');
        $productIds = $subQuery->get()->getResultArray();
        $productIds = array_column($productIds, 'product_id');

        if (empty($productIds)) {
            return [];
        }

        // حالا محصولات رو بگیر
        $builder = $db->table('product p');
        $builder->whereIn('p.id', $productIds);
        $builder->where('p.is_active', 1);

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        // ====== سورت با sort_field و sort_type ======
        $allowedFields = ['published_at', 'price', 'visit_count', 'created_at'];
        $allowedTypes = ['asc', 'desc'];

        $field = in_array($sortField, $allowedFields) ? $sortField : 'published_at';
        $type = in_array($sortType, $allowedTypes) ? $sortType : 'desc';

        $builder->orderBy("p.{$field}", $type);

        $products = $builder->get()->getResultArray();

        // ====== اضافه کردن اطلاعات قیمت به هر محصول ======
        $productService = service('productService');
        foreach ($products as &$product) {
            $priceInfo = $productService->getFinalPrice($product);
            $product['final_price'] = $priceInfo['final_price'];
            $product['original_price'] = $priceInfo['original_price'];
            $product['has_discount'] = $priceInfo['has_discount'];
            $product['discount_percent'] = $priceInfo['discount_percent'];
        }

        return $products;
    }
    public function countProductsWithFilters(array $menu3Ids, array $filters = [])
    {
        if (empty($menu3Ids)) {
            return 0;
        }

        $db = \Config\Database::connect();

        $builder = $db->table('product_menu pm');
        $builder->select('pm.product_id');
        $builder->whereIn('pm.menu_3_id', $menu3Ids);

        foreach ($filters as $labelId => $optionIds) {
            if (!empty($optionIds)) {
                $alias = 'po_' . $labelId;
                $builder->join("product_option {$alias}", "{$alias}.product_id = pm.product_id");
                $builder->whereIn("{$alias}.option_id", $optionIds);
            }
        }

        $builder->groupBy('pm.product_id');
        return $builder->countAllResults();
    }
}
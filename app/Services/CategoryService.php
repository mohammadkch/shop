<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\ProductMenuModel;
use App\Models\ProductPriceModel;

class CategoryService
{
    protected $productModel;
    protected $productMenuModel;
    protected $productPriceModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->productMenuModel = new ProductMenuModel();
        $this->productPriceModel = new ProductPriceModel();
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
            // ۲. دریافت آپشن‌های موجود برای این لیبل
            // برای رنگ و سایز از product_price استفاده میکنیم
            // برای ویژگی‌ها از product_option استفاده میکنیم
            $sql = "";

            if ($label['type'] == 'color') {
                $sql = "SELECT DISTINCT o.id, o.value, o.color_code, o.sort_order
                    FROM `option` o
                    JOIN product_price pp ON pp.color_option_id = o.id
                    JOIN product_menu pm ON pm.product_id = pp.product_id
                    WHERE o.label_id = ?
                    AND o.is_active = 1
                    AND pm.menu_3_id IN (" . implode(',', array_map('intval', $menu3Ids)) . ")
                    AND pp.stock > 0
                    ORDER BY o.sort_order ASC";
            } elseif ($label['type'] == 'size') {
                $sql = "SELECT DISTINCT o.id, o.value, o.color_code, o.sort_order
                    FROM `option` o
                    JOIN product_price pp ON pp.size_option_id = o.id
                    JOIN product_menu pm ON pm.product_id = pp.product_id
                    WHERE o.label_id = ?
                    AND o.is_active = 1
                    AND pm.menu_3_id IN (" . implode(',', array_map('intval', $menu3Ids)) . ")
                    AND pp.stock > 0
                    ORDER BY o.sort_order ASC";
            } else {
                // ویژگی‌ها (feature) - از product_option قدیمی
                $sql = "SELECT DISTINCT o.id, o.value, o.color_code, o.sort_order
                    FROM `option` o
                    JOIN product_option po ON po.option_id = o.id
                    JOIN product_menu pm ON pm.product_id = po.product_id
                    WHERE o.label_id = ?
                    AND o.is_active = 1
                    AND pm.menu_3_id IN (" . implode(',', array_map('intval', $menu3Ids)) . ")
                    ORDER BY o.sort_order ASC";
            }

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

        // ساب‌کوئری برای product_id های مورد نظر
        $subQuery = $db->table('product_menu pm');
        $subQuery->select('pm.product_id');
        $subQuery->whereIn('pm.menu_3_id', $menu3Ids);

        // اعمال فیلترها
        foreach ($filters as $labelId => $optionIds) {
            if (!empty($optionIds)) {
                $labelModel = model('App\Models\LabelModel');
                $label = $labelModel->find($labelId);

                if ($label) {
                    if ($label['type'] == 'color') {
                        $alias = 'pp_' . $labelId;
                        $subQuery->join("product_price {$alias}", "{$alias}.product_id = pm.product_id");
                        $subQuery->whereIn("{$alias}.color_option_id", $optionIds);
                    } elseif ($label['type'] == 'size') {
                        $alias = 'pp_' . $labelId;
                        $subQuery->join("product_price {$alias}", "{$alias}.product_id = pm.product_id");
                        $subQuery->whereIn("{$alias}.size_option_id", $optionIds);
                    } else {
                        $alias = 'po_' . $labelId;
                        $subQuery->join("product_option {$alias}", "{$alias}.product_id = pm.product_id");
                        $subQuery->whereIn("{$alias}.option_id", $optionIds);
                    }
                }
            }
        }

        $subQuery->groupBy('pm.product_id');
        $productIds = $subQuery->get()->getResultArray();
        $productIds = array_column($productIds, 'product_id');

        if (empty($productIds)) {
            return [];
        }

        // ====== دریافت محصولات با قیمت ======
        $builder = $db->table('product p');
        $builder->select('p.*');
        $builder->whereIn('p.id', $productIds);
        $builder->where('p.is_active', 1);
        $builder->groupBy('p.id');

        // ====== سورت ======
        $allowedFields = ['published_at', 'created_at', 'visit_count'];
        $allowedTypes = ['asc', 'desc'];

        $field = in_array($sortField, $allowedFields) ? $sortField : 'published_at';
        $type = in_array($sortType, $allowedTypes) ? $sortType : 'desc';

        if ($field == 'price') {
            // قیمت رو جداگانه هندل میکنیم
            $builder->orderBy('sort_price', $type);
        } else {
            $builder->orderBy("p.{$field}", $type);
        }

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $products = $builder->get()->getResultArray();

        // ====== محاسبه قیمت برای هر محصول ======
        $productIdsWithPrice = [];
        foreach ($products as &$product) {
            // ۱. همه رکوردهای قیمت این محصول رو بگیر
            $allPrices = $db->table('product_price')
                ->where('product_id', $product['id'])
                ->get()
                ->getResultArray();

            if (empty($allPrices)) {
                $product['final_price'] = 0;
                $product['original_price'] = 0;
                $product['has_discount'] = false;
                $product['discount_percent'] = 0;
                $product['sort_price'] = 0;
                continue;
            }

            // ====== ۲. منطق جدید انتخاب قیمت ======
            $selectedRecord = null;
            $bestPrice = PHP_INT_MAX;

            foreach ($allPrices as $record) {
                // موجودی نداره → رد کن
                if ((int) $record['stock'] <= 0) {
                    continue;
                }

                // اگه is_default = 1 باشه، اولویت داره → همین رو انتخاب کن و دیگه ادامه نده
                if ((int) $record['is_default'] === 1) {
                    $selectedRecord = $record;
                    break;
                }

                // اگه is_default نبود، ارزان‌ترین قیمت رو پیدا کن
                // تاریخ تخفیف رو نادیده بگیر
                $price = (float) $record['price'];
                $salePrice = $record['sale_price'] ? (float) $record['sale_price'] : null;

                // قیمت نهایی برای این رکورد (بدون در نظر گرفتن تاریخ)
                $finalPrice = $price;
                if ($salePrice && $salePrice > 0 && $salePrice < $price) {
                    $finalPrice = $salePrice;
                }

                if ($finalPrice < $bestPrice) {
                    $bestPrice = $finalPrice;
                    $selectedRecord = $record;
                }
            }

            // ====== ۳. اگه هیچ رکوردی با موجودی پیدا نشد ======
            if (!$selectedRecord) {
                $product['final_price'] = 0;
                $product['original_price'] = 0;
                $product['has_discount'] = false;
                $product['discount_percent'] = 0;
                $product['sort_price'] = 0;
                continue;
            }

            // ====== ۴. محاسبه قیمت نهایی ======
            $price = (float) $selectedRecord['price'];
            $salePrice = $selectedRecord['sale_price'] ? (float) $selectedRecord['sale_price'] : null;

            // تاریخ تخفیف رو نادیده بگیر
            $finalPrice = $price;
            $hasDiscount = false;
            $discountPercent = 0;

            if ($salePrice && $salePrice > 0 && $salePrice < $price) {
                $finalPrice = $salePrice;
                $hasDiscount = true;
                $discountPercent = round((($price - $salePrice) / $price) * 100);
            }

            // ====== ۵. ذخیره در محصول ======
            $product['final_price'] = $finalPrice;
            $product['original_price'] = $price;
            $product['has_discount'] = $hasDiscount;
            $product['discount_percent'] = $discountPercent;
            $product['sort_price'] = $finalPrice; // ← این برای سورت قیمت

            $productIdsWithPrice[$product['id']] = $finalPrice;
        }

        // ====== ۶. سورت بر اساس sort_price ======
        if ($sortField == 'price') {
            usort($products, function($a, $b) use ($sortType) {
                $priceA = $a['sort_price'] ?? 0;
                $priceB = $b['sort_price'] ?? 0;
                if ($sortType == 'asc') {
                    return $priceA - $priceB;
                } else {
                    return $priceB - $priceA;
                }
            });
        }

        return $products;
    }

    public function countProductsWithFilters(array $menu3Ids, array $filters = [])
    {
        if (empty($menu3Ids)) {
            return 0;
        }

        $db = \Config\Database::connect();

        // ====== ۱. اول محصولاتی که در این دسته‌بندی هستن رو پیدا کن ======
        $subQuery = $db->table('product_menu pm');
        $subQuery->select('pm.product_id');
        $subQuery->whereIn('pm.menu_3_id', $menu3Ids);

        // اعمال فیلترها
        foreach ($filters as $labelId => $optionIds) {
            if (!empty($optionIds)) {
                $labelModel = model('App\Models\LabelModel');
                $label = $labelModel->find($labelId);

                if ($label) {
                    if ($label['type'] == 'color') {
                        $alias = 'pp_' . $labelId;
                        $subQuery->join("product_price {$alias}", "{$alias}.product_id = pm.product_id");
                        $subQuery->whereIn("{$alias}.color_option_id", $optionIds);
                    } elseif ($label['type'] == 'size') {
                        $alias = 'pp_' . $labelId;
                        $subQuery->join("product_price {$alias}", "{$alias}.product_id = pm.product_id");
                        $subQuery->whereIn("{$alias}.size_option_id", $optionIds);
                    } else {
                        $alias = 'po_' . $labelId;
                        $subQuery->join("product_option {$alias}", "{$alias}.product_id = pm.product_id");
                        $subQuery->whereIn("{$alias}.option_id", $optionIds);
                    }
                }
            }
        }

        $subQuery->groupBy('pm.product_id');
        $productIdsResult = $subQuery->get()->getResultArray();
        $productIds = array_column($productIdsResult, 'product_id');

        if (empty($productIds)) {
            return 0;
        }

        // ====== ۲. فقط محصولاتی رو شمارش کن که حداقل یه رکورد قیمت با موجودی > ۰ دارن ======
        // ساخت ساب‌کوئری برای product_id هایی که stock > 0 دارن
        $priceSubQuery = $db->table('product_price pp')
            ->select('pp.product_id')
            ->where('pp.stock >', 0)
            ->groupBy('pp.product_id')
            ->get()
            ->getResultArray();

        $productIdsWithStock = array_column($priceSubQuery, 'product_id');

        if (empty($productIdsWithStock)) {
            return 0;
        }

        // حالا شمارش نهایی با ترکیب دو مجموعه
        $finalProductIds = array_intersect($productIds, $productIdsWithStock);

        if (empty($finalProductIds)) {
            return 0;
        }

        // شمارش نهایی
        $builder = $db->table('product p');
        $builder->select('p.id');
        $builder->whereIn('p.id', $finalProductIds);
        $builder->where('p.is_active', 1);

        return $builder->countAllResults();
    }
}
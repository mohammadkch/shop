<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPriceModel extends Model
{
    protected $table            = 'product_price';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'product_id',
        'color_option_id',
        'size_option_id',
        'price',
        'sale_price',
        'sale_start_date',
        'sale_end_date',
        'stock',
        'sku',
        'is_default'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * دریافت قیمت برای ترکیب خاص
     */
    public function getPriceForCombination($productId, $colorOptionId = null, $sizeOptionId = null)
    {
        // ۱. ترکیب دقیق
        $record = $this->where('product_id', $productId)
            ->where('color_option_id', $colorOptionId)
            ->where('size_option_id', $sizeOptionId)
            ->first();

        if ($record) {
            return $record;
        }

        // ۲. فقط رنگ (اگه سایز null باشه)
        if ($colorOptionId && !$sizeOptionId) {
            $record = $this->where('product_id', $productId)
                ->where('color_option_id', $colorOptionId)
                ->where('size_option_id', null)
                ->first();
            if ($record) return $record;
        }

        // ۳. فقط سایز (اگه رنگ null باشه)
        if (!$colorOptionId && $sizeOptionId) {
            $record = $this->where('product_id', $productId)
                ->where('color_option_id', null)
                ->where('size_option_id', $sizeOptionId)
                ->first();
            if ($record) return $record;
        }

        // ۴. قیمت پیش‌فرض
        return $this->where('product_id', $productId)
            ->where('is_default', 1)
            ->first();
    }

    /**
     * دریافت موجودی برای ترکیب خاص
     */
    public function getStockForCombination($productId, $colorOptionId = null, $sizeOptionId = null)
    {
        $record = $this->getPriceForCombination($productId, $colorOptionId, $sizeOptionId);
        return $record ? (int) $record['stock'] : 0;
    }

    /**
     * دریافت لیست رنگ‌های موجود برای یک محصول (با موجودی > 0)
     */
    public function getAvailableColors($productId)
    {
        return $this->select('color_option_id, option.value, option.color_code')
            ->join('option', 'option.id = product_price.color_option_id')
            ->where('product_id', $productId)
            ->where('color_option_id IS NOT NULL')
            ->where('stock >', 0)
            ->groupBy('color_option_id')
            ->orderBy('option.sort_order', 'ASC')
            ->findAll();
    }

    /**
     * دریافت لیست سایزهای موجود برای یک محصول (با موجودی > 0)
     */
    public function getAvailableSizes($productId)
    {
        return $this->select('size_option_id, option.value')
            ->join('option', 'option.id = product_price.size_option_id')
            ->where('product_id', $productId)
            ->where('size_option_id IS NOT NULL')
            ->where('stock >', 0)
            ->groupBy('size_option_id')
            ->orderBy('option.sort_order', 'ASC')
            ->findAll();
    }
}
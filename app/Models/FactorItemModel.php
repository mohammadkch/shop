<?php

namespace App\Models;

use CodeIgniter\Model;

class FactorItemModel extends Model
{
    protected $table            = 'factor_item';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'factor_id',
        'product_id',
        'color_option_id',
        'size_option_id',
        'quantity',
        'price',
        'sale_price',
        'total'
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * متد استاندارد getData با جوین و شرط‌های مخصوص جدول factor_item
     */
    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // ====== شرط‌ها ======
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('factor_item.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['factor_id']) && !empty($where['factor_id'])) {
            $builder->where('factor_item.factor_id', $where['factor_id']);
            unset($where['factor_id']);
        }

        if (isset($where['product_id']) && !empty($where['product_id'])) {
            $builder->where('factor_item.product_id', $where['product_id']);
            unset($where['product_id']);
        }

        if (isset($where['cart_item_id']) && !empty($where['cart_item_id'])) {
            $builder->where('factor_item.cart_item_id', $where['cart_item_id']);
            unset($where['cart_item_id']);
        }

        if (isset($where['factor_item.id IN'])) {
            $inValue = $where['factor_item.id IN'];
            if (is_array($inValue)) {
                $builder->whereIn('factor_item.id', $inValue);
            } else {
                $cleanValue = trim($inValue, '()');
                $ids = explode(',', $cleanValue);
                $builder->whereIn('factor_item.id', $ids);
            }
            unset($where['factor_item.id IN']);
        }

        // شرط‌های معمولی
        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        // ====== select و جوین‌ها ======
        $builder->select('
            factor_item.*,
            product.name as product_name,
            product.slug as product_slug,
            color_option.value as color_value,
            color_option.color_code,
            size_option.value as size_value,
            product_image.image_name
        ');
        $builder->join('product', 'product.id = factor_item.product_id');
        $builder->join('option as color_option', 'color_option.id = factor_item.color_option_id', 'left');
        $builder->join('option as size_option', 'size_option.id = factor_item.size_option_id', 'left');
        $builder->join('product_image', 'product_image.product_id = product.id AND product_image.product_image_type_id = 2 AND product_image.is_active = 1', 'left');
        $builder->groupBy('factor_item.id');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('factor_item.id', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * دریافت آیتم‌های یک فاکتور
     */
    public function getItemsByFactorId($factorId)
    {
        return $this->getData(['factor_id' => $factorId]);
    }

    public function copyFromCartItems($factorId, $cartItems)
    {
        $insertData = [];
        foreach ($cartItems as $item) {
            $originalPrice = (float) $item['price'];
            $salePrice = isset($item['sale_price']) && $item['sale_price'] > 0 ? (float) $item['sale_price'] : null;
            $finalPrice = ($salePrice !== null && $salePrice < $originalPrice) ? $salePrice : $originalPrice;

            $insertData[] = [
                'factor_id' => $factorId,
                'product_id' => $item['product_id'],
                'color_option_id' => $item['color_option_id'],
                'size_option_id' => $item['size_option_id'],
                'quantity' => $item['quantity'],
                'price' => $originalPrice,
                'sale_price' => $salePrice,
                'total' => $finalPrice * $item['quantity']
            ];
        }

        if (!empty($insertData)) {
            return $this->insertBatch($insertData);
        }

        return false;
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table            = 'cart_item';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['cart_id', 'product_id', 'color_option_id', 'size_option_id', 'quantity', 'price', 'sale_price'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getItemsWithProduct($cartId)
    {
        // subquery برای گرفتن فقط یک thumbnail (type_id = 2)
        $subQuery = $this->db->table('product_image')
            ->select('MIN(image_name) as image_name, product_id')
            ->where('is_active', 1)
            ->where('product_image_type_id', 2)  // ← فقط thumbnail
            ->groupBy('product_id')
            ->get()
            ->getResultArray();

        // تبدیل به آرایه کلید-مقدار
        $imageMap = [];
        foreach ($subQuery as $row) {
            $imageMap[$row['product_id']] = $row['image_name'];
        }

        // دریافت آیتم‌های سبد خرید
        $items = $this->select('
        cart_item.*, 
        product.name as product_name, 
        product.slug,
        color_option.value as color_value,
        color_option.color_code,
        size_option.value as size_value
    ')
            ->join('product', 'product.id = cart_item.product_id')
            ->join('option as color_option', 'color_option.id = cart_item.color_option_id', 'left')
            ->join('option as size_option', 'size_option.id = cart_item.size_option_id', 'left')
            ->where('cart_id', $cartId)
            ->findAll();

        // اضافه کردن image_name به هر آیتم از map
        foreach ($items as &$item) {
            $item['image_name'] = $imageMap[$item['product_id']] ?? null;
        }

        return $items;
    }

    public function getTotalItems($cartId)
    {
        $result = $this->select('SUM(quantity) as total')
            ->where('cart_id', $cartId)
            ->first();
        return $result['total'] ?? 0;
    }

    public function getTotalPrice($cartId)
    {
        $result = $this->select('SUM(price * quantity) as total')
            ->where('cart_id', $cartId)
            ->first();
        return $result['total'] ?? 0;
    }

    public function getItemByProductAndOptions($cartId, $productId, $colorOptionId = null, $sizeOptionId = null)
    {
        $builder = $this->where('cart_id', $cartId)
            ->where('product_id', $productId);

        if ($colorOptionId) {
            $builder->where('color_option_id', $colorOptionId);
        } else {
            $builder->where('color_option_id IS NULL');
        }

        if ($sizeOptionId) {
            $builder->where('size_option_id', $sizeOptionId);
        } else {
            $builder->where('size_option_id IS NULL');
        }

        return $builder->first();
    }
}
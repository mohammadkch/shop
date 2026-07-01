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
    protected $allowedFields    = ['cart_id', 'product_id', 'color_option_id', 'size_option_id', 'quantity', 'price'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getItemsWithProduct($cartId)
    {
        return $this->select('
            cart_item.*, 
            product.name as product_name, 
            product.slug,
            product_image.image_name,
            color_option.value as color_value,
            color_option.color_code,
            size_option.value as size_value
        ')
            ->join('product', 'product.id = cart_item.product_id')
            ->join('product_image', 'product_image.product_id = product.id AND product_image.is_active = 1', 'left')
            ->join('option as color_option', 'color_option.id = cart_item.color_option_id', 'left')
            ->join('option as size_option', 'size_option.id = cart_item.size_option_id', 'left')
            ->where('cart_id', $cartId)
            ->findAll();
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
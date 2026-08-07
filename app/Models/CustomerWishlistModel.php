<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerWishlistModel extends Model
{
    protected $table            = 'customer_wishlist';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['customer_id', 'product_id', 'created_at'];

    protected $useTimestamps = false;

    public function countForCustomer(int $customerId): int
    {
        return $this->where('customer_id', $customerId)->countAllResults();
    }

    public function findForCustomerAndProduct(int $customerId, int $productId): ?array
    {
        return $this->where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->first();
    }

    public function hasProduct(int $customerId, int $productId): bool
    {
        return $this->findForCustomerAndProduct($customerId, $productId) !== null;
    }

    public function getProductIdsForCustomer(int $customerId): array
    {
        $rows = $this->select('product_id')
            ->where('customer_id', $customerId)
            ->orderBy('id', 'DESC')
            ->findAll();

        return array_map('intval', array_column($rows, 'product_id'));
    }

    public function getProductsForCustomer(int $customerId): array
    {
        return $this->select('customer_wishlist.id AS wishlist_id, customer_wishlist.created_at AS wishlist_created_at')
            ->select('product.*')
            ->select('(
                SELECT product_thumbnail.image_name
                FROM product_image AS product_thumbnail
                WHERE product_thumbnail.product_id = product.id
                  AND product_thumbnail.product_image_type_id = 2
                  AND product_thumbnail.is_active = 1
                ORDER BY product_thumbnail.sort_order ASC, product_thumbnail.id ASC
                LIMIT 1
            ) AS thumbnail', false)
            ->join('product', 'product.id = customer_wishlist.product_id')
            ->where('customer_wishlist.customer_id', $customerId)
            ->orderBy('customer_wishlist.id', 'DESC')
            ->findAll();
    }
}

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
}

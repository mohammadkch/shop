<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductSlugRedirectModel extends Model
{
    protected $table = 'product_slug_redirect';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['product_id', 'history_id', 'old_slug', 'created_at'];
    protected $useTimestamps = false;

    public function findForProduct(int $productId, string $slug): ?array
    {
        return $this->where('product_id', $productId)
            ->where('old_slug', $slug)
            ->first();
    }
}

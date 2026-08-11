<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductSlugHistoryModel extends Model
{
    protected $table = 'product_slug_history';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['product_id', 'old_slug', 'new_slug', 'created_at'];
    protected $useTimestamps = false;
}

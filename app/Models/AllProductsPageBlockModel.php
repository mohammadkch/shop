<?php

namespace App\Models;

use CodeIgniter\Model;

class AllProductsPageBlockModel extends Model
{
    protected $table = 'all_products_page_block';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'all_products_page_id', 'type', 'content', 'image', 'image_alt', 'caption', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'int';
}

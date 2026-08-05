<?php

namespace App\Models;

use CodeIgniter\Model;

class AllProductsPageModel extends Model
{
    protected $table = 'all_products_page';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['h1_title', 'meta_title', 'meta_description'];
    protected $useTimestamps = true;
    protected $dateFormat = 'int';
}

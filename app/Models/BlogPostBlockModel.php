<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostBlockModel extends Model
{
    protected $table = 'blog_post_block';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'blog_post_id', 'type', 'content', 'image', 'image_alt', 'caption', 'sort_order',
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'int';
}

<?php

namespace App\Models;

use App\Models\Menu2Model;
use App\Models\OptionModel;
use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'product';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'slug',
        'description',
        'is_active',
        'published_at',
        'price',
        'sale_price',
        'sale_start_date',
        'sale_end_date',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sku',
        'weight'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // فیلتر بر اساس id
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('id', $where['id']);
            unset($where['id']);
        }

        // جستجو در name
        if (isset($where['name']) && !empty($where['name'])) {
            $builder->like('name', $where['name']);
            unset($where['name']);
        }

        // جستجو در slug
        if (isset($where['slug']) && !empty($where['slug'])) {
            $builder->like('slug', $where['slug']);
            unset($where['slug']);
        }

        // فیلتر بر اساس is_active
        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('is_active', $where['is_active']);
            unset($where['is_active']);
        }

        // شرط‌های معمولی
        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy("{$this->table}.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    public function options()
    {
        return $this->belongsToMany(OptionModel::class, 'product_option', 'product_id', 'option_id');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu2Model::class, 'product_menu', 'product_id', 'menu_2_id');
    }
}
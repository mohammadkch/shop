<?php

namespace App\Models;

use App\Models\Menu3Model;
use App\Models\ProductModel;
use CodeIgniter\Model;

class ProductMenuModel extends Model
{
    protected $table            = 'product_menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id', 'menu_3_id'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['product_id']) && $where['product_id'] !== '') {
            $builder->where('product_id', $where['product_id']);
            unset($where['product_id']);
        }

        if (isset($where['menu_3_id']) && $where['menu_3_id'] !== '') {
            $builder->where('menu_3_id', $where['menu_3_id']);
            unset($where['menu_3_id']);
        }

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

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function menu3()
    {
        return $this->belongsTo(Menu3Model::class, 'menu_3_id');
    }
}
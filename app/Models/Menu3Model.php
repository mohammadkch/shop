<?php

namespace App\Models;

use CodeIgniter\Model;

class Menu3Model extends Model
{
    protected $table            = 'menu_3';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['menu_2_id', 'name', 'slug', 'is_active'];

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

        if (isset($where['name']) && !empty($where['name'])) {
            $builder->like('name', $where['name']);
            unset($where['name']);
        }

        if (isset($where['slug']) && !empty($where['slug'])) {
            $builder->like('slug', $where['slug']);
            unset($where['slug']);
        }

        if (isset($where['menu_1_id']) && $where['menu_1_id'] !== '') {
            $builder->where('menu_1_id', $where['menu_1_id']);
            unset($where['menu_1_id']);
        }

        if (isset($where['menu_2_id']) && $where['menu_2_id'] !== '') {
            $builder->where('menu_2_id', $where['menu_2_id']);
            unset($where['menu_2_id']);
        }

        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('menu_3.is_active', $where['is_active']);
            unset($where['is_active']);
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

        $builder->select('
            menu_3.*,
            menu_2.name as menu_2_name,
            menu_1.id as menu_1_name,
            menu_1.name as menu_1_name
        ');
        $builder->join('menu_2', 'menu_3.menu_2_id = menu_2.id', 'left');
        $builder->join('menu_1', 'menu_2.menu_1_id = menu_1.id', 'left');

        $builder->orderBy("{$this->table}.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    public function menu2()
    {
        return $this->belongsTo(Menu2Model::class, 'menu_2_id');
    }

    public function products()
    {
        return $this->belongsToMany(ProductModel::class, 'product_menu', 'menu_3_id', 'product_id');
    }

    public function imageTypes()
    {
        return $this->hasMany(Menu3ImageTypeModel::class, 'menu_3_id');
    }
}
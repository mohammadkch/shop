<?php

namespace App\Models;

use CodeIgniter\Model;

class Menu2ImageTypeModel extends Model
{
    protected $table            = 'menu_2_image_type';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'width', 'height', 'extension', 'file_size_limit', 'path', 'is_active'];

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

        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('is_active', $where['is_active']);
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

        $builder->orderBy("{$this->table}.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    public function images()
    {
        return $this->hasMany(Menu2ImageModel::class, 'menu_2_image_type_id');
    }
}
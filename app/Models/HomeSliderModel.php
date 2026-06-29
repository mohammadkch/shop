<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeSliderModel extends Model
{
    protected $table            = 'home_slider';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'image', 'link', 'sort_order', 'is_active'];

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

        if (isset($where['title']) && !empty($where['title'])) {
            $builder->like('title', $where['title']);
            unset($where['title']);
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

        $builder->orderBy('sort_order', 'ASC');

        return $builder->get()->getResultArray();
    }
}
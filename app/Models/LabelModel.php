<?php

namespace App\Models;

use App\Models\OptionModel;
use CodeIgniter\Model;

class LabelModel extends Model
{
    protected $table            = 'label';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'is_active'];

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
        return $this->hasMany(OptionModel::class, 'label_id');
    }
}
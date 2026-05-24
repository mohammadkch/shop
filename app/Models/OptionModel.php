<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
    protected $table            = 'option';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['label_id', 'value', 'sort_order', 'is_active'];

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

        // فیلتر بر اساس label_id
        if (isset($where['label_id']) && $where['label_id'] !== '') {
            $builder->where('label_id', $where['label_id']);
            unset($where['label_id']);
        }

        // جستجو در value
        if (isset($where['value']) && !empty($where['value'])) {
            $builder->like('value', $where['value']);
            unset($where['value']);
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

        $builder->orderBy('sort_order', 'ASC');
        $builder->orderBy("{$this->table}.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    public function label()
    {
        return $this->belongsTo(LabelModel::class, 'label_id');
    }
}
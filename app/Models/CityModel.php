<?php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
    protected $table            = 'city';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['state_id', 'name', 'sort_order'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * متد استاندارد getData با جوین و شرط‌های مخصوص جدول city
     */
    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // ====== شرط‌ها ======
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('city.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['state_id']) && !empty($where['state_id'])) {
            $builder->where('city.state_id', $where['state_id']);
            unset($where['state_id']);
        }

        if (isset($where['name']) && !empty($where['name'])) {
            $builder->like('city.name', $where['name']);
            unset($where['name']);
        }

        if (isset($where['state_name']) && !empty($where['state_name'])) {
            $builder->like('state.name', $where['state_name']);
            unset($where['state_name']);
        }

        if (isset($where['city.id IN'])) {
            $inValue = $where['city.id IN'];
            if (is_array($inValue)) {
                $builder->whereIn('city.id', $inValue);
            } else {
                $cleanValue = trim($inValue, '()');
                $ids = explode(',', $cleanValue);
                $builder->whereIn('city.id', $ids);
            }
            unset($where['city.id IN']);
        }

        // شرط‌های معمولی
        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        // ====== select و جوین‌ها ======
        $builder->select('
            city.*,
            state.name as state_name,
            state.sort_order as state_sort_order
        ');
        $builder->join('state', 'state.id = city.state_id');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('state.sort_order', 'ASC');
        $builder->orderBy('city.sort_order', 'ASC');
        $builder->orderBy("city.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }
}
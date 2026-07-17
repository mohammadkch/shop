<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingTypeModel extends Model
{
    protected $table            = 'shipping_type';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'sort_order'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * متد استاندارد getData با شرط‌های مخصوص جدول shipping_type
     */
    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // ====== شرط‌ها ======
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('shipping_type.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['name']) && !empty($where['name'])) {
            $builder->like('shipping_type.name', $where['name']);
            unset($where['name']);
        }

        if (isset($where['shipping_type.id IN'])) {
            $inValue = $where['shipping_type.id IN'];
            if (is_array($inValue)) {
                $builder->whereIn('shipping_type.id', $inValue);
            } else {
                $cleanValue = trim($inValue, '()');
                $ids = explode(',', $cleanValue);
                $builder->whereIn('shipping_type.id', $ids);
            }
            unset($where['shipping_type.id IN']);
        }

        // شرط‌های معمولی
        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        // ====== select ======
        $builder->select('shipping_type.*');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('shipping_type.sort_order', 'ASC');
        $builder->orderBy("shipping_type.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }
}
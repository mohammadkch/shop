<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingPriceModel extends Model
{
    protected $table            = 'shipping_price';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['shipping_type_id', 'city_id', 'price'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * متد استاندارد getData با جوین و شرط‌های مخصوص جدول shipping_price
     */
    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // ====== شرط‌ها ======
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('shipping_price.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['shipping_type_id']) && !empty($where['shipping_type_id'])) {
            $builder->where('shipping_price.shipping_type_id', $where['shipping_type_id']);
            unset($where['shipping_type_id']);
        }

        if (isset($where['city_id']) && !empty($where['city_id'])) {
            $builder->where('shipping_price.city_id', $where['city_id']);
            unset($where['city_id']);
        }

        if (isset($where['price']) && !empty($where['price'])) {
            $builder->where('shipping_price.price', $where['price']);
            unset($where['price']);
        }

        if (isset($where['shipping_type_name']) && !empty($where['shipping_type_name'])) {
            $builder->like('shipping_type.name', $where['shipping_type_name']);
            unset($where['shipping_type_name']);
        }

        if (isset($where['city_name']) && !empty($where['city_name'])) {
            $builder->like('city.name', $where['city_name']);
            unset($where['city_name']);
        }

        if (isset($where['shipping_price.id IN'])) {
            $inValue = $where['shipping_price.id IN'];
            if (is_array($inValue)) {
                $builder->whereIn('shipping_price.id', $inValue);
            } else {
                $cleanValue = trim($inValue, '()');
                $ids = explode(',', $cleanValue);
                $builder->whereIn('shipping_price.id', $ids);
            }
            unset($where['shipping_price.id IN']);
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
            shipping_price.*,
            shipping_type.name as shipping_type_name,
            shipping_type.sort_order as shipping_type_sort_order,
            city.name as city_name,
            city.state_id,
            state.name as state_name
        ');
        $builder->join('shipping_type', 'shipping_type.id = shipping_price.shipping_type_id');
        $builder->join('city', 'city.id = shipping_price.city_id');
        $builder->join('state', 'state.id = city.state_id');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('shipping_type.sort_order', 'ASC');
        $builder->orderBy('city.sort_order', 'ASC');
        $builder->orderBy("shipping_price.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * دریافت قیمت ارسال بر اساس شهر و نوع ارسال
     */
    public function getPriceByCityAndType($cityId, $shippingTypeId)
    {
        return $this->where('city_id', $cityId)
            ->where('shipping_type_id', $shippingTypeId)
            ->first();
    }

    /**
     * دریافت همه قیمت‌های ارسال یک شهر
     */
    public function getPricesByCity($cityId)
    {
        return $this->select('shipping_price.*, shipping_type.name as shipping_type_name')
            ->join('shipping_type', 'shipping_type.id = shipping_price.shipping_type_id')
            ->where('city_id', $cityId)
            ->findAll();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerAddressModel extends Model
{
    protected $table            = 'customer_address';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'customer_id',
        'city_id',
        'title',
        'recipient_name',
        'recipient_mobile',
        'address',
        'postal_code'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * متد استاندارد getData با جوین و شرط‌های مخصوص جدول customer_address
     */
    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // ====== شرط‌ها ======
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('customer_address.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['customer_id']) && !empty($where['customer_id'])) {
            $builder->where('customer_address.customer_id', $where['customer_id']);
            unset($where['customer_id']);
        }

        if (isset($where['city_id']) && !empty($where['city_id'])) {
            $builder->where('customer_address.city_id', $where['city_id']);
            unset($where['city_id']);
        }

        if (isset($where['title']) && !empty($where['title'])) {
            $builder->like('customer_address.title', $where['title']);
            unset($where['title']);
        }

        if (isset($where['recipient_name']) && !empty($where['recipient_name'])) {
            $builder->like('customer_address.recipient_name', $where['recipient_name']);
            unset($where['recipient_name']);
        }

        if (isset($where['recipient_mobile']) && !empty($where['recipient_mobile'])) {
            $builder->like('customer_address.recipient_mobile', $where['recipient_mobile']);
            unset($where['recipient_mobile']);
        }

        if (isset($where['address']) && !empty($where['address'])) {
            $builder->like('customer_address.address', $where['address']);
            unset($where['address']);
        }

        if (isset($where['postal_code']) && !empty($where['postal_code'])) {
            $builder->like('customer_address.postal_code', $where['postal_code']);
            unset($where['postal_code']);
        }

        if (isset($where['city_name']) && !empty($where['city_name'])) {
            $builder->like('city.name', $where['city_name']);
            unset($where['city_name']);
        }

        if (isset($where['state_name']) && !empty($where['state_name'])) {
            $builder->like('state.name', $where['state_name']);
            unset($where['state_name']);
        }

        if (isset($where['customer_address.id IN'])) {
            $inValue = $where['customer_address.id IN'];
            if (is_array($inValue)) {
                $builder->whereIn('customer_address.id', $inValue);
            } else {
                $cleanValue = trim($inValue, '()');
                $ids = explode(',', $cleanValue);
                $builder->whereIn('customer_address.id', $ids);
            }
            unset($where['customer_address.id IN']);
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
            customer_address.*,
            city.name as city_name,
            city.state_id,
            state.name as state_name
        ');
        $builder->join('city', 'city.id = customer_address.city_id');
        $builder->join('state', 'state.id = city.state_id');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('customer_address.id', 'DESC');
        $builder->orderBy("customer_address.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * دریافت آدرس‌های یک مشتری
     */
    public function getAddressesByCustomer($customerId)
    {
        return $this->where('customer_id', $customerId)
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    /**
     * دریافت آدرس به همراه اطلاعات کامل شهر و استان
     */
    public function getAddressWithDetails($addressId)
    {
        return $this->select('
                customer_address.*,
                city.name as city_name,
                city.id as city_id,
                state.name as state_name,
                state.id as state_id
            ')
            ->join('city', 'city.id = customer_address.city_id')
            ->join('state', 'state.id = city.state_id')
            ->where('customer_address.id', $addressId)
            ->first();
    }
}
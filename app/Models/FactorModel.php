<?php

namespace App\Models;

use CodeIgniter\Model;

class FactorModel extends Model
{
    protected $table            = 'factor';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'customer_id',
        'cart_id',
        'address_id',
        'shipping_type_id',
        'shipping_price',
        'subtotal',
        'total',
        'status',
        'expires_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * متد استاندارد getData با جوین و شرط‌های مخصوص جدول factor
     */
    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // ====== شرط‌ها ======
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('factor.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['customer_id']) && !empty($where['customer_id'])) {
            $builder->where('factor.customer_id', $where['customer_id']);
            unset($where['customer_id']);
        }

        if (isset($where['cart_id']) && !empty($where['cart_id'])) {
            $builder->where('factor.cart_id', $where['cart_id']);
            unset($where['cart_id']);
        }

        if (isset($where['status']) && !empty($where['status'])) {
            $builder->where('factor.status', $where['status']);
            unset($where['status']);
        }

        if (isset($where['status IN'])) {
            $inValue = $where['status IN'];
            if (is_array($inValue)) {
                $builder->whereIn('factor.status', $inValue);
            } else {
                $cleanValue = trim($inValue, '()');
                $statuses = array_map('trim', explode(',', $cleanValue));
                $builder->whereIn('factor.status', $statuses);
            }
            unset($where['status IN']);
        }

        if (isset($where['expires_at >=']) && !empty($where['expires_at >='])) {
            $builder->where('factor.expires_at >=', $where['expires_at >=']);
            unset($where['expires_at >=']);
        }

        if (isset($where['expires_at <=']) && !empty($where['expires_at <='])) {
            $builder->where('factor.expires_at <=', $where['expires_at <=']);
            unset($where['expires_at <=']);
        }

        if (isset($where['factor.id IN'])) {
            $inValue = $where['factor.id IN'];
            if (is_array($inValue)) {
                $builder->whereIn('factor.id', $inValue);
            } else {
                $cleanValue = trim($inValue, '()');
                $ids = explode(',', $cleanValue);
                $builder->whereIn('factor.id', $ids);
            }
            unset($where['factor.id IN']);
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
            factor.*,
            customer.mobile as customer_mobile,
            customer.firstname as customer_firstname,
            customer.lastname as customer_lastname,
            customer_address.title as address_title,
            customer_address.address as address_full,
            customer_address.recipient_name,
            customer_address.recipient_mobile,
            customer_address.postal_code,
            city.name as city_name,
            state.name as state_name,
            shipping_type.name as shipping_type_name
        ');
        $builder->join('customer', 'customer.id = factor.customer_id');
        $builder->join('customer_address', 'customer_address.id = factor.address_id', 'left');
        $builder->join('city', 'city.id = customer_address.city_id', 'left');
        $builder->join('state', 'state.id = city.state_id', 'left');
        $builder->join('shipping_type', 'shipping_type.id = factor.shipping_type_id', 'left');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('factor.id', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * دریافت فاکتور pending فعال برای یک کارت
     */
    public function getActivePendingFactorByCart($cartId)
    {
        $now = time();
        return $this->where('cart_id', $cartId)
            ->where('status', 'pending')
            ->where('expires_at >', $now)
            ->first();
    }

    /**
     * بررسی اینکه آیا فاکتور منقضی شده یا نه
     */
    public function isExpired($factorId)
    {
        $factor = $this->find($factorId);
        if (!$factor) {
            return true;
        }
        return $factor['expires_at'] < time();
    }

    /**
     * محاسبه زمان باقیمانده تا انقضا (به دقیقه)
     */
    public function getRemainingMinutes($factorId)
    {
        $factor = $this->find($factorId);
        if (!$factor) {
            return 0;
        }
        $remaining = $factor['expires_at'] - time();
        return $remaining > 0 ? ceil($remaining / 60) : 0;
    }
}
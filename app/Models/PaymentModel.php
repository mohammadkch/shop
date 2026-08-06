<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'factor_id',
        'customer_id',
        'payment_method_id',
        'gateway',
        'order_id',
        'final_amount',
        'status',
        'payment_token',
        'gateway_track_id',
        'ref_number',
        'card_number',
        'gateway_amount',
        'gateway_result',
        'gateway_status',
        'gateway_message',
        'paid_at',
        'verified_at',
        'expires_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * دریافت پرداخت فعال برای یک فاکتور
     */
    public function getActivePaymentByFactor($factorId)
    {
        return $this->where('factor_id', $factorId)
            ->whereIn('status', ['created', 'pending'])
            ->where('expires_at >', time())
            ->first();
    }
}

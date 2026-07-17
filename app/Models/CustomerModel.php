<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['mobile', 'firstname', 'lastname', 'email', 'national_code', 'gender', 'birthdate', 'password', 'avatar', 'is_active', 'last_login'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findByMobile($mobile)
    {
        return $this->where('mobile', $mobile)->first();
    }

    public function updateLastLogin($customerId)
    {
        return $this->update($customerId, ['last_login' => time()]);
    }

    public function isComplete($customer)
    {
        if (!$customer) return false;
        return !empty($customer['firstname']) && !empty($customer['lastname']);
    }
}
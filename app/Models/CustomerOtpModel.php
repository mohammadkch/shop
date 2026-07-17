<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerOtpModel extends Model
{
    protected $table            = 'customer_otp';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mobile', 'otp_code', 'expires_at', 'is_used'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    public function saveOtp($mobile, $otpCode, $expiresAt)
    {
        // ۱. باطل کردن کدهای قبلی با Query Builder مستقیم
        $this->db->table($this->table)
            ->where('mobile', $mobile)
            ->where('is_used', 0)
            ->update(['is_used' => 1]);

        // ۲. درج کد جدید - فقط فیلدهای مشخص شده
        $data = [
            'mobile'     => $mobile,
            'otp_code'   => $otpCode,
            'expires_at' => $expiresAt,
            'is_used'    => 0
        ];

        return $this->db->table($this->table)->insert($data);
    }

    public function getValidOtp($mobile, $otpCode)
    {
        $now = time();
        return $this->db->table($this->table)
            ->where('mobile', $mobile)
            ->where('otp_code', $otpCode)
            ->where('is_used', 0)
            ->where('expires_at >', $now)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();
    }

    public function markAsUsed($otpId)
    {
        return $this->db->table($this->table)
            ->where('id', $otpId)
            ->update(['is_used' => 1]);
    }

    public function invalidateOldOtps($mobile)
    {
        return $this->db->table($this->table)
            ->where('mobile', $mobile)
            ->where('is_used', 0)
            ->update(['is_used' => 1]);
    }

    public function cleanExpiredOtps()
    {
        $now = time();
        return $this->db->table($this->table)
            ->where('expires_at <', $now)
            ->delete();
    }

    public function getLastValidOtp($mobile)
    {
        $now = time();
        return $this->db->table($this->table)
            ->where('mobile', $mobile)
            ->where('is_used', 0)
            ->where('expires_at >', $now)  // فقط کدهای معتبر
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();
    }
}
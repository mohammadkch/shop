<?php

namespace App\Services;

use App\Models\CustomerOtpModel;

class OtpService
{
    protected $otpModel;

    public function __construct()
    {
        $this->otpModel = new CustomerOtpModel();
    }

    /**
     * تولید کد ۵ رقمی تصادفی
     */
    public function generateCode(): string
    {
        return str_pad((string) random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * ذخیره کد OTP برای شماره موبایل
     * @return int|false ID رکورد ذخیره شده یا false در صورت خطا
     */
    public function store($mobile)
    {
        // ۱. تولید کد
        $otpCode = $this->generateCode();

        // ۲. زمان انقضا (۲ دقیقه بعد)
        $expiresAt = time() + 120;

        // ۳. ذخیره در دیتابیس (قبلی‌ها باطل میشن)
        $insertId = $this->otpModel->saveOtp($mobile, $otpCode, $expiresAt);

        // ۴. پاک کردن کدهای منقضی شده
        $this->otpModel->cleanExpiredOtps();

        return [
            'otp_id'    => $insertId,
            'otp_code'  => $otpCode,
            'expires_at' => $expiresAt
        ];
    }

    /**
     * اعتبارسنجی کد OTP
     * @return array|false در صورت معتبر بودن، اطلاعات کد رو برمی‌گردونه
     */
    public function verify($mobile, $otpCode)
    {
        $record = $this->otpModel->getValidOtp($mobile, $otpCode);

        if (!$record) {
            return false;
        }

        // علامت زدن به عنوان استفاده شده
        $this->otpModel->markAsUsed($record['id']);

        return $record;
    }

    public function resend($mobile)
    {
        // ۱. آخرین کد معتبر را پیدا کن
        $lastOtp = $this->otpModel->getLastValidOtp($mobile);

        // ۲. اگر کد معتبر وجود دارد
        if ($lastOtp && $lastOtp['expires_at'] > time()) {
            return [
                'otp_id'      => $lastOtp['id'],
                'otp_code'    => $lastOtp['otp_code'],
                'expires_at'  => $lastOtp['expires_at'],
                'is_new_code' => false,
                'message'     => 'کد قبلی هنوز معتبر است'
            ];
        }

        // ۳. اگر کد معتبری وجود ندارد → کد جدید بساز
        return $this->store($mobile);
    }

    public function invalidateOld($mobile)
    {
        return $this->otpModel->invalidateOldOtps($mobile);
    }

    public function cleanExpired()
    {
        return $this->otpModel->cleanExpiredOtps();
    }

    public function getLogMessage($mobile, $otpCode)
    {
        return "🔐 کد تایید برای {$mobile}: {$otpCode} (معتبر تا ۲ دقیقه)";
    }

    /**
     * گرفتن آخرین کد معتبر برای یک موبایل (بدون ساخت کد جدید)
     * @return array|null
     */
    public function getValidOtp($mobile)
    {
        return $this->otpModel->getLastValidOtp($mobile);
    }
}
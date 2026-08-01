<?php

namespace App\Contracts;

interface SmsProviderInterface
{
    /**
     * @return array{success: bool, message: string, message_id: int|string|null, cost: float|int|null}
     */
    public function sendOtp(string $mobile, string $code): array;
}

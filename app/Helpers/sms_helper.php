<?php

use App\Contracts\SmsProviderInterface;

if (! function_exists('send_otp_sms')) {
    /**
     * @return array{success: bool, message: string, message_id: int|string|null, cost: float|int|null}
     */
    function send_otp_sms(string $mobile, string $code): array
    {
        /** @var SmsProviderInterface $provider */
        $provider = service('smsProvider');

        return $provider->sendOtp($mobile, $code);
    }
}

<?php

namespace App\Libraries\Sms;

use App\Contracts\SmsProviderInterface;
use Config\Sms;

class LogSmsProvider implements SmsProviderInterface
{
    public function __construct(private readonly Sms $config)
    {
    }

    public function sendOtp(string $mobile, string $code): array
    {
        if (ENVIRONMENT !== 'production' && $this->config->logOtpInDevelopment) {
            log_message('debug', 'Development OTP for {mobile}: {code}', [
                'mobile' => $this->maskMobile($mobile),
                'code' => $code,
            ]);
        }

        return [
            'success' => true,
            'message' => 'OTP accepted by development provider',
            'message_id' => null,
            'cost' => null,
        ];
    }

    private function maskMobile(string $mobile): string
    {
        return strlen($mobile) === 11
            ? substr($mobile, 0, 4) . '*****' . substr($mobile, -2)
            : '[masked]';
    }
}

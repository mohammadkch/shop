<?php

namespace App\Libraries\Sms;

use App\Contracts\SmsProviderInterface;
use Config\Sms;
use Config\Services;
use Throwable;

class SmsIrProvider implements SmsProviderInterface
{
    private readonly SmsAuditLogger $audit;

    public function __construct(private readonly Sms $config, ?SmsAuditLogger $audit = null)
    {
        $this->audit = $audit ?? new SmsAuditLogger($config->auditLog);
    }

    public function sendOtp(string $mobile, string $code): array
    {
        $requestId = bin2hex(random_bytes(6));
        $normalizedMobile = $this->normalizeMobile($mobile);

        if ($this->config->apiKey === '' || $this->config->templateId <= 0 || $this->config->otpParameterName === '') {
            $this->audit->write('configuration_failed', [
                'request_id' => $requestId,
                'error' => 'incomplete_configuration',
            ]);
            log_message('error', 'SMS.ir configuration is incomplete.');
            return $this->failure();
        }

        if ($normalizedMobile === null) {
            $this->audit->write('validation_failed', [
                'request_id' => $requestId,
                'mobile_masked' => $this->maskMobile($mobile),
                'error' => 'invalid_mobile',
            ]);
            log_message('warning', 'SMS.ir request rejected because the mobile number is invalid.');
            return $this->failure();
        }

        if ($code === '' || mb_strlen($code) > 25) {
            $this->audit->write('validation_failed', [
                'request_id' => $requestId,
                'mobile_masked' => $this->maskMobile($normalizedMobile),
                'error' => 'invalid_otp_value',
                'code_length' => mb_strlen($code),
            ]);
            log_message('warning', 'SMS.ir request rejected because the OTP value is invalid.');
            return $this->failure();
        }

        $this->audit->write('request_started', [
            'request_id' => $requestId,
            'mobile_masked' => $this->maskMobile($normalizedMobile),
            'mobile_format' => 'smsir-9xxxxxxxxx',
            'template_id' => $this->config->templateId,
            'parameter_name' => $this->config->otpParameterName,
            'endpoint' => $this->config->baseUrl . '/v1/send/verify',
            'code_length' => mb_strlen($code),
        ]);

        try {
            $response = Services::curlrequest()->request('POST', $this->config->baseUrl . '/v1/send/verify', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-API-KEY' => $this->config->apiKey,
                ],
                'json' => [
                    'mobile' => $normalizedMobile,
                    'templateId' => $this->config->templateId,
                    'parameters' => [[
                        'name' => $this->config->otpParameterName,
                        'value' => $code,
                    ]],
                ],
                'timeout' => $this->config->timeout,
                'connect_timeout' => min(5, $this->config->timeout),
                'http_errors' => false,
            ]);
        } catch (Throwable $exception) {
            $this->audit->write('connection_failed', [
                'request_id' => $requestId,
                'exception' => $exception::class,
                'error' => 'connection_or_timeout',
            ]);
            log_message('error', 'SMS.ir connection failed: {exception}', [
                'exception' => $exception::class,
            ]);
            return $this->failure();
        }

        $httpStatus = $response->getStatusCode();
        if ($httpStatus !== 200) {
            $this->audit->write('http_failed', [
                'request_id' => $requestId,
                'http_status' => $httpStatus,
                'error' => 'unsuccessful_http_status',
            ]);
            log_message('error', 'SMS.ir returned an unsuccessful HTTP status: {status}', [
                'status' => $httpStatus,
            ]);
            return $this->failure();
        }

        try {
            $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            $this->audit->write('response_failed', [
                'request_id' => $requestId,
                'http_status' => $httpStatus,
                'error' => 'invalid_json',
            ]);
            log_message('error', 'SMS.ir returned an invalid JSON response.');
            return $this->failure();
        }

        $messageId = $payload['data']['messageId'] ?? null;
        if (($payload['status'] ?? null) !== 1 || $messageId === null || $messageId === '') {
            $this->audit->write('provider_rejected', [
                'request_id' => $requestId,
                'http_status' => $httpStatus,
                'provider_status' => $payload['status'] ?? null,
                'provider_message' => $this->safeProviderMessage($payload['message'] ?? null),
                'error' => 'unsuccessful_provider_response',
            ]);
            log_message('error', 'SMS.ir returned an unsuccessful provider response.');
            return $this->failure();
        }

        $this->audit->write('provider_accepted', [
            'request_id' => $requestId,
            'mobile_masked' => $this->maskMobile($normalizedMobile),
            'http_status' => $httpStatus,
            'provider_status' => $payload['status'],
            'provider_message' => $this->safeProviderMessage($payload['message'] ?? null),
            'message_id' => $messageId,
            'cost' => $payload['data']['cost'] ?? null,
        ]);

        return [
            'success' => true,
            'message' => 'OTP sent successfully',
            'message_id' => $messageId,
            'cost' => $payload['data']['cost'] ?? null,
        ];
    }

    private function normalizeMobile(string $mobile): ?string
    {
        $mobile = preg_replace('/[^0-9+]/', '', trim($mobile)) ?? '';

        if (str_starts_with($mobile, '+98')) {
            $mobile = substr($mobile, 3);
        } elseif (str_starts_with($mobile, '0098')) {
            $mobile = substr($mobile, 4);
        } elseif (str_starts_with($mobile, '98')) {
            $mobile = substr($mobile, 2);
        } elseif (str_starts_with($mobile, '0')) {
            $mobile = substr($mobile, 1);
        }

        return preg_match('/^9[0-9]{9}$/', $mobile) === 1 ? $mobile : null;
    }

    private function failure(): array
    {
        return [
            'success' => false,
            'message' => 'SMS provider error',
            'message_id' => null,
            'cost' => null,
        ];
    }

    private function maskMobile(string $mobile): string
    {
        $digits = preg_replace('/\D/', '', $mobile) ?? '';

        return strlen($digits) >= 10
            ? substr($digits, 0, 3) . '*****' . substr($digits, -2)
            : '[masked]';
    }

    private function safeProviderMessage(mixed $message): ?string
    {
        if (! is_string($message)) {
            return null;
        }

        return mb_substr(strip_tags($message), 0, 200);
    }
}

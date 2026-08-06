<?php

namespace App\Libraries\Payment;

use App\Contracts\PaymentGatewayInterface;
use Config\Zibal;
use Throwable;

class ZibalGateway implements PaymentGatewayInterface
{
    public function __construct(private readonly Zibal $config)
    {
    }

    public function request(array $payment): array
    {
        return $this->post('/v1/request', [
            'merchant' => $this->config->merchant,
            'amount' => (int) $payment['amount'],
            'callbackUrl' => (string) $payment['callback_url'],
            'orderId' => (string) $payment['order_id'],
            'mobile' => (string) ($payment['mobile'] ?? ''),
            'description' => (string) ($payment['description'] ?? ''),
        ]);
    }

    public function verify(string $trackId): array
    {
        return $this->post('/v1/verify', [
            'merchant' => $this->config->merchant,
            'trackId' => (int) $trackId,
        ]);
    }

    public function inquiry(string $trackId): array
    {
        return $this->post('/v1/inquiry', [
            'merchant' => $this->config->merchant,
            'trackId' => (int) $trackId,
        ]);
    }

    public function paymentUrl(string $trackId): string
    {
        return $this->config->baseUrl . '/start/' . rawurlencode($trackId);
    }

    private function post(string $path, array $payload): array
    {
        if ($this->config->merchant === '') {
            return $this->failure('تنظیمات درگاه زیبال کامل نیست.');
        }

        try {
            $response = service('curlrequest')->post($this->config->baseUrl . $path, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
                'timeout' => $this->config->timeout,
                'connect_timeout' => min(5, $this->config->timeout),
                'http_errors' => false,
            ]);
        } catch (Throwable $exception) {
            log_message('error', 'Zibal connection failed: {exception}', ['exception' => $exception::class]);
            return $this->failure('ارتباط با درگاه پرداخت برقرار نشد.');
        }

        if ($response->getStatusCode() !== 200) {
            log_message('error', 'Zibal returned HTTP status {status}.', ['status' => $response->getStatusCode()]);
            return $this->failure('درگاه پرداخت پاسخ معتبری نداد.');
        }

        $data = json_decode((string) $response->getBody(), true);
        if (!is_array($data)) {
            return $this->failure('پاسخ درگاه پرداخت قابل پردازش نیست.');
        }

        $data['transport_success'] = true;
        return $data;
    }

    private function failure(string $message): array
    {
        return [
            'transport_success' => false,
            'result' => null,
            'message' => $message,
        ];
    }
}

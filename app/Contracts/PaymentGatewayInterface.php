<?php

namespace App\Contracts;

interface PaymentGatewayInterface
{
    public function request(array $payment): array;

    public function verify(string $trackId): array;

    public function inquiry(string $trackId): array;

    public function paymentUrl(string $trackId): string;
}

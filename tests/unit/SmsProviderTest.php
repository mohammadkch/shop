<?php

namespace Tests\Unit;

use App\Libraries\Sms\LogSmsProvider;
use App\Libraries\Sms\SmsIrProvider;
use Config\Sms;
use PHPUnit\Framework\TestCase;

final class SmsProviderTest extends TestCase
{
    public function testSmsIrFailsSafelyWhenConfigurationIsMissing(): void
    {
        $config = new Sms();
        $config->apiKey = '';
        $config->templateId = 0;

        $result = (new SmsIrProvider($config))->sendOtp('09123456789', '12345');

        self::assertFalse($result['success']);
        self::assertSame('SMS provider error', $result['message']);
        self::assertNull($result['message_id']);
        self::assertNull($result['cost']);
    }

    public function testSmsIrRejectsInvalidMobileWithoutSendingRequest(): void
    {
        $config = new Sms();
        $config->apiKey = 'test-key';
        $config->templateId = 123;

        $result = (new SmsIrProvider($config))->sendOtp('1234', '12345');

        self::assertFalse($result['success']);
    }

    public function testDevelopmentProviderReturnsTheStandardShape(): void
    {
        $config = new Sms();
        $config->logOtpInDevelopment = false;

        $result = (new LogSmsProvider($config))->sendOtp('09123456789', '12345');

        self::assertTrue($result['success']);
        self::assertArrayHasKey('message_id', $result);
        self::assertArrayHasKey('cost', $result);
    }
}

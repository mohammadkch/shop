<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Sms extends BaseConfig
{
    public bool $enabled = false;
    public string $provider = 'log';
    public string $apiKey = '';
    public int $templateId = 0;
    public string $otpParameterName = 'Code';
    public string $baseUrl = 'https://api.sms.ir';
    public int $timeout = 10;
    public bool $auditLog = true;
    public bool $logOtpInDevelopment = false;

    public function __construct()
    {
        parent::__construct();

        $this->enabled = $this->envBool('sms.enabled', $this->enabled);
        $this->provider = strtolower(trim((string) env('sms.provider', $this->provider)));
        $this->apiKey = trim((string) env('sms.smsir.apiKey', ''));
        $this->templateId = max(0, (int) env('sms.smsir.templateId', 0));
        $this->otpParameterName = trim((string) env('sms.smsir.otpParameterName', $this->otpParameterName));
        $this->baseUrl = rtrim(trim((string) env('sms.smsir.baseUrl', $this->baseUrl)), '/');
        $this->timeout = max(1, (int) env('sms.smsir.timeout', $this->timeout));
        $this->auditLog = $this->envBool('sms.auditLog', true);
        $this->logOtpInDevelopment = $this->envBool('sms.logOtpInDevelopment', false);
    }

    private function envBool(string $key, bool $default): bool
    {
        $value = env($key, $default);
        $parsed = filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);

        return $parsed ?? $default;
    }
}

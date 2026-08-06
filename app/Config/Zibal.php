<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Zibal extends BaseConfig
{
    public string $merchant = '';
    public string $baseUrl = 'https://gateway.zibal.ir';
    public string $callbackUrl = '';
    public int $timeout = 15;

    public function __construct()
    {
        parent::__construct();

        $defaultMerchant = ENVIRONMENT === 'production' ? '' : 'zibal';
        $this->merchant = trim((string) env('zibal.merchant', $defaultMerchant));
        $this->baseUrl = rtrim(trim((string) env('zibal.baseUrl', $this->baseUrl)), '/');
        $this->callbackUrl = trim((string) env('zibal.callbackUrl', ''));
        $this->timeout = max(3, (int) env('zibal.timeout', $this->timeout));
    }
}

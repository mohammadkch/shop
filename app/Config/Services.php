<?php

namespace Config;

use App\Libraries\AdminAuthLib;
use App\Libraries\CustomerAuthLib;
use App\Libraries\UrlLib;
use App\Libraries\Sms\LogSmsProvider;
use App\Libraries\Sms\SmsIrProvider;
use App\Libraries\Payment\ZibalGateway;
use App\Services\AddressService;
use App\Services\MenuService;
use App\Services\PaymentService;
use App\Services\ShippingService;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function adminAuth($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('adminAuth');
        }
        return new AdminAuthLib();
    }

    public static function url($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('url');
        }
        return new UrlLib();
    }

    public static function menuService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('menuService');
        }

        return new MenuService();
    }

    public static function productService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('productService');
        }
        return new \App\Services\ProductService();
    }

    public static function cartService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('cartService');
        }
        return new \App\Services\CartService();
    }


    public static function breadcrumbService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('breadcrumbService');
        }
        return new \App\Services\BreadcrumbService();
    }

    public static function categoryService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('categoryService');
        }
        return new \App\Services\CategoryService();
    }

    public static function searchService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('searchService');
        }

        return new \App\Services\SearchService([
            new \App\Services\Search\ProductSearchProvider(),
            new \App\Services\Search\ArticleSearchProvider(),
            new \App\Services\Search\CategorySearchProvider(),
        ]);
    }

    public static function homeService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('homeService');
        }
        return new \App\Services\HomeService();
    }

    public static function otpService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('otpService');
        }
        return new \App\Services\OtpService();
    }

    public static function smsProvider($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('smsProvider');
        }

        $config = config('Sms');

        if (! $config->enabled || $config->provider === 'log') {
            return new LogSmsProvider($config);
        }

        if ($config->provider === 'smsir') {
            return new SmsIrProvider($config);
        }

        throw new \RuntimeException('Unsupported SMS provider.');
    }

    public static function customerAuth($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('customerAuth');
        }
        return new CustomerAuthLib();
    }

    public static function addressService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('addressService');
        }
        return new AddressService();
    }

    public static function shippingService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('shippingService');
        }
        return new ShippingService();
    }

    public static function paymentGateway($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('paymentGateway');
        }

        return new ZibalGateway(config('Zibal'));
    }

    public static function paymentService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('paymentService');
        }

        return new PaymentService(static::paymentGateway(), static::cartService());
    }


}

<?php

namespace App\Filters;

use \CodeIgniter\Filters\FilterInterface;
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;


class UrlFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $titles = [
            '/' => 'صفحه اصلی | فروشگاه momo',
            'home' => 'صفحه اصلی | فروشگاه momo',
            'product/show' => 'جزئیات محصول | فروشگاه momo',
            'category/index' => 'محصولات | فروشگاه momo',
            'contact/index' => 'تماس با ما | فروشگاه momo',
            'about/index' => 'درباره ما | فروشگاه momo',
            'faq/index' => 'سوالات پرتکرار | فروشگاه momo',
            'customer-support/index' => 'پشتیبانی مشتریان | فروشگاه momo',
            'auth/login' => 'ورود | فروشگاه momo',
            'customer/dashboard/index' => 'پیشخوان کاربری | فروشگاه momo',
            'customer/profile/index' => 'پروفایل کاربر | فروشگاه momo',
            'cart/index' => 'سبد خرید | فروشگاه momo',
            'cart/proceed-to-checkout' => '',
            'checkout/shipping' => '',
            'blog/index' => 'مجله مد و پوشاک | فروشگاه momo',
            'blog/show' => 'مقاله | فروشگاه momo',
        ];

        $url = service('url');
        $router = service('router');

        $controllerName = $router->controllerName(); // \App\Controllers\Customer\Dashboard
        $methodName = $router->methodName();          // index  <-- این خط جا افتاده بود

        $normalized = str_replace('\\', '/', ltrim($controllerName, '\\'));
        $relativePath = preg_replace('#^App/Controllers/#i', '', $normalized);
        $relativePath = strtolower($relativePath); // customer/dashboard

        $fullRoute = $relativePath . '/' . $methodName; // customer/dashboard/index

        $title = $titles[$fullRoute] ?? 'فروشگاه momo';

//        echo '<pre>';
//        print_r($controllerName); echo '<br>';
//        print_r($relativePath); echo '<br>';
//        print_r($methodName); echo '<br>';
//        print_r($fullRoute); echo '<br>';
//        print_r($title); echo '<br>';
//        exit();


        $url->setControllerName($controllerName);
        $url->setClassName($relativePath);
        $url->setMethodName($methodName);
        $url->setTitle($title);

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}

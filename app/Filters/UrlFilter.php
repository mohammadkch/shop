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
            'home/index' => 'صفحه اصلی | فروشگاه لباس',
            'product/index' => 'محصولات | فروشگاه لباس',
            'product/show' => 'جزئیات محصول | فروشگاه لباس',
            'category/index' => 'دسته‌بندی | فروشگاه لباس',
            'cart/index' => 'سبد خرید | فروشگاه لباس',
            'checkout/index' => 'تسویه حساب | فروشگاه لباس',
            'blog/index' => 'وبلاگ | فروشگاه لباس',
            'contact/index' => 'تماس با ما | فروشگاه لباس',
            'about/index' => 'درباره ما | فروشگاه لباس',
            'auth/login' => 'ورود | فروشگاه لباس',
            'auth/register' => 'ثبت نام | فروشگاه لباس',
        ];

        $url = service('Url');
        $router = service('router');




        $controllerName = $router->controllerName();
        $className = str_replace('_', '-', strtolower(basename(str_replace('\\', '/', $controllerName))));
        $methodName = $router->methodName();
        $fullRoute = $className . '/' . $methodName;
        $title = $titles[$fullRoute] ?? 'فروشگاه لباس';

        $url->setControllerName($controllerName);
        $url->setClassName($className);
        $url->setMethodName($methodName);
        $url->setTitle($title);

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
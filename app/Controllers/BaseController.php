<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{

    protected $helpers = ['html', 'flash', 'product'];
    protected $viewPath = '';
    protected $viewData;
    protected $auth;
    protected $urlLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {

        parent::initController($request, $response, $logger);
        $this->urlLib = service('Url');
        $this->auth = service('customerAuth');
        $menuService = service('menuService');

        $scriptMap = [
            'category' => ['category'],
            'product'  => ['product', 'cart'],
            'cart'     => ['cart'],
            'home'     => ['home'],
            'checkout' => ['checkout'],
            'customer/dashboard' => ['customer'],
            'customer/profile' => ['customer'],
            'customer/wishlist' => ['customer'],
        ];

        $className = $this->urlLib->getClassName();
        $this->viewData['controllerScripts'] = $scriptMap[$className] ?? [];

        if (!$request->isAJAX()) {
            $this->viewData['shopMenus'] = $menuService->getShopMenus();
        }

        $this->viewData['assetsPath'] = base_url('assets/');
        $this->viewData['mediaPath'] = base_url('images/');


        $this->viewData['className'] = $this->urlLib->getClassName();
        $this->viewData['controllerName'] = $this->urlLib->getControllerName();
        $this->viewData['methodName'] = $this->urlLib->getMethodName();
        $this->viewData['title'] = $this->urlLib->getTitle();

        // ===================================================
        // اضافه کردن دیتای لاگین کاربر به همه صفحات
        // ===================================================

        $isLoggedIn = $this->auth->isLoggedIn();
        $customer = null;
        $customerName = '';
        $isProfileComplete = false;

        if ($isLoggedIn) {
            $customer = $this->auth->getCustomer();
            $customerName = $this->auth->getName();
            $isProfileComplete = $this->auth->hasMinimunProfile();
        }

        $this->viewData['isLoggedIn'] = $isLoggedIn;
        $this->viewData['customer'] = $customer;
        $this->viewData['customerName'] = $customerName;
        $this->viewData['isProfileComplete'] = $isProfileComplete;
    }
    protected function flash($key, $customMessage = null)
    {
        setFlash($key, $customMessage);
    }


}

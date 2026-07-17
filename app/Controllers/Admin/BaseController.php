<?php

namespace App\Controllers\Admin;

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
    protected $helpers = ['flash', 'html', 'rowset'];
    protected $viewPath = 'admin/';
    protected $viewData;
    protected $authLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {

        parent::initController($request, $response, $logger);
        helper('html');
        helper('rowset');
        $this->authLib = service('adminAuth');

        $this->viewData['assetsPath'] = base_url('assets/');

        $this->viewData['className'] = $this->authLib->getClassName();
        $this->viewData['controllerName'] = $this->authLib->getControllerName() ;
        $this->viewData['methodName'] = $this->authLib->getMethodName();
        $this->viewData['title'] = $this->authLib->getTitle();
        $this->viewData['full_name'] = $this->authLib->getLoginData('full_name');
        $this->viewData['avatar'] = $this->authLib->getLoginData('avatar');
        $this->viewData['role'] = $this->authLib->getLoginData('role');
    }

    protected function flash($key, $customMessage = null)
    {
        setFlash($key, $customMessage);
    }

}

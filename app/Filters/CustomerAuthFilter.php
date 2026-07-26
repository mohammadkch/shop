<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CustomerAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service('customerAuth');

        if (!$auth->isLoggedIn()) {
            return redirect()->to('/login');
        }

        // چک کردن اینکه کاربر غیرفعال نباشه
        $customer = $auth->getCustomer();
        if (!$customer || $customer['is_active'] != 1) {
            $auth->logout();

            return redirect()->to('/login');
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // کاری نداریم
    }
}
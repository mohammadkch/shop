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
            $session = session();

            $currentUrl = current_url(true);
            $returnUrl = $currentUrl->getPath();

            if ($currentUrl->getQuery()) {
                $returnUrl .= '?' . $currentUrl->getQuery();
            }

            $session->set('return_url', $returnUrl);

            return redirect()->to('/login');
        }

        // چک کردن اینکه کاربر غیرفعال نباشه
        $customer = $auth->getCustomer();
        if (!$customer || $customer['is_active'] != 1) {
            $auth->logout();
            return redirect()->to('/login')->with('error', 'حساب کاربری شما غیرفعال است');
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // کاری نداریم
    }
}
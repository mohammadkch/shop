<?php

namespace App\Controllers;

class Payment extends BaseController
{
    public function __construct()
    {
        helper(['menu']);
    }

    public function start(int $factorId)
    {
        $customerId = (int) service('customerAuth')->getCustomerId();
        $result = service('paymentService')->start($factorId, $customerId);

        if (($result['success'] ?? false) === true) {
            return redirect()->to($result['redirect_url']);
        }

        $this->flash('payment_start_error', $result['message'] ?? 'شروع پرداخت انجام نشد.');
        if (($result['reason'] ?? '') === 'cart_review' || ($result['reason'] ?? '') === 'cart') {
            return redirect()->to('cart');
        }

        return redirect()->to('checkout/payment/' . $factorId);
    }

    public function callback()
    {
        $result = service('paymentService')->handleCallback($this->request->getGet());
        $payment = $result['payment'] ?? null;
        $factor = $payment
            ? model('App\Models\FactorModel')->find($payment['factor_id'])
            : null;

        $data = $this->viewData + [
            'title' => ($result['success'] ?? false) ? 'پرداخت موفق' : 'پرداخت ناموفق',
            'result' => $result,
            'payment' => $payment,
            'factor' => $factor,
        ];

        return view(
            ($result['success'] ?? false) ? 'checkout/payment_success' : 'checkout/payment_failed',
            $data
        );
    }
}

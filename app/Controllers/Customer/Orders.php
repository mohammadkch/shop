<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\FactorModel;

class Orders extends BaseController
{
    private const CUSTOMER_ORDER_STATUSES = [
        'paid',
        'confirmed',
        'paid_stock_issue',
    ];

    protected CustomerModel $customerModel;
    protected FactorModel $factorModel;

    public function __construct()
    {
        helper(['menu', 'jalali']);
        $this->customerModel = new CustomerModel();
        $this->factorModel = new FactorModel();
    }

    public function index()
    {
        $customerId = (int) $this->auth->getCustomerId();
        $customer = $this->customerModel->find($customerId);

        if (!$customer) {
            return redirect()->to('/logout');
        }

        $orders = $this->factorModel
            ->select('factor.*')
            ->select('(
                SELECT COALESCE(SUM(factor_order_item.quantity), 0)
                FROM factor_item AS factor_order_item
                WHERE factor_order_item.factor_id = factor.id
            ) AS items_count', false)
            ->where('factor.customer_id', $customerId)
            ->whereIn('factor.status', self::CUSTOMER_ORDER_STATUSES)
            ->orderBy('factor.id', 'DESC')
            ->findAll();

        $this->viewData['customer'] = $customer;
        $this->viewData['orders'] = $orders;
        $this->viewData['title'] = 'سفارش‌های من';

        return view('customer/orders/index', $this->viewData);
    }
}

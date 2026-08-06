<?php

namespace App\Controllers\Admin;

class Order extends BaseController
{
    private const STATUSES = [
        'awaiting_payment', 'payment_pending', 'paid', 'paid_stock_issue',
        'confirmed', 'expired', 'cancelled',
    ];

    public function index()
    {
        $status = (string) $this->request->getGet('status');
        $builder = model('App\Models\FactorModel')
            ->select('factor.*, customer.firstname, customer.lastname, customer.mobile')
            ->join('customer', 'customer.id = factor.customer_id')
            ->orderBy('factor.id', 'DESC');
        if (in_array($status, self::STATUSES, true)) {
            $builder->where('factor.status', $status);
        }

        $this->viewData['orders'] = $builder->findAll(100);
        $this->viewData['selected_status'] = $status;
        $this->viewData['statuses'] = self::STATUSES;
        $this->viewData['title'] = 'مدیریت سفارش‌ها';
        return view('admin/order/index', $this->viewData);
    }

    public function show(int $id)
    {
        $rows = model('App\Models\FactorModel')->getData(['id' => $id]);
        if (!$rows) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->viewData['order'] = $rows[0];
        $this->viewData['items'] = model('App\Models\FactorItemModel')->getItemsByFactorId($id);
        $this->viewData['payments'] = model('App\Models\PaymentModel')
            ->where('factor_id', $id)->orderBy('id', 'DESC')->findAll();
        $this->viewData['title'] = 'جزئیات سفارش ' . $id;
        return view('admin/order/show', $this->viewData);
    }

    public function confirm(int $id)
    {
        $db = db_connect();
        $db->transBegin();
        $order = $db->query('SELECT * FROM factor WHERE id = ? FOR UPDATE', [$id])->getRowArray();
        if (!$order || $order['status'] !== 'paid') {
            $db->transRollback();
            return redirect()->to(ADMIN_PATH . '/order/' . $id)
                ->with('error', 'فقط سفارش پرداخت‌شده قابل تأیید است.');
        }

        model('App\Models\FactorModel')->update($id, ['status' => 'confirmed']);
        if (!$db->transStatus()) {
            $db->transRollback();
            return redirect()->to(ADMIN_PATH . '/order/' . $id)
                ->with('error', 'تأیید سفارش انجام نشد.');
        }
        $db->transCommit();

        return redirect()->to(ADMIN_PATH . '/order/' . $id)
            ->with('success', 'سفارش با موفقیت تأیید شد.');
    }
}

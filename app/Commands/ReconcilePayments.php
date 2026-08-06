<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ReconcilePayments extends BaseCommand
{
    protected $group = 'Payment';
    protected $name = 'payment:reconcile';
    protected $description = 'Reconciles pending Zibal payments using the inquiry endpoint.';

    public function run(array $params)
    {
        $limit = isset($params[0]) ? max(1, min(500, (int) $params[0])) : 50;
        $result = service('paymentService')->reconcilePending($limit);

        CLI::write(sprintf(
            'Checked: %d | Paid: %d | Failed: %d | Still pending: %d',
            $result['checked'],
            $result['paid'],
            $result['failed'],
            $result['pending']
        ), 'green');
    }
}

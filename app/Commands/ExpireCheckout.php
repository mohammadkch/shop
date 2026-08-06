<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ExpireCheckout extends BaseCommand
{
    protected $group = 'Checkout';
    protected $name = 'checkout:expire';
    protected $description = 'Marks abandoned factors and their unfinished payments as expired.';

    public function run(array $params)
    {
        $now = time();
        $factorModel = model('App\Models\FactorModel');
        $factors = $factorModel->select('id')
            ->where('status', 'awaiting_payment')
            ->where('expires_at <=', $now)
            ->findAll();

        if (!$factors) {
            CLI::write('No expired checkout found.', 'green');
            return;
        }

        $factorIds = array_map('intval', array_column($factors, 'id'));
        $db = db_connect();
        $db->transStart();

        model('App\Models\PaymentModel')->whereIn('factor_id', $factorIds)
            ->whereIn('status', ['created', 'pending'])
            ->set(['status' => 'expired'])
            ->update();
        $factorModel->whereIn('id', $factorIds)
            ->set(['status' => 'expired'])
            ->update();

        $db->transComplete();
        if (!$db->transStatus()) {
            CLI::error('Checkout expiration failed.');
            return;
        }

        CLI::write(count($factorIds) . ' checkout(s) expired.', 'green');
    }
}

<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use App\Models\FactorItemModel;
use App\Models\FactorModel;
use App\Models\PaymentModel;
use Throwable;

class PaymentService
{
    private FactorModel $factorModel;
    private FactorItemModel $factorItemModel;
    private PaymentModel $paymentModel;

    public function __construct(
        private readonly PaymentGatewayInterface $gateway,
        private readonly CartService $cartService
    ) {
        $this->factorModel = new FactorModel();
        $this->factorItemModel = new FactorItemModel();
        $this->paymentModel = new PaymentModel();
    }

    public function start(int $factorId, int $customerId): array
    {
        $factor = $this->factorModel->find($factorId);
        if (!$factor || (int) $factor['customer_id'] !== $customerId) {
            return $this->error('فاکتور موردنظر پیدا نشد.', 'cart');
        }
        if ($factor['status'] === 'paid' || $factor['status'] === 'confirmed') {
            return $this->error('این فاکتور قبلاً پرداخت شده است.', 'paid');
        }
        if ($factor['status'] === 'payment_pending') {
            $activePayment = $this->paymentModel->where('factor_id', $factorId)
                ->where('status', 'pending')
                ->orderBy('id', 'DESC')
                ->first();
            if ($activePayment && !empty($activePayment['gateway_track_id'])) {
                return [
                    'success' => true,
                    'payment_id' => (int) $activePayment['id'],
                    'redirect_url' => $this->gateway->paymentUrl((string) $activePayment['gateway_track_id']),
                ];
            }
            return $this->error('وضعیت پرداخت قبلی در حال بررسی است. لطفاً چند دقیقه دیگر دوباره تلاش کنید.');
        }
        if ($factor['status'] !== 'awaiting_payment') {
            return $this->error('این فاکتور در حال حاضر قابل پرداخت نیست.', 'cart');
        }
        if ((int) $factor['expires_at'] <= time()) {
            $this->expireFactor($factorId);
            return $this->error('زمان پرداخت این فاکتور به پایان رسیده است.', 'cart');
        }

        $refresh = $this->cartService->refreshPricesAndAvailability();
        if ($refresh['has_unavailable_items']) {
            return $this->error('موجودی یک یا چند محصول کافی نیست. لطفاً سبد خرید را بررسی کنید.', 'cart_review');
        }
        if ($refresh['price_changed'] || !$this->factorMatchesCurrentCart($factor)) {
            return $this->error('قیمت یا محتویات سبد خرید تغییر کرده است. لطفاً دوباره آن را تأیید کنید.', 'cart_review');
        }

        $db = db_connect();
        $db->transBegin();
        try {
            $lockedFactor = $db->query('SELECT * FROM factor WHERE id = ? FOR UPDATE', [$factorId])->getRowArray();
            if (!$lockedFactor || $lockedFactor['status'] !== 'awaiting_payment' || (int) $lockedFactor['expires_at'] <= time()) {
                $db->transRollback();
                return $this->error('این فاکتور دیگر قابل پرداخت نیست.', 'cart');
            }

            $activePayment = $db->query(
                "SELECT * FROM payment WHERE factor_id = ? AND status IN ('created','pending') ORDER BY id DESC LIMIT 1 FOR UPDATE",
                [$factorId]
            )->getRowArray();
            if ($activePayment && $activePayment['status'] === 'pending' && !empty($activePayment['gateway_track_id'])) {
                $db->transCommit();
                return [
                    'success' => true,
                    'payment_id' => (int) $activePayment['id'],
                    'redirect_url' => $this->gateway->paymentUrl((string) $activePayment['gateway_track_id']),
                ];
            }
            if ($activePayment && $activePayment['status'] === 'created' && (int) $activePayment['created_at'] > time() - 120) {
                $db->transRollback();
                return $this->error('درخواست پرداخت در حال ایجاد است. چند لحظه دیگر دوباره تلاش کنید.');
            }
            if ($activePayment && $activePayment['status'] === 'created') {
                $this->paymentModel->update($activePayment['id'], ['status' => 'failed']);
            }

            $orderId = sprintf('MOMO-%d-%s', $factorId, strtoupper(bin2hex(random_bytes(4))));
            $paymentId = $this->paymentModel->insert([
                'factor_id' => $factorId,
                'customer_id' => $customerId,
                'payment_method_id' => 1,
                'gateway' => 'zibal',
                'order_id' => $orderId,
                'final_amount' => $lockedFactor['total'],
                'status' => 'created',
                'expires_at' => $lockedFactor['expires_at'],
            ], true);
            if (!$paymentId || !$db->transStatus()) {
                throw new \RuntimeException('Payment creation failed.');
            }
            $db->transCommit();
            $factor = $lockedFactor;
        } catch (Throwable $exception) {
            $db->transRollback();
            log_message('error', 'Creating payment attempt failed: {exception}', ['exception' => $exception::class]);
            return $this->error('شروع فرایند پرداخت انجام نشد. لطفاً دوباره تلاش کنید.');
        }

        $config = config('Zibal');
        $response = $this->gateway->request([
            'amount' => $this->toRial($factor['total']),
            'callback_url' => $config->callbackUrl !== ''
                ? $config->callbackUrl
                : site_url('checkout/zibal/callback'),
            'order_id' => $orderId,
            'mobile' => service('customerAuth')->getData('mobile'),
            'description' => 'پرداخت فاکتور ' . $factorId . ' فروشگاه مومو',
        ]);

        if (($response['transport_success'] ?? false) !== true || (int) ($response['result'] ?? 0) !== 100 || empty($response['trackId'])) {
            $this->paymentModel->update($paymentId, [
                'status' => 'failed',
                'gateway_result' => $response['result'] ?? null,
                'gateway_message' => $this->safeMessage($response['message'] ?? 'خطا در ایجاد تراکنش'),
            ]);
            return $this->error($this->publicGatewayError($response));
        }

        $trackId = (string) $response['trackId'];
        $db = db_connect();
        $db->transStart();
        $this->paymentModel->update($paymentId, [
            'status' => 'pending',
            'payment_token' => $trackId,
            'gateway_track_id' => $trackId,
            'gateway_result' => (int) $response['result'],
            'gateway_message' => $this->safeMessage($response['message'] ?? null),
        ]);
        $this->factorModel->update($factorId, ['status' => 'payment_pending']);
        $db->transComplete();

        if (!$db->transStatus()) {
            log_message('critical', 'Zibal trackId received but local payment update failed for payment {id}.', ['id' => $paymentId]);
            return $this->error('ثبت اطلاعات درگاه کامل نشد. لطفاً با پشتیبانی تماس بگیرید.');
        }

        return [
            'success' => true,
            'payment_id' => (int) $paymentId,
            'redirect_url' => $this->gateway->paymentUrl($trackId),
        ];
    }

    public function handleCallback(array $query): array
    {
        $trackId = preg_replace('/\D+/', '', (string) ($query['trackId'] ?? ''));
        if ($trackId === '') {
            return $this->result(false, 'اطلاعات بازگشتی درگاه کامل نیست.');
        }

        $payment = $this->paymentModel->where('gateway_track_id', $trackId)->first();
        if (!$payment) {
            return $this->result(false, 'تراکنش موردنظر در مومو پیدا نشد.');
        }
        if ($payment['status'] === 'paid') {
            return $this->successResult($payment, 'پرداخت شما قبلاً با موفقیت ثبت شده است.');
        }

        if ((string) ($query['orderId'] ?? '') !== '' && (string) $query['orderId'] !== (string) $payment['order_id']) {
            return $this->result(false, 'شناسه سفارش بازگشتی معتبر نیست.', $payment);
        }

        if ((int) ($query['success'] ?? 0) !== 1) {
            $inquiry = $this->gateway->inquiry($trackId);
            if ((int) ($inquiry['result'] ?? 0) !== 100) {
                return $this->result(false, 'وضعیت قطعی پرداخت دریافت نشد. تراکنش شما به‌صورت خودکار بررسی خواهد شد.', $payment);
            }

            $status = (int) ($inquiry['status'] ?? 0);
            if (in_array($status, [1, 2], true)) {
                $verification = $status === 2 ? $this->gateway->verify($trackId) : $inquiry;
                if ((int) ($verification['result'] ?? 0) === 201) {
                    $verification = $this->gateway->inquiry($trackId);
                }
                return $this->completeVerifiedPayment($payment, $verification);
            }

            if (in_array($status, [-1, -2], true)) {
                return $this->result(false, 'وضعیت پرداخت هنوز نهایی نشده است و به‌صورت خودکار بررسی خواهد شد.', $payment);
            }

            $this->markFailed($payment, $status === 3 ? 'cancelled' : 'failed', $status, $inquiry['message'] ?? 'پرداخت در درگاه تکمیل نشد.', (int) $inquiry['result']);
            return $this->result(false, $status === 3 ? 'پرداخت توسط شما لغو شد.' : 'پرداخت ناموفق بود.', $payment);
        }

        $verification = $this->gateway->verify($trackId);
        if ((int) ($verification['result'] ?? 0) === 201) {
            $verification = $this->gateway->inquiry($trackId);
        }

        return $this->completeVerifiedPayment($payment, $verification);
    }

    public function reconcilePending(int $limit = 50): array
    {
        $payments = $this->paymentModel->where('status', 'pending')
            ->where('gateway_track_id IS NOT NULL')
            ->orderBy('id', 'ASC')
            ->findAll($limit);
        $result = ['checked' => 0, 'paid' => 0, 'failed' => 0, 'pending' => 0];

        foreach ($payments as $payment) {
            $result['checked']++;
            $inquiry = $this->gateway->inquiry((string) $payment['gateway_track_id']);
            if ((int) ($inquiry['result'] ?? 0) !== 100) {
                $result['pending']++;
                continue;
            }

            $gatewayStatus = (int) ($inquiry['status'] ?? 0);
            if ($gatewayStatus === -1 && (int) $payment['expires_at'] <= time()) {
                $this->expireFactor((int) $payment['factor_id']);
                $result['failed']++;
                continue;
            }
            if ($gatewayStatus === 2) {
                $inquiry = $this->gateway->verify((string) $payment['gateway_track_id']);
                if ((int) ($inquiry['result'] ?? 0) === 201) {
                    $inquiry = $this->gateway->inquiry((string) $payment['gateway_track_id']);
                }
            }

            if (in_array((int) ($inquiry['status'] ?? 0), [1, 2], true)
                && in_array((int) ($inquiry['result'] ?? 0), [100, 201], true)) {
                $completed = $this->completeVerifiedPayment($payment, $inquiry);
                $result[$completed['success'] ? 'paid' : 'pending']++;
            } elseif (in_array($gatewayStatus, [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15, 18, 21], true)) {
                $this->markFailed($payment, $gatewayStatus === 3 ? 'cancelled' : 'failed', $gatewayStatus, $inquiry['message'] ?? null);
                $result['failed']++;
            } else {
                $result['pending']++;
            }
        }

        return $result;
    }

    private function completeVerifiedPayment(array $payment, array $verification): array
    {
        $resultCode = (int) ($verification['result'] ?? 0);
        $gatewayStatus = (int) ($verification['status'] ?? 0);
        if (!in_array($resultCode, [100, 201], true) || !in_array($gatewayStatus, [1, 2], true)) {
            if ($resultCode === 202) {
                $this->markFailed($payment, 'failed', $gatewayStatus, $verification['message'] ?? null, $resultCode);
            }
            return $this->result(false, $this->publicGatewayError($verification), $payment);
        }

        $expectedAmount = $this->toRial($payment['final_amount']);
        if ((int) ($verification['amount'] ?? 0) !== $expectedAmount
            || (!empty($verification['orderId']) && (string) $verification['orderId'] !== (string) $payment['order_id'])) {
            log_message('critical', 'Zibal verified payment data mismatch for payment {id}.', ['id' => $payment['id']]);
            return $this->result(false, 'اطلاعات پرداخت با فاکتور مطابقت ندارد. لطفاً با پشتیبانی تماس بگیرید.', $payment);
        }

        $db = db_connect();
        $db->transBegin();
        try {
            $lockedPayment = $db->query('SELECT * FROM payment WHERE id = ? FOR UPDATE', [$payment['id']])->getRowArray();
            if (!$lockedPayment) {
                throw new \RuntimeException('Payment disappeared during verification.');
            }
            if ($lockedPayment['status'] === 'paid') {
                $db->transCommit();
                return $this->successResult($lockedPayment, 'پرداخت شما قبلاً با موفقیت ثبت شده است.');
            }

            $factor = $db->query('SELECT * FROM factor WHERE id = ? FOR UPDATE', [$lockedPayment['factor_id']])->getRowArray();
            if (!$factor) {
                throw new \RuntimeException('Factor not found during verification.');
            }

            $items = $this->factorItemModel->where('factor_id', $factor['id'])->findAll();
            $stockRows = [];
            $stockIssue = false;
            foreach ($items as $item) {
                $stockRow = $db->query(
                    'SELECT * FROM product_price WHERE product_id = ? AND color_option_id <=> ? AND size_option_id <=> ? ORDER BY is_default DESC, id ASC LIMIT 1 FOR UPDATE',
                    [$item['product_id'], $item['color_option_id'], $item['size_option_id']]
                )->getRowArray();
                if (!$stockRow || (int) $stockRow['stock'] < (int) $item['quantity']) {
                    $stockIssue = true;
                    break;
                }
                $stockRows[] = ['row' => $stockRow, 'quantity' => (int) $item['quantity']];
            }

            if (!$stockIssue) {
                foreach ($stockRows as $stock) {
                    $db->table('product_price')->where('id', $stock['row']['id'])->update([
                        'stock' => (int) $stock['row']['stock'] - $stock['quantity'],
                        'updated_at' => time(),
                    ]);
                }
            }

            $paymentData = $this->verifiedFields($verification) + ['status' => 'paid'];
            $this->paymentModel->update($lockedPayment['id'], $paymentData);
            $this->factorModel->update($factor['id'], [
                'status' => $stockIssue ? 'paid_stock_issue' : 'paid',
            ]);

            if (!$stockIssue) {
                $this->removePurchasedItemsFromCart($factor, $items);
            }

            if (!$db->transStatus()) {
                throw new \RuntimeException('Payment transaction failed.');
            }
            $db->transCommit();

            $freshPayment = $this->paymentModel->find($lockedPayment['id']);
            if ($stockIssue) {
                log_message('critical', 'Paid factor {factorId} needs stock review.', ['factorId' => $factor['id']]);
                return $this->result(true, 'پرداخت ثبت شد؛ سفارش برای بررسی موجودی به پشتیبانی ارجاع شد.', $freshPayment, true);
            }
            return $this->successResult($freshPayment, 'پرداخت شما با موفقیت انجام شد.');
        } catch (Throwable $exception) {
            $db->transRollback();
            log_message('critical', 'Finalizing payment failed: {exception}', ['exception' => $exception::class]);
            return $this->result(false, 'ثبت نهایی پرداخت کامل نشد. لطفاً با پشتیبانی تماس بگیرید.', $payment);
        }
    }

    private function factorMatchesCurrentCart(array $factor): bool
    {
        $cart = $this->cartService->getCart();
        if ((int) $cart['id'] !== (int) $factor['cart_id']) {
            return false;
        }
        $cartItems = $this->cartService->getItems();
        $factorItems = $this->factorItemModel->where('factor_id', $factor['id'])->findAll();
        if (count($cartItems) !== count($factorItems)) {
            return false;
        }

        $cartById = array_column($cartItems, null, 'id');
        foreach ($factorItems as $item) {
            $cartItem = $cartById[$item['cart_item_id']] ?? null;
            if (!$cartItem
                || (int) $cartItem['quantity'] !== (int) $item['quantity']
                || (float) $cartItem['price'] !== (float) $item['price']
                || (float) ($cartItem['sale_price'] ?? 0) !== (float) ($item['sale_price'] ?? 0)) {
                return false;
            }
        }

        return true;
    }

    private function removePurchasedItemsFromCart(array $factor, array $items): void
    {
        $db = db_connect();
        foreach ($items as $item) {
            $cartItem = $db->query(
                'SELECT * FROM cart_item WHERE id = ? AND cart_id = ? FOR UPDATE',
                [$item['cart_item_id'], $factor['cart_id']]
            )->getRowArray();
            if (!$cartItem) {
                continue;
            }
            if ((int) $cartItem['quantity'] <= (int) $item['quantity']) {
                $db->table('cart_item')->where('id', $cartItem['id'])->delete();
            } else {
                $db->table('cart_item')->where('id', $cartItem['id'])->update([
                    'quantity' => (int) $cartItem['quantity'] - (int) $item['quantity'],
                    'updated_at' => time(),
                ]);
            }
        }
    }

    private function markFailed(array $payment, string $status, int $gatewayStatus, ?string $message, ?int $result = null): void
    {
        $db = db_connect();
        $db->transStart();
        $this->paymentModel->update($payment['id'], [
            'status' => $status,
            'gateway_result' => $result,
            'gateway_status' => $gatewayStatus,
            'gateway_message' => $this->safeMessage($message),
        ]);
        $factor = $this->factorModel->find($payment['factor_id']);
        if ($factor && $factor['status'] === 'payment_pending') {
            $this->factorModel->update($factor['id'], [
                'status' => (int) $factor['expires_at'] > time() ? 'awaiting_payment' : 'expired',
            ]);
        }
        $db->transComplete();
    }

    private function expireFactor(int $factorId): void
    {
        $db = db_connect();
        $db->transStart();
        $this->paymentModel->where('factor_id', $factorId)
            ->whereIn('status', ['created', 'pending'])
            ->set(['status' => 'expired'])
            ->update();
        $this->factorModel->update($factorId, ['status' => 'expired']);
        $db->transComplete();
    }

    private function verifiedFields(array $data): array
    {
        return [
            'ref_number' => isset($data['refNumber']) ? (string) $data['refNumber'] : null,
            'card_number' => isset($data['cardNumber']) ? substr((string) $data['cardNumber'], 0, 32) : null,
            'gateway_amount' => isset($data['amount']) ? (int) $data['amount'] : null,
            'gateway_result' => isset($data['result']) ? (int) $data['result'] : null,
            'gateway_status' => isset($data['status']) ? (int) $data['status'] : null,
            'gateway_message' => $this->safeMessage($data['message'] ?? null),
            'paid_at' => $this->timestamp($data['paidAt'] ?? null) ?? time(),
            'verified_at' => $this->timestamp($data['verifiedAt'] ?? null) ?? time(),
        ];
    }

    private function successResult(array $payment, string $message): array
    {
        return $this->result(true, $message, $payment);
    }

    private function result(bool $success, string $message, ?array $payment = null, bool $needsReview = false): array
    {
        return [
            'success' => $success,
            'message' => $message,
            'payment' => $payment,
            'needs_review' => $needsReview,
        ];
    }

    private function error(string $message, string $reason = 'gateway'): array
    {
        return ['success' => false, 'message' => $message, 'reason' => $reason];
    }

    private function toRial($amount): int
    {
        return (int) round((float) $amount * 10);
    }

    private function timestamp($value): ?int
    {
        if (!$value) return null;
        $timestamp = strtotime((string) $value);
        return $timestamp === false ? null : $timestamp;
    }

    private function safeMessage($message): ?string
    {
        if ($message === null || $message === '') return null;
        return mb_substr(trim(strip_tags((string) $message)), 0, 255);
    }

    private function publicGatewayError(array $response): string
    {
        return ($response['transport_success'] ?? true) === false
            ? (string) ($response['message'] ?? 'ارتباط با درگاه پرداخت برقرار نشد.')
            : 'درگاه پرداخت درخواست را نپذیرفت. لطفاً دوباره تلاش کنید.';
    }
}

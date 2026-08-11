<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Models\ProductSlugHistoryModel;
use App\Models\ProductSlugRedirectModel;

class ProductSlug extends BaseController
{
    private ProductModel $productModel;
    private ProductSlugHistoryModel $historyModel;
    private ProductSlugRedirectModel $redirectModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->historyModel = new ProductSlugHistoryModel();
        $this->redirectModel = new ProductSlugRedirectModel();
    }

    public function manage($productId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $history = $this->historyModel
            ->select('product_slug_history.*, product_slug_redirect.id AS redirect_id')
            ->join('product_slug_redirect', 'product_slug_redirect.history_id = product_slug_history.id', 'left')
            ->where('product_slug_history.product_id', $product['id'])
            ->orderBy('product_slug_history.id', 'DESC')
            ->findAll();

        $this->viewData['product'] = $product;
        $this->viewData['history'] = $history;
        $this->viewData['title'] = 'تاریخچه Slug محصول - ' . $product['name'];

        return view('admin/product_slug/manage', $this->viewData);
    }

    public function enable($productId, $historyId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $history = $this->historyModel
            ->where('id', (int) $historyId)
            ->where('product_id', $product['id'])
            ->first();

        if (!$history) {
            return $this->backWithError($product['id'], 'رکورد تاریخچه برای این محصول پیدا نشد.');
        }

        $oldSlug = trim((string) $history['old_slug']);
        if ($oldSlug === '' || $oldSlug === $product['slug']) {
            return $this->backWithError($product['id'], 'Slug قدیمی معتبر نیست یا اکنون Slug اصلی محصول است.');
        }

        if ($this->redirectModel->findForProduct((int) $product['id'], $oldSlug)) {
            return $this->backWithError($product['id'], 'برای این Slug قبلاً Redirect فعال شده است.');
        }

        if (!$this->redirectModel->insert([
            'product_id' => (int) $product['id'],
            'history_id' => (int) $history['id'],
            'old_slug' => $oldSlug,
            'created_at' => time(),
        ])) {
            return $this->backWithError($product['id'], 'فعال‌سازی Redirect انجام نشد.');
        }

        $this->flash('product_update_success', 'Redirect با موفقیت فعال شد و مستقیماً به Slug فعلی محصول می‌رود.');
        return redirect()->to(ADMIN_PATH . '/product-slug/manage/' . $product['id']);
    }

    public function disable($productId, $redirectId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $redirect = $this->redirectModel
            ->where('id', (int) $redirectId)
            ->where('product_id', $product['id'])
            ->first();

        if (!$redirect || !$this->redirectModel->delete($redirect['id'])) {
            return $this->backWithError($product['id'], 'غیرفعال‌سازی Redirect انجام نشد.');
        }

        $this->flash('product_update_success', 'Redirect غیرفعال شد؛ رکورد تاریخچه همچنان محفوظ است.');
        return redirect()->to(ADMIN_PATH . '/product-slug/manage/' . $product['id']);
    }

    private function findProduct(int $productId): ?array
    {
        $product = $productId > 0 ? $this->productModel->find($productId) : null;
        if (!$product) {
            $this->flash('product_update_error', 'محصول مورد نظر یافت نشد.');
            return null;
        }

        return $product;
    }

    private function backWithError(int $productId, string $message)
    {
        $this->flash('product_update_error', $message);
        return redirect()->to(ADMIN_PATH . '/product-slug/manage/' . $productId);
    }
}

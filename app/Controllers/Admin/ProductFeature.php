<?php

namespace App\Controllers\Admin;

use App\Models\ProductFeatureModel;
use App\Models\ProductModel;

class ProductFeature extends BaseController
{
    private ProductModel $productModel;
    private ProductFeatureModel $featureModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->featureModel = new ProductFeatureModel();
    }

    public function manage($productId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $editFeature = null;
        $editId = (int) ($this->request->getGet('edit') ?? 0);
        if ($editId > 0) {
            $editFeature = $this->findFeature($editId, (int) $product['id']);
            if (!$editFeature) {
                $this->flash('feature_error', 'فیچر مورد نظر برای این محصول یافت نشد');
                return redirect()->to(ADMIN_PATH . '/product-feature/manage/' . $product['id']);
            }
        }

        $this->viewData['product'] = $product;
        $this->viewData['features'] = $this->featureModel
            ->where('product_id', $product['id'])
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['editFeature'] = $editFeature;
        $this->viewData['title'] = 'مدیریت فیچرهای محصول - ' . $product['name'];

        return view('admin/product_feature/manage', $this->viewData);
    }

    public function store($productId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $data = $this->featureData();
        if (!$this->validateFeature($data)) {
            return redirect()->back()->withInput();
        }

        $data['product_id'] = (int) $product['id'];
        if (!$this->featureModel->insert($data)) {
            $this->flash('feature_error', 'خطا در افزودن فیچر محصول');
            return redirect()->back()->withInput();
        }

        $this->flash('feature_success', 'فیچر محصول با موفقیت اضافه شد');
        return redirect()->to(ADMIN_PATH . '/product-feature/manage/' . $product['id']);
    }

    public function update($productId, $featureId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $feature = $this->findFeature((int) $featureId, (int) $product['id']);
        if (!$feature) {
            $this->flash('feature_error', 'فیچر مورد نظر برای این محصول یافت نشد');
            return redirect()->to(ADMIN_PATH . '/product-feature/manage/' . $product['id']);
        }

        $data = $this->featureData();
        if (!$this->validateFeature($data)) {
            return redirect()->back()->withInput();
        }

        if (!$this->featureModel->update($feature['id'], $data)) {
            $this->flash('feature_error', 'خطا در ویرایش فیچر محصول');
            return redirect()->back()->withInput();
        }

        $this->flash('feature_success', 'فیچر محصول با موفقیت ویرایش شد');
        return redirect()->to(ADMIN_PATH . '/product-feature/manage/' . $product['id']);
    }

    public function toggleActive($productId, $featureId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $feature = $this->findFeature((int) $featureId, (int) $product['id']);
        if (!$feature) {
            $this->flash('feature_error', 'فیچر مورد نظر برای این محصول یافت نشد');
            return redirect()->to(ADMIN_PATH . '/product-feature/manage/' . $product['id']);
        }

        $this->featureModel->update($feature['id'], [
            'is_active' => (int) !$feature['is_active'],
        ]);

        $this->flash('feature_success', 'وضعیت فیچر با موفقیت تغییر کرد');
        return redirect()->to(ADMIN_PATH . '/product-feature/manage/' . $product['id']);
    }

    public function delete($productId, $featureId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $feature = $this->findFeature((int) $featureId, (int) $product['id']);
        if (!$feature) {
            $this->flash('feature_error', 'فیچر مورد نظر برای این محصول یافت نشد');
            return redirect()->to(ADMIN_PATH . '/product-feature/manage/' . $product['id']);
        }

        if (!$this->featureModel->delete($feature['id'])) {
            $this->flash('feature_error', 'خطا در حذف فیچر محصول');
        } else {
            $this->flash('feature_success', 'فیچر محصول با موفقیت حذف شد');
        }

        return redirect()->to(ADMIN_PATH . '/product-feature/manage/' . $product['id']);
    }

    private function findProduct(int $productId): ?array
    {
        if ($productId < 1) {
            $this->flash('feature_error', 'محصول مورد نظر یافت نشد');
            return null;
        }

        $product = $this->productModel->find($productId);
        if (!$product) {
            $this->flash('feature_error', 'محصول مورد نظر یافت نشد');
            return null;
        }

        return $product;
    }

    private function findFeature(int $featureId, int $productId): ?array
    {
        if ($featureId < 1) {
            return null;
        }

        return $this->featureModel
            ->where('id', $featureId)
            ->where('product_id', $productId)
            ->first();
    }

    private function featureData(): array
    {
        return [
            'feature_key'   => trim((string) $this->request->getPost('feature_key')),
            'feature_value' => trim((string) $this->request->getPost('feature_value')),
            'sort_order'    => trim((string) $this->request->getPost('sort_order')),
            'is_active'     => (string) ($this->request->getPost('is_active') ?? '0'),
        ];
    }

    private function validateFeature(array $data): bool
    {
        $rules = [
            'feature_key'   => 'required|max_length[150]',
            'feature_value' => 'required',
            'sort_order'    => 'required|integer|greater_than_equal_to[0]',
            'is_active'     => 'required|in_list[0,1]',
        ];

        $messages = [
            'feature_key' => [
                'required'   => 'عنوان ویژگی الزامی است.',
                'max_length' => 'عنوان ویژگی نباید بیشتر از ۱۵۰ کاراکتر باشد.',
            ],
            'feature_value' => [
                'required' => 'مقدار ویژگی الزامی است.',
            ],
            'sort_order' => [
                'required'              => 'ترتیب نمایش الزامی است.',
                'integer'               => 'ترتیب نمایش باید عدد صحیح باشد.',
                'greater_than_equal_to' => 'ترتیب نمایش نمی‌تواند منفی باشد.',
            ],
            'is_active' => [
                'required' => 'وضعیت فیچر الزامی است.',
                'in_list'  => 'وضعیت فیچر معتبر نیست.',
            ],
        ];

        if (!$this->validateData($data, $rules, $messages)) {
            $this->flash('feature_error', implode(' | ', service('validation')->getErrors()));
            return false;
        }

        return true;
    }
}

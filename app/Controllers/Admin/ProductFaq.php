<?php

namespace App\Controllers\Admin;

use App\Models\ProductFaqModel;
use App\Models\ProductModel;

class ProductFaq extends BaseController
{
    private ProductModel $productModel;
    private ProductFaqModel $faqModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->faqModel = new ProductFaqModel();
    }

    public function manage($productId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $editFaq = null;
        $editId = (int) ($this->request->getGet('edit') ?? 0);
        if ($editId > 0) {
            $editFaq = $this->findFaq($editId, (int) $product['id']);
            if (!$editFaq) {
                $this->flash('product_faq_error', 'سؤال مورد نظر برای این محصول یافت نشد');
                return redirect()->to(ADMIN_PATH . '/product-faq/manage/' . $product['id']);
            }
        }

        $this->viewData['product'] = $product;
        $this->viewData['faqs'] = $this->orderedFaqs((int) $product['id']);
        $this->viewData['editFaq'] = $editFaq;
        $this->viewData['title'] = 'مدیریت سؤالات محصول - ' . $product['name'];

        return view('admin/product_faq/manage', $this->viewData);
    }

    public function store($productId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $data = $this->faqData();
        if (!$this->validateFaq($data)) {
            return redirect()->back()->withInput();
        }

        $lastFaq = $this->faqModel
            ->where('product_id', $product['id'])
            ->orderBy('sort_order', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();

        $data['product_id'] = (int) $product['id'];
        $data['sort_order'] = ((int) ($lastFaq['sort_order'] ?? 0)) + 1;

        if (!$this->faqModel->insert($data)) {
            $this->flash('product_faq_error', 'خطا در افزودن سؤال محصول');
            return redirect()->back()->withInput();
        }

        $this->flash('product_faq_success', 'سؤال محصول با موفقیت اضافه شد');
        return redirect()->to(ADMIN_PATH . '/product-faq/manage/' . $product['id']);
    }

    public function update($productId, $faqId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $faq = $this->findFaq((int) $faqId, (int) $product['id']);
        if (!$faq) {
            $this->flash('product_faq_error', 'سؤال مورد نظر برای این محصول یافت نشد');
            return redirect()->to(ADMIN_PATH . '/product-faq/manage/' . $product['id']);
        }

        $data = $this->faqData();
        if (!$this->validateFaq($data)) {
            return redirect()->back()->withInput();
        }

        if (!$this->faqModel->update($faq['id'], $data)) {
            $this->flash('product_faq_error', 'خطا در ویرایش سؤال محصول');
            return redirect()->back()->withInput();
        }

        $this->flash('product_faq_success', 'سؤال محصول با موفقیت ویرایش شد');
        return redirect()->to(ADMIN_PATH . '/product-faq/manage/' . $product['id']);
    }

    public function move($productId, $faqId, $direction)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $faq = $this->findFaq((int) $faqId, (int) $product['id']);
        if (!$faq || !in_array($direction, ['up', 'down'], true)) {
            $this->flash('product_faq_error', 'درخواست جابه‌جایی معتبر نیست');
            return redirect()->to(ADMIN_PATH . '/product-faq/manage/' . $product['id']);
        }

        $faqs = $this->orderedFaqs((int) $product['id']);
        $currentIndex = array_search((int) $faq['id'], array_map('intval', array_column($faqs, 'id')), true);
        $targetIndex = $direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;

        if ($currentIndex !== false && isset($faqs[$targetIndex])) {
            [$faqs[$currentIndex], $faqs[$targetIndex]] = [$faqs[$targetIndex], $faqs[$currentIndex]];
            $this->saveOrder($faqs);
            $this->flash('product_faq_success', 'ترتیب سؤال‌ها تغییر کرد');
        }

        return redirect()->to(ADMIN_PATH . '/product-faq/manage/' . $product['id']);
    }

    public function delete($productId, $faqId)
    {
        $product = $this->findProduct((int) $productId);
        if (!$product) {
            return redirect()->to(ADMIN_PATH . '/product');
        }

        $faq = $this->findFaq((int) $faqId, (int) $product['id']);
        if (!$faq || !$this->faqModel->delete($faq['id'])) {
            $this->flash('product_faq_error', 'خطا در حذف سؤال محصول');
        } else {
            $this->saveOrder($this->orderedFaqs((int) $product['id']));
            $this->flash('product_faq_success', 'سؤال محصول با موفقیت حذف شد');
        }

        return redirect()->to(ADMIN_PATH . '/product-faq/manage/' . $product['id']);
    }

    private function orderedFaqs(int $productId): array
    {
        return $this->faqModel
            ->where('product_id', $productId)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    private function saveOrder(array $faqs): void
    {
        foreach ($faqs as $index => $faq) {
            $this->faqModel->update($faq['id'], ['sort_order' => $index + 1]);
        }
    }

    private function findProduct(int $productId): ?array
    {
        $product = $productId > 0 ? $this->productModel->find($productId) : null;
        if (!$product) {
            $this->flash('product_faq_error', 'محصول مورد نظر یافت نشد');
            return null;
        }

        return $product;
    }

    private function findFaq(int $faqId, int $productId): ?array
    {
        if ($faqId < 1) {
            return null;
        }

        return $this->faqModel
            ->where('id', $faqId)
            ->where('product_id', $productId)
            ->first();
    }

    private function faqData(): array
    {
        return [
            'question' => trim((string) $this->request->getPost('question')),
            'answer'   => trim((string) $this->request->getPost('answer')),
        ];
    }

    private function validateFaq(array $data): bool
    {
        $rules = [
            'question' => 'required|max_length[500]',
            'answer'   => 'required',
        ];
        $messages = [
            'question' => [
                'required'   => 'متن سؤال الزامی است.',
                'max_length' => 'متن سؤال نباید بیشتر از ۵۰۰ کاراکتر باشد.',
            ],
            'answer' => ['required' => 'پاسخ سؤال الزامی است.'],
        ];

        if (!$this->validateData($data, $rules, $messages)) {
            $this->flash('product_faq_error', implode(' | ', service('validation')->getErrors()));
            return false;
        }

        return true;
    }
}

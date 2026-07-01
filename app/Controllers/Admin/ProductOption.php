<?php

namespace App\Controllers\Admin;

class ProductOption extends BaseController
{
    public function form($productId)
    {
        $productId = (int) $productId;

        // بررسی وجود محصول
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        // اگه درخواست POST بود، بره به formHandler
        if ($this->request->getMethod() === 'POST') {
            return $this->formHandler($productId);
        }

        // دریافت همه لیبل‌های فعال
        $labelModel = model('App\Models\LabelModel');
        $labels = $labelModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        // دریافت آپشن‌های متصل به این محصول
        $productOptionModel = model('App\Models\ProductOptionModel');
        $existingOptions = $productOptionModel
            ->where('product_id', $productId)
            ->findAll();

        $existingOptionIds = array_column($existingOptions, 'option_id');

        // دریافت همه آپشن‌ها (با احتساب غیرفعال‌ها)
        $optionModel = model('App\Models\OptionModel');
        $allOptions = $optionModel->orderBy('sort_order', 'ASC')->findAll();

        // گروه‌بندی آپشن‌ها بر اساس label_id
        $optionsByLabel = [];
        foreach ($allOptions as $option) {
            $labelId = $option['label_id'];
            if (!isset($optionsByLabel[$labelId])) {
                $optionsByLabel[$labelId] = [];
            }
            $optionsByLabel[$labelId][] = $option;
        }

        $this->viewData['product'] = $product;
        $this->viewData['product_id'] = $productId;
        $this->viewData['labels'] = $labels;
        $this->viewData['optionsByLabel'] = $optionsByLabel;
        $this->viewData['existingOptionIds'] = $existingOptionIds;
        $this->viewData['title'] = 'مدیریت آپشن‌های محصول - ' . $product['name'];
        $this->viewData['form_action'] = 'admin/product-option/form/' . $productId;

        return view('admin/product_option/form', $this->viewData);
    }

    public function formHandler($productId)
    {
        $productId = (int) $productId;

        // بررسی وجود محصول
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        // دریافت آپشن‌های انتخاب شده از فرم (به صورت آرایه)
        $selectedOptions = $this->request->getPost('options') ?? [];

        // اطمینان از اینکه آرایه است و مقادیر integer هستند
        if (!is_array($selectedOptions)) {
            $selectedOptions = [];
        }
        $selectedOptions = array_map('intval', $selectedOptions);
        $selectedOptions = array_filter($selectedOptions, function($val) {
            return $val > 0;
        });

        // دریافت آپشن‌های فعلی این محصول از دیتابیس
        $productOptionModel = model('App\Models\ProductOptionModel');
        $currentOptions = $productOptionModel
            ->where('product_id', $productId)
            ->findAll();

        $currentOptionIds = array_column($currentOptions, 'option_id');

        // پیدا کردن آیتم‌های جدید (در فرم هستن ولی در دیتابیس نیستن)
        $newOptions = array_diff($selectedOptions, $currentOptionIds);

        // پیدا کردن آیتم‌های حذف شده (در دیتابیس هستن ولی در فرم نیستن)
        $removedOptions = array_diff($currentOptionIds, $selectedOptions);

        // اضافه کردن آیتم‌های جدید
        foreach ($newOptions as $optionId) {
            $productOptionModel->insert([
                'product_id' => $productId,
                'option_id' => $optionId
            ]);
        }

        // حذف آیتم‌های حذف شده
        if (!empty($removedOptions)) {
            $productOptionModel
                ->where('product_id', $productId)
                ->whereIn('option_id', $removedOptions)
                ->delete();
        }

        $this->flash('option_update_success', 'آپشن‌های محصول با موفقیت به‌روزرسانی شد');
        return redirect()->to('admin/product-option/form/' . $productId);
    }
}
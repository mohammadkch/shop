<?php

namespace App\Controllers;

class Product extends BaseController
{
    protected $breadcrumbService;
    protected $productService;

    public function __construct()
    {
        $this->breadcrumbService = service('breadcrumbService');
        $this->productService = service('productService');
    }

    public function show($slug)
    {
        helper(['menu']);

        // دریافت تمام داده‌های مورد نیاز از سرویس
        $data = $this->productService->prepareProductShowData($slug);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('محصول مورد نظر یافت نشد');
        }

        // ساخت breadcrumb
        $breadcrumb = $this->breadcrumbService->buildFromProduct($data['product']);
        $data['breadcrumb'] = $breadcrumb;

        // متا تگ‌ها
        $data['meta_title'] = $data['product']['meta_title'] ?? $data['product']['name'];
        $data['meta_description'] = $data['product']['meta_description']
            ?? substr(strip_tags($data['product']['description'] ?? ''), 0, 160);

        // ادغام با viewData موجود (که از BaseController می‌آید)
        $this->viewData = array_merge($this->viewData, $data);

//        echo '<pre>';
//        print_r($this->viewData['options']);
//        print_r($this->viewData['priceInfo']);
//        print_r($this->viewData['totalStock']); echo '<hr>';
//        print_r($this->viewData['selectedStock']);
//        print_r($this->viewData['priceMap']);
//        exit();

        return view('product/show', $this->viewData);
    }
}
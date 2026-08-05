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

    public function show(int $id, string $slug)
    {
        helper(['menu', 'blog_content', 'product']);

        // دریافت تمام داده‌های مورد نیاز از سرویس
        $data = $this->productService->prepareProductShowData($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('محصول مورد نظر یافت نشد');
        }

        $canonicalUrl = product_url($data['product']);
        if ($slug !== $data['product']['slug']) {
            return redirect()->to($canonicalUrl)->setStatusCode(301);
        }

        // ساخت breadcrumb
        $breadcrumb = $this->breadcrumbService->buildFromProduct($data['product']);
        $data['breadcrumb'] = $breadcrumb;

        $descriptionHtml = sanitizeBlogHtml($data['product']['description'] ?? '');
        $data['product']['description'] = $descriptionHtml;

        $metaTitle = trim((string) ($data['product']['meta_title'] ?? ''));
        if ($metaTitle !== '') {
            $data['title'] = $metaTitle . ' | فروشگاه مومو';
        }

        $metaDescription = trim((string) ($data['product']['meta_description'] ?? ''));
        if ($metaDescription === '') {
            $descriptionText = trim(preg_replace('/\s+/u', ' ', strip_tags($descriptionHtml)));
            $metaDescription = $descriptionText !== ''
                ? mb_substr($descriptionText, 0, 160)
                : 'خرید ' . $data['product']['name'] . ' از فروشگاه مومو؛ مشاهده مشخصات، قیمت و گزینه‌های محصول.';
        }
        $data['metaDescription'] = $metaDescription;
        $data['canonicalUrl'] = $canonicalUrl;

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

    public function legacy(string $slug)
    {
        helper('product');

        $product = $this->productService->getProductBySlug($slug);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('محصول مورد نظر یافت نشد');
        }

        return redirect()->to(product_url($product))->setStatusCode(301);
    }
}

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

        $product = $this->productService->getProductBySlug($slug);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('محصول مورد نظر یافت نشد');
        }

        $images = $this->productService->getProductImages($product['id']);
        $options = $this->productService->getProductOptions($product['id']);
        $priceInfo = $this->productService->getFinalPrice($product);
        $totalStock = $this->productService->getStock($product['id']);

        $relatedProducts = [];
        if (!empty($product['category']) && isset($product['category']['id'])) {
            $relatedProducts = $this->productService->getRelatedProducts(
                $product['id'],
                $product['category']['id']
            );
        }

        // ====== ساخت breadcrumb ======
        $breadcrumb = $this->breadcrumbService->buildFromProduct($product);

        $this->viewData['product'] = $product;
        $this->viewData['images'] = $images;
        $this->viewData['options'] = $options;
        $this->viewData['priceInfo'] = $priceInfo;
        $this->viewData['totalStock'] = $totalStock;
        $this->viewData['relatedProducts'] = $relatedProducts;
        $this->viewData['breadcrumb'] = $breadcrumb;

        // سئو
        $this->viewData['meta_title'] = $product['meta_title'] ?? $product['name'];
        $this->viewData['meta_description'] = $product['meta_description'] ?? substr(strip_tags($product['description'] ?? ''), 0, 160);

        return view('product/show', $this->viewData);
    }
}
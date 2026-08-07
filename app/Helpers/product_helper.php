<?php

if (!function_exists('product_url')) {
    function product_url(array|int $product, ?string $slug = null): string
    {
        if (is_array($product)) {
            // در رکوردهای واسط مانند cart_item و factor_item، id متعلق به خود
            // رکورد واسط است و شناسه واقعی محصول در product_id قرار دارد.
            $id = (int) ($product['product_id'] ?? $product['id'] ?? 0);
            $slug = (string) ($product['slug'] ?? $product['product_slug'] ?? '');
        } else {
            $id = $product;
        }

        return site_url('product/' . $id . '/' . trim((string) $slug, '/'));
    }
}

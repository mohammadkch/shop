<?php

if (!function_exists('product_url')) {
    function product_url(array|int $product, ?string $slug = null): string
    {
        if (is_array($product)) {
            $id = (int) ($product['id'] ?? $product['product_id'] ?? 0);
            $slug = (string) ($product['slug'] ?? $product['product_slug'] ?? '');
        } else {
            $id = $product;
        }

        return site_url('product/' . $id . '/' . trim((string) $slug, '/'));
    }
}

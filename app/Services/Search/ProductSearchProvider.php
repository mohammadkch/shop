<?php

namespace App\Services\Search;

use App\Contracts\SearchProviderInterface;

class ProductSearchProvider implements SearchProviderInterface
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
        helper('product');
    }

    public function key(): string
    {
        return 'product';
    }

    public function count(string $query): int
    {
        return $this->baseBuilder($query)->countAllResults();
    }

    public function search(string $query, int $limit, int $offset = 0): array
    {
        $builder = $this->baseBuilder($query);
        $finalPriceSql = $this->selectedPriceSql('CASE WHEN pp.sale_price > 0 AND pp.sale_price < pp.price THEN pp.sale_price ELSE pp.price END');
        $originalPriceSql = $this->selectedPriceSql('pp.price');

        $builder->select('p.id, p.name, p.slug');
        $builder->select("({$finalPriceSql}) AS final_price", false);
        $builder->select("({$originalPriceSql}) AS original_price", false);
        $builder->select('(SELECT pi.image_name FROM product_image pi WHERE pi.product_id = p.id AND pi.product_image_type_id = 2 AND pi.is_active = 1 ORDER BY pi.sort_order ASC, pi.id ASC LIMIT 1) AS image_name', false);
        $builder->select('EXISTS (SELECT 1 FROM product_price stock_price WHERE stock_price.product_id = p.id AND stock_price.stock > 0 AND stock_price.price > 0) AS is_in_stock', false);
        $builder->orderBy('is_in_stock', 'DESC');
        $prefix = $this->db->escape($this->db->escapeLikeString($query) . '%');
        $builder->orderBy("CASE WHEN p.name = " . $this->db->escape($query) . " THEN 0 WHEN p.name LIKE {$prefix} ESCAPE '!' THEN 1 ELSE 2 END", '', false);
        $builder->orderBy('p.published_at', 'DESC');
        $builder->orderBy('p.id', 'DESC');
        $builder->limit($limit, $offset);

        return array_map([$this, 'mapProduct'], $builder->get()->getResultArray());
    }

    private function baseBuilder(string $query)
    {
        $builder = $this->db->table('product p');
        $builder->where('p.is_active', 1);
        $builder->groupStart()
            ->like('p.name', $query)
            ->orLike('p.sku', $query)
            ->orLike('p.meta_title', $query)
            ->orWhere("EXISTS (
                SELECT 1 FROM product_menu pm
                JOIN menu_3 m3 ON m3.id = pm.menu_3_id
                JOIN menu_2 m2 ON m2.id = m3.menu_2_id
                JOIN menu_1 m1 ON m1.id = m2.menu_1_id
                WHERE pm.product_id = p.id
                  AND (m1.name LIKE " . $this->db->escape('%' . $this->db->escapeLikeString($query) . '%') . " ESCAPE '!'
                    OR m2.name LIKE " . $this->db->escape('%' . $this->db->escapeLikeString($query) . '%') . " ESCAPE '!'
                    OR m3.name LIKE " . $this->db->escape('%' . $this->db->escapeLikeString($query) . '%') . " ESCAPE '!')
            )", null, false)
            ->groupEnd();

        return $builder;
    }

    private function selectedPriceSql(string $select): string
    {
        return "SELECT {$select}
            FROM product_price pp
            WHERE pp.product_id = p.id AND pp.stock > 0 AND pp.price > 0
            ORDER BY pp.is_default DESC,
                CASE WHEN pp.sale_price > 0 AND pp.sale_price < pp.price THEN pp.sale_price ELSE pp.price END ASC,
                pp.id ASC
            LIMIT 1";
    }

    private function mapProduct(array $product): array
    {
        $inStock = (bool) $product['is_in_stock'];
        $finalPrice = $inStock ? (float) $product['final_price'] : 0;
        $originalPrice = $inStock ? (float) $product['original_price'] : 0;

        return [
            'type' => $this->key(),
            'id' => (int) $product['id'],
            'title' => $product['name'],
            'url' => product_url($product),
            'image' => !empty($product['image_name'])
                ? base_url('images/products/' . $product['image_name'])
                : base_url('assets/images/product/placeholder.jpg'),
            'is_in_stock' => $inStock,
            'final_price' => $finalPrice,
            'original_price' => $originalPrice,
            'has_discount' => $inStock && $finalPrice > 0 && $finalPrice < $originalPrice,
        ];
    }
}

<?php

namespace App\Services\Search;

use App\Contracts\SearchProviderInterface;

class CategorySearchProvider implements SearchProviderInterface
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function key(): string
    {
        return 'category';
    }

    public function count(string $query): int
    {
        return $this->baseBuilder($query)->countAllResults();
    }

    public function search(string $query, int $limit, int $offset = 0): array
    {
        $builder = $this->baseBuilder($query);
        $builder->select('m1.id, m1.name, m1.slug, m1.description');
        $builder->select('(SELECT image_name FROM menu_1_image image WHERE image.menu_1_id = m1.id AND image.menu_1_image_type_id = 2 AND image.is_active = 1 ORDER BY image.sort_order ASC, image.id ASC LIMIT 1) AS image_name', false);
        $prefix = $this->db->escape($this->db->escapeLikeString($query) . '%');
        $builder->orderBy("CASE WHEN m1.name = " . $this->db->escape($query) . " THEN 0 WHEN m1.name LIKE {$prefix} ESCAPE '!' THEN 1 ELSE 2 END", '', false);
        $builder->orderBy('m1.sort_order', 'ASC');
        $builder->orderBy('m1.id', 'ASC');
        $builder->limit($limit, $offset);

        return array_map([$this, 'mapCategory'], $builder->get()->getResultArray());
    }

    private function baseBuilder(string $query)
    {
        return $this->db->table('menu_1 m1')
            ->where('m1.is_active', 1)
            ->groupStart()
                ->like('m1.name', $query)
                ->orLike('m1.meta_title', $query)
            ->groupEnd();
    }

    private function mapCategory(array $category): array
    {
        return [
            'type' => $this->key(),
            'id' => (int) $category['id'],
            'title' => $category['name'],
            'subtitle' => 'دسته‌بندی محصولات',
            'excerpt' => $category['description'] ?? '',
            'url' => site_url('category/' . $category['slug']),
            'image' => !empty($category['image_name'])
                ? base_url('images/menus/' . $category['image_name'])
                : base_url('assets/images/category/default.png'),
        ];
    }
}

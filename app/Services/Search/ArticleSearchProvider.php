<?php

namespace App\Services\Search;

use App\Contracts\SearchProviderInterface;
use App\Models\BlogPostModel;

class ArticleSearchProvider implements SearchProviderInterface
{
    private BlogPostModel $postModel;

    public function __construct()
    {
        $this->postModel = new BlogPostModel();
    }

    public function key(): string
    {
        return 'article';
    }

    public function count(string $query): int
    {
        return $this->baseBuilder($query)->countAllResults();
    }

    public function search(string $query, int $limit, int $offset = 0): array
    {
        $builder = $this->baseBuilder($query);
        $db = db_connect();
        $prefix = $db->escape($db->escapeLikeString($query) . '%');
        $builder->orderBy("CASE WHEN post.title = " . $db->escape($query) . " THEN 0 WHEN post.title LIKE {$prefix} ESCAPE '!' THEN 1 ELSE 2 END", '', false);
        $builder->orderBy('post.published_at', 'DESC');
        $builder->orderBy('post.id', 'DESC');
        $builder->limit($limit, $offset);

        return array_map([$this, 'mapArticle'], $builder->get()->getResultArray());
    }

    private function baseBuilder(string $query)
    {
        return $this->postModel->publicBuilder()
            ->where('category.is_active', 1)
            ->groupStart()
                ->like('post.title', $query)
                ->orLike('post.excerpt', $query)
                ->orLike('post.meta_title', $query)
                ->orLike('category.name', $query)
            ->groupEnd();
    }

    private function mapArticle(array $article): array
    {
        return [
            'type' => $this->key(),
            'id' => (int) $article['id'],
            'title' => $article['title'],
            'subtitle' => $article['category_name'],
            'excerpt' => $article['excerpt'] ?? '',
            'url' => site_url('blog/' . $article['slug']),
            'image' => !empty($article['featured_image'])
                ? base_url('images/' . $article['featured_image'])
                : base_url('assets/images/blog/blog-1.jpg'),
        ];
    }
}

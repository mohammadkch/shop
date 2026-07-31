<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostModel extends Model
{
    protected $table = 'blog_post';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id', 'blog_category_id', 'title', 'slug', 'excerpt',
        'featured_image', 'featured_image_alt', 'status', 'published_at',
        'meta_title', 'meta_description', 'canonical_url', 'view_count',
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    public function adminData(array $filters, ?int $limit = null, int $offset = 0, bool $count = false)
    {
        $builder = $this->db->table($this->table . ' post')
            ->join('blog_category category', 'category.id = post.blog_category_id')
            ->join('user author', 'author.id = post.user_id')
            ->select('post.*, category.name AS category_name, author.full_name AS author_name');

        if (!empty($filters['title'])) {
            $builder->like('post.title', $filters['title']);
        }
        if (!empty($filters['status'])) {
            $builder->where('post.status', $filters['status']);
        }
        if (!empty($filters['blog_category_id'])) {
            $builder->where('post.blog_category_id', $filters['blog_category_id']);
        }
        if ($count) {
            return $builder->countAllResults();
        }
        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }
        return $builder->orderBy('post.id', 'DESC')->get()->getResultArray();
    }

    public function publicBuilder()
    {
        return $this->db->table($this->table . ' post')
            ->join('blog_category category', 'category.id = post.blog_category_id')
            ->join('user author', 'author.id = post.user_id')
            ->select('post.*, category.name AS category_name, category.slug AS category_slug, author.full_name AS author_name')
            ->groupStart()
                ->where('post.status', 'published')
                ->orGroupStart()
                    ->where('post.status', 'scheduled')
                    ->where('post.published_at <=', time())
                ->groupEnd()
            ->groupEnd()
            ->where('post.published_at IS NOT NULL', null, false)
            ->where('post.published_at <=', time());
    }
}

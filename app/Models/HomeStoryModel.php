<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeStoryModel extends Model
{
    protected $table            = 'home_story';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type', 'title', 'avatar', 'url', 'duration', 'link', 'sort_order', 'is_active'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // فیلتر بر اساس id
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('home_story.id', $where['id']);
            unset($where['id']);
        }

        // جستجو در title
        if (isset($where['title']) && !empty($where['title'])) {
            $builder->like('home_story.title', $where['title']);
            unset($where['title']);
        }

        // فیلتر بر اساس is_active
        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('home_story.is_active', $where['is_active']);
            unset($where['is_active']);
        }

        // فیلتر بر اساس type
        if (isset($where['type']) && !empty($where['type'])) {
            $builder->where('home_story.type', $where['type']);
            unset($where['type']);
        }

        // شرط‌های معمولی
        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy("home_story.sort_order", 'ASC');

        return $builder->get()->getResultArray();
    }
}

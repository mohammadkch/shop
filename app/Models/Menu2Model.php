<?php

namespace App\Models;

use App\Models\Menu1Model;
use CodeIgniter\Model;

class Menu2Model extends Model
{
    protected $table            = 'menu_2';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['menu_1_id', 'name', 'slug', 'is_active'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // فیلتر بر اساس id
        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('id', $where['id']);
            unset($where['id']);
        }

        // جستجو در name
        if (isset($where['name']) && !empty($where['name'])) {
            $builder->like('name', $where['name']);
            unset($where['name']);
        }

        // جستجو در slug
        if (isset($where['slug']) && !empty($where['slug'])) {
            $builder->like('slug', $where['slug']);
            unset($where['slug']);
        }

        // فیلتر بر اساس menu_1_id
        if (isset($where['menu_1_id']) && $where['menu_1_id'] !== '') {
            $builder->where('menu_1_id', $where['menu_1_id']);
            unset($where['menu_1_id']);
        }

        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('menu_2.is_active', $where['is_active']);
            unset($where['is_active']);
        }

        // شرط‌های معمولی
        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        $builder->select('
            menu_2.*,
            menu_1.name as menu_1_name
        ');
        $builder->join('menu_1', 'menu_2.menu_1_id = menu_1.id', 'left');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy("{$this->table}.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    public function menu1()
    {
        return $this->belongsTo(Menu1Model::class, 'menu_1_id');
    }
}
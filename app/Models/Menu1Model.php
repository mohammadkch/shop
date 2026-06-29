<?php

namespace App\Models;

use CodeIgniter\Model;

class Menu1Model extends Model
{
    protected $table            = 'menu_1';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['name', 'slug', 'is_active', 'description'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('menu_1.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['name']) && !empty($where['name'])) {
            $builder->like('menu_1.name', $where['name']);
            unset($where['name']);
        }

        if (isset($where['slug']) && !empty($where['slug'])) {
            $builder->like('menu_1.slug', $where['slug']);
            unset($where['slug']);
        }

        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('menu_1.is_active', $where['is_active']);
            unset($where['is_active']);
        }

        if (!empty($where)) {
            $builder->where($where);
        }

        // برای count، کوئری ساده بدون جوین
        if ($count) {
            return $builder->countAllResults();
        }

        // برای دیتا، جوین و group by
        $builder->select('
        menu_1.*,
        COUNT(menu_1_image.id) as images_count,
        GROUP_CONCAT(
            CONCAT_WS("|||", 
                menu_1_image.id,
                menu_1_image.menu_1_image_type_id,
                menu_1_image.image_name,
                menu_1_image.original_name,
                menu_1_image.alt,
                menu_1_image.sort_order,
                menu_1_image_type.name,
                menu_1_image_type.path
            ) SEPARATOR ";;;"
        ) as images_data
    ');
        $builder->join('menu_1_image', 'menu_1_image.menu_1_id = menu_1.id', 'left');
        $builder->join('menu_1_image_type', 'menu_1_image_type.id = menu_1_image.menu_1_image_type_id', 'left');
        $builder->groupBy('menu_1.id');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy("menu_1.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }
}
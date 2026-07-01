<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeSelectedCategoryModel extends Model
{
    protected $table            = 'home_selected_category';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['menu_1_id', 'menu_2_id', 'menu_3_id', 'sort_order', 'is_active'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        // جوین با جداول منو برای دریافت نام‌ها
        $builder->select('
        home_selected_category.*,
        menu_1.id as menu_1_id,
        menu_1.name as menu_1_name,
        menu_2.id as menu_2_id,
        menu_2.name as menu_2_name,
        menu_3.id as menu_3_id,
        menu_3.name as menu_3_name
    ');
        $builder->join('menu_1', 'home_selected_category.menu_1_id = menu_1.id', 'left');
        $builder->join('menu_2', 'home_selected_category.menu_2_id = menu_2.id', 'left');
        $builder->join('menu_3', 'home_selected_category.menu_3_id = menu_3.id', 'left');

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('home_selected_category.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['menu_1_id']) && !empty($where['menu_1_id'])) {
            $builder->where('home_selected_category.menu_1_id', $where['menu_1_id']);
            unset($where['menu_1_id']);
        }

        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('home_selected_category.is_active', $where['is_active']);
            unset($where['is_active']);
        }

        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('home_selected_category.sort_order', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function getSelectedMenus()
    {
        $builder = $this->db->table($this->table . ' hsc');
        $builder->select('
        hsc.*,
        menu_1.id as menu_1_id,
        menu_1.name as menu_1_name,
        menu_1.slug as menu_1_slug,
        menu_2.id as menu_2_id,
        menu_2.name as menu_2_name,
        menu_2.slug as menu_2_slug,
        menu_3.id as menu_3_id,
        menu_3.name as menu_3_name,
        menu_3.slug as menu_3_slug,
        menu_1_image.image_name as menu_1_image_name,
        menu_2_image.image_name as menu_2_image_name,
        menu_3_image.image_name as menu_3_image_name
    ');
        $builder->join('menu_1', 'hsc.menu_1_id = menu_1.id', 'left');
        $builder->join('menu_2', 'hsc.menu_2_id = menu_2.id', 'left');
        $builder->join('menu_3', 'hsc.menu_3_id = menu_3.id', 'left');
        $builder->join('menu_1_image', 'hsc.menu_1_id = menu_1_image.menu_1_id AND menu_1_image.menu_1_image_type_id = 2 AND menu_1_image.is_active = 1', 'left');
        $builder->join('menu_2_image', 'hsc.menu_2_id = menu_2_image.menu_2_id AND menu_2_image.menu_2_image_type_id = 2 AND menu_2_image.is_active = 1', 'left');
        $builder->join('menu_3_image', 'hsc.menu_3_id = menu_3_image.menu_3_id AND menu_3_image.menu_3_image_type_id = 2 AND menu_3_image.is_active = 1', 'left');
        $builder->where('hsc.is_active', 1);
        $builder->orderBy('hsc.sort_order', 'ASC');

        return $builder->get()->getResultArray();
    }
}
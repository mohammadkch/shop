<?php

namespace App\Models;

use App\Models\Menu2Model;
use App\Models\Menu3ImageModel;
use CodeIgniter\Model;

class Menu3Model extends Model
{
    protected $table            = 'menu_3';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['menu_2_id', 'name', 'slug', 'is_active', 'description'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('menu_3.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['name']) && !empty($where['name'])) {
            $builder->like('menu_3.name', $where['name']);
            unset($where['name']);
        }

        if (isset($where['slug']) && !empty($where['slug'])) {
            $builder->like('menu_3.slug', $where['slug']);
            unset($where['slug']);
        }

        if (isset($where['menu_2_id']) && $where['menu_2_id'] !== '') {
            $builder->where('menu_3.menu_2_id', $where['menu_2_id']);
            unset($where['menu_2_id']);
        }

        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('menu_3.is_active', $where['is_active']);
            unset($where['is_active']);
        }

        if (isset($where['menu_3.id IN'])) {
            $inValue = $where['menu_3.id IN'];
            if (is_array($inValue)) {
                $builder->whereIn('menu_3.id', $inValue);
            } else {
                $cleanValue = trim($inValue, '()');
                $ids = explode(',', $cleanValue);
                $builder->whereIn('menu_3.id', $ids);
            }
            unset($where['menu_3.id IN']);
        }

        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        $builder->select('
            menu_3.*,
            menu_2.name as menu_2_name,
            menu_1.id as menu_1_id,
            menu_1.name as menu_1_name,
            GROUP_CONCAT(
                CONCAT_WS(\'|||\',
                    menu_3_image.id,
                    menu_3_image.menu_3_image_type_id,
                    menu_3_image.image_name,
                    menu_3_image.original_name,
                    menu_3_image.alt,
                    menu_3_image.sort_order,
                    menu_3_image_type.name,
                    menu_3_image_type.path
                ) SEPARATOR \';;;\'
            ) as images_data
        ');
        $builder->join('menu_2', 'menu_3.menu_2_id = menu_2.id', 'left');
        $builder->join('menu_1', 'menu_2.menu_1_id = menu_1.id', 'left');
        $builder->join('menu_3_image', 'menu_3_image.menu_3_id = menu_3.id', 'left');
        $builder->join('menu_3_image_type', 'menu_3_image_type.id = menu_3_image.menu_3_image_type_id', 'left');
        $builder->groupBy('menu_3.id');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy("{$this->table}.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    public function menu2()
    {
        return $this->belongsTo(Menu2Model::class, 'menu_2_id');
    }

    public function images()
    {
        return $this->hasMany(Menu3ImageModel::class, 'menu_3_id');
    }
}
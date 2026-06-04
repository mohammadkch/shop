<?php

namespace App\Models;

use App\Models\Menu2ImageTypeModel;
use App\Models\Menu2Model;
use CodeIgniter\Model;

class Menu2ImageModel extends Model
{
    protected $table            = 'menu_2_image';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['menu_2_image_type_id', 'menu_2_id', 'image_name', 'original_name', 'alt', 'sort_order', 'is_active'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('menu_2_image.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['menu_2_image_type_id']) && $where['menu_2_image_type_id'] !== '') {
            $builder->where('menu_2_image.menu_2_image_type_id', $where['menu_2_image_type_id']);
            unset($where['menu_2_image_type_id']);
        }

        if (isset($where['menu_2_id']) && $where['menu_2_id'] !== '') {
            $builder->where('menu_2_image.menu_2_id', $where['menu_2_id']);
            unset($where['menu_2_id']);
        }

        if (isset($where['alt']) && !empty($where['alt'])) {
            $builder->like('menu_2_image.alt', $where['alt']);
            unset($where['alt']);
        }

        if (isset($where['image_name']) && !empty($where['image_name'])) {
            $builder->like('menu_2_image.image_name', $where['image_name']);
            unset($where['image_name']);
        }

        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        $builder->select('
            menu_2_image.*,
            menu_2_image_type.name as type_name,
            menu_2_image_type.width,
            menu_2_image_type.height,
            menu_2_image_type.path,
            menu_2.name as menu_name,
            menu_2.slug as menu_slug
        ');
        $builder->join('menu_2_image_type', 'menu_2_image_type.id = menu_2_image.menu_2_image_type_id', 'left');
        $builder->join('menu_2', 'menu_2.id = menu_2_image.menu_2_id', 'left');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('menu_2_image.sort_order', 'ASC');
        $builder->orderBy('menu_2_image.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function imageType()
    {
        return $this->belongsTo(Menu2ImageTypeModel::class, 'menu_2_image_type_id');
    }

    public function menu2()
    {
        return $this->belongsTo(Menu2Model::class, 'menu_2_id');
    }
}
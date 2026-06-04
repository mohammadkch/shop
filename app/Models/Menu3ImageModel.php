<?php

namespace App\Models;

use App\Models\Menu3ImageTypeModel;
use App\Models\Menu3Model;
use CodeIgniter\Model;

class Menu3ImageModel extends Model
{
    protected $table            = 'menu_3_image';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['menu_3_image_type_id', 'menu_3_id', 'image_name', 'original_name', 'alt', 'sort_order'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('menu_3_image.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['menu_3_image_type_id']) && $where['menu_3_image_type_id'] !== '') {
            $builder->where('menu_3_image.menu_3_image_type_id', $where['menu_3_image_type_id']);
            unset($where['menu_3_image_type_id']);
        }

        if (isset($where['menu_3_id']) && $where['menu_3_id'] !== '') {
            $builder->where('menu_3_image.menu_3_id', $where['menu_3_id']);
            unset($where['menu_3_id']);
        }

        if (isset($where['alt']) && !empty($where['alt'])) {
            $builder->like('menu_3_image.alt', $where['alt']);
            unset($where['alt']);
        }

        if (isset($where['image_name']) && !empty($where['image_name'])) {
            $builder->like('menu_3_image.image_name', $where['image_name']);
            unset($where['image_name']);
        }

        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        $builder->select('
            menu_3_image.*,
            menu_3_image_type.name as type_name,
            menu_3_image_type.width,
            menu_3_image_type.height,
            menu_3_image_type.path,
            menu_3.name as menu_name,
            menu_3.slug as menu_slug
        ');
        $builder->join('menu_3_image_type', 'menu_3_image_type.id = menu_3_image.menu_3_image_type_id', 'left');
        $builder->join('menu_3', 'menu_3.id = menu_3_image.menu_3_id', 'left');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('menu_3_image.sort_order', 'ASC');
        $builder->orderBy('menu_3_image.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function imageType()
    {
        return $this->belongsTo(Menu3ImageTypeModel::class, 'menu_3_image_type_id');
    }

    public function menu3()
    {
        return $this->belongsTo(Menu3Model::class, 'menu_3_id');
    }
}
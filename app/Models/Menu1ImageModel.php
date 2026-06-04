<?php

namespace App\Models;

use App\Models\Menu1ImageTypeModel;
use App\Models\Menu1Model;
use CodeIgniter\Model;

class Menu1ImageModel extends Model
{
    protected $table            = 'menu_1_image';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['menu_1_image_type_id', 'menu_1_id', 'image_name', 'original_name', 'alt', 'sort_order', 'is_active'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('menu_1_image.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['menu_1_image_type_id']) && $where['menu_1_image_type_id'] !== '') {
            $builder->where('menu_1_image.menu_1_image_type_id', $where['menu_1_image_type_id']);
            unset($where['menu_1_image_type_id']);
        }

        if (isset($where['menu_1_id']) && $where['menu_1_id'] !== '') {
            $builder->where('menu_1_image.menu_1_id', $where['menu_1_id']);
            unset($where['menu_1_id']);
        }

        if (isset($where['alt']) && !empty($where['alt'])) {
            $builder->like('menu_1_image.alt', $where['alt']);
            unset($where['alt']);
        }

        if (isset($where['image_name']) && !empty($where['image_name'])) {
            $builder->like('menu_1_image.image_name', $where['image_name']);
            unset($where['image_name']);
        }

        // فیلتر is_active - اضافه کردن نام جدول
        if (isset($where['is_active']) && $where['is_active'] !== '') {
            $builder->where('menu_1_image.is_active', $where['is_active']);
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
        menu_1_image.*,
        menu_1_image_type.name as type_name,
        menu_1_image_type.width,
        menu_1_image_type.height,
        menu_1_image_type.path,
        menu_1_image_type.is_active as type_is_active,
        menu_1.name as menu_name,
        menu_1.slug as menu_slug
    ');
        $builder->join('menu_1_image_type', 'menu_1_image_type.id = menu_1_image.menu_1_image_type_id', 'left');
        $builder->join('menu_1', 'menu_1.id = menu_1_image.menu_1_id', 'left');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('menu_1_image.sort_order', 'ASC');
        $builder->orderBy('menu_1_image.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }
    public function imageType()
    {
        return $this->belongsTo(Menu1ImageTypeModel::class, 'menu_1_image_type_id');
    }

    public function menu1()
    {
        return $this->belongsTo(Menu1Model::class, 'menu_1_id');
    }
}
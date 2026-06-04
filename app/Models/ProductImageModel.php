<?php

namespace App\Models;

use App\Models\ProductImageTypeModel;
use App\Models\ProductModel;
use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table            = 'product_image';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_image_type_id', 'product_id', 'image_name', 'original_name', 'alt', 'sort_order', 'is_main'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getData($where = [], $limit = null, $offset = 0, $count = false)
    {
        $builder = $this->db->table($this->table);

        if (isset($where['id']) && !empty($where['id'])) {
            $builder->where('product_image.id', $where['id']);
            unset($where['id']);
        }

        if (isset($where['product_image_type_id']) && $where['product_image_type_id'] !== '') {
            $builder->where('product_image.product_image_type_id', $where['product_image_type_id']);
            unset($where['product_image_type_id']);
        }

        if (isset($where['product_id']) && $where['product_id'] !== '') {
            $builder->where('product_image.product_id', $where['product_id']);
            unset($where['product_id']);
        }

        if (isset($where['is_main']) && $where['is_main'] !== '') {
            $builder->where('product_image.is_main', $where['is_main']);
            unset($where['is_main']);
        }

        if (isset($where['alt']) && !empty($where['alt'])) {
            $builder->like('product_image.alt', $where['alt']);
            unset($where['alt']);
        }

        if (isset($where['image_name']) && !empty($where['image_name'])) {
            $builder->like('product_image.image_name', $where['image_name']);
            unset($where['image_name']);
        }

        if (!empty($where)) {
            $builder->where($where);
        }

        if ($count) {
            return $builder->countAllResults();
        }

        $builder->select('
            product_image.*,
            product_image_type.name as type_name,
            product_image_type.width,
            product_image_type.height,
            product_image_type.path
        ');
        $builder->join('product_image_type', 'product_image_type.id = product_image.product_image_type_id', 'left');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        $builder->orderBy('product_image.sort_order', 'ASC');
        $builder->orderBy('product_image.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function imageType()
    {
        return $this->belongsTo(ProductImageTypeModel::class, 'product_image_type_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
}
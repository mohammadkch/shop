<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductOptionModel extends Model
{
    protected $table            = 'product_option';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id', 'option_id', 'stock', 'sku'];

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

        // فیلتر بر اساس product_id
        if (isset($where['product_id']) && $where['product_id'] !== '') {
            $builder->where('product_id', $where['product_id']);
            unset($where['product_id']);
        }

        // فیلتر بر اساس option_id
        if (isset($where['option_id']) && $where['option_id'] !== '') {
            $builder->where('option_id', $where['option_id']);
            unset($where['option_id']);
        }

        // جستجو در sku
        if (isset($where['sku']) && !empty($where['sku'])) {
            $builder->like('sku', $where['sku']);
            unset($where['sku']);
        }

        // فیلتر بر اساس stock (موجودی بیشتر از صفر)
        if (isset($where['in_stock']) && $where['in_stock'] === true) {
            $builder->where('stock >', 0);
            unset($where['in_stock']);
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

        $builder->orderBy("{$this->table}.created_at", 'DESC');

        return $builder->get()->getResultArray();
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function option()
    {
        return $this->belongsTo(OptionModel::class, 'option_id');
    }
}
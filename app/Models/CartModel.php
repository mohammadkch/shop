<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'session_id'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getCartByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getCartBySessionId($sessionId)
    {
        return $this->where('session_id', $sessionId)->first();
    }

    public function getOrCreateCart($userId = null, $sessionId = null)
    {
        $cart = null;

        if ($userId) {
            $cart = $this->getCartByUserId($userId);
        }

        if (!$cart && $sessionId) {
            $cart = $this->getCartBySessionId($sessionId);
        }

        if (!$cart) {
            $data = [];
            if ($userId) $data['user_id'] = $userId;
            if ($sessionId) $data['session_id'] = $sessionId;

            $this->insert($data);
            $cart = $this->find($this->insertID());
        }

        return $cart;
    }
}
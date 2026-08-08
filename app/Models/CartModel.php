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

    public function getGuestCartBySessionId($sessionId)
    {
        return $this->where('session_id', $sessionId)
            ->where('user_id IS NULL')
            ->first();
    }

    public function getOrCreateCart($userId = null, $sessionId = null)
    {
        $userId = $userId ? (int) $userId : null;

        if ($userId) {
            $userCart = $this->getCartByUserId($userId);
            if ($userCart) {
                // سبد حساب کاربری با user_id شناخته می‌شود، نه Session مرورگر.
                if ($userCart['session_id'] !== null) {
                    $this->update($userCart['id'], ['session_id' => null]);
                    $userCart['session_id'] = null;
                }
                return $userCart;
            }

            if ($sessionId) {
                $guestCart = $this->getGuestCartBySessionId($sessionId);
                if ($guestCart) {
                    $this->update($guestCart['id'], [
                        'user_id' => $userId,
                        'session_id' => null,
                    ]);
                    return $this->find($guestCart['id']);
                }
            }

            $this->insert(['user_id' => $userId]);
            return $this->find($this->insertID());
        }

        if ($sessionId) {
            $guestCart = $this->getGuestCartBySessionId($sessionId);
            if ($guestCart) {
                return $guestCart;
            }
        }

        $this->insert([
            'user_id' => null,
            'session_id' => $sessionId,
        ]);
        return $this->find($this->insertID());
    }
}

<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'username', 'password', 'full_name', 'role',
        'last_login', 'avatar', 'is_active', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'int';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)
            ->where('is_active', 1)
            ->first();
    }

    public function getUserById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => time()]);
    }
}
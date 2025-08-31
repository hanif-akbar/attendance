<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_pegawai',
        'username',
        'password',
        'status',
        'role'
    ];

    /**
     * Check if username is unique (excluding current user ID)
     * 
     * @param string $username
     * @param int|null $excludeId
     * @return bool
     */
    public function isUsernameUnique($username, $excludeId = null)
    {
        $builder = $this->builder();
        $builder->where('username', $username);
        
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() === 0;
    }

    /**
     * Get user by username
     * 
     * @param string $username
     * @return array|null
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Update username for a user
     * 
     * @param int $userId
     * @param string $newUsername
     * @return bool
     */
    public function updateUsername($userId, $newUsername)
    {
        return $this->update($userId, ['username' => $newUsername]);
    }
}

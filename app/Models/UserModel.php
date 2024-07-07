<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['email', 'password', 'role'];

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}

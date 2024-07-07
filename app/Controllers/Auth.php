<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        log_message('info', 'Login attempt: email=' . $email);

        $user = $userModel->getUserByEmail($email);

        if ($user) {
            log_message('info', 'User found: ' . json_encode($user));

            if (password_verify($password, $user['password'])) {
                log_message('info', 'Password verified');

                $response = [
                    'status' => 200,
                    'error' => null,
                    'messages' => [
                        'success' => 'Login successful',
                        'user' => [
                            'id_user' => $user['id_user'],
                            'email' => $user['email'],
                            'role' => $user['role']
                        ]
                    ]
                ];
                return $this->respond($response);
            } else {
                log_message('error', 'Invalid password');
                return $this->fail('Invalid password', 401);
            }
        } else {
            log_message('error', 'Email not found');
            return $this->failNotFound('Email not found');
        }
    }
}

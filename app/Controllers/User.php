<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class User extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new UserModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($id_user = null)
{
    $model = new UserModel();
    $data =  $model->find($id_user) ;
    
    if (!$data) {
        return $this->failNotFound('No Data Found');
    } else {
        return $this->respond($data);
    }
}

    public function show($id_user = null)
    {
        $model = new UserModel();
        $data = $model->find($id_user);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function create()
    {
        helper(['form']);
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'role'      => 'required',
        ];
        
        $data = [
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
            'role'      => $this->request->getVar('role'),
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors(), 400);
        
        $model = new UserModel();
        $model->save($data);

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Inserted'
            ]
        ];

        return $this->respondCreated($response);
    }

    public function login()
    {
        $model = new UserModel();

        // Ambil data dari form login
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Cari user berdasarkan email
        $user = $model->where('email', $email)->first();

        // Jika user tidak ditemukan atau password tidak sesuai, kembalikan pesan error
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->fail('Invalid email or password', 401);
        }

        // Jika email dan password cocok, kembalikan data user dan role
        return $this->respond([
            'message' => 'Login successful',
            'user' => [
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ], 200);
    }

    public function update($id_user = null)
{
    helper(['form']);
    $rules = [
        'email' => 'required',
        'password' => 'required',
        'role'      => 'required',
    ];
    
    $data = [
        'email' => $this->request->getVar('email'),
        'password' => $this->request->getVar('password'),
        'role'      => $this->request->getVar('role'),
    ];

    if (!$this->validate($rules)) {
        return $this->fail($this->validator->getErrors(), 400);
    }
    
    $model = new UserModel();
    $dataToUpdate = $model->find($id_user);

    if (!$dataToUpdate) {
        return $this->failNotFound('No Data Found');
    }
    
    $model->update($id_user, $data);

    $response = [
        'status'   => 200,
        'error'    => null,
        'messages' => [
            'success' => 'Data Updated'
        ]
    ];

    return $this->respond($response);
}
    public function delete($id_user = null)
    {
        $model = new UserModel();
        $dataToDelete = $model->find($id_user);

        if (!$dataToDelete) return $this->failNotFound('No Data Found');
        
        $model->delete($id_user);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
        ];

        return $this->respond($response);
    }

    public function import()
{
    try {
        $request = \Config\Services::request();
        
        // Periksa apakah file telah diunggah
        $file = $this->request->getFile('file');
        if (!$file) {
            return $this->failValidationError('No file uploaded');
        }
        
       // Check if the file is an Excel file
if (!$file->isValid() || !in_array($file->getClientExtension(), ['xlsx', 'xls'])) {
    return $this->failValidationError('Invalid file type. Only Excel files (.xlsx, .xls) are allowed');
}

        
        // Load the spreadsheet
        $spreadsheet = IOFactory::load($file);
    
        // Get the active sheet
        $sheet = $spreadsheet->getActiveSheet();
    
        // Get highest row
        $highestRow = $sheet->getHighestRow();
    
        $userModel = new UserModel();
    
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':E' . $row, NULL, TRUE, FALSE)[0];
            
            // Memeriksa apakah setidaknya satu nilai dalam baris tidak kosong
            $nonEmptyValues = array_filter($rowData);
            if (!empty($nonEmptyValues)) {
                $data = [
                    'email' => $rowData[0] ?? null,
                    'password' => $rowData[1] ?? null,
                    'role' => $rowData[0] ?? null,
                   
                ];
            
                $userModel->insert($data);
            }
        }
        
        return $this->respond(['message' => 'Data from Excel file imported successfully'], ResponseInterface::HTTP_CREATED);
    } catch (\Exception $e) {
        return $this->failServerError('An error occurred while importing data: ' . $e->getMessage());
    }
}

}

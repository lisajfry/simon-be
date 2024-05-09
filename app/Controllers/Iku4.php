<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku4Model;

class Iku4 extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        $model = new Iku4Model();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku4_id = null)
    {
        $model = new Iku4Model();
        $data = $model->find($iku4_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function create()
    {
        helper(['form']);
    
        $data = [
            'NIDN'       => $this->request->getVar('NIDN'),
            'nama_dosen' => $this->request->getVar('nama_dosen'),
            'status'     => $this->request->getVar('status'),

        ];
    
        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
    
        $model = new Iku4Model();
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

    public function update($iku4_id = null)
    {
        helper(['form']);
    
        $data = [
            'NIDN'       => $this->request->getVar('NIDN'),
            'nama_dosen' => $this->request->getVar('nama_dosen'),
            'status'     => $this->request->getVar('status'),

        ];
    
        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
    
        $model = new Iku4Model();
        $dataToUpdate = $model->find($iku4_id);
    
        if (!$dataToUpdate) return $this->failNotFound('No Data Found');
    
        $model->update($iku4_id, $data);
    
        // Kode untuk menampilkan view setelah update
        return view('edit_iku4', $data);
    }

    public function delete($iku4_id = null)
    {
        $model = new Iku4Model();
        $dataToDelete = $model->find($iku4_id);

        if (!$dataToDelete) return $this->failNotFound('No Data Found');
        
        $model->delete($iku4_id);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
        ];

        return $this->respond($response);
    }
}
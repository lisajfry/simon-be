<?php

namespace App\Controllers;

use App\Models\DosenNIDKModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class DosenNIDK extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new DosenNIDKModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($NIDK = null)
    {
        $model = new DosenNIDKModel();
        $data = $model->find($NIDK);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function show($NIDK = null)
    {
        $model = new DosenNIDKModel();
        $data = $model->find($NIDK);
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
            'NIDK' => 'required|is_unique[dosenNIDK.NIDK]',
            'nama_dosen' => 'required',
        ];
        
        $data = [
            'NIDK' => $this->request->getVar('NIDK'),
            'nama_dosen' => $this->request->getVar('nama_dosen'),
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors(), 400);
        
        $model = new DosenNIDKModel();
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

    public function update($NIDK = null)
    {
        helper(['form']);
        $rules = [
            'nama_dosen' => 'required',
        ];
        
        $data = [
            'nama_dosen' => $this->request->getVar('nama_dosen'),
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors(), 400);
        
        $model = new DosenNIDKModel();
        $dataToUpdate = $model->find($NIDK);

        if (!$dataToUpdate) return $this->failNotFound('No Data Found');
        
        $model->update($NIDK, $data);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];

        return $this->respond($response);
    }

    public function delete($NIDK = null)
    {
        $model = new DosenNIDKModel();
        $dataToDelete = $model->find($NIDK);

        if (!$dataToDelete) return $this->failNotFound('No Data Found');
        
        $model->delete($NIDK);

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

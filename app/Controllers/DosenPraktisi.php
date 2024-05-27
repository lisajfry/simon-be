<?php

namespace App\Controllers;

use App\Models\DosenPraktisiModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\DosenPraktisiModelModel;

class Dosenpraktisi extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new DosenPraktisiModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($NIDN_praktisi = null)
    {
        $model = new DosenPraktisiModel();
        $data = $model->find($NIDN_praktisi);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function show($NIDN_praktisi = null)
    {
        $model = new DosenPraktisiModel();
        $data = $model->find($NIDN_praktisi);
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
            'NIDN_praktisi' => 'required|is_unique[dosenpraktisi.NIDN_praktisi]',
            'nama_dosen_praktisi' => 'required',
        ];
        
        $data = [
            'NIDN_praktisi' => $this->request->getVar('NIDN_praktisi'),
            'nama_dosen_praktisi' => $this->request->getVar('nama_dosen_praktisi'),
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors(), 400);
        
        $model = new DosenPraktisiModel();
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

    public function update($NIDN_praktisi = null)
    {
        helper(['form']);
        $rules = [
            'nama_dosen_praktisi' => 'required',
        ];
        
        $data = [
            'nama_dosen_praktisi' => $this->request->getVar('nama_dosen_praktisi'),
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors(), 400);
        
        $model = new DosenPraktisiModel();
        $dataToUpdate = $model->find($NIDN_praktisi);

        if (!$dataToUpdate) return $this->failNotFound('No Data Found');
        
        $model->update($NIDN_praktisi, $data);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];

        return $this->respond($response);
    }

    public function delete($NIDN_praktisi = null)
    {
        $model = new DosenPraktisiModel();
        $dataToDelete = $model->find($NIDN_praktisi);

        if (!$dataToDelete) return $this->failNotFound('No Data Found');
        
        $model->delete($NIDN_praktisi);

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
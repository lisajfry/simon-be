<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku4Model;
use App\Models\DosenModel;
use App\Models\DosenNIDKModel;

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

    public function getNamaDosen($NIDN = null)
    {
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->find($NIDN);
        
        if (!$dosen) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond(['nama_dosen' => $dosen['nama_dosen']]);
        }
    }

    public function create()
    {
        helper(['form', 'filesystem']);
        
        $NIDN = $this->request->getVar('NIDN');
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }
        
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }

        $data = [
            'NIDN' => $NIDN,
            'status' => $this->request->getVar('status'),
        ];

        if ($file = $this->request->getFile('bukti_pdf')) {
            if (!$file->isValid() || $file->getMimeType() !== 'application/pdf') {
                return $this->failValidationError('Invalid PDF file');
            }
            
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $data['bukti_pdf'] = $newName;
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
        helper(['form', 'filesystem']);
        
        $NIDN = $this->request->getVar('NIDN');
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }
        
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }

        $data = [
            'NIDN' => $NIDN,
            'status' => $this->request->getVar('status'),
        ];

        if ($file = $this->request->getFile('bukti_pdf')) {
            if (!$file->isValid() || $file->getMimeType() !== 'application/pdf') {
                return $this->failValidationError('Invalid PDF file');
            }
            
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $data['bukti_pdf'] = $newName;
        }

        $model = new Iku4Model();
        $dataToUpdate = $model->find($iku4_id);

        if (!$dataToUpdate) return $this->failNotFound('No Data Found');

        $model->update($iku4_id, $data);

        return $this->respondUpdated([
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ]);
    }

    public function show($iku4_id = null)
    {
        $model = new Iku4Model();
        $data = $model->find($iku4_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function delete($iku4_id = null)
    {
        $model = new Iku4Model();
        $data = $model->find($iku4_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $model->delete($iku4_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
    }
}
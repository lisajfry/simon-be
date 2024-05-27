<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku4Model;
use App\Models\DosenModel;

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
        helper(['form']);

        // Ambil NIM dari request
        $NIDN = $this->request->getVar('NIDN');

        // Periksa apakah NIM valid
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }

        // Cari data dosen berdasarkan NIDN
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();

        // Periksa apakah data dosen ditemukan
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }

        $bukti_pdfFile = $this->request->getFile('bukti_pdf');
        if ($bukti_pdfFile->isValid() && !$bukti_pdfFile->hasMoved()) {
            $newName = $bukti_pdfFile->getRandomName();
            $bukti_pdfFile->move(WRITEPATH . 'uploads', $newName);

        // Data untuk disimpan
        $data = [
            'NIDN' => $NIDN,
            'status' => $this->request->getVar('status'),
            'bukti_pdf' => $newName,
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
    }
    public function update($iku4_id = null)
    {
        helper(['form']);

        // Ambil NIM dari request
        $NIDN = $this->request->getVar('NIDN');

        // Periksa apakah NIM valid
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }

        // Cari data dosen berdasarkan NIDN
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();

        // Periksa apakah data dosen ditemukan
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }

        // Data untuk diupdate
        $data = [
            'NIDN' => $NIDN,
            'status' => $this->request->getVar('status'),
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
<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku2prestasiModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;

class Iku2prestasi extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new Iku2prestasiModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku2prestasi_id = null)
    {
        $model = new Iku2prestasiModel();
        $data = $model->find($iku2prestasi_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function create()
    {
        helper(['form']);

        // Ambil NIM dari request
        $NIM = $this->request->getVar('NIM');

        // Periksa apakah NIM valid
        if (!$NIM) {
            return $this->failValidationError('NIM is required');
        }

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();

        // Periksa apakah data mahasiswa ditemukan
        if (!$mahasiswa) {
            return $this->failValidationError('No Data Found for the given NIM');
        }


        // Ambil NIM dari request
        $NIDN = $this->request->getVar('NIDN');

        // Periksa apakah NIM valid
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }

        // Cari data mahasiswa berdasarkan NIM
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();

        // Periksa apakah data mahasiswa ditemukan
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }
      
                // Data untuk disimpan
            $data = [
                'NIM' => $NIM,
                'NIDN' => $NIDN,
                'tingkat_lomba' => $this->request->getVar('tingkat_lomba'),
                'prestasi' => $this->request->getVar('prestasi'),
            ];

        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new Iku2prestasiModel();
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

    public function update($iku2prestasi_id = null)
    {
        helper(['form']);

        // Ambil NIM dari request
        $NIM = $this->request->getVar('NIM');

        // Periksa apakah NIM valid
        if (!$NIM) {
            return $this->failValidationError('NIM is required');
        }

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();

        // Periksa apakah data mahasiswa ditemukan
        if (!$mahasiswa) {
            return $this->failValidationError('No Data Found for the given NIM');
        }

        $NIDN = $this->request->getVar('NIDN');

        // Periksa apakah NIM valid
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }

        // Cari data mahasiswa berdasarkan NIM
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();

        // Periksa apakah data mahasiswa ditemukan
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }


      // Data untuk disimpan
            $data = [
                'NIM' => $NIM,
                'NIDN' => $NIDN,
                'tingkat_lomba' => $this->request->getVar('tingkat_lomba'),
                'prestasi' => $this->request->getVar('prestasi'),
            ];

        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new Iku2prestasiModel();
        $dataToUpdate = $model->find($iku2prestasi_id);

        if (!$dataToUpdate) return $this->failNotFound('No Data Found');

        $model->update($iku2prestasi_id, $data);

        // Kode untuk menampilkan view setelah update
        return view('edit_iku2prestasi', $data);
    }

    public function show($iku2prestasi_id = null)
    {
        $model = new Iku2prestasiModel();
        $data = $model->find($iku2prestasi_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function delete($iku2prestasi_id = null)
    {
        $model = new Iku2prestasiModel();
        $data = $model->find($iku2prestasi_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $model->delete($iku2prestasi_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
    }

}

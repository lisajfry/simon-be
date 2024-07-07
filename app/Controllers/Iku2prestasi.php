<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku2prestasiModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;
use CodeIgniter\HTTP\Response;

class Iku2prestasi extends ResourceController
{
    use ResponseTrait;

    // Index with year filter
    public function index()
    {
        $model = new Iku2prestasiModel();
        $year = $this->request->getVar('year');

        if ($year) {
            $data = $model->where('tahun', $year)->findAll();
        } else {
            $data = $model->findAll();
        }

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
        $NIDN = $this->request->getVar('NIDN');

        // Periksa apakah NIM valid
        if (!$NIM) {
            return $this->failValidationError('NIM is required');
        }
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();

        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();

        // Periksa apakah data mahasiswa ditemukan
        if (!$mahasiswa) {
            return $this->failValidationError('No Data Found for the given NIM');
        }

        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }

        $sertifikatFile = $this->request->getFile('sertifikat');
        if ($sertifikatFile->isValid() && !$sertifikatFile->hasMoved()) {
            $newName = $sertifikatFile->getRandomName();
            $sertifikatFile->move(WRITEPATH . 'uploads', $newName);
        
            // Data untuk disimpan
            $data = [
                'NIM' => $NIM,
                'NIDN' => $NIDN,
                'tahun' => $this->request->getVar('tahun'),
                'nama_kompetisi' => $this->request->getVar('nama_kompetisi'),
                'penyelenggara' => $this->request->getVar('penyelenggara'),
                'tingkat_kompetisi' => $this->request->getVar('tingkat_kompetisi'),
                'jmlh_peserta' => $this->request->getVar('jmlh_peserta'),
                'prestasi' => $this->request->getVar('prestasi'),
                'countries' => json_encode($this->request->getVar('countries')),
                'provinces' => json_encode($this->request->getVar('provinces')),
                'jmlh_negara_mengikuti' => $this->request->getVar('jmlh_negara_mengikuti'),
                'jmlh_provinsi_mengikuti' => $this->request->getVar('jmlh_provinsi_mengikuti'),
                'sertifikat' => $newName,
                // tambahkan field lainnya sesuai kebutuhan
            ];

            $model = new Iku2prestasiModel();
            $model->save($data);

            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => 'Data Inserted'
                ]
            ];

            return $this->respondCreated($response);
        }
    }

    public function update($id = null)
    {
        helper(['form']);

        // Ambil NIM dari request
        $NIM = $this->request->getVar('NIM');
        $NIDN = $this->request->getVar('NIDN');

        // Periksa apakah NIM valid
        if (!$NIM) {
            return $this->failValidationError('NIM is required');
        }
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();

        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();

        // Periksa apakah data mahasiswa ditemukan
        if (!$mahasiswa) {
            return $this->failValidationError('No Data Found for the given NIM');
        }

        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }

        $sertifikatFile = $this->request->getFile('sertifikat');
        if ($sertifikatFile->isValid() && !$sertifikatFile->hasMoved()) {
            $newName = $sertifikatFile->getRandomName();
            $sertifikatFile->move(WRITEPATH . 'uploads', $newName);
        
            // Data untuk disimpan
            $data = [
                'NIM' => $NIM,
                'NIDN' => $NIDN,
                'tahun' => $this->request->getVar('tahun'),
                'nama_kompetisi' => $this->request->getVar('nama_kompetisi'),
                'penyelenggara' => $this->request->getVar('penyelenggara'), 
                'tingkat_kompetisi' => $this->request->getVar('tingkat_kompetisi'),
                'jmlh_peserta' => $this->request->getVar('jmlh_peserta'),
                'prestasi' => $this->request->getVar('prestasi'),
                'countries' => json_encode($this->request->getVar('countries')),
                'provinces' => json_encode($this->request->getVar('provinces')),
                'jmlh_negara_mengikuti' => $this->request->getVar('jmlh_negara_mengikuti'),
                'jmlh_provinsi_mengikuti' => $this->request->getVar('jmlh_provinsi_mengikuti'),
                'sertifikat' => $newName,
            ];

            $model = new Iku2prestasiModel();
            $model->update($id, $data);

            // Kode untuk menampilkan view setelah update
            return view('edit_iku2prestasi', $data);
        }
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

<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku2kegiatanModel;
use App\Models\MahasiswaModel;

class Iku2kegiatan extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new Iku2kegiatanModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku2kegiatan_id = null)
    {
        $model = new Iku2kegiatanModel();
        $data = $model->find($iku2kegiatan_id);
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

      
      // Data untuk disimpan
$data = [
    'NIM' => $NIM,
    'aktivitas' => $this->request->getVar('aktivitas'),
    'tempat_kegiatan' => $this->request->getVar('tempat_kegiatan'),
    'sks' => $this->request->getVar('sks'),
    'tgl_mulai_kegiatan' => $this->request->getVar('tgl_mulai_kegiatan'), // Tanggal dalam format yang sesuai
    'tgl_selesai_kegiatan' => $this->request->getVar('tgl_selesai_kegiatan'), // Tanggal dalam format yang sesuai
];


        

        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new Iku2kegiatanModel();
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

    public function update($iku2kegiatan_id = null)
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

      // Data untuk disimpan
$data = [
    'NIM' => $NIM,
    'aktivitas' => $this->request->getVar('aktivitas'),
    'tempat_kegiatan' => $this->request->getVar('tempat_kegiatan'),
    'sks' => $this->request->getVar('sks'),
    'tgl_mulai_kegiatan' => $this->request->getVar('tgl_mulai_kegiatan'), // Tanggal dalam format yang sesuai
    'tgl_selesai_kegiatan' => $this->request->getVar('tgl_selesai_kegiatan'), // Tanggal dalam format yang sesuai
];


        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new Iku2kegiatanModel();
        $dataToUpdate = $model->find($iku2kegiatan_id);

        if (!$dataToUpdate) return $this->failNotFound('No Data Found');

        $model->update($iku2kegiatan_id, $data);

        // Kode untuk menampilkan view setelah update
        return view('edit_iku2kegiatan', $data);
    }

    public function show($iku2kegiatan_id = null)
    {
        $model = new Iku2kegiatanModel();
        $data = $model->find($iku2kegiatan_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function delete($iku2kegiatan_id = null)
    {
        $model = new Iku2kegiatanModel();
        $data = $model->find($iku2kegiatan_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $model->delete($iku2kegiatan_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
    }

}

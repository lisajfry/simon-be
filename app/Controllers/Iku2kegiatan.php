<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku2kegiatanModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;

class Iku2kegiatan extends ResourceController
{
    use ResponseTrait;

    // Index with year filter
    public function index()
    {
        $model = new Iku2kegiatanModel();
        $year = $this->request->getVar('year');

        if ($year) {
            $data = $model->where('tahun', $year)->findAll();
        } else {
            $data = $model->findAll();
        }

        return $this->respond($data);
    }

    // Fetch available years
    public function getFilters()
    {
        $model = new Iku2kegiatanModel();
        $years = $model->select('tahun')->distinct()->findAll();

        return $this->respond(['years' => array_column($years, 'tahun')]);
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

        // Data untuk disimpan
        $data = [
            'NIM' => $NIM,
            'NIDN' => $NIDN,
            'semester' => $this->request->getVar('semester'),
            'tahun' => $this->request->getVar('tahun'),
            'aktivitas' => $this->request->getVar('aktivitas'),
            'tempat_kegiatan' => $this->request->getVar('tempat_kegiatan'),
            'sks' => $this->request->getVar('sks'),
            'tgl_mulai_kegiatan' => $this->request->getVar('tgl_mulai_kegiatan'),
            'tgl_selesai_kegiatan' => $this->request->getVar('tgl_selesai_kegiatan'),
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

        // Ambil NIM dan NIDN dari request
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

        // Data untuk diupdate
        $data = [
            'NIM' => $NIM,
            'NIDN' => $NIDN,
            'semester' => $this->request->getVar('semester'),
            'tahun' => $this->request->getVar('tahun'),
            'aktivitas' => $this->request->getVar('aktivitas'),
            'tempat_kegiatan' => $this->request->getVar('tempat_kegiatan'),
            'sks' => $this->request->getVar('sks'),
            'tgl_mulai_kegiatan' => $this->request->getVar('tgl_mulai_kegiatan'),
            'tgl_selesai_kegiatan' => $this->request->getVar('tgl_selesai_kegiatan'),
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

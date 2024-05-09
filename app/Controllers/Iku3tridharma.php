<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku3tridharmaModel;
use App\Models\DosenModel;

class Iku3tridharma extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new Iku3tridharmaModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku3tridharma_id = null)
    {
        $model = new Iku3tridharmaModel();
        $data = $model->find($iku3tridharma_id);
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
    'NIDN' => $NIDN,
    'surat_sk' => $this->request->getVar('surat_sk'),
    'ptn_tridharma' => $this->request->getVar('ptn_ttridharma'),
    'tgl_mulai_tridharma' => $this->request->getVar('tgl_mulai_tridharma'), // Tanggal dalam format yang sesuai
    'tgl_selesai_tridharma' => $this->request->getVar('tgl_selesai_tridharma'), // Tanggal dalam format yang sesuai
];


        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new Iku3tridharmaModel();
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

    public function update($iku3tridharma_id = null)
    {
        helper(['form']);

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
    'NIDN' => $NIDN,
    'surat_sk' => $this->request->getVar('surat_sk'),
    'ptn_tridharma' => $this->request->getVar('ptn_tridharma'),
    'tgl_mulai_tridharma' => $this->request->getVar('tgl_mulai_tridharma'), // Tanggal dalam format yang sesuai
    'tgl_selesai_tridharma' => $this->request->getVar('tgl_selesai_tridharma'), // Tanggal dalam format yang sesuai
];


        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new Iku3tridharmaModel();
        $dataToUpdate = $model->find($iku3tridharma_id);

        if (!$dataToUpdate) return $this->failNotFound('No Data Found');

        $model->update($iku3tridharma_id, $data);

        // Kode untuk menampilkan view setelah update
        return view('edit_iku3tridharma', $data);
    }

    public function show($iku3tridharma_id = null)
    {
        $model = new Iku3tridharmaModel();
        $data = $model->find($iku3tridharma_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function delete($iku3tridharma_id = null)
    {
        $model = new Iku3tridharmaModel();
        $data = $model->find($iku3tridharma_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $model->delete($iku3tridharma_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
    }

}

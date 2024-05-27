<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku2inboundModel;
use App\Models\MahasiswaModel;

class Iku2Inbound extends ResourceController
{
    use ResponseTrait;
    protected $iku2inboundModel;
    public function __construct()
    {
        $this->iku2inboundModel = new Iku2inboundModel();
    }

    public function index()
    {
        $model = new Iku2inboundModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku2inbound_id = null)
    {
        $model = new Iku2inboundModel();
        $data = $model->find($iku2inbound_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function create()
    {
        helper(['form']);

        $NIM = $this->request->getVar('NIM');
        if (!$NIM) {
            return $this->failValidationError('NIM is required');
        }

        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();
        if (!$mahasiswa) {
            return $this->failValidationError('No Data Found for the given NIM');
        }

        $surat_rekomendasiFile = $this->request->getFile('surat_rekomendasi');
        if ($surat_rekomendasiFile->isValid() && !$surat_rekomendasiFile->hasMoved()) {
            $newName = $surat_rekomendasiFile->getRandomName();
            $surat_rekomendasiFile->move(WRITEPATH . 'uploads', $newName);

            $data = [
                'NIM' => $NIM,
                'asal_negara' => $this->request->getVar('asal_negara'),
                'asal_ptn' => $this->request->getVar('asal_ptn'),
                'surat_rekomendasi' => $newName,
                'sks' => $this->request->getVar('sks'),
                'tgl_mulai_inbound' => $this->request->getVar('tgl_mulai_inbound'),
                'tgl_selesai_inbound' => $this->request->getVar('tgl_selesai_inbound'),
            ];

            $model = new Iku2inboundModel();
            $model->save($data);
            return redirect()->to('/upload/success');
        } else {
            return $this->failValidationError('Failed to upload surat_rekomendasi file');
        }
    }

    public function update($id_iku2inbound = null)
{
    $NIM = $this->request->getVar('NIM');
    if (!$NIM) {
        return $this->failValidationError('NIM is required');
    }

    $mahasiswaModel = new MahasiswaModel();
    $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();
    if (!$mahasiswa) {
        return $this->failValidationError('No Data Found for the given NIM');
    }

    $surat_rekomendasiFile = $this->request->getFile('surat_rekomendasi');
        if ($surat_rekomendasiFile->isValid() && !$surat_rekomendasiFile->hasMoved()) {
            $newName = $surat_rekomendasiFile->getRandomName();
            $surat_rekomendasiFile->move(WRITEPATH . 'uploads', $newName);

    $data = [
            'NIM' => $NIM,
            'asal_negara' => $this->request->getVar('asal_negara'),
            'asal_ptn' => $this->request->getVar('asal_ptn'),
            'surat_rekomendasi' => $newName,
            'sks' => $this->request->getVar('sks'),
            'tgl_mulai_inbound' => $this->request->getVar('tgl_mulai_inbound'),
            'tgl_selesai_inbound' => $this->request->getVar('tgl_selesai_inbound'),
    ];

    $model = new Iku2inboundModel();
    $model->update($id_iku2inbound, $data);

    return redirect()->to('/iku2inbound'); // Ganti dengan URL yang sesuai
}
}


    public function download($filename)
{
    return $this->response->download(WRITEPATH . 'uploads/' . $filename, null);
}



    public function show($iku2inbound_id = null)
    {
        $model = new Iku2inboundModel();
        $data = $model->find($iku2inbound_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function delete($iku2inbound_id = null)
    {
        $model = new Iku2inboundModel();
        $data = $model->find($iku2inbound_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $model->delete($iku2inbound_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
    }

    public function success()
    {
        // Anda bisa menampilkan pesan sukses di sini, atau merender view yang berisi pesan sukses.
        // Contoh sederhana: mengembalikan pesan sukses sebagai response JSON.
        return $this->respond(['message' => 'File uploaded successfully']);
    }
}

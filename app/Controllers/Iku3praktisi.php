<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku3praktisiModel;
use App\Models\DosenModel;

class Iku3praktisi extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $year = $this->request->getVar('year');
        $model = new Iku3praktisiModel();
        
        if ($year) {
            $data = $model->where('tahun', $year)->findAll();
        } else {
            $data = $model->findAll();
        }
        
        return $this->respond($data);
    }

    public function get($iku3praktisi_id = null)
    {
        $model = new Iku3praktisiModel();
        $data = $model->find($iku3praktisi_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function create()
    {
        helper(['form']);

        $NIDN = $this->request->getVar('NIDN');
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }

        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }

        $surat_skFile = $this->request->getFile('surat_sk');
        if ($surat_skFile->isValid() && !$surat_skFile->hasMoved()) {
            $newName = $surat_skFile->getRandomName();
            $surat_skFile->move(WRITEPATH . 'uploads', $newName);

            $data = [
                'NIDN' => $NIDN,
                'surat_sk' => $newName,
                'tahun' => $this->request->getVar('tahun'),
                'instansi_praktisi' => $this->request->getVar('instansi_praktisi'),
                'tgl_mulai_praktisi' => $this->request->getVar('tgl_mulai_praktisi'),
                'tgl_selesai_praktisi' => $this->request->getVar('tgl_selesai_praktisi'),
            ];

            $model = new Iku3praktisiModel();
            $model->save($data);
            return redirect()->to('/upload/success');
        } else {
            return $this->failValidationError('Failed to upload surat_sk file');
        }
    }

    public function download($filename)
    {
        return $this->response->download(WRITEPATH . 'uploads/' . $filename, null);
    }

    public function update($id_iku3praktisi = null)
    {
        $NIDN = $this->request->getVar('NIDN');
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }

        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given NIDN');
        }

        $surat_skFile = $this->request->getFile('surat_sk');
        if ($surat_skFile->isValid() && !$surat_skFile->hasMoved()) {
            $newName = $surat_skFile->getRandomName();
            $surat_skFile->move(WRITEPATH . 'uploads', $newName);

            $data = [
                'NIDN' => $NIDN,
                'surat_sk' => $newName,
                'tahun' => $this->request->getVar('tahun'),
                'instansi_praktisi' => $this->request->getVar('instansi_praktisi'),
                'tgl_mulai_praktisi' => $this->request->getVar('tgl_mulai_praktisi'),
                'tgl_selesai_praktisi' => $this->request->getVar('tgl_selesai_praktisi'),
            ];

            $model = new Iku3praktisiModel();
            $model->update($id_iku3praktisi, $data);

            return redirect()->to('/iku3praktisi'); // Ganti dengan URL yang sesuai
        }
    }

    public function show($iku3praktisi_id = null)
    {
        $model = new Iku3praktisiModel();
        $data = $model->find($iku3praktisi_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function delete($iku3praktisi_id = null)
    {
        $model = new Iku3praktisiModel();
        $data = $model->find($iku3praktisi_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $model->delete($iku3praktisi_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
    }

    public function success()
    {
        // Anda bisa menampilkan pesan sukses di sini, atau merender view yang berisi pesan sukses.
        // Contoh sederhana: mengembalikan pesan sukses sebagai response JSON.
        return $this->respond(['message' => 'File uploaded successfully']);
    }
}

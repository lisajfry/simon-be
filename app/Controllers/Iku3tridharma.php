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
    protected $iku3tridharmaModel;

    public function __construct()
    {
        $this->iku3tridharmaModel = new Iku3tridharmaModel();
    }

    public function index()
    {
        $year = $this->request->getVar('year');
        $model = new Iku3tridharmaModel();
        
        if ($year) {
            $data = $model->where('tahun', $year)->findAll();
        } else {
            $data = $model->findAll();
        }
        
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
                'jenis_tridharma' => $this->request->getVar('jenis_tridharma'),
                'nama_aktivitas_tridharma' => $this->request->getVar('nama_aktivitas_tridharma'),
                'tempat_tridharma' => $this->request->getVar('tempat_tridharma'),
                'tgl_mulai_tridharma' => $this->request->getVar('tgl_mulai_tridharma'),
                'tgl_selesai_tridharma' => $this->request->getVar('tgl_selesai_tridharma'),
            ];

            $model = new Iku3tridharmaModel();
            $model->save($data);
            return redirect()->to('/upload/success');
        } else {
            return $this->failValidationError('Failed to upload surat_sk file');
        }
    }

    public function update($id_iku3tridharma = null)
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
                'jenis_tridharma' => $this->request->getVar('jenis_tridharma'),
                'tahun' => $this->request->getVar('tahun'),
                'nama_aktivitas_tridharma' => $this->request->getVar('nama_aktivitas_tridharma'),
                'tempat_tridharma' => $this->request->getVar('tempat_tridharma'),
                'tgl_mulai_tridharma' => $this->request->getVar('tgl_mulai_tridharma'),
                'tgl_selesai_tridharma' => $this->request->getVar('tgl_selesai_tridharma'),
            ];

            $model = new Iku3tridharmaModel();
            $model->update($id_iku3tridharma, $data);

            return redirect()->to('/iku3tridharma'); // Ganti dengan URL yang sesuai
        }
    }

    public function download($filename)
    {
        return $this->response->download(WRITEPATH . 'uploads/' . $filename, null);
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

    public function success()
    {
        // Anda bisa menampilkan pesan sukses di sini, atau merender view yang berisi pesan sukses.
        // Contoh sederhana: mengembalikan pesan sukses sebagai response JSON.
        return $this->respond(['message' => 'File uploaded successfully']);
    }
}

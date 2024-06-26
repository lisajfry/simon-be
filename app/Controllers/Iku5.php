<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku5Model;
use App\Models\DosenModel;
use App\Models\DosenNIDKModel;

class Iku5 extends ResourceController
{
    use ResponseTrait;
    protected $iku5Model;

    public function __construct()
    {
        $this->iku5Model = new Iku5Model();
    }

    public function index()
    {
        $model = new Iku5Model();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku5_id = null)
    {
        $model = new Iku5Model();
        $data = $model->find($iku5_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function show($iku5_id = null)
    {
        $data = $this->iku5Model->find($iku5_id);

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
        $NIDK = $this->request->getVar('NIDK');

        if (!$NIDN && !$NIDK) {
            return $this->failValidationError('Either NIDN or NIDK is required');
        }

        if ($NIDN) {
            $dosenModel = new DosenModel();
            $dosen = $dosenModel->where('NIDN', $NIDN)->first();
            if (!$dosen) {
                return $this->failValidationError('No Data Found for the given NIDN');
            }
        }

        if ($NIDK) {
            $dosenNIDKModel = new DosenNIDKModel();
            $dosenNIDK = $dosenNIDKModel->where('NIDK', $NIDK)->first();
            if (!$dosenNIDK) {
                return $this->failValidationError('No Data Found for the given NIDK');
            }
        }

        $buktiPendukungFile = $this->request->getFile('bukti_pendukung');
        if ($buktiPendukungFile->isValid() && !$buktiPendukungFile->hasMoved()) {
            $newName = $buktiPendukungFile->getRandomName();
            $buktiPendukungFile->move(WRITEPATH . 'uploads', $newName);

            $data = [
                'NIDN' => $NIDN,
                'status' => $this->request->getVar('status'),
                'jenis_karya' => $this->request->getVar('jenis_karya'),
                'kategori_karya' => $this->request->getVar('kategori_karya'),
                'judul_karya' => $this->request->getVar('judul_karya'),
                'pendanaan' => $this->request->getVar('pendanaan'),
                'kriteria' => $this->request->getVar('kriteria'),
                'bukti_pendukung' => $newName,
                'tahun' => $this->request->getVar('tahun'),
            ];

            if ($NIDK) {
                $data['NIDK'] = $NIDK;
            }

            $this->iku5Model->save($data);
            return redirect()->to('/iku5/success');
        } else {
            return $this->failValidationError('Failed to upload bukti_pendukung file');
        }
    }

    public function update($id_iku5 = null)
    {
        $NIDN = $this->request->getVar('NIDN');
        $NIDK = $this->request->getVar('NIDK');

        if (!$NIDN && !$NIDK) {
            return $this->failValidationError('Either NIDN or NIDK is required');
        }

        if ($NIDN) {
            $dosenModel = new DosenModel();
            $dosen = $dosenModel->where('NIDN', $NIDN)->first();
            if (!$dosen) {
                return $this->failValidationError('No Data Found for the given NIDN');
            }
        }

        if ($NIDK) {
            $dosenNIDKModel = new DosenNIDKModel();
            $dosenNIDK = $dosenNIDKModel->where('NIDK', $NIDK)->first();
            if (!$dosenNIDK) {
                return $this->failValidationError('No Data Found for the given NIDK');
            }
        }

        $data = [
            'NIDN' => $NIDN,
            'status' => $this->request->getVar('status'),
            'jenis_karya' => $this->request->getVar('jenis_karya'),
            'kategori_karya' => $this->request->getVar('kategori_karya'),
            'judul_karya' => $this->request->getVar('judul_karya'),
            'pendanaan' => $this->request->getVar('pendanaan'),
            'kriteria' => $this->request->getVar('kriteria'),
            'tahun' => $this->request->getVar('tahun'),
        ];

        if ($NIDK) {
            $data['NIDK'] = $NIDK;
        }

        $buktiPendukungFile = $this->request->getFile('bukti_pendukung');
        if ($buktiPendukungFile->isValid() && !$buktiPendukungFile->hasMoved()) {
            $newName = $buktiPendukungFile->getRandomName();
            $buktiPendukungFile->move(WRITEPATH . 'uploads', $newName);
            $data['bukti_pendukung'] = $newName;
        }

        $this->iku5Model->update($id_iku5, $data);

        return redirect()->to('/iku5'); // Change this to the appropriate URL
    }

    public function delete($iku5_id = null)
    {
        $data = $this->iku5Model->find($iku5_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $this->iku5Model->delete($iku5_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
    }

    public function success()
    {
        return $this->respond(['message' => 'File uploaded successfully']);
    }
}

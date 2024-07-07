<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
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

    // Index with year filter
    public function index()
    {
        $year = $this->request->getVar('year');

        if ($year) {
            $data = $this->iku5Model->where('tahun', $year)->findAll();
        } else {
            $data = $this->iku5Model->findAll();
        }

        return $this->respond($data);
    }

    // Fetch available years
    public function getFilters()
    {
        $years = $this->iku5Model->select('tahun')->distinct()->findAll();
        return $this->respond(['years' => array_column($years, 'tahun')]);
    }

    public function get($iku5_id = null)
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

        if (empty($NIDN) && empty($NIDK)) {
            return redirect()->back()->withInput()->with('error', 'Either NIDN or NIDK must be filled');
        }

        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();
        $dosenNIDKModel = new DosenNIDKModel();
        $dosenNIDK = $dosenNIDKModel->where('NIDK', $NIDK)->first();

        $bukti_pendukungFile = $this->request->getFile('bukti_pendukung');
        if ($bukti_pendukungFile->isValid() && !$bukti_pendukungFile->hasMoved()) {
            $newName = $bukti_pendukungFile->getRandomName();
            $bukti_pendukungFile->move(WRITEPATH . 'uploads', $newName);

            $data = [
                'status' => $this->request->getVar('status'),
                'jenis_karya' => $this->request->getVar('jenis_karya'),
                'kategori_karya' => $this->request->getVar('kategori_karya'),
                'judul_karya' => $this->request->getVar('judul_karya'),
                'pendanaan' => $this->request->getVar('pendanaan'),
                'kriteria' => $this->request->getVar('kriteria'),
                'bukti_pendukung' => $newName,
                'tahun' => $this->request->getVar('tahun'),
            ];

            if (!empty($NIDN)) {
                $data['NIDN'] = $NIDN;
            }
            if (!empty($NIDK)) {
                $data['NIDK'] = $NIDK;
            }

            $this->iku5Model->save($data);
            return redirect()->to('/upload/success');
        } else {
            return $this->failValidationError('Failed to upload bukti_pendukung file');
        }
    }

    public function update($id_iku5 = null)
    {
        helper(['form']);

        $NIDN = $this->request->getVar('NIDN');
        $NIDK = $this->request->getVar('NIDK');

        if (empty($NIDN) && empty($NIDK)) {
            return $this->failValidationError('NIDN atau NIDK harus diisi.');
        }

        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();
        $dosenNIDKModel = new DosenNIDKModel();
        $dosenNIDK = $dosenNIDKModel->where('NIDK', $NIDK)->first();

        $bukti_pendukungFile = $this->request->getFile('bukti_pendukung');
        if ($bukti_pendukungFile->isValid() && !$bukti_pendukungFile->hasMoved()) {
            $newName = $bukti_pendukungFile->getRandomName();
            $bukti_pendukungFile->move(WRITEPATH . 'uploads', $newName);
        } else {
            $newName = null;
        }

        $data = [
            'NIDN' => $NIDN,
            'NIDK' => $NIDK,
            'status' => $this->request->getVar('status'),
            'jenis_karya' => $this->request->getVar('jenis_karya'),
            'kategori_karya' => $this->request->getVar('kategori_karya'),
            'judul_karya' => $this->request->getVar('judul_karya'),
            'pendanaan' => $this->request->getVar('pendanaan'),
            'kriteria' => $this->request->getVar('kriteria'),
            'tahun' => $this->request->getVar('tahun'),
        ];

        if ($newName !== null) {
            $data['bukti_pendukung'] = $newName;
        }

        $this->iku5Model->update($id_iku5, $data);

        return redirect()->to('/iku5');
    }

    public function download($filename)
    {
        return $this->response->download(WRITEPATH . 'uploads/' . $filename, null);
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

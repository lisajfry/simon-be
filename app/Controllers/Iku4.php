<?php
namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku4Model;
use App\Models\DosenModel;
use App\Models\DosenNIDKModel;


class Iku4 extends ResourceController
{
    use ResponseTrait;


    protected $iku4Model;


    public function __construct()
    {
        $this->iku4Model = new Iku4Model();
    }


    public function index()
    {
        $year = $this->request->getGet('year');


        if ($year) {
            $data = $this->iku4Model->where('YEAR(tanggal)', $year)->findAll();
        } else {
            $data = $this->iku4Model->findAll();
        }


        return $this->respond($data);
    }


    public function get($iku4_id = null)
    {
        $data = $this->iku4Model->find($iku4_id);
        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            return $this->respond($data);
        }
    }


    public function getIku4()
    {
        $year = $this->request->getGet('year');


        if ($year) {
            $iku4 = $this->iku4Model->where('YEAR(tanggal)', $year)->findAll();
        } else {
            $iku4 = $this->iku4Model->findAll();
        }


        return $this->response->setJSON($iku4);
    }


    public function getNamaDosen($NIDN = null)
    {
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->find($NIDN);


        if (!$dosen) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            return $this->respond(['nama_dosen' => $dosen['nama_dosen']]);
        }
    }


    public function getNamaDosenNIDK($NIDK = null)
    {
        $dosenNIDKModel = new DosenNIDKModel();
        $dosen = $dosenNIDKModel->find($NIDK);


        if (!$dosen) {
            return $this->failNotFound('Data tidak ditemukan');
        } else {
            return $this->respond(['nama_dosen' => $dosen['nama_dosen']]);
        }
    }


    public function create()
    {
        $NIDN = $this->request->getVar('NIDN');
        $NIDK = $this->request->getVar('NIDK');


        if (empty($NIDN) && empty($NIDK)) {
            return $this->fail('NIDN atau NIDK harus diisi');
        }


        $data = [
            'NIDN' => $NIDN,
            'NIDK' => $NIDK,
            'id_berkas' => $this->request->getVar('id_berkas'),
            'tanggal' => $this->request->getVar('tanggal'),
            'status' => $this->request->getVar('status'),
        ];


        // Handle file upload
        $file = $this->request->getFile('bukti_pdf');
        if ($file->isValid() && $file->getMimeType() === 'application/pdf') {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $data['bukti_pdf'] = $newName;
        } else {
            return $this->fail('File PDF tidak valid');
        }


        if ($this->iku4Model->insert($data)) {
            return $this->respondCreated(['message' => 'Data berhasil disimpan']);
        } else {
            return $this->fail('Gagal menyimpan data');
        }
    }


    public function update($iku4_id = null)
    {
        $NIDN = $this->request->getVar('NIDN');
        $NIDK = $this->request->getVar('NIDK');


        if (empty($NIDN) && empty($NIDK)) {
            return $this->fail('NIDN atau NIDK harus diisi');
        }


        $data = [
            'NIDN' => $NIDN,
            'NIDK' => $NIDK,
            'id_berkas' => $this->request->getVar('id_berkas'),
            'tanggal' => $this->request->getVar('tanggal'),
            'status' => $this->request->getVar('status'),
        ];


        // Handle file upload
        $file = $this->request->getFile('bukti_pdf');
        if ($file->isValid() && $file->getMimeType() === 'application/pdf') {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            $data['bukti_pdf'] = $newName;
        } elseif ($file->getError() !== UPLOAD_ERR_NO_FILE) {
            return $this->fail('File PDF tidak valid');
        }


        if ($this->iku4Model->update($iku4_id, $data)) {
            return $this->respondUpdated(['message' => 'Data berhasil diperbarui']);
        } else {
            return $this->fail('Gagal memperbarui data');
        }
    }


    public function delete($iku4_id = null)
    {
        $data = $this->iku4Model->find($iku4_id);


        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }


        if ($this->iku4Model->delete($iku4_id)) {
            return $this->respondDeleted(['message' => 'Data berhasil dihapus']);
        } else {
            return $this->fail('Gagal menghapus data');
        }
    }
}

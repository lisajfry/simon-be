<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RekapModel;


class Rekap extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new RekapModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($rekap_id = null)
    {
        $model = new RekapModel();
        $data = $model->find($rekap_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    // Mahasiswa.php (Controller)

            public function getNamaMahasiswa($NIM = null)
            {
                $mahasiswaModel = new MahasiswaModel();
                $mahasiswa = $mahasiswaModel->find($NIM);
                
                if (!$mahasiswa) {
                    return $this->failNotFound('No Data Found');
                } else {
                    return $this->respond(['nama_mahasiswa' => $mahasiswa['nama_mahasiswa']]);
                }
            }


    

    public function create()
    {
        helper(['form']);

        // Data untuk disimpan
        $data = [
            'indikator' => $this->request->getVar('indikator'),
            'target' => $this->request->getVar('target')
        ];

        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new RekapModel();
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

    public function update($rekap_id = null)
{
    helper(['form']);

    // Data untuk diupdate
    $data = [
        'indikator' => $this->request->getVar('indikator'),
        'target' => $this->request->getVar('target')
    ];

    // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
    foreach ($data as $key => $value) {
        if (empty($value)) {
            unset($data[$key]);
        }
    }

    $model = new RekapModel();
    $dataToUpdate = $model->find($rekap_id);

    if (!$dataToUpdate) return $this->failNotFound('No Data Found');

    // Periksa apakah data yang diperbarui berbeda dari data yang ada
    if ($dataToUpdate['indikator'] == $data['indikator'] && $dataToUpdate['target'] == $data['target']) {
        return $this->respond(['message' => 'No changes made']);
    }

    $model->update($rekap_id, $data);

}


    public function show($rekap_id = null)
    {
        $model = new RekapModel();
        $data = $model->find($rekap_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function delete($rekap_id = null)
    {
        $model = new RekapModel();
        $data = $model->find($rekap_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $model->delete($rekap_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
    }

}
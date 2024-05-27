<?php


namespace App\Controllers;


use CodeIgniter\RESTful\ResourceController;
use App\Models\Iku7Model;


class Iku7 extends ResourceController
{
    // Index
    public function index()
    {
        $model = new Iku7Model();
        $data = $model->findAll();
        return $this->respond($data);
    }


    // GET
    public function get($iku7_id = null)
    {
        $model = new Iku7Model();
        $data = $model->find($iku7_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }


    // SHOW
    public function show($iku7_id = null)
    {
        $model = new Iku7Model();
        $data = $model->find($iku7_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        }
        return $this->respond($data);
    }


    // CREATE
    public function create()
    {
        $model = new Iku7Model();


        // File Upload Handling
        $file = $this->request->getFile('rps');
        if ($file->isValid() && $file->getExtension() === 'pdf') {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);
            $rpsPath = 'uploads/' . $newName;
        } else {
            return $this->fail('Invalid File or File Type');
        }


        $data = [
            'kode_mk' => $this->request->getVar('kode_mk'),
            'nama_mk' => $this->request->getVar('nama_mk'),
            'tahun' => $this->request->getVar('tahun'),
            'semester' => $this->request->getVar('semester'),
            'kelas' => $this->request->getVar('kelas'),
            'jum_bobot' => $this->request->getVar('jum_bobot'),
            'rps' => $rpsPath, // Menyimpan path file RPS
        ];


        $model->insert($data);


        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data Inserted'
            ]
        ];


        return $this->respondCreated($response);
    }


    // UPDATE
    public function update($iku7_id = null)
    {
        $model = new Iku7Model();
        $data = [
            'kode_mk' => $this->request->getVar('kode_mk'),
            'nama_mk' => $this->request->getVar('nama_mk'),
            'tahun' => $this->request->getVar('tahun'),
            'semester' => $this->request->getVar('semester'),
            'kelas' => $this->request->getVar('kelas'),
            'jum_bobot' => $this->request->getVar('jum_bobot'),
        ];


        $model->update($iku7_id, $data);


        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];


        return $this->respond($response);
    }


    // DELETE
    public function delete($iku7_id = null)
    {
        $model = new Iku7Model();
        $model->delete($iku7_id);


        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
        ];


        return $this->respondDeleted($response);
    }
}

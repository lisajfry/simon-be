<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Codeigniter\API\ResponseTrait;
use App\Models\iku7Model;

class Iku7 extends ResourceController
{
    use ResponseTrait;

    //index
    public function index()
    {
        $model = new Iku7Model();
        $data = $model->findAll();
        return $this->respond($data);
    }

    //GET
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

    //SHOW
    public function show($iku7_id = null)
    {
        $model = new Iku7Model();
        $data = $model->find(['iku7_id'=> $iku7_id]);
        if (!$data) return $this->failNotFound('No Data Found');
        return $this->respond($data);
    }

    //CREATE
    public function create()
    {
        helper(['form']);
        $rules = [
            'Kode_MK'                        => 'required|numeric',
            'Nama_MK'                        => 'required',
            'Tahun'                          => 'required|numeric',
            'Semester'                       => 'required|numeric',
            'Kelas'                          => 'required',
            'Presentase_Bobot_Terpenuhi'     => 'required|numeric',
            'RPS'                            => 'required',
            'Rancangan_Tugas_Dan_Evaluasi'   => 'required',
        ];

        $data = [
            'Kode_MK'                      => $this->request->getVar('Kode_MK'),
            'Nama_MK'                      => $this->request->getVar('Nama_MK'),
            'Tahun'                        => $this->request->getVar('Tahun'),
            'Semester'                     => $this->request->getVar('Semester'),
            'Kelas'                        => $this->request->getVar('Kelas'),
            'Presentase_Bobot_Terpenuhi'   => $this->request->getVar('Presentase_Bobot_Terpenuhi'),
            'RPS'                          => $this->request->getVar('RPS'),
            'Rancangan_Tugas_Dan_Evaluasi' => $this->request->getVar('Rancangan_Tugas_Dan_Evaluasi')
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors(), 400);
        
        $model = new Iku7Model();
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


    //UPDATE
    public function update($iku7_id = null)
    {
        helper(['form']);
        $rules = [
            'Kode_MK'                        => 'required|numeric',
            'Nama_MK'                        => 'required',
            'Tahun'                          => 'required|numeric',
            'Semester'                       => 'required|numeric',
            'Kelas'                          => 'required',
            'Presentase_Bobot_Terpenuhi'     => 'required|numeric',
            'RPS'                            => 'required',
            'Rancangan_Tugas_Dan_Evaluasi'   => 'required',
        ];

        $data = [
            'Kode_MK'                      => $this->request->getVar('Kode_MK'),
            'Nama_MK'                      => $this->request->getVar('Nama_MK'),
            'Tahun'                        => $this->request->getVar('Tahun'),
            'Semester'                     => $this->request->getVar('Semester'),
            'Kelas'                        => $this->request->getVar('Kelas'),
            'Presentase_Bobot_Terpenuhi'   => $this->request->getVar('Presentase_Bobot_Terpenuhi'),
            'RPS'                          => $this->request->getVar('RPS'),
            'Rancangan_Tugas_Dan_Evaluasi' => $this->request->getVar('Rancangan_Tugas_Dan_Evaluasi')
        ];

        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new Iku7Model();
        $findById = $model->find(['iku7_id'=> $iku7_id]);
        if (!$findById) return $this->failNotFound('No Data Found');
        $model->update($iku7_id, $data);
        $response = [
            'status' => 200,
            'error'  => null,
            'messages' => [
                'success' => 'data updated!'
            ]
        ];

        return $this->respond($response);

    }

    //DELETE
    public function delete($iku7_id = null)
    {
        $model = new Iku7Model();

        if (!$iku7_id) return $this->failNotFound('No ID Provided');

        $dataToDelete = $model->find($iku7_id);

        if (!$dataToDelete) return $this->failNotFound('No Data Found');

        $model->delete($iku7_id);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
        ];

        return $this->respond($response);
    }


}
<?php


namespace App\Controllers;


use App\Models\BerkasSertifikasiModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class BerkasSertifikasi extends ResourceController
{
    use ResponseTrait;


    public function index()
    {
        $model = new BerkasSertifikasiModel();
        $data = $model->findAll();
        return $this->respond($data);
    }


    public function get($id_berkas = null)
    {
        $model = new BerkasSertifikasiModel();
        $data = $model->find($id_berkas);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }


    public function show($id_berkas = null)
    {
        $model = new BerkasSertifikasiModel();
        $data = $model->find($id_berkas);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }


    public function create()
    {
        helper(['form']);
        $rules = [
            'id_berkas' => 'required|is_unique[berkassertifikasi.id_berkas]',
            'nama_berkas' => 'required',
            // add other necessary fields and their validation rules
        ];


        $data = [
            'id_berkas' => $this->request->getVar('id_berkas'),
            'nama_berkas' => $this->request->getVar('nama_berkas'),
            // add other necessary fields
        ];


        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }


        $model = new BerkasSertifikasiModel();
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


    public function update($id_berkas = null)
    {
        helper(['form']);
        $rules = [
            'nama_berkas' => 'required',
            // add other necessary fields and their validation rules
        ];


        $data = [
            'nama_berkas' => $this->request->getVar('nama_berkas'),
            // add other necessary fields
        ];


        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }


        $model = new BerkasSertifikasiModel();
        $dataToUpdate = $model->find($id_berkas);


        if (!$dataToUpdate) {
            return $this->failNotFound('No Data Found');
        }


        $model->update($id_berkas, $data);


        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];


        return $this->respond($response);
    }


    public function delete($id_berkas = null)
    {
        $model = new BerkasSertifikasiModel();
        $dataToDelete = $model->find($id_berkas);


        if (!$dataToDelete) {
            return $this->failNotFound('No Data Found');
        }


        $model->delete($id_berkas);


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



<?php

namespace App\Controllers;

use App\Models\YearModel;
use CodeIgniter\RESTful\ResourceController;

class Year extends ResourceController
{
    protected $modelName = 'App\Models\YearModel';
    protected $format    = 'json';

    public function index()
    {
        $years = $this->model->findAll();
        return $this->respond($years);
    }

    public function show($id = null)
    {
        $year = $this->model->find($id);
        if ($year) {
            return $this->respond($year);
        } else {
            return $this->failNotFound('Year not found');
        }
    }

    public function create()
    {
        $data = [
            'tahun' => $this->request->getPost('tahun')
        ];

        if ($this->model->insert($data)) {
            return $this->respondCreated($data, 'Year added successfully');
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function update($id = null)
    {
        $data = [
            'tahun' => $this->request->getRawInput()['tahun']
        ];

        if ($this->model->update($id, $data)) {
            return $this->respond($data, 200, 'Year updated successfully');
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id], 'Year deleted successfully');
        } else {
            return $this->failNotFound('Year not found');
        }
    }
}

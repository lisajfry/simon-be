<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LulusanModel;

class Lulusan extends ResourceController
{
    use ResponseTrait;
    
    

    public function index()
    {
        $model = new LulusanModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($no_ijazah = null)
    {
        $model = new LulusanModel();
        $data = $model->find($no_ijazah);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function show($no_ijazah = null)
    {
        $model = new LulusanModel();
        $data = $model->find($no_ijazah);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function create()
    {
        helper(['form']);
    
        $data = [
            'no_ijazah' => $this->request->getVar('no_ijazah'),
            'nama_alumni' => $this->request->getVar('nama_alumni'),
        ];
    
        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
    
        $model = new LulusanModel();
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
    
    public function update($no_ijazah = null)
    {
        helper(['form']);
    
        $data = [
            'no_ijazah' => $this->request->getVar('no_ijazah'),
            'nama_alumni' => $this->request->getVar('nama_alumni'),
        ];
    
        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
    
        $model = new LulusanModel();
        $dataToUpdate = $model->find($no_ijazah);
    
        if (!$dataToUpdate) return $this->failNotFound('No Data Found');
    
        $model->update($no_ijazah, $data);
    
        // Kode untuk menampilkan view setelah update
        return view('edit_lulusan', $data);
    }
    

    public function delete($no_ijazah = null)
    {
        $model = new LulusanModel();
        $dataToDelete = $model->find($no_ijazah);

        if (!$dataToDelete) return $this->failNotFound('No Data Found');
        
        $model->delete($no_ijazah);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
        ];

        return $this->respond($response);
    }

    public function import()
{
    try {
        $request = \Config\Services::request();
        
        // Periksa apakah file telah diunggah
        $file = $this->request->getFile('file');
        if (!$file) {
            return $this->failValidationError('No file uploaded');
        }
        
       // Check if the file is an Excel file
if (!$file->isValid() || !in_array($file->getClientExtension(), ['xlsx', 'xls'])) {
    return $this->failValidationError('Invalid file type. Only Excel files (.xlsx, .xls) are allowed');
}

        
        // Load the spreadsheet
        $spreadsheet = IOFactory::load($file);
    
        // Get the active sheet
        $sheet = $spreadsheet->getActiveSheet();
    
        // Get highest row
        $highestRow = $sheet->getHighestRow();
    
        $lulusanModel = new LulusanModel();
    
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':E' . $row, NULL, TRUE, FALSE)[0];
            
            // Memeriksa apakah setidaknya satu nilai dalam baris tidak kosong
            $nonEmptyValues = array_filter($rowData);
            if (!empty($nonEmptyValues)) {
                $data = [
                    'no_ijazah' => $rowData[0] ?? null,
                    'nama_alumni' => $rowData[1] ?? null,
                ];
            
                $lulusanModel->insert($data);
            }
        }
        
        return $this->respond(['message' => 'Data from Excel file imported successfully'], ResponseInterface::HTTP_CREATED);
    } catch (\Exception $e) {
        return $this->failServerError('An error occurred while importing data: ' . $e->getMessage());
    }
}
}
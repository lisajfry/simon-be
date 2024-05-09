<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;

class Mahasiswa extends ResourceController
{
    use ResponseTrait;
    

    public function index()
{
    $model = new MahasiswaModel();
    $data = $model->findAll();


    return $this->respond($data);
}

    public function get($NIM = null)
    {
        $model = new MahasiswaModel();
        $data = $model->find($NIM);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function show($NIM = null)
    {
        $model = new MahasiswaModel();
        $data = $model->find($NIM);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function create()
{
    $rules = [
        'NIM' => 'required|max_length[20]',
        'nama_mahasiswa' => 'required|max_length[255]',
        'angkatan' => 'required|in_list[TI 2020,TI 2021,TI 2022,TI 2023]',
        'keterangan' => 'required|in_list[lulus,mahasiswa aktif]',
    ];

    if (!$this->validate($rules)) {
        return $this->respond(["error" => $this->validator->getErrors()], 400);
    }

    $data = [
        'NIM' => $this->request->getVar('NIM'),
        'nama_mahasiswa' => $this->request->getVar('nama_mahasiswa'),
        'angkatan' => $this->request->getVar('angkatan'),
        'keterangan' => $this->request->getVar('keterangan'),
    ];

    $mahasiswaModel = new MahasiswaModel();
    $mahasiswaModel->insert($data);

    $response = [
        'status' => 201,
        'error' => null,
        'messages' => [
            'success' => 'Data Inserted'
        ]
    ];

    return $this->respondCreated($response);
}
public function update($NIM = null)
{
    $rules = [
        'nama_mahasiswa' => 'required|max_length[255]',
        'angkatan' => 'required|in_list[TI 2020, TI 2021, TI 2022, TI 2023]',
        'keterangan' => 'required|in_list[lulus,mahasiswa aktif]',
    ];

    if (!$this->validate($rules)) {
        return $this->respond(["error" => $this->validator->getErrors()], 400);
    }

    $data = [
        'nama_mahasiswa' => $this->request->getVar('nama_mahasiswa'),
        'angkatan' => $this->request->getVar('angkatan'),
        'keterangan' => $this->request->getVar('keterangan'),
    ];

    $mahasiswaModel = new MahasiswaModel();
    $mahasiswa = $mahasiswaModel->find($NIM);

    if (!$mahasiswa) {
        return $this->respond(["error" => "No Data Found"], 404);
    }

    $mahasiswaModel->update($NIM, $data);

    // Menampilkan view setelah pembaruan dengan data mahasiswa yang telah diperbarui
    $updatedMahasiswa = $mahasiswaModel->find($NIM);
    $response = [
        'status' => 201,
        'error' => null,
        'messages' => [
            'success' => 'Data Updated'
        ]
    ];
    return $this->respondCreated($updatedMahasiswa, 'Data Updated');
}

    

    public function delete($NIM = null)
    {
        $model = new MahasiswaModel();
        $dataToDelete = $model->find($NIM);

        if (!$dataToDelete) return $this->failNotFound('No Data Found');
        
        $model->delete($NIM);

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

        $mahasiswaModel = new MahasiswaModel();

        for ($row = 5; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':D' . $row, NULL, TRUE, FALSE)[0];
        
            // Memeriksa apakah setidaknya satu nilai dalam baris tidak kosong
            $nonEmptyValues = array_filter($rowData);
            if (!empty($nonEmptyValues)) {
                $data = [
                    'NIM' => $rowData[0] ?? null,
                    'nama_mahasiswa' => $rowData[1] ?? null,
                    'angkatan' => $rowData[2] ?? null,
                    'keterangan' => $rowData[3] ?? null,
                ];
        
                // Memeriksa apakah angkatan tidak kosong sebelum menyimpan
                if (!empty($data['angkatan'])) {
                    // Validasi nilai angkatan
                    if (!in_array($data['angkatan'], ['TI 2020', 'TI 2021', 'TI 2022', 'TI 2023'])) {
                        return $this->failValidationError('Invalid value for angkatan. Allowed values are: TI 2020, TI 2021, TI 2022, TI 2023');
                    }

                    $mahasiswaModel->insert($data);
                } else {
                    return $this->failValidationError('Angkatan cannot be empty');
                }
            }
        }
        
        return $this->respond(['message' => 'Data from Excel file imported successfully'], ResponseInterface::HTTP_CREATED);
    } catch (\Exception $e) {
        return $this->failServerError('An error occurred while importing data: ' . $e->getMessage());
    }
}
}
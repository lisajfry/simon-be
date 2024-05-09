<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku1Model;
use App\Models\MahasiswaModel;

class Iku1 extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new Iku1Model();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku1_id = null)
    {
        $model = new Iku1Model();
        $data = $model->find($iku1_id);
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

        // Ambil NIM dari request
        $NIM = $this->request->getVar('NIM');

        // Periksa apakah NIM valid
        if (!$NIM) {
            return $this->failValidationError('NIM is required');
        }

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();

        // Periksa apakah data mahasiswa ditemukan
        if (!$mahasiswa) {
            return $this->failValidationError('No Data Found for the given NIM');
        }

        // Data untuk disimpan
        $data = [
            'NIM' => $NIM,
            'status' => $this->request->getVar('status'),
            'gaji' => $this->request->getVar('gaji'),
            'masa_tunggu' => $this->request->getVar('masa_tunggu')
        ];

        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new Iku1Model();
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

    public function update($iku1_id = null)
    {
        helper(['form']);

        // Ambil NIM dari request
        $NIM = $this->request->getVar('NIM');

        // Periksa apakah NIM valid
        if (!$NIM) {
            return $this->failValidationError('NIM is required');
        }

        // Cari data mahasiswa berdasarkan NIM
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();

        // Periksa apakah data mahasiswa ditemukan
        if (!$mahasiswa) {
            return $this->failValidationError('No Data Found for the given NIM');
        }

        // Data untuk diupdate
        $data = [
            'NIM' => $NIM,
            'status' => $this->request->getVar('status'),
            'gaji' => $this->request->getVar('gaji'),
            'masa_tunggu' => $this->request->getVar('masa_tunggu')
        ];

        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        $model = new Iku1Model();
        $dataToUpdate = $model->find($iku1_id);

        if (!$dataToUpdate) return $this->failNotFound('No Data Found');

        $model->update($iku1_id, $data);

        // Kode untuk menampilkan view setelah update
        return view('edit_iku1', $data);
    }

    public function show($iku1_id = null)
    {
        $model = new Iku1Model();
        $data = $model->find($iku1_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function delete($iku1_id = null)
    {
        $model = new Iku1Model();
        $data = $model->find($iku1_id);

        if (!$data) {
            return $this->failNotFound('No Data Found');
        }

        $model->delete($iku1_id);

        return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
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

            // Periksa apakah file merupakan file Excel yang valid
            if (!$file->isValid() || !in_array($file->getClientExtension(), ['xlsx', 'xls'])) {
                return $this->failValidationError('Invalid file type. Only Excel files (.xlsx, .xls) are allowed');
            }

            // Load spreadsheet
            $spreadsheet = IOFactory::load($file);

            // Dapatkan lembar kerja aktif
            $sheet = $spreadsheet->getActiveSheet();

            // Dapatkan baris tertinggi
            $highestRow = $sheet->getHighestRow();

            // Inisialisasi model untuk data iku1
            $iku1Model = new Iku1Model();
            // Inisialisasi model untuk data mahasiswa
            $mahasiswaModel = new MahasiswaModel();

            // Iterasi melalui baris-baris pada file Excel, dimulai dari baris kedua
           // Iterasi melalui baris-baris pada file Excel, dimulai dari baris kedua
for ($row = 5; $row <= $highestRow; $row++) {
    // Ambil data dari kolom-kolom yang sesuai
    $NIM = $sheet->getCell('A' . $row)->getValue();
    $status = $sheet->getCell('B' . $row)->getValue();
    $gaji = $sheet->getCell('C' . $row)->getValue();
    $masa_tunggu = $sheet->getCell('D' . $row)->getValue();

    // Cek apakah NIM sudah ada di tabel mahasiswa
    $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();

    if ($mahasiswa) {
        // Siapkan data untuk disimpan ke dalam model iku1
        $data = [
            'NIM' => $NIM,
            'status' => $status,
            'gaji' => $gaji,
            'masa_tunggu' => $masa_tunggu,
        ];

        // Simpan data ke dalam tabel iku1
        $iku1Model->insert($data);
    } else {
        // NIM tidak ditemukan di tabel mahasiswa
        // Anda bisa menangani kasus ini sesuai kebutuhan
    }
}


            // Berhasil mengimpor data
            return $this->respond(['message' => 'Data from Excel file imported successfully'], ResponseInterface::HTTP_CREATED);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return $this->failServerError('An error occurred while importing data: ' . $e->getMessage());
        }
    }
}

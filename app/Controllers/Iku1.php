<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku1Model;
use App\Models\LulusanModel; // Tambahkan pemanggilan model untuk tabel lulusan

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

    public function create()
{
    helper(['form']);

    // Ambil no_ijazah dari request
    $no_ijazah = $this->request->getVar('no_ijazah');

    // Periksa apakah no_ijazah valid
    if (!$no_ijazah) {
        return $this->failValidationError('No_ijazah is required');
    }

    // Cari data lulusan berdasarkan no_ijazah
    $lulusanModel = new LulusanModel();
    $lulusan = $lulusanModel->where('no_ijazah', $no_ijazah)->first();

    // Periksa apakah data lulusan ditemukan
    if (!$lulusan) {
        return $this->failValidationError('No Data Found for the given no_ijazah');
    }

    // Data untuk disimpan
    $data = [
        'no_ijazah' => $no_ijazah,
        'nama_alumni' => $lulusan['nama_alumni'], // Ambil nama_alumni dari data lulusan
        'status'      => $this->request->getVar('status'),
        'gaji'        => $this->request->getVar('gaji'),
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
    
        // Ambil no_ijazah dari request
        $no_ijazah = $this->request->getVar('no_ijazah');
        
        // Periksa apakah no_ijazah valid
        if (!$no_ijazah) {
            return $this->failValidationError('No_ijazah is required');
        }
        
        // Cari data lulusan berdasarkan no_ijazah
        $lulusanModel = new LulusanModel();
        $lulusan = $lulusanModel->where('no_ijazah', $no_ijazah)->first();
        
        // Periksa apakah data lulusan ditemukan
        if (!$lulusan) {
            return $this->failValidationError('No Data Found for the given no_ijazah');
        }
    
        // Data untuk diupdate
        $data = [
            'no_ijazah' => $no_ijazah,
            'nama_alumni' => $lulusan['nama_alumni'], // Ambil nama_alumni dari data lulusan
            'status'      => $this->request->getVar('status'),
            'gaji'        => $this->request->getVar('gaji'),
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
        // Inisialisasi model untuk data lulusan
        $lulusanModel = new LulusanModel();
    
        // Iterasi melalui baris-baris pada file Excel, dimulai dari baris kedua
        for ($row = 2; $row <= $highestRow; $row++) {
            // Ambil data dari kolom-kolom yang sesuai
            $no_ijazah = $sheet->getCell('A' . $row)->getValue();
            $nama_alumni = $sheet->getCell('B' . $row)->getValue();
            $status = $sheet->getCell('C' . $row)->getValue();
            $gaji = $sheet->getCell('D' . $row)->getValue();
            $masa_tunggu = $sheet->getCell('E' . $row)->getValue();
            
            // Siapkan data untuk disimpan ke dalam model iku1
            $data = [
                'no_ijazah' => $no_ijazah,
                'nama_alumni' => $nama_alumni,
                'status' => $status,
                'gaji' => $gaji,
                'masa_tunggu' => $masa_tunggu,
            ];
            
            // Simpan data ke dalam tabel iku1
            $iku1Model->insert($data);
            
            // Siapkan data untuk disimpan ke dalam model lulusan
            $dataLulusan = [
                'no_ijazah' => $no_ijazah,
                'nama_alumni' => $nama_alumni,
            ];
            
            // Simpan data ke dalam tabel lulusan
            $lulusanModel->insert($dataLulusan);
        }
        
        // Berhasil mengimpor data
        return $this->respond(['message' => 'Data from Excel file imported successfully'], ResponseInterface::HTTP_CREATED);
    } catch (\Exception $e) {
        // Tangani kesalahan jika terjadi
        return $this->failServerError('An error occurred while importing data: ' . $e->getMessage());
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

}
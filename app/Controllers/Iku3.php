<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku3Model;
use App\Models\DosenModel; // Tambahkan pemanggilan model untuk tabel lulusan

class Iku3 extends ResourceController
{
    use ResponseTrait;


    public function index()
    {
        $model = new Iku3Model();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku3_id = null)
    {
        $model = new Iku3Model();
        $data = $model->find($iku3_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function show($iku3_id = null)
    {
        $model = new Iku3Model();
        $data = $model->find($iku3_id);
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
    $NIDN = $this->request->getVar('NIDN');

    // Periksa apakah no_ijazah valid
    if (!$NIDN) {
        return $this->failValidationError('No_ijazah is required');
    }

    // Cari data lulusan berdasarkan no_ijazah
    $dosenModel = new DosenModel();
    $dosen = $dosenModel->where('dosen', $NIDN)->first();

    // Periksa apakah data lulusan ditemukan
    if (!$NIDN) {
        return $this->failValidationError('No Data Found for the given no_ijazah');
    }

    // Data untuk disimpan
    $data = [
        'NIDN' => $NIDN,
        'nama_dosen' => $dosen['nama_dosen'], // Ambil nama_alumni dari data lulusan
        'aktivitas_dosen'      => $this->request->getVar('aktivitas_dosen'),
    ];

    // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
    foreach ($data as $key => $value) {
        if (empty($value)) {
            unset($data[$key]);
        }
    }

    $model = new Iku3Model();
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

    
    public function update($iku3_id = null)
    {
        helper(['form']);
    
        // Ambil no_ijazah dari request
        $NIDN = $this->request->getVar('NIDN');
        
        // Periksa apakah no_ijazah valid
        if (!$NIDN) {
            return $this->failValidationError('NIDN is required');
        }
        
        // Cari data lulusan berdasarkan no_ijazah
        $dosenModel = new DosenModel();
        $dosen = $dosenModel->where('NIDN', $NIDN)->first();
        
        // Periksa apakah data lulusan ditemukan
        if (!$dosen) {
            return $this->failValidationError('No Data Found for the given no_ijazah');
        }
    
        // Data untuk diupdate
        $data = [
            'NIDN' => $NIDN,
            'nama_dosen' => $dosen['nama_dosen'], // Ambil nama_alumni dari data lulusan
            'aktivitas_dosen'      => $this->request->getVar('aktivitas_dosen'),
        ];
    
        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
    
        $model = new Iku3Model();
        $dataToUpdate = $model->find($iku3_id);
    
        if (!$dataToUpdate) return $this->failNotFound('No Data Found');
    
        $model->update($iku3_id, $data);
    
        // Kode untuk menampilkan view setelah update
        return view('edit_iku3', $data);
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
        $iku3Model = new Iku3Model();
        // Inisialisasi model untuk data lulusan
        $dosenModel = new DosenModel();
    
        // Iterasi melalui baris-baris pada file Excel, dimulai dari baris kedua
        for ($row = 2; $row <= $highestRow; $row++) {
            // Ambil data dari kolom-kolom yang sesuai
            $NIDN = $sheet->getCell('A' . $row)->getValue();
            $nama_dosen = $sheet->getCell('B' . $row)->getValue();
            $aktivitas_dosen = $sheet->getCell('C' . $row)->getValue();
            
            
            // Siapkan data untuk disimpan ke dalam model iku1
            $data = [
                'NIDN' => $NIDN,
                'nama_dosen' => $nama_dosen,
                'aktivitas_dosen' => $aktivitas_dosen,
            ];
            
            // Simpan data ke dalam tabel iku1
            $iku3Model->insert($data);
            
            // Siapkan data untuk disimpan ke dalam model lulusan
            $dataDosen = [
                'NIDN' => $NIDN,
                'nama_dosen' => $nama_dosen,
            ];
            
            // Simpan data ke dalam tabel lulusan
            $dosenModel->insert($dataDosen);
        }
        
        // Berhasil mengimpor data
        return $this->respond(['message' => 'Data from Excel file imported successfully'], ResponseInterface::HTTP_CREATED);
    } catch (\Exception $e) {
        // Tangani kesalahan jika terjadi
        return $this->failServerError('An error occurred while importing data: ' . $e->getMessage());
    }
}

public function delete($iku3_id = null)
{
    $model = new Iku3Model();
    $data = $model->find($iku3_id);
    
    if (!$data) {
        return $this->failNotFound('No Data Found');
    }
    
    $model->delete($iku3_id);
    
    return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
}

}
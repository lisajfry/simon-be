<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku2kegiatanModel;
use App\Models\MahasiswaModel; // Tambahkan pemanggilan model untuk tabel lulusan

class Iku2kegiatan extends ResourceController
{
    use ResponseTrait;


    public function index()
    {
        $model = new Iku2kegiatanModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    public function get($iku2kegiatan_id = null)
    {
        $model = new Iku2kegiatanModel();
        $data = $model->find($iku2kegiatan_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }

    public function show($iku2kegiatan_id = null)
    {
        $model = new Iku2kegiatanModel();
        $data = $model->find($iku2kegiatan_id);
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
    $NIM = $this->request->getVar('NIM');

    // Periksa apakah no_ijazah valid
    if (!$NIM) {
        return $this->failValidationError('NIM is required');
    }

    // Cari data lulusan berdasarkan no_ijazah
    $mahasiswaModel = new MahasiswaModel();
    $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();

    // Periksa apakah data lulusan ditemukan
    if (!$mahasiswa) {
        return $this->failValidationError('No Data Found for the given no_ijazah');
    }

    // Data untuk disimpan
    $data = [
        'NIM' => $NIM,
        'nama_mahasiswa' => $mahasiswa['nama_mahasiswa'],
        'angkatan' => $mahasiswa['angkatan'], // Ambil nama_alumni dari data lulusan
        'aktivitas'      => $this->request->getVar('aktivitas'),
        'sks'        => $this->request->getVar('sks')
    ];

    // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
    foreach ($data as $key => $value) {
        if (empty($value)) {
            unset($data[$key]);
        }
    }

    $model = new Iku2kegiatanModel();
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

    
    public function update($iku2kegiatan_id = null)
    {
        helper(['form']);
    
        // Ambil no_ijazah dari request
        $NIM = $this->request->getVar('NIM');
        
        // Periksa apakah no_ijazah valid
        if (!$NIM) {
            return $this->failValidationError('NIM is required');
        }
        
        // Cari data lulusan berdasarkan no_ijazah
        $mahasiswaModel = new MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('NIM', $NIM)->first();
        
        // Periksa apakah data lulusan ditemukan
        if (!$mahasiswa) {
            return $this->failValidationError('No Data Found for the given no_ijazah');
        }
    
        // Data untuk diupdate
        $data = [
            'NIM' => $NIM,
            'nama_mahasiswa' => $mahasiswa['nama_mahasiswa'], // Ambil nama_alumni dari data lulusan
            'angkatan' => $mahasiswa['angkatan'],
            'aktivitas'      => $this->request->getVar('aktivitas'),
            'sks'        => $this->request->getVar('sks'),
        ];
    
        // Periksa apakah bidang-bidang yang diperlukan ada yang kosong
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
    
        $model = new Iku2kegiatanModel();
        $dataToUpdate = $model->find($iku2kegiatan_id);
    
        if (!$dataToUpdate) return $this->failNotFound('No Data Found');
    
        $model->update($iku2kegiatan_id, $data);
    
        // Kode untuk menampilkan view setelah update
        return view('edit_iku2kegiatan', $data);
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
        $iku2kegiatanModel = new Iku2kegiatanModel();
        // Inisialisasi model untuk data lulusan
        $mahasiswaModel = new MahasiswaModel();
    
        // Iterasi melalui baris-baris pada file Excel, dimulai dari baris kedua
        for ($row = 2; $row <= $highestRow; $row++) {
            // Ambil data dari kolom-kolom yang sesuai
            $NIM = $sheet->getCell('A' . $row)->getValue();
            $nama_mahasiswa = $sheet->getCell('B' . $row)->getValue();
            $angkatan = $sheet->getCell('C' . $row)->getValue();
            $aktivitas = $sheet->getCell('D' . $row)->getValue();
            $sks = $sheet->getCell('E' . $row)->getValue();
            
            // Siapkan data untuk disimpan ke dalam model iku1
            $data = [
                'NIM' => $NIM,
                'nama_mahasiswa' => $nama_mahasiswa,
                'angkatan' => $angkatan,
                'aktivitas' => $aktivitas,
                'sks' => $sks,
            ];
            
            // Simpan data ke dalam tabel iku1
            $iku2kegiatanModel->insert($data);
            
            // Siapkan data untuk disimpan ke dalam model lulusan
            $dataMahasiswa = [
                'NIM' => $NIM,
                'nama_mahasiswa' => $nama_mahasiswa,
                'angkatan' => $angkatan,
            ];
            
            // Simpan data ke dalam tabel lulusan
            $mahasiswaModel->insert($dataMahasiswa);
        }
        
        // Berhasil mengimpor data
        return $this->respond(['message' => 'Data from Excel file imported successfully'], ResponseInterface::HTTP_CREATED);
    } catch (\Exception $e) {
        // Tangani kesalahan jika terjadi
        return $this->failServerError('An error occurred while importing data: ' . $e->getMessage());
    }
}

public function delete($iku2kegiatan_id = null)
{
    $model = new Iku2kegiatanModel();
    $data = $model->find($iku2kegiatan_id);
    
    if (!$data) {
        return $this->failNotFound('No Data Found');
    }
    
    $model->delete($iku2kegiatan_id);
    
    return $this->respondDeleted(['message' => 'Data Deleted Successfully']);
}

}
<?php

namespace App\Models;

use CodeIgniter\Model;

class Iku2prestasiModel extends Model
{
    protected $table            = 'iku2prestasi';
    protected $primaryKey       = 'iku2prestasi_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NIM', 'NIDN', 'nama_kompetisi','penyelenggara','tingkat_kompetisi', 'prestasi', 'countries', 'provinces', 'jmlh_peserta', 'jmlh_provinsi_mengikuti', 'jmlh_negara_mengikuti', 'sertifikat'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'date';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Method to get data by NIM
    public function getIku2kegiatanWithNamaMahasiswa()
    {
        // Lakukan join antara tabel iku2kegiatan dan mahasiswa
        return $this->db->table('iku2kegiatan')
                        ->select('iku2kegiatan.*, mahasiswa.nama_mahasiswa')
                        ->join('mahasiswa', 'mahasiswa.NIM = iku2kegiatan.NIM')
                        ->get()
                        ->getResultArray();
    }

    // Relasi dengan tabel Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'NIM', 'NIM');
    }

    // Relasi dengan tabel Dosen
    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'NIDN', 'NIDN');
    }
}

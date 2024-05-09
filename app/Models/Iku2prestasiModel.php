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
    protected $allowedFields    = ['NIM', 'NIDN', 'tingkat_lomba', 'prestasi'];

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
    public function getIku2prestasiWithNamaMahasiswa()
    {
        // Lakukan join antara tabel iku2kegiatan dan mahasiswa
        return $this->db->table('iku2prestasi')
                        ->select('iku2prestasi.*, mahasiswa.nama_mahasiswa')
                        ->join('mahasiswa', 'mahasiswa.NIM = iku2kegiatan.NIM')
                        ->get()
                        ->getResultArray();
    }

    public function getIku2prestasiWithNamaDosen()
    {
        // Lakukan join antara tabel iku2kegiatan dan mahasiswa
        return $this->db->table('iku2prestasi')
                        ->select('iku2prestasi.*, dosen.nama_dosen')
                        ->join('dosen', 'dosen.NIDN = iku2prestasi.NIDN')
                        ->get()
                        ->getResultArray();
    }
}

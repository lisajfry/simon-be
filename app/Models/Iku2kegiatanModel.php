<?php

namespace App\Models;

use CodeIgniter\Model;

class Iku2kegiatanModel extends Model
{
    protected $table            = 'iku2kegiatan';
    protected $primaryKey       = 'iku2kegiatan_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NIM', 'aktivitas', 'tempat_kegiatan', 'sks', 'tgl_mulai_kegiatan', 'tgl_selesai_kegiatan'];

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
}

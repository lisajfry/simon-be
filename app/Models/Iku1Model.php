<?php

namespace App\Models;

use CodeIgniter\Model;

class Iku1Model extends Model
{
    protected $table            = 'iku1';
    protected $primaryKey       = 'iku1_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NIM', 'status', 'gaji', 'masa_tunggu','tahun'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
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
    public function getIku1WithNamaMahasiswa()
    {
        // Lakukan join antara tabel iku1 dan mahasiswa
        return $this->db->table('iku1')
                        ->select('iku1.*, mahasiswa.nama_mahasiswa')
                        ->join('mahasiswa', 'mahasiswa.NIM = iku1.NIM')
                        ->get()
                        ->getResultArray();
    }
}

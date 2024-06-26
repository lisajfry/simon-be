<?php

namespace App\Models;

use CodeIgniter\Model;

class Iku4Model extends Model
{
    protected $table            = 'iku4';
    protected $primaryKey       = 'iku4_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NIDN', 'status'];

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
    public function getIku4WithNamaDosen()
    {
        // Lakukan join antara tabel iku1 dan mahasiswa
        return $this->db->table('iku4')
                        ->select('iku4.*, dosen.nama_dosen')
                        ->join('dosen', 'dosen.NIDN = iku4.NIDN')
                        ->get()
                        ->getResultArray();
    }
    public function getIku4WithNamaDosenpraktisi()
    {
        // Lakukan join antara tabel iku1 dan mahasiswa
        return $this->db->table('iku4')
                        ->select('iku4.*, dosenNIDK.nama_dosen')
                        ->join('dosenNIDK', 'dosenNIDK.NIDK = iku4.NIDK')
                        ->get()
                        ->getResultArray();
    }

}
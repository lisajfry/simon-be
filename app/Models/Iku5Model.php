<?php

namespace App\Models;

use CodeIgniter\Model;

class Iku5Model extends Model
{
    protected $table            = 'iku5';
    protected $primaryKey       = 'iku5_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'NIDN', 'NIDK', 'status', 'jenis_karya', 'kategori_karya', 'judul_karya', 
        'pendanaan', 'kriteria', 'bukti_pendukung', 'tahun'
    ];

    protected bool $allowEmptyInserts = true; // Allow empty inserts

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

    // Method to get data with the name of the lecturer
    public function getIku5WithNamaDosen()
    {
        // Join between iku5 table and dosen table
        return $this->db->table('iku5')
                        ->select('iku5.*, dosen.nama_dosen, dosenNIDK.nama_dosen as nama_dosenNIDK')
                        ->join('dosen', 'dosen.NIDN = iku5.NIDN')
                        ->join('dosenNIDK', 'dosenNIDK.NIDK = iku5.NIDK')
                        ->get()
                        ->getResultArray();
    }
}

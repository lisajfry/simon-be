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
        'NIDN', 'NIDK', 'status', 'jenis_karya', 'kategori_karya', 
        'judul_karya', 'pendanaan', 'kriteria', 'bukti_pendukung', 'tahun'
    ];

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

    // Method to get data with associated dosen and years
    public function getIku5WithDetails()
    {
        return $this->db->table($this->table)
                        ->select('iku5.*, dosen.nama_dosen, dosenNIDK.nama_dosen')
                        ->join('dosen', 'dosen.NIDN = iku5.NIDN', 'left')
                        ->join('dosenNIDK', 'dosenNIDK.NIDK = iku5.NIDK', 'left')
                        ->get()
                        ->getResultArray();
    }
}

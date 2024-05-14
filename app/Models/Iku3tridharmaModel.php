<?php

namespace App\Models;

use CodeIgniter\Model;

class Iku3tridharmaModel extends Model
{
    protected $table            = 'iku3tridharma';
    protected $primaryKey       = 'iku3tridharma_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NIDN', 'surat_sk', 'ptn_tridharma', 'tgl_mulai_tridharma', 'tgl_selesai_tridharma'];

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
    
    public function getIku3tridharmaWithNamaDosen()
    {
        // Lakukan join antara tabel iku2kegiatan dan mahasiswa
        return $this->db->table('iku3tridharma')
                        ->select('iku3tridharma.*, dosen.nama_dosen')
                        ->join('dosen', 'dosen.NIDN = iku3tridharma.NIDN')
                        ->get()
                        ->getResultArray();
    }

}

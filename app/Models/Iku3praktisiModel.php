<?php

namespace App\Models;

use CodeIgniter\Model;

class Iku3praktisiModel extends Model
{
    protected $table            = 'iku3praktisi';
    protected $primaryKey       = 'iku3praktisi_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NIDN','tahun',  'surat_sk', 'instansi_praktisi', 'tgl_mulai_praktisi', 'tgl_selesai_praktisi'];

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
    public function getIku3praktisiWithNamaDosen()
    {
        // Lakukan join antara tabel iku2kegiatan dan mahasiswa
        return $this->db->table('iku3praktisi')
                        ->select('iku3praktisi.*, dosen.nama_dosen')
                        ->join('dosen', 'dosen.NIDN = iku3praktisi.NIDN')
                        ->get()
                        ->getResultArray();
    }
}

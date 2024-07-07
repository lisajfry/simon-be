<?php

namespace App\Models;

use CodeIgniter\Model;

class Iku2inboundModel extends Model
{
    protected $table            = 'iku2inbound';
    protected $primaryKey       = 'iku2inbound_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NIM', 'semester', 'tahun','ptn_asal', 'ptn_pertukaran','surat_rekomendasi', 'sks','NIDN', 'tgl_mulai_inbound', 'tgl_selesai_inbound'];

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
    public function getIku2inboundWithNamaMahasiswa()
    {
       
        return $this->db->table('iku2inbound')
                        ->select('iku2inbound.*, mahasiswa.nama_mahasiswa')
                        ->join('mahasiswa', 'mahasiswa.NIM = iku2inbound.NIM')
                        ->get()
                        ->getResultArray();
    }
}

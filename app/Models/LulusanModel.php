<?php

namespace App\Models;

use CodeIgniter\Model;

class LulusanModel extends Model
{
    protected $table            = 'lulusan';
    protected $primaryKey       = 'no_ijazah';
    protected $useAutoIncrement = false; // Menggunakan nilai NIM sebagai primary key
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_ijazah', 'nama_alumni']; // Daftar kolom yang diperbolehkan untuk diisi

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'no_ijazah' => 'required|is_unique[lulusan.no_ijazah]',
        'nama_alumni' => 'required',
    ];
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
}

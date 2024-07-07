<?php

namespace App\Models;

use CodeIgniter\Model;

class RekapitulasiModel extends Model
{
    protected $table = 'rekapitulasi';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tahun', 'indikator', 'target', 'capaian'
    ];

    protected $useTimestamps = false;

    public function getByYear($year)
    {
        return $this->where('tahun', $year)->findAll();
    }
}


    

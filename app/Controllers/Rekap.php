<?php namespace App\Controllers;

use App\Models\RekapitulasiModel;
use CodeIgniter\RESTful\ResourceController;

class Rekapitulasi extends ResourceController
{
    protected $rekapitulasiModel;

    public function __construct()
    {
        $this->rekapitulasiModel = new RekapitulasiModel();
    }

    public function index()
    {
        $tahun = $this->request->getGet('tahun');
        $data = $this->rekapitulasiModel->getByYear($tahun);
        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $indicators = ['IKU 1', 'IKU 2', 'IKU 3', 'IKU 4', 'IKU 5', 'IKU 6', 'IKU 7'];
        foreach ($indicators as $index => $indicator) {
            $this->rekapitulasiModel->updateOrInsert(
                ['tahun' => $data['tahun'], 'indikator' => $indicator],
                ['target' => $data['targets'][$index], 'capaian' => $data['capaian'][$index]]
            );
        }
        return $this->respondCreated(['message' => 'Rekapitulasi berhasil disimpan']);
    }
}

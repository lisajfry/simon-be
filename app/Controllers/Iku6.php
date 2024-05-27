<?php


namespace App\Controllers;


use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku6Model;


class Iku6 extends ResourceController
{
    use ResponseTrait;


    public function index()
    {
        $model = new Iku6Model();
        $data = $model->findAll();
        return $this->respond($data);
    }


    public function get($iku6_id = null)
    {
        $model = new Iku6Model();
        $data = $model->find($iku6_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }


    // SHOW
    public function show($iku6_id = null)
    {
        $model = new Iku6Model();
        $data = $model->find($iku6_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        }
        return $this->respond($data);
    }


    public function create()
{
    helper(['form']);


    $rules = [
        'nama_mitra' => 'required',
        'nama_kegiatan' => 'required',
        'alamat_mitra' => 'required',
        'tgl_mulai_kegiatan' => 'required',
        'tgl_selesai_kegiatan' => 'required',
        'kriteria_mitra' => 'required',
        'mou' => 'uploaded[mou]|mime_in[mou,application/pdf]|max_size[mou,5120]',
        'pks' => 'uploaded[pks]|mime_in[pks,application/pdf]|max_size[pks,5120]',
    ];


    if (!$this->validate($rules)) {
        return $this->fail($this->validator->getErrors());
    }


    $mouFile = $this->request->getFile('mou');
    $pksFile = $this->request->getFile('pks');
    $newMouName = $mouFile->getRandomName();
    $newPksName = $pksFile->getRandomName();
    $mouFile->move(WRITEPATH . 'uploads', $newMouName);
    $pksFile->move(WRITEPATH . 'uploads', $newPksName);


    $data = [
        'nama_mitra' => $this->request->getVar('nama_mitra'),
        'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
        'alamat_mitra' => $this->request->getVar('alamat_mitra'),
        'tgl_mulai_kegiatan' => $this->request->getVar('tgl_mulai_kegiatan'),
        'tgl_selesai_kegiatan' => $this->request->getVar('tgl_selesai_kegiatan'),
        'kriteria_mitra' => $this->request->getVar('kriteria_mitra'),
        'mou' => $newMouName,
        'pks' => $newPksName,
    ];


    $model = new Iku6Model();
    $model->insert($data);


    // Tambahkan pesan sukses
    $response = [
        'status' => 201,
        'message' => 'Data berhasil dibuat',
        'data' => $data
    ];


    return $this->respondCreated($response);
}


public function update($iku6_id = null)
{
    helper(['form']);
    $model = new Iku6Model();
    $dataToUpdate = $model->find($iku6_id);


    if (!$dataToUpdate) return $this->failNotFound('No Data Found');


    // Initialize data array
    $data = [
        'nama_mitra' => $this->request->getVar('nama_mitra'),
        'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
        'alamat_mitra' => $this->request->getVar('alamat_mitra'),
        'tgl_mulai_kegiatan' => $this->request->getVar('tgl_mulai_kegiatan'),
        'tgl_selesai_kegiatan' => $this->request->getVar('tgl_selesai_kegiatan'),
        'kriteria_mitra' => $this->request->getVar('kriteria_mitra'),
    ];


    // Handle MOU file upload
    $mouFile = $this->request->getFile('mou');
    if ($mouFile && $mouFile->isValid() && !$mouFile->hasMoved()) {
        $newMouName = $mouFile->getRandomName();
        $mouFile->move(WRITEPATH . 'uploads', $newMouName);
        $data['mou'] = $newMouName; // Menggunakan nama file yang baru diunggah
    }


    // Handle PKS file upload
    $pksFile = $this->request->getFile('pks');
    if ($pksFile && $pksFile->isValid() && !$pksFile->hasMoved()) {
        $newPksName = $pksFile->getRandomName();
        $pksFile->move(WRITEPATH . 'uploads', $newPksName);
        $data['pks'] = $newPksName; // Menggunakan nama file yang baru diunggah
    }


    // Update the model
    if (!$model->update($iku6_id, $data)) {
        return $this->failValidationError('Failed to update data');
    }


    // Return success message
    $response = [
        'status' => 200,
        'message' => 'Data berhasil diupdate',
        'data' => $data
    ];


    return $this->respond($response);
}








    public function delete($iku6_id = null)
    {
        $model = new Iku6Model();
        $iku6 = $model->find($iku6_id);
        if (!$iku6) {
            return $this->failNotFound('No Data Found');
        }


        $model->delete($iku6_id);


        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
        ];


        return $this->respondDeleted($response);
    }


}

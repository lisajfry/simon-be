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
        $year = $this->request->getVar('year');


        if ($year) {
            $data = $model->where(['tahun' => $year])->findAll();
        } else {
            $data = $model->findAll();
        }
        return $this->respond($data);
    }


    public function getFilters()
    {
        $model = new Iku6Model();
        $years = $model->select('tahun')->distinct()->findAll();


        return $this->respond([
            'years' => array_column($years, 'tahun'),
        ]);
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
    $model = new Iku6Model();




    $file = $this->request->getFile('mou');
    if ($file->isValid() && $file->getExtension() === 'pdf') {
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads', $newName);
        $mouPath = 'uploads/' . $newName;
    } else {
        $mouPath = null; // Set null if no valid file uploaded
    }




    $data = [
        'nama_mitra' => $this->request->getPost('nama_mitra'),
        'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
        'alamat_mitra' => $this->request->getPost('alamat_mitra'),
        'tahun' => $this->request->getPost('tahun'),
        'tgl_mulai_kegiatan' => $this->request->getPost('tgl_mulai_kegiatan'),
        'tgl_selesai_kegiatan' => $this->request->getPost('tgl_selesai_kegiatan'),
        'kriteria_mitra' => $this->request->getPost('kriteria_mitra'),
        'mou' => $mouPath,
    ];




    $model->insert($data);




    $response = [
        'status' => 201,
        'error' => null,
        'messages' => [
            'success' => 'Data Inserted'
        ]
    ];




    return $this->respondCreated($response);
}




public function update($iku6_id = null)
{
    $model = new Iku6Model();
 
    $data = [
        'nama_mitra' => $this->request->getPost('nama_mitra'),
        'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
        'alamat_mitra' => $this->request->getPost('alamat_mitra'),
        'tahun' => $this->request->getPost('tahun'),
        'tgl_mulai_kegiatan' => $this->request->getPost('tgl_mulai_kegiatan'),
        'tgl_selesai_kegiatan' => $this->request->getPost('tgl_selesai_kegiatan'),
        'kriteria_mitra' => $this->request->getPost('kriteria_mitra'),
    ];




     // Handle file upload
     $file = $this->request->getFile('mou');
     if ($file && $file->isValid() && $file->getExtension() === 'pdf') {
         $newName = $file->getRandomName();
         $file->move(ROOTPATH . 'public/uploads', $newName);
         $data['mou'] = 'uploads/' . $newName;
     }
 
     $model->update($iku6_id, $data);
 
     $response = [
         'status' => 200,
         'error' => null,
         'messages' => [
             'success' => 'Data Updated'
         ]
     ];
 
     return $this->respond($response);
}












    public function delete($iku6_id = null)
    {
        $model = new Iku6Model();
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

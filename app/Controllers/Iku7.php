<?php




namespace App\Controllers;




use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Iku7Model;




class Iku7 extends ResourceController
{
    use ResponseTrait;
    // Index
    public function index()
    {
        $model = new Iku7Model();
        $data = $model->findAll();
        return $this->respond($data);
    }




    // GET
    public function get($iku7_id = null)
    {
        $model = new Iku7Model();
        $data = $model->find($iku7_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        } else {
            return $this->respond($data);
        }
    }




    // SHOW
    public function show($iku7_id = null)
    {
        $model = new Iku7Model();
        $data = $model->find($iku7_id);
        if (!$data) {
            return $this->failNotFound('No Data Found');
        }
        return $this->respond($data);
    }




   // CREATE
public function create()
{
    $model = new Iku7Model();


    // File Upload Handling
    $file = $this->request->getFile('rps');
    if ($file->isValid() && $file->getExtension() === 'pdf') {
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads', $newName);
        $rpsPath = 'uploads/' . $newName;
    } else {
        $rpsPath = null; // Set null if no valid file uploaded
    }


    // Hitung presentase bobot
    $caseMethod = $this->request->getVar('case_method');
    $tbProject = $this->request->getVar('tb_project');
    $presentaseBobot = (float)$caseMethod + (float)$tbProject;


    $data = [
        'kode_mk' => $this->request->getVar('kode_mk'),
        'nama_mk' => $this->request->getVar('nama_mk'),
        'tahun' => $this->request->getVar('tahun'),
        'semester' => $this->request->getVar('semester'),
        'kelas' => $this->request->getVar('kelas'),
        'case_method' => $caseMethod,
        'tb_project' => $tbProject,
        'presentase_bobot' => $presentaseBobot,
        'rps' => $rpsPath,
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




public function update($iku7_id = null)
{
    $model = new Iku7Model();


    $data = [
        'kode_mk' => $this->request->getVar('kode_mk'),
        'nama_mk' => $this->request->getVar('nama_mk'),
        'tahun' => $this->request->getVar('tahun'),
        'semester' => $this->request->getVar('semester'),
        'kelas' => $this->request->getVar('kelas'),
        'case_method' => $this->request->getVar('case_method'),
        'tb_project' => $this->request->getVar('tb_project'),
    ];


    // Hitung presentase bobot
    $caseMethod = $data['case_method'];
    $tbProject = $data['tb_project'];
    $presentaseBobot = (float)$caseMethod + (float)$tbProject;
    $data['presentase_bobot'] = $presentaseBobot;


    // Handle file upload
    $file = $this->request->getFile('rps');
    if ($file && $file->isValid() && $file->getExtension() === 'pdf') {
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads', $newName);
        $data['rps'] = 'uploads/' . $newName;
    }


    $model->update($iku7_id, $data);


    $response = [
        'status' => 200,
        'error' => null,
        'messages' => [
            'success' => 'Data Updated'
        ]
    ];


    return $this->respond($response);
}




    // DELETE
    public function delete($iku7_id = null)
    {
        $model = new Iku7Model();
        $model->delete($iku7_id);




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

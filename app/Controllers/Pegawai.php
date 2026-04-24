<?php namespace App\Controllers;
use App\Models\PegawaiModel;

class Pegawai extends BaseController {
    public function index() {
        $model = new PegawaiModel();
        return view('admin/pegawai/index', [
            'title' => 'Manajemen Pegawai',
            'pegawaiList' => $model->paginate(10),
            'pager' => $model->pager
        ]);
    }
    public function store() {
        (new PegawaiModel())->insert($this->request->getPost());
        return $this->response->setJSON(['success' => true, 'message' => 'Pegawai ditambahkan.']);
    }
    public function update() {
        $data = $this->request->getPost();
        (new PegawaiModel())->update($data['id'], $data);
        return $this->response->setJSON(['success' => true, 'message' => 'Data diperbarui.']);
    }
    public function delete() {
        (new PegawaiModel())->delete($this->request->getPost('id'));
        return $this->response->setJSON(['success' => true, 'message' => 'Pegawai dihapus.']);
    }
}

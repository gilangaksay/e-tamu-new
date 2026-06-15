<?php namespace App\Controllers;
use App\Models\PegawaiModel;

class Pegawai extends BaseController {
    public function index() {
        if (session()->get('admin_role') != 'admin') return redirect()->to(site_url('admin/dashboard'))->with('error', 
        'Akses ditolak');
        $model = new PegawaiModel();
        $limit = $this->request->getGet('limit') ?? 10;
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        if ($search) {
            $model->groupStart()
                  ->like('nama', $search)
                  ->orLike('jabatan', $search)
                  ->orLike('unit_kerja', $search)
                  ->groupEnd();
        }

        if ($status !== null && $status !== '') {
            $model->where('aktif', $status);
        }

        return view('admin/pegawai/index', [
            'title' => 'Manajemen Pegawai',
            'pegawaiList' => $model->paginate($limit),
            'pager' => $model->pager,
            'limit' => $limit,
            'search' => $search,
            'status' => $status
        ]);
    }
    public function store() {
        if (session()->get('admin_role') != 'admin') return $this->response->setJSON(['success' 
         => false, 'message' => 'Akses ditolak']);
        (new PegawaiModel())->insert($this->request->getPost());
        return $this->response->setJSON(['success' => true, 'message' => 'Pegawai ditambahkan.']);
    }
    public function update() {
        if (session()->get('admin_role') != 'admin') return $this->response->setJSON(['success' 
         => false, 'message' => 'Akses ditolak']);
        $data = $this->request->getPost();
        (new PegawaiModel())->update($data['id'], $data);
        return $this->response->setJSON(['success' => true, 'message' => 'Data diperbarui.']);
    }
    public function delete() {
        if (session()->get('admin_role') != 'admin') return $this->response->setJSON(['success'
          => false, 'message' => 'Akses ditolak']);
        (new PegawaiModel())->delete($this->request->getPost('id'));
        return $this->response->setJSON(['success' => true, 'message' => 'Pegawai dihapus.']);
    }
}

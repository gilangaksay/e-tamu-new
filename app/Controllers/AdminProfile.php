<?php namespace App\Controllers;
use App\Models\AdminModel;

class AdminProfile extends BaseController {
    public function index() {
        $model = new AdminModel();
        $admins = $model->findAll();
        $currentAdmin = $model->find(session()->get('admin_id'));

        return view('admin/profile/index', [
            'title' => 'Manajemen Profil & Admin',
            'admins' => $admins,
            'me' => $currentAdmin
        ]);
    }

    public function create() {
        if (session()->get('admin_role') != 'admin') return redirect()->back()->with('error', 'Akses ditolak');
        $model = new AdminModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role' => $this->request->getPost('role'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $foto = $this->request->getFile('foto');
        if ($foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/admin', $newName);
            $data['foto'] = $newName;
        }

        $model->insert($data);
        return redirect()->back()->with('success', 'Admin baru berhasil ditambahkan');
    }

    public function updateSelf() {
        $model = new AdminModel();
        $id = session()->get('admin_id');
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username' => $this->request->getPost('username')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $path = FCPATH . 'uploads/admin/';
            if(!is_dir($path)) mkdir($path, 0777, true);
            $foto->move($path, $newName);
            $data['foto'] = $newName;
            session()->set('admin_foto', $newName);
        }

        $model->update($id, $data);
        session()->set('admin_nama', $data['nama_lengkap']);
        
        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui');
    }

    public function delete($id) {
        if (session()->get('admin_role') != 'admin') return redirect()->back()->with('error', 'Akses ditolak');
        if ($id == session()->get('admin_id')) return redirect()->back()->with('error', 'Tidak bisa menghapus diri sendiri');
        (new AdminModel())->delete($id);
        return redirect()->back()->with('success', 'Admin berhasil dihapus');
    }
}

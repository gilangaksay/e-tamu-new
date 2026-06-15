<?php namespace App\Controllers;
use App\Models\TamuModel;

class Pengaturan extends BaseController {
    public function index() {
        if (session()->get('admin_role') != 'admin') return redirect()->to(site_url('admin/dashboard'))
            ->with('error', 'Akses ditolak');
        $db = \Config\Database::connect();
        $settings = $db->table('pengaturan')->get()->getResultArray();
        $data = [];
        foreach($settings as $s) $data[$s['kunci']] = $s['nilai'];

        return view('admin/settings/index', [
            'title' => 'Pengaturan Instansi',
            's' => $data
        ]);
    }

    public function update() {
        if (session()->get('admin_role') != 'admin') return redirect()
            ->to(site_url('admin/dashboard'))->with('error', 'Akses ditolak');
        $db = \Config\Database::connect();
        $posts = $this->request->getPost();
        
        foreach($posts as $key => $val) {
            if($key == 'csrf_test_name') continue;
            $db->table('pengaturan')->where('kunci', $key)->update(['nilai' => $val]);
        }

        $logo = $this->request->getFile('logo_file');
        if($logo && $logo->isValid() && !$logo->hasMoved()) {
            $newName = $logo->getRandomName();
            $logo->move(FCPATH . 'assets/img', $newName);
            $db->table('pengaturan')->where('kunci', 'logo')->update(['nilai' => $newName]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui');
    }
}

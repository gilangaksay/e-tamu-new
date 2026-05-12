<?php namespace App\Controllers;
use App\Models\TamuModel;
use App\Models\PegawaiModel;

class DataTamu extends BaseController {
    public function index() {
        $model = new TamuModel();
        $filters = $this->request->getGet();
        return view('admin/tamu/index', [
            'title' => 'Data Tamu',
            'tamuList' => $model->filterTamu($filters)->paginate(10),
            'pager' => $model->pager,
            'pegawaiList' => (new PegawaiModel())->getAktif(),
            'filters' => $filters
        ]);
    }
    public function updateStatus() {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        (new TamuModel())->update($id, ['status' => $status]);
        return $this->response->setJSON(['success' => true, 'message' => 'Status diperbarui.']);
    }
    public function update() {
        $data = $this->request->getPost();
        
        // Validasi input wajib
        if (!$this->validate([
            'no_identitas' => 'required|exact_length[16]|numeric',
            'no_telp'      => 'required',
            'nama'         => 'required'
        ])) {
            return $this->response->setJSON(['success' => false, 'message' => 'NIK harus 16 digit angka dan data wajib diisi.']);
        }

        // Jika role petugas, kunci field identitas dan demografi (HANYA boleh ubah tujuan/keperluan)
        if (session()->get('admin_role') === 'petugas') {
            unset($data['nama'], $data['no_identitas'], $data['no_telp'], $data['instansi'], $data['jenis_kelamin'], $data['disabilitas'], $data['usia']);
        }
        
        (new TamuModel())->update($data['id'], $data);
        return $this->response->setJSON(['success' => true, 'message' => 'Data tamu diperbarui.']);
    }
    public function delete() {
        (new TamuModel())->delete($this->request->getPost('id'));
        return $this->response->setJSON(['success' => true, 'message' => 'Data dihapus.']);
    }
}

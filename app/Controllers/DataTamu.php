<?php namespace App\Controllers;
use App\Models\TamuModel;
use App\Models\PegawaiModel;

class DataTamu extends BaseController {
    public function index() {
        $model = new TamuModel();
        $filters = $this->request->getGet();
        $limit = $this->request->getGet('limit') ?? 10;
        return view('admin/tamu/index', [
            'title' => 'Data Tamu',
            'tamuList' => $model->filterTamu($filters)->paginate($limit),
            'pager' => $model->pager,
            'pegawaiList' => (new PegawaiModel())->getAktif(),
            'filters' => array_merge($filters, ['limit' => $limit])
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
        
        // Pastikan pegawai_id bernilai null jika yang dimasukkan adalah teks manual (bukan ID)
        if (isset($data['pegawai_id']) && !empty($data['pegawai_id']) && !is_numeric($data['pegawai_id'])) {
            $data['pegawai_id'] = null;
        }

        (new TamuModel())->update($data['id'], $data);
        return $this->response->setJSON(['success' => true, 'message' => 'Data tamu diperbarui.']);
    }
    public function delete() {
        (new TamuModel())->delete($this->request->getPost('id'));
        return $this->response->setJSON(['success' => true, 'message' => 'Data dihapus.']);
    }
}

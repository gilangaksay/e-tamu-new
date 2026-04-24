<?php namespace App\Controllers;
use App\Models\TamuModel;

class Tamu extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        $settings = $db->table('pengaturan')->get()->getResultArray();
        $sData = [];
        foreach($settings as $s) $sData[$s['kunci']] = $s['nilai'];

        return view('tamu/form', [
            'title' => $sData['nama_instansi'],
            's' => $sData
        ]);
    }

    public function submit() {
        if (!$this->validate([
            'no_identitas' => 'required|exact_length[16]|numeric',
            'no_telp'      => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'NIK harus 16 digit angka.');
        }

        $model = new TamuModel();
        $data = $this->request->getPost();
        
        $fotoData = $this->request->getPost('foto');
        if($fotoData) {
            $fotoData = str_replace('data:image/jpeg;base64,', '', $fotoData);
            $fotoData = str_replace(' ', '+', $fotoData);
            $dataFoto = base64_decode($fotoData);
            $imageName = 'tamu_' . time() . '.jpg';
            file_put_contents(FCPATH . 'uploads/tamu/' . $imageName, $dataFoto);
            $data['foto'] = $imageName;
        }

        $data['no_antrian'] = $model->generateNoAntrian();
        $data['status'] = 'menunggu';
        $model->insert($data);

        return redirect()->to(site_url('tamu/konfirmasi/' . $model->insertID()));
    }

    public function konfirmasi($id) {
        $model = new TamuModel();
        $tamu = $model->find($id);
        if(!$tamu) return redirect()->to(site_url('/'));
        
        return view('tamu/konfirmasi', [
            'title' => 'Konfirmasi Kunjungan',
            'tamu' => $tamu
        ]);
    }
}

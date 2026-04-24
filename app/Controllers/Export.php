<?php namespace App\Controllers;
use App\Models\TamuModel;

class Export extends BaseController {
    public function index() {
        if (session()->get('admin_role') != 'admin') return redirect()->to(site_url('admin/dashboard'))->with('error', 'Akses ditolak');
        
        $filters = $this->request->getGet();
        $filters['tgl_mulai'] = $filters['tgl_mulai'] ?? date('Y-m-01');
        $filters['tgl_akhir'] = $filters['tgl_akhir'] ?? date('Y-m-d');
        
        return view('admin/export/index', array_merge([
            'title' => 'Cetak Laporan',
            'years' => range(date('Y'), date('Y') - 5)
        ], $filters));
    }

    public function print() {
        if (session()->get('admin_role') != 'admin') return redirect()->to(site_url('admin/dashboard'))->with('error', 'Akses ditolak');
        $model = new TamuModel();
        
        $filters = $this->request->getGet();
        $laporanTamu = $model->filterTamu($filters)->orderBy('created_at', 'ASC')->findAll();

        $db = \Config\Database::connect();
        $settings = $db->table('pengaturan')->get()->getResultArray();
        $s = []; foreach($settings as $set) $s[$set['kunci']] = $set['nilai'];

        // Build active filter labels for print header
        $filterLabels = [];
        if (!empty($filters['search'])) $filterLabels[] = 'Pencarian: ' . $filters['search'];
        if (!empty($filters['keperluan'])) $filterLabels[] = 'Keperluan: ' . $filters['keperluan'];
        if (!empty($filters['jenis_kelamin'])) $filterLabels[] = 'Jenis Kelamin: ' . ($filters['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan');
        if (!empty($filters['disabilitas'])) $filterLabels[] = 'Disabilitas: ' . $filters['disabilitas'];
        if (!empty($filters['usia'])) $filterLabels[] = 'Usia: ' . $filters['usia'];
        if (!empty($filters['status'])) $filterLabels[] = 'Status: ' . ucfirst($filters['status']);
        if (!empty($filters['tahun'])) $filterLabels[] = 'Tahun: ' . $filters['tahun'];

        return view('admin/export/print_view', array_merge([
            'laporanTamu' => $laporanTamu,
            's' => $s,
            'filterLabels' => $filterLabels
        ], $filters));
    }
}

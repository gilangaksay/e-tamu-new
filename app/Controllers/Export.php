<?php namespace App\Controllers;
use App\Models\TamuModel;
use App\Models\PegawaiModel;

class Export extends BaseController {
    public function index() {
        if (!in_array(session()->get('admin_role'), ['admin', 'petugas'])) return redirect()->to(site_url('admin/dashboard'))->with('error', 'Akses ditolak');
        
        $filters = $this->request->getGet();
        $filters['tgl_mulai'] = $filters['tgl_mulai'] ?? date('Y-m-01');
        $filters['tgl_akhir'] = $filters['tgl_akhir'] ?? date('Y-m-d');
        
        return view('admin/export/index', array_merge([
            'title' => 'Cetak Laporan',
            'years' => range(date('Y'), date('Y') - 5),
            'pegawaiList' => (new PegawaiModel())->getAktif(),
        ], $filters));
    }

    public function print() {
        if (!in_array(session()->get('admin_role'), ['admin', 'petugas'])) return redirect()->to(site_url('admin/dashboard'))->with('error', 'Akses ditolak');
        $model = new TamuModel();
        
        $filters = $this->request->getGet();
        $format = $filters['format'] ?? 'print';
        
        $laporanTamu = $model->filterTamu($filters)->orderBy('created_at', 'ASC')->findAll();

        $db = \Config\Database::connect();
        $settings = $db->table('pengaturan')->get()->getResultArray();
        $s = []; foreach($settings as $set) $s[$set['kunci']] = $set['nilai'];

        // Build active filter labels for print header
        $filterLabels = [];
        if (!empty($filters['search'])) $filterLabels[] = 'Karyawan Dituju: ' . $filters['search'];
        if (!empty($filters['keperluan'])) $filterLabels[] = 'Keperluan: ' . $filters['keperluan'];
        if (!empty($filters['jenis_kelamin'])) $filterLabels[] = 'Jenis Kelamin: ' . ($filters['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan');
        if (!empty($filters['disabilitas'])) $filterLabels[] = 'Disabilitas: ' . $filters['disabilitas'];
        if (!empty($filters['usia'])) $filterLabels[] = 'Usia: ' . $filters['usia'];
        if (!empty($filters['status'])) $filterLabels[] = 'Status: ' . ucfirst($filters['status']);
        if (!empty($filters['tahun'])) $filterLabels[] = 'Tahun: ' . $filters['tahun'];

        $data = array_merge([
            'laporanTamu' => $laporanTamu,
            's' => $s,
            'filterLabels' => $filterLabels
        ], $filters);

        if ($format == 'pdf') {
            ini_set('memory_limit', '1024M'); // Increase memory limit
            
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'Helvetica');
            
            // Try to get logo as base64 to avoid GD dependency if possible, 
            // but dompdf still uses GD for rendering PNGs.
            $logoPath = FCPATH . 'assets/img/' . ($s['logo'] ?? 'logo.png');
            if (file_exists($logoPath)) {
                $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                $dataImg = file_get_contents($logoPath);
                $data['logo_base64'] = 'data:image/' . $type . ';base64,' . base64_encode($dataImg);
            }

            $dompdf = new \Dompdf\Dompdf($options);
            $html = view('admin/export/pdf_view', $data);
            
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            
            return $this->response->setHeader('Content-Type', 'application/pdf')
                                ->setBody($dompdf->output())
                                ->send();
        } elseif ($format == 'excel') {
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan_Kunjungan_" . date('Ymd') . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            
            return view('admin/export/excel_view', $data);
        }

        return view('admin/export/print_view', $data);
    }
}

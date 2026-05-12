<?php namespace App\Controllers;
use App\Models\TamuModel;
use App\Models\PegawaiModel;


class Laporan extends BaseController {
    public function index() {
        $model = new TamuModel();
        
        $filters = $this->request->getGet();
        $filters['tgl_mulai'] = $filters['tgl_mulai'] ?? '';
        $filters['tgl_akhir'] = $filters['tgl_akhir'] ?? '';
        $filters['search'] = $filters['search'] ?? '';
        $filters['pegawai_id'] = $filters['pegawai_id'] ?? '';
        $filters['keperluan'] = $filters['keperluan'] ?? '';
        $filters['status'] = $filters['status'] ?? '';
        $filters['jenis_kelamin'] = $filters['jenis_kelamin'] ?? '';
        $filters['disabilitas'] = $filters['disabilitas'] ?? '';
        $filters['usia'] = $filters['usia'] ?? '';

        $laporanTamu = $model->filterTamu($filters)->paginate(10);

        // Statistics
        $stats = [
            'harian'  => $model->where('DATE(tamu.created_at)', date('Y-m-d'))->countAllResults(),
            'mingguan' => $model->where('tamu.created_at >=', date('Y-m-d', strtotime('-7 days')))->countAllResults(),
            'bulanan' => $model->where('MONTH(tamu.created_at)', date('m'))->where('YEAR(tamu.created_at)', date('Y'))->countAllResults(),
            'tahunan' => $model->where('YEAR(tamu.created_at)', date('Y'))->countAllResults()
        ];


        return view('admin/laporan/index', array_merge([
            'title' => 'Laporan Aktivitas',
            'laporanTamu' => $laporanTamu,
            'pager' => $model->pager,
            'stats' => $stats,
            'pegawaiList' => (new PegawaiModel())->getAktif()
        ], $filters));

    }
}

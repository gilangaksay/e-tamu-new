<?php namespace App\Controllers;
use App\Models\TamuModel;

class Laporan extends BaseController {
    public function index() {
        $model = new TamuModel();
        
        $filters = $this->request->getGet();
        $filters['tgl_mulai'] = $filters['tgl_mulai'] ?? date('Y-m-01');
        $filters['tgl_akhir'] = $filters['tgl_akhir'] ?? date('Y-m-d');

        $laporanTamu = $model->filterTamu($filters)->paginate(10);

        // Statistics
        $stats = [
            'harian'  => $model->where('DATE(created_at)', date('Y-m-d'))->countAllResults(),
            'mingguan' => $model->where('created_at >=', date('Y-m-d', strtotime('-7 days')))->countAllResults(),
            'bulanan' => $model->where('MONTH(created_at)', date('m'))->where('YEAR(created_at)', date('Y'))->countAllResults(),
            'tahunan' => $model->where('YEAR(created_at)', date('Y'))->countAllResults()
        ];

        return view('admin/laporan/index', array_merge([
            'title' => 'Laporan Aktivitas',
            'laporanTamu' => $laporanTamu,
            'pager' => $model->pager,
            'stats' => $stats
        ], $filters));
    }
}

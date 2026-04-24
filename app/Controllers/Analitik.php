<?php namespace App\Controllers;
use App\Models\TamuModel;

class Analitik extends BaseController {
    public function index() {
        $model = new TamuModel();
        
        // 1. Distribution of Purposes (Donut Chart)
        $purposes = $model->select('keperluan, COUNT(*) as total')->groupBy('keperluan')->findAll();
        
        // 2. Trend by Month (this year)
        $monthlyData = []; $monthlyLabels = [];
        for ($m=1; $m<=12; $m++) {
            $monthlyLabels[] = date('M', mktime(0,0,0,$m, 1));
            $monthlyData[] = $model->where('MONTH(created_at)', $m)->where('YEAR(created_at)', date('Y'))->countAllResults();
        }

        // 3. Peak Hours (Custom Ranges)
        $peakHours = [
            'Pagi (08-11)' => $model->where('HOUR(created_at) >=', 8)->where('HOUR(created_at) <=', 11)->countAllResults(),
            'Siang (11-13)' => $model->where('HOUR(created_at) >', 11)->where('HOUR(created_at) <=', 13)->countAllResults(),
            'Sore (13-16)' => $model->where('HOUR(created_at) >', 13)->where('HOUR(created_at) <=', 16)->countAllResults(),
        ];

        return view('admin/analitik/index', [
            'title' => 'Analitik Pengunjung',
            'purposes' => $purposes,
            'monthly' => ['labels' => $monthlyLabels, 'data' => $monthlyData],
            'peakHours' => $peakHours
        ]);
    }
}

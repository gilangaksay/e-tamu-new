<?php namespace App\Controllers;
use App\Models\AdminModel;
use App\Models\TamuModel;

class Admin extends BaseController {
    public function login() { 
        if (session()->get('admin_logged_in')) return redirect()->to(site_url('admin/dashboard'));
        return view('admin/login', ['title' => 'Login Admin']); 
    }
    public function loginProcess() {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $model = new AdminModel();
        $admin = $model->where('username', $username)->first();
        
        if (!$admin) {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
        
        if (password_verify($password, $admin['password'])) {
            session()->set([
                'admin_id' => $admin['id'], 
                'admin_nama' => $admin['nama_lengkap'], 
                'admin_foto' => $admin['foto'],
                'admin_role' => $admin['role'] ?? 'admin',
                'admin_logged_in' => true
            ]);
            return redirect()->to(site_url('admin/dashboard'))->with('success', 'Selamat datang!');
        }
        
        return redirect()->back()->with('error', 'Password salah.');
    }
    public function logout() { session()->destroy(); return redirect()->to(site_url('admin/login')); }
    public function dashboard() {
        $model = new TamuModel();
        $range = $this->request->getGet('range') ?? 'mingguan';
        
        // Status Distribution for Donut Chart
        $statusCounts = [
            'waiting' => $model->where('status', 'menunggu')->countAllResults(),
            'visiting' => $model->where('status', 'berkunjung')->countAllResults(),
            'done' => $model->where('status', 'selesai')->countAllResults(),
            'cancelled' => $model->where('status', 'dibatalkan')->countAllResults(),
        ];

        return view('admin/dashboard', [
            'title' => 'Ringkasan Sistem',
            'chartStats' => $model->getChartStats($range),
            'currentRange' => $range,
            'tamuTerbaru' => $model->orderBy('created_at', 'DESC')->limit(10)->findAll(),
            'statusCounts' => $statusCounts,
            'totalTamu' => $model->countAllResults()
        ]);
    }
}

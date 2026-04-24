<?php namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model {
    protected $table = 'admin';
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'foto', 'role'];
    protected $useTimestamps = true;
    public function verifyLogin($username, $password) {
        $admin = $this->where('username', $username)->first();
        return ($admin && password_verify($password, $admin['password'])) ? $admin : null;
    }
}

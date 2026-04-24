<?php namespace App\Models;
use CodeIgniter\Model;

class PegawaiModel extends Model {
    protected $table = 'pegawai';
    protected $allowedFields = ['nama', 'jabatan', 'unit_kerja', 'aktif'];
    protected $useTimestamps = true;
    public function getAktif() { return $this->where('aktif', 1)->orderBy('nama', 'ASC')->findAll(); }
}

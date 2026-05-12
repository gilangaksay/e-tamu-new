<?php namespace App\Models;
use CodeIgniter\Model;

class TamuModel extends Model {
    protected $table = 'tamu';
    protected $allowedFields = ['nama', 'no_identitas', 'instansi', 'tujuan_orang', 'no_telp', 'pegawai_id', 'keperluan', 'keterangan', 'status', 'no_antrian', 'foto', 'jenis_kelamin', 'disabilitas', 'usia'];
    protected $useTimestamps = true;

    public function getTamuWithPegawai($id = null) {
        $builder = $this->select('tamu.*');
        return ($id !== null) ? $builder->where('tamu.id', $id)->first() : $builder->orderBy('tamu.created_at', 'DESC');
    }

    public function generateNoAntrian() {
        $last = $this->where('DATE(created_at)', date('Y-m-d'))->orderBy('id', 'DESC')->first();
        $num = $last ? (int)substr($last['no_antrian'], 1) + 1 : 1;
        return 'A' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    public function filterTamu($filters = []) {
        $builder = $this->select('tamu.*, pegawai.nama as nama_pegawai')
                        ->join('pegawai', 'pegawai.id = tamu.pegawai_id', 'left');

        if (!empty($filters['tgl_mulai'])) $builder->where('DATE(tamu.created_at) >=', $filters['tgl_mulai']);
        if (!empty($filters['tgl_akhir'])) $builder->where('DATE(tamu.created_at) <=', $filters['tgl_akhir']);
        if (!empty($filters['status'])) $builder->where('tamu.status', $filters['status']);
        if (!empty($filters['tahun'])) $builder->where('YEAR(tamu.created_at)', $filters['tahun']);
        if (!empty($filters['keperluan'])) $builder->where('tamu.keperluan', $filters['keperluan']);
        if (!empty($filters['jenis_kelamin'])) $builder->where('tamu.jenis_kelamin', $filters['jenis_kelamin']);
        if (!empty($filters['disabilitas'])) $builder->where('tamu.disabilitas', $filters['disabilitas']);
        if (!empty($filters['usia'])) $builder->where('tamu.usia', $filters['usia']);
        if (!empty($filters['pegawai_id'])) $builder->where('tamu.pegawai_id', $filters['pegawai_id']);
        
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $builder->groupStart()
                    ->like('tamu.nama', $search)
                    ->orLike('tamu.no_identitas', $search)
                    ->orLike('tamu.tujuan_orang', $search)
                    ->orLike('pegawai.nama', $search)
                    ->groupEnd();
        }
        return $builder->orderBy('tamu.created_at', 'DESC');
    }


    public function getChartStats($range = 'mingguan') {
        $labels = []; $data = [];
        if ($range == 'harian') {
            for ($i = 23; $i >= 0; $i--) {
                $time = strtotime("-{$i} hours");
                $labels[] = date('H:i', $time);
                $data[] = $this->where('DATE(created_at)', date('Y-m-d', $time))
                               ->where('HOUR(created_at)', date('H', $time))
                               ->countAllResults();
            }
        } elseif ($range == 'bulanan') {
            for ($i = 29; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-{$i} days"));
                $labels[] = date('d/m', strtotime($date));
                $data[] = $this->where('DATE(created_at)', $date)->countAllResults();
            }
        } elseif ($range == 'tahunan') {
            for ($i = 11; $i >= 0; $i--) {
                $month = date('Y-m', strtotime("-{$i} months"));
                $labels[] = date('M y', strtotime("-{$i} months"));
                $data[] = $this->like('created_at', $month, 'after')->countAllResults();
            }
        } else { // mingguan
            for ($i = 6; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-{$i} days"));
                $labels[] = date('d/m', strtotime($date));
                $data[] = $this->where('DATE(created_at)', $date)->countAllResults();
            }
        }
        return ['labels' => $labels, 'data' => $data];
    }
}

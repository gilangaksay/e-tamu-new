<?= $this->include('admin/layout/header') ?>

<div class="row g-4 mb-5 mt-1">
    <div class="col-md-3 col-sm-6">
        <div class="modern-card p-4 bg-white border-0 shadow-sm border-start border-primary border-5 h-100 transition-hover">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3">
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
                <h2 class="fw-800 text-dark mb-0"><?= $stats['harian'] ?></h2>
            </div>
            <p class="text-muted extra-small fw-bold text-uppercase tracking-wider mb-0">Harian</p>
            <small class="text-primary extra-small">Hari ini</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="modern-card p-4 bg-white border-0 shadow-sm border-start border-indigo border-5 h-100 transition-hover">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="p-2 bg-indigo bg-opacity-10 text-indigo rounded-3">
                    <i class="bi bi-graph-up-arrow fs-4"></i>
                </div>
                <h2 class="fw-800 text-dark mb-0"><?= $stats['mingguan'] ?></h2>
            </div>
            <p class="text-muted extra-small fw-bold text-uppercase tracking-wider mb-0">Mingguan</p>
            <small class="text-indigo extra-small">7 hari terakhir</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="modern-card p-4 bg-white border-0 shadow-sm border-start border-purple border-5 h-100 transition-hover">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="p-2 bg-purple bg-opacity-10 text-purple rounded-3">
                    <i class="bi bi-calendar3-range fs-4"></i>
                </div>
                <h2 class="fw-800 text-dark mb-0"><?= $stats['bulanan'] ?></h2>
            </div>
            <p class="text-muted extra-small fw-bold text-uppercase tracking-wider mb-0">Bulanan</p>
            <small class="text-purple extra-small">Bulan ini</small>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="modern-card p-4 bg-white border-0 shadow-sm border-start border-success border-5 h-100 transition-hover">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="p-2 bg-success bg-opacity-10 text-success rounded-3">
                    <i class="bi bi-award fs-4"></i>
                </div>
                <h2 class="fw-800 text-dark mb-0"><?= $stats['tahunan'] ?></h2>
            </div>
            <p class="text-muted extra-small fw-bold text-uppercase tracking-wider mb-0">Tahunan</p>
            <small class="text-success extra-small">Tahun <?= date('Y') ?></small>
        </div>
    </div>
</div>

<div class="modern-card bg-white border-0 shadow-sm overflow-hidden mb-5">
    <div class="p-4 bg-light bg-opacity-50 d-flex justify-content-between align-items-center border-bottom">
        <div>
            <h6 class="fw-800 mb-1">Riwayat Kunjungan Mendalam</h6>
            <p class="text-muted extra-small m-0">Menampilkan data dari <?= date('d M Y', strtotime($tgl_mulai)) ?> s/d <?= date('d M Y', strtotime($tgl_akhir)) ?></p>
        </div>
    </div>

    <div id="filterLaporan">
        <div class="p-4 border-bottom bg-white">
            <form class="row g-3">
                <div class="col-md-5">
                    <label class="form-label extra-small fw-bold text-dark">Cari Pengunjung</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Nama atau NIK..." value="<?= $search ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label extra-small fw-bold text-dark">Mulai</label>
                    <input type="date" name="tgl_mulai" class="form-control form-control-sm" value="<?= $tgl_mulai ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label extra-small fw-bold text-dark">Akhir</label>
                    <input type="date" name="tgl_akhir" class="form-control form-control-sm" value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fw-800">Filter Data</button>
                    <a href="<?= site_url('admin/laporan') ?>" class="btn btn-light btn-sm py-2 px-3 fw-800 border" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>

                <!-- Filter Tambahan -->
                <div class="col-12 mt-3">
                    <div class="p-3 rounded-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <p class="extra-small fw-800 text-primary text-uppercase tracking-wider mb-3"><i class="bi bi-funnel-fill me-1"></i> Filter Tambahan</p>
                        <div class="row g-3">
                            <div class="col-md">
                                <label class="form-label extra-small fw-bold text-muted">Keperluan</label>
                                <select name="keperluan" class="form-select form-select-sm">
                                    <option value="">Semua</option>
                                    <option value="Layanan AHU" <?= ($keperluan ?? '') == 'Layanan AHU' ? 'selected' : '' ?>>Layanan AHU</option>
                                    <option value="Layanan KI" <?= ($keperluan ?? '') == 'Layanan KI' ? 'selected' : '' ?>>Layanan KI</option>
                                    <option value="Layanan Peraturan Perundangan-undangan" <?= ($keperluan ?? '') == 'Layanan Peraturan Perundangan-undangan' ? 'selected' : '' ?>>Layanan Peraturan Perundangan-undangan</option>
                                    <option value="Layanan Umum" <?= ($keperluan ?? '') == 'Layanan Umum' ? 'selected' : '' ?>>Layanan Umum</option>
                                    <option value="Lainnya" <?= ($keperluan ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <label class="form-label extra-small fw-bold text-muted">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="">Semua</option>
                                    <option value="menunggu" <?= ($status ?? '') == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                    <option value="berkunjung" <?= ($status ?? '') == 'berkunjung' ? 'selected' : '' ?>>Berkunjung</option>
                                    <option value="selesai" <?= ($status ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                    <option value="dibatalkan" <?= ($status ?? '') == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <label class="form-label extra-small fw-bold text-muted">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select form-select-sm">
                                    <option value="">Semua</option>
                                    <option value="L" <?= ($jenis_kelamin ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= ($jenis_kelamin ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <label class="form-label extra-small fw-bold text-muted">Disabilitas</label>
                                <select name="disabilitas" class="form-select form-select-sm">
                                    <option value="">Semua</option>
                                    <option value="Non Disabilitas" <?= ($disabilitas ?? '') == 'Non Disabilitas' ? 'selected' : '' ?>>Non Disabilitas</option>
                                    <option value="Disabilitas" <?= ($disabilitas ?? '') == 'Disabilitas' ? 'selected' : '' ?>>Disabilitas</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <label class="form-label extra-small fw-bold text-muted">Usia</label>
                                <select name="usia" class="form-select form-select-sm">
                                    <option value="">Semua</option>
                                    <option value="15-20" <?= ($usia ?? '') == '15-20' ? 'selected' : '' ?>>15-20</option>
                                    <option value="21-30" <?= ($usia ?? '') == '21-30' ? 'selected' : '' ?>>21-30</option>
                                    <option value="31-40" <?= ($usia ?? '') == '31-40' ? 'selected' : '' ?>>31-40</option>
                                    <option value="41-50" <?= ($usia ?? '') == '41-50' ? 'selected' : '' ?>>41-50</option>
                                    <option value="50+" <?= ($usia ?? '') == '50+' ? 'selected' : '' ?>>50+</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="bg-light">
                    <th class="ps-4 py-3 border-0 text-muted extra-small text-uppercase fw-800">Antrian</th>
                    <th class="py-3 border-0 text-muted extra-small text-uppercase fw-800">Identitas Pengunjung</th>
                    <th class="py-3 border-0 text-muted extra-small text-uppercase fw-800">Tujuan & Waktu</th>
                    <th class="pe-4 py-3 border-0 text-muted extra-small text-uppercase fw-800 text-end">Status Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($laporanTamu)): ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada data kunjungan yang tercatat untuk periode ini.</td></tr>
                <?php endif; ?>
                <?php foreach($laporanTamu as $t): ?>
                <tr>
                    <td class="ps-4">
                        <div class="p-2 bg-light rounded-3 text-center" style="width:45px;">
                            <span class="fw-800 text-primary small"><?= $t['no_antrian'] ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark mb-0"><?= esc($t['nama']) ?></div>
                        <div class="extra-small text-muted"><?= esc($t['no_identitas']) ?></div>
                        <div class="extra-small text-muted mb-1"><?= esc($t['no_telp'] ?? '-') ?></div>
                        <span class="badge bg-light text-primary border border-primary border-opacity-10 py-1 px-2" style="font-size:0.6rem;"><?= esc($t['instansi'] ?? 'Pribadi') ?></span>
                    </td>
                    <td>
                        <div class="small fw-800 mb-1"><?= esc($t['keperluan']) ?></div>
                        <div class="extra-small text-muted d-flex align-items-center gap-2">
                            <span><i class="bi bi-calendar-event me-1"></i><?= date('d/m/Y', strtotime($t['created_at'])) ?></span>
                            <span><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($t['created_at'])) ?> WIB</span>
                        </div>
                    </td>
                    <td class="pe-4 text-end">
                        <?php 
                            $statusLabel = [
                                'menunggu' => ['bg' => 'bg-warning', 'text' => 'Menunggu'],
                                'berkunjung' => ['bg' => 'bg-info', 'text' => 'Berkunjung'],
                                'selesai' => ['bg' => 'bg-success', 'text' => 'Selesai'],
                                'dibatalkan' => ['bg' => 'bg-danger', 'text' => 'Dibatalkan']
                            ];
                            $s = $statusLabel[$t['status']] ?? ['bg' => 'bg-secondary', 'text' => $t['status']];
                        ?>
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill <?= $s['bg'] ?> bg-opacity-10">
                            <div class="rounded-circle <?= $s['bg'] ?>" style="width:6px; height:6px;"></div>
                            <span class="fw-bold text-uppercase <?= str_replace('bg', 'text', $s['bg']) ?>" style="font-size:0.65rem;"><?= $s['text'] ?></span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-top bg-light bg-opacity-25 d-flex justify-content-end">
        <?= $pager->links('default', 'modern') ?>
    </div>
</div>

<style>
    .transition-hover { transition: 0.3s; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
</style>

<?= $this->include('admin/layout/footer') ?>

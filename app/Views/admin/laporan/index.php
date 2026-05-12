<?= $this->include('admin/layout/header') ?>

<!-- Tom Select Assets -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>


<div class="row g-4 mb-5 mt-1">
<?php
function format_indo($date) {
    if (!$date) return '-';
    $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $months = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $timestamp = strtotime($date);
    $day = $days[date('w', $timestamp)];
    $d = date('d', $timestamp);
    $m = $months[(int)date('m', $timestamp)];
    $y = date('Y', $timestamp);
    return "$day, $d $m $y";
}
?>
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
            <p class="text-muted extra-small m-0">
                <?php if(!empty($tgl_mulai) && !empty($tgl_akhir)): ?>
                    Menampilkan data dari <?= date('d M Y', strtotime($tgl_mulai)) ?> s/d <?= date('d M Y', strtotime($tgl_akhir)) ?>
                <?php else: ?>
                    Menampilkan Semua Data Kunjungan
                <?php endif; ?>
                <?php if(!empty($search)): ?>
                    <span class="badge bg-primary bg-opacity-10 text-primary ms-2 border border-primary border-opacity-10">Pencarian: "<?= esc($search) ?>"</span>
                <?php endif; ?>
            </p>
        </div>

    </div>

    <div id="filterLaporan">
        <div class="p-4 border-bottom bg-white">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label extra-small fw-bold text-dark">Cari Nama/NIK Tamu</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari..." value="<?= $search ?? '' ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label extra-small fw-bold text-dark">Filter Karyawan</label>
                    <select name="pegawai_id" id="filter_pegawai" class="rounded-3">
                        <option value="">Semua Karyawan</option>
                        <?php foreach($pegawaiList as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= ($pegawai_id ?? '') == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label extra-small fw-bold text-dark">Mulai</label>
                    <input type="date" name="tgl_mulai" class="form-control form-control-sm" value="<?= $tgl_mulai ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label extra-small fw-bold text-dark">Akhir</label>
                    <input type="date" name="tgl_akhir" class="form-control form-control-sm" value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fw-800">Filter</button>
                    <a href="<?= site_url('admin/laporan') ?>" class="btn btn-light btn-sm py-2 px-2 fw-800 border" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
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
                    <th class="py-3 border-0 text-muted extra-small text-uppercase fw-800">Profil & Foto</th>
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
                        <div class="d-flex align-items-center gap-3">
                            <div class="position-relative">
                                <div class="rounded-circle border-white border-3 shadow-sm overflow-hidden bg-light" style="width:55px; height:55px;">
                                    <?php if($t['foto']): ?>
                                        <img src="<?= base_url('uploads/tamu/' . $t['foto']) ?>" class="w-100 h-100 object-fit-cover" onclick="showFoto('<?= base_url('uploads/tamu/' . $t['foto']) ?>')" style="cursor:zoom-in;">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-person-fill fs-4"></i></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div>
                                <div class="fw-800 text-dark mb-0 fs-6"><?= esc($t['nama']) ?></div>
                                <div class="extra-small text-muted"><i class="bi bi-card-text me-1"></i><?= esc($t['no_identitas']) ?></div>
                                <div class="extra-small text-muted"><i class="bi bi-whatsapp me-1"></i><?= esc($t['no_telp'] ?? '-') ?></div>
                                <div class="badge bg-light text-primary mt-1 border border-primary border-opacity-10" style="font-size:0.6rem;"><?= esc($t['instansi'] ?? 'Pribadi') ?></div>
                                <div class="badge bg-light text-success mt-1 border border-success border-opacity-10" style="font-size:0.6rem;"><i class="bi bi-person-fill me-1"></i>Ke: <?= esc($t['tujuan_orang'] ?? '-') ?></div>
                                <div class="mt-1 d-flex gap-1 flex-wrap">
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10" style="font-size:0.55rem;" title="Jenis Kelamin"><?= $t['jenis_kelamin'] ?? '-' ?></span>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10" style="font-size:0.55rem;" title="Usia"><?= $t['usia'] ?? '-' ?> Thn</span>
                                    <?php if(($t['disabilitas'] ?? '') == 'Disabilitas'): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10" style="font-size:0.55rem;">Disabilitas</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if(str_starts_with($t['keperluan'], 'Lainnya: ')): ?>
                            <div class="small fw-800 text-dark mb-1">Lainnya</div>
                            <div class="extra-small text-primary fw-bold mb-1 italic"><?= esc(substr($t['keperluan'], 9)) ?></div>
                        <?php else: ?>
                            <div class="small fw-800 text-dark mb-1"><?= esc($t['keperluan']) ?></div>
                        <?php endif; ?>
                        <div class="extra-small text-muted text-truncate mb-2" style="max-width:180px;" title="<?= esc($t['keterangan']) ?>"><?= esc($t['keterangan'] ?? '-') ?></div>
                        <div class="extra-small d-flex gap-2">
                            <span class="text-secondary"><i class="bi bi-calendar-event me-1"></i><?= format_indo($t['created_at']) ?></span>
                            <span class="text-secondary"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($t['created_at'])) ?></span>
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
        <?= $pager->links('default', 'boxed') ?>
    </div>
</div>

<script>
    function showFoto(url) {
        Swal.fire({
            imageUrl: url,
            imageAlt: 'Selfie Tamu',
            showConfirmButton: false,
            customClass: {
                image: 'rounded-5 border-white border-5 shadow-2xl'
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        new TomSelect("#filter_pegawai", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    });

</script>

<style>
    .transition-hover { transition: 0.3s; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }

    /* Tom Select Styling */
    .ts-control { border: none !important; padding: 12px 20px !important; border-radius: 12px !important; background-color: #f8fafc !important; font-weight: 600 !important; color: #334155 !important; min-height: 45px !important; border: 1px solid #e2e8f0 !important; }
    .ts-wrapper.single .ts-control { background-image: none !important; }
    .ts-wrapper.single .ts-control::after { content: "\F229"; font-family: "bootstrap-icons"; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #6366f1; font-weight: bold; }
    .ts-dropdown { border-radius: 12px !important; border: 1px solid #e2e8f0 !important; box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; padding: 5px !important; }
</style>


<?= $this->include('admin/layout/footer') ?>

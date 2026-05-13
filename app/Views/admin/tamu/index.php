<?= $this->include('admin/layout/header') ?>

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

<!-- Header Section -->
<div class="row mb-5 mt-2">
    <div class="col-12">
        <div class="modern-card p-4 bg-white border-0 shadow-sm border-start border-primary border-5 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-800 mb-1 text-dark">Manajemen Tamu</h4>
                <p class="text-muted small m-0">Kelola antrian dan riwayat kunjungan pengunjung secara real-time.</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <form action="" method="GET" class="d-flex gap-2">
                    <input type="hidden" name="limit" value="<?= $filters['limit'] ?? 10 ?>">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari Nama/NIK..." value="<?= $filters['search'] ?? '' ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-800">Cari</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Filter Box -->
<div class="mb-4" id="filterBox">
    <div class="modern-card p-4 bg-white border-0 shadow-lg">
        <form action="" method="GET" class="row g-3 align-items-end">
            <input type="hidden" name="limit" value="<?= $filters['limit'] ?? 10 ?>">
            <div class="col-md-3"><label class="form-label small fw-800 text-muted">Mulai Tanggal</label><input type="date" name="tgl_mulai" class="form-control rounded-3" value="<?= $filters['tgl_mulai'] ?? '' ?>"></div>
            <div class="col-md-3"><label class="form-label small fw-800 text-muted">Sampai Tanggal</label><input type="date" name="tgl_akhir" class="form-control rounded-3" value="<?= $filters['tgl_akhir'] ?? '' ?>"></div>
            <div class="col-md-3">
                <label class="form-label small fw-800 text-muted">Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="">Semua Status</option>
                    <option value="menunggu" <?= ($filters['status'] ?? '') == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="berkunjung" <?= ($filters['status'] ?? '') == 'berkunjung' ? 'selected' : '' ?>>Berkunjung</option>
                    <option value="selesai" <?= ($filters['status'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="dibatalkan" <?= ($filters['status'] ?? '') == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-3 text-end mt-3"><button type="submit" class="btn-modern px-5 py-2 shadow-sm">Terapkan Perubahan</button></div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="modern-card bg-white border-0 shadow-sm overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="bg-light bg-opacity-50">
                    <th class="ps-4 py-3 border-0 text-muted extra-small text-uppercase fw-800">No</th>
                    <th class="py-3 border-0 text-muted extra-small text-uppercase fw-800">Antrian</th>
                    <th class="py-3 border-0 text-muted extra-small text-uppercase fw-800">Profil & Foto</th>
                    <th class="py-3 border-0 text-muted extra-small text-uppercase fw-800">Kunjungan</th>
                    <th class="py-3 border-0 text-muted extra-small text-uppercase fw-800">Kendali Status</th>
                    <th class="pe-4 py-3 border-0 text-muted extra-small text-uppercase fw-800 text-end">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $currentLimit = $filters['limit'] ?? 10;
                    $no = 1 + ($pager->getCurrentPage() - 1) * $currentLimit;
                    foreach($tamuList as $t): 
                ?>
                <tr id="row-<?= $t['id'] ?>" class="border-bottom border-light">
                    <!-- Column 0: No -->
                    <td class="ps-4 text-muted fw-bold small"><?= $no++ ?></td>
                    
                    <!-- Column 1: Antrian -->
                    <td>
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary fw-800 rounded-4" style="width:45px; height:45px; font-size:0.9rem;">
                            <?= $t['no_antrian'] ?>
                        </div>
                    </td>
                    
                    <!-- Column 2: Foto & Profil -->
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
                                <div class="position-absolute bottom-0 end-0 bg-success border border-white border-2 rounded-circle" style="width:12px; height:12px;"></div>
                            </div>
                            <div>
                                <div class="fw-800 text-dark mb-0 fs-6"><?= esc($t['nama']) ?></div>
                                <div class="extra-small text-muted"><i class="bi bi-card-text me-1"></i><?= esc($t['no_identitas']) ?></div>
                                <div class="extra-small text-muted"><i class="bi bi-whatsapp me-1"></i><?= esc($t['no_telp'] ?? '-') ?></div>
                                <div class="badge bg-light text-primary mt-1 border border-primary border-opacity-10" style="font-size:0.6rem;"><?= esc($t['instansi'] ?? 'Pribadi') ?></div>
                                <div class="badge bg-light text-success mt-1 border border-success border-opacity-10" style="font-size:0.6rem;"><i class="bi bi-person-fill me-1"></i>Ke: <?= esc($t['nama_pegawai'] ?? $t['tujuan_orang'] ?? '-') ?></div>
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
                    
                    <!-- Column 3: Keperluan -->
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
                    
                    <!-- Column 4: Status Control -->
                    <td>
                        <?php 
                            $stClass = 'bg-warning';
                            if($t['status'] == 'berkunjung') $stClass = 'bg-info';
                            if($t['status'] == 'selesai') $stClass = 'bg-success';
                            if($t['status'] == 'dibatalkan') $stClass = 'bg-danger';
                        ?>
                        <div class="dropdown">
                            <button class="btn btn-sm <?= $stClass ?> bg-opacity-10 <?= str_replace('bg', 'text', $stClass) ?> rounded-pill px-3 fw-bold border-0 dropdown-toggle text-uppercase" style="font-size:0.65rem;" data-bs-toggle="dropdown">
                                <?= $t['status'] ?>
                            </button>
                            <ul class="dropdown-menu border-0 shadow-lg rounded-4 p-2" style="font-size:0.75rem;">
                                <li><a class="dropdown-item py-2 px-3 fw-bold text-warning" href="javascript:void(0)" onclick="updateStatus(<?= $t['id'] ?>, 'menunggu')"><i class="bi bi-hourglass-split me-2"></i> MENUNGGU</a></li>
                                <li><a class="dropdown-item py-2 px-3 fw-bold text-info" href="javascript:void(0)" onclick="updateStatus(<?= $t['id'] ?>, 'berkunjung')"><i class="bi bi-person-walking me-2"></i> BERKUNJUNG</a></li>
                                <li><a class="dropdown-item py-2 px-3 fw-bold text-success" href="javascript:void(0)" onclick="updateStatus(<?= $t['id'] ?>, 'selesai')"><i class="bi bi-check-circle-fill me-2"></i> SELESAI</a></li>
                                <li><a class="dropdown-item py-2 px-3 fw-bold text-danger" href="javascript:void(0)" onclick="updateStatus(<?= $t['id'] ?>, 'dibatalkan')"><i class="bi bi-x-circle-fill me-2"></i> DIBATALKAN</a></li>
                            </ul>
                        </div>
                    </td>
                    
                    <!-- Column 5: Aksi -->
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <button onclick='editTamu(<?= json_encode($t) ?>)' class="btn btn-light btn-sm rounded-3 border-0 transition-hover" title="Sunting"><i class="bi bi-pencil-square fs-6"></i></button>
                            <button onclick="deleteTamu(<?= $t['id'] ?>)" class="btn btn-light btn-sm rounded-3 border-0 text-danger transition-hover" title="Hapus"><i class="bi bi-trash3-fill fs-6"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-top bg-light bg-opacity-25 d-flex justify-content-end"><?= $pager->links('default', 'boxed') ?></div>
</div>

<!-- Modal Edit (Refined Aesthetic) -->
<!-- Tambahkan Tom Select untuk fitur searching di dropdown -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<div class="modal fade" id="modalTamu" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-5 shadow-2xl overflow-hidden">
            <div class="p-4 bg-primary text-white text-center">
                <i class="bi bi-person-gear fs-1 mb-2 d-block"></i>
                <h5 class="fw-800 m-0">Sunting Detail Tamu</h5>
                <p class="small opacity-75 m-0 mb-2">Perbarui informasi pengunjung jika diperlukan</p>
            </div>
            <div class="modal-body p-4 bg-white">
                <form id="formTamu" class="row g-3">
                    <input type="hidden" name="id" id="tamuId">
                    <?php $isPetugas = (session()->get('admin_role') === 'petugas'); ?>
                    <div class="col-12"><label class="form-label small fw-800 text-muted">Nama Lengkap</label><input type="text" name="nama" id="nama" class="form-control rounded-3" required <?= $isPetugas ? 'readonly style="opacity:0.6; cursor:not-allowed;"' : '' ?>></div>
                    <div class="col-6"><label class="form-label small fw-800 text-muted">NIK / KTP</label><input type="text" name="no_identitas" id="no_identitas" class="form-control rounded-3" minlength="16" maxlength="16" pattern="\d{16}" title="NIK harus berjumlah 16 digit angka" required <?= $isPetugas ? 'readonly style="opacity:0.6; cursor:not-allowed;"' : '' ?>></div>
                    <div class="col-6"><label class="form-label small fw-800 text-muted">Nomor HP / WhatsApp</label><input type="tel" name="no_telp" id="no_telp" class="form-control rounded-3" required <?= $isPetugas ? 'readonly style="opacity:0.6; cursor:not-allowed;"' : '' ?>></div>
                    <div class="col-12"><label class="form-label small fw-800 text-muted">Instansi</label><input type="text" name="instansi" id="instansi" class="form-control rounded-3" <?= $isPetugas ? 'readonly style="opacity:0.6; cursor:not-allowed;"' : '' ?>></div>
                    <div class="col-12">
                        <label class="form-label small fw-800 text-muted">Orang yang Dituju</label>
                        <select name="pegawai_id" id="tujuan_orang_select" class="rounded-3">
                            <option value="">Pilih Karyawan...</option>
                            <?php foreach($pegawaiList as $p): ?>
                                <option value="<?= $p['id'] ?>" data-nama="<?= esc($p['nama']) ?>"><?= esc($p['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="tujuan_orang" id="tujuan_orang_hidden">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-800 text-muted">Keperluan</label>
                        <select name="keperluan" id="keperluan" class="form-select rounded-3" required>
                            <option value="Layanan AHU">Layanan AHU</option>
                            <option value="Layanan KI">Layanan KI</option>
                            <option value="Layanan Peraturan Perundangan-undangan">Layanan Peraturan Perundangan-undangan</option>
                            <option value="Layanan Umum">Layanan Umum</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-12"><label class="form-label small fw-800 text-muted">Alasan Keperluan</label><textarea name="keterangan" id="keterangan_edit" class="form-control rounded-3" rows="3"></textarea></div>
                    <div class="col-4">
                        <label class="form-label small fw-800 text-muted">L/P</label>
                        <select name="jenis_kelamin" id="jenis_kelamin_edit" class="form-select rounded-3" <?= $isPetugas ? 'style="pointer-events: none; opacity:0.6; background-color: #e9ecef;" tabindex="-1"' : '' ?>>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-800 text-muted">Disabilitas</label>
                        <select name="disabilitas" id="disabilitas_edit" class="form-select rounded-3" <?= $isPetugas ? 'style="pointer-events: none; opacity:0.6; background-color: #e9ecef;" tabindex="-1"' : '' ?>>
                            <option value="Non Disabilitas">Non</option>
                            <option value="Disabilitas">Disabilitas</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label small fw-800 text-muted">Usia</label>
                        <select name="usia" id="usia_edit" class="form-select rounded-3" <?= $isPetugas ? 'style="pointer-events: none; opacity:0.6; background-color: #e9ecef;" tabindex="-1"' : '' ?>>
                            <option value="15-20">15-20</option>
                            <option value="21-30">21-30</option>
                            <option value="31-40">31-40</option>
                            <option value="41-50">41-50</option>
                            <option value="50+">50+</option>
                        </select>
                    </div>
                    <div class="col-12 pt-3"><button type="button" onclick="saveTamu()" class="btn-modern w-100 py-3 shadow-lg">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let tamuModal;
    let tsTujuan;

    document.addEventListener('DOMContentLoaded', () => { 
        tamuModal = new bootstrap.Modal(document.getElementById('modalTamu')); 
        
        // Inisialisasi Tom Select
        tsTujuan = new TomSelect("#tujuan_orang_select", {
            create: true, // Izinkan input manual jika karyawan tidak ada di list
            sortField: {
                field: "text",
                direction: "asc"
            },
            onChange: function(value) {
                const hidden = document.getElementById('tujuan_orang_hidden');
                if (!value) {
                    hidden.value = '';
                    return;
                }
                
                const option = this.options[value];
                if (option && option.nama) {
                    // Jika dari dropdown (ada data-nama)
                    hidden.value = option.nama;
                } else {
                    // Jika input manual atau value adalah text
                    hidden.value = value;
                }
            }
        });
    });

    function editTamu(data) { 
        document.getElementById('tamuId').value = data.id; 
        document.getElementById('nama').value = data.nama; 
        document.getElementById('no_identitas').value = data.no_identitas; 
        document.getElementById('no_telp').value = data.no_telp || ''; 
        document.getElementById('instansi').value = data.instansi; 
        
        // Set nilai Tom Select
        if (tsTujuan) {
            if (data.pegawai_id && data.pegawai_id != 0) {
                tsTujuan.setValue(data.pegawai_id);
            } else {
                tsTujuan.setValue(data.tujuan_orang || '');
            }
        }
        document.getElementById('tujuan_orang_hidden').value = data.tujuan_orang || '';
        
        // Handle Keperluan Dropdown
        const keperluanSelect = document.getElementById('keperluan');
        // Check if value exists in options, if not set to 'Lainnya' (for compatibility with old 'Lainnya: detail' data)
        let valExists = false;
        for(let i=0; i < keperluanSelect.options.length; i++) {
            if(keperluanSelect.options[i].value == data.keperluan) {
                valExists = true;
                break;
            }
        }
        
        if (valExists) {
            keperluanSelect.value = data.keperluan;
        } else if (data.keperluan && data.keperluan.startsWith('Lainnya')) {
            keperluanSelect.value = 'Lainnya';
        } else {
            keperluanSelect.value = 'Lainnya'; // Fallback
        }
        
        document.getElementById('keterangan_edit').value = data.keterangan || ''; 
        document.getElementById('jenis_kelamin_edit').value = data.jenis_kelamin || 'L'; 
        document.getElementById('disabilitas_edit').value = data.disabilitas || 'Non Disabilitas'; 
        document.getElementById('usia_edit').value = data.usia || '21-30'; 
        tamuModal.show(); 
    }
    function saveTamu() { const formData = new FormData(document.getElementById('formTamu')); formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>'); fetch('<?= site_url('admin/data-tamu/update') ?>', { method: 'POST', body: formData }).then(r => r.json()).then(d => { if(d.success) { location.reload(); } else { Swal.fire({ title: 'Gagal!', text: d.message, icon: 'error', confirmButtonColor: '#4f46e5' }); } }); }
    function showFoto(url) { Swal.fire({ imageUrl: url, imageAlt: 'Selfie Tamu', showConfirmButton: false, customClass: { image: 'rounded-5 border-white border-5 shadow-2xl' } }); }
    function updateStatus(id, status) { fetch('<?= site_url('admin/data-tamu/update-status') ?>', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: `id=${id}&status=${status}&<?= csrf_token() ?>=<?= csrf_hash() ?>` }).then(r => r.json()).then(d => { if(d.success) location.reload(); }); }
    function deleteTamu(id) { Swal.fire({ title: 'Hapus data?', text: 'Proses ini tidak dapat dibatalkan', icon: 'warning', showCancelButton: true, confirmButtonColor: '#4f46e5', cancelButtonColor: '#f43f5e', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal' }).then((res) => { if(res.isConfirmed) fetch('<?= site_url('admin/data-tamu/delete') ?>', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: `id=${id}&<?= csrf_token() ?>=<?= csrf_hash() ?>` }).then(r => r.json()).then(d => { if(d.success) { document.getElementById('row-'+id).remove(); Swal.fire({ title: 'Terhapus!', icon: 'success', toast: true, position: 'top-end', showConfirmButton: false, timer: 1500 }); } }); }); }
</script>

<style>
    .transition-hover { transition: 0.2s; }
    .transition-hover:hover { background: #f8fafc !important; transform: scale(1.1); }
    .btn-modern:hover { transform: scale(1.02); }
</style>

<?= $this->include('admin/layout/footer') ?>

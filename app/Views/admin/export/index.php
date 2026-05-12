<?= $this->include('admin/layout/header') ?>

<!-- Tom Select Assets -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<!-- Custom Header with Gradient -->
<div class="row mb-5">
    <div class="col-12">
        <div class="modern-card p-0 border-0 shadow-lg overflow-hidden position-relative" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); min-height: 160px;">
            <div class="p-4 p-md-5 position-relative" style="z-index: 3;">
                <div class="rounded-pill px-3 py-1 bg-white bg-opacity-20 d-inline-block small fw-bold text-white mb-3" style="backdrop-filter: blur(5px);">
                    <i class="bi bi-printer-fill me-1"></i> Dokumentasi & Arsip
                </div>
                <h2 class="fw-800 text-white m-0">Pusat Cetak Laporan</h2>
                <p class="text-white text-opacity-75 small m-0">Generate laporan kunjungan fisik yang rapi dan profesional.</p>
            </div>
            <i class="bi bi-file-earmark-pdf position-absolute text-white opacity-10" style="right: 30px; bottom: -10px; font-size: 8rem;"></i>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="row g-4">
            <!-- Instructions (Left) -->
            <div class="col-md-4">
                <div class="modern-card p-4 bg-white border-0 shadow-sm h-100 border-top border-primary border-5">
                    <h6 class="fw-800 text-dark mb-4 small text-uppercase tracking-wider">Panduan Cetak</h6>
                    
                    <div class="d-flex gap-3 mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px; height:32px;">1</div>
                        <div>
                            <p class="small fw-bold m-0">Tentukan Rentang Waktu</p>
                            <p class="extra-small text-muted m-0">Pilih tanggal awal dan akhir laporan yang ingin dicetak.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px; height:32px;">2</div>
                        <div>
                            <p class="small fw-bold m-0">Atur Filter Data</p>
                            <p class="extra-small text-muted m-0">Saring berdasarkan keperluan, jenis kelamin, usia, disabilitas, atau status.</p>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px; height:32px;">3</div>
                        <div>
                            <p class="small fw-bold m-0">Pratinjau Dokumen</p>
                            <p class="extra-small text-muted m-0">Sistem akan membuka tab baru dengan format kertas resmi kantor.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width:32px; height:32px;">4</div>
                        <div>
                            <p class="small fw-bold m-0">Cetak & Hubungkan</p>
                            <p class="extra-small text-muted m-0">Gunakan pintasan Ctrl+P untuk langsung mencetak ke perangkat Printer.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Card (Right) -->
            <div class="col-md-8">
                <div class="modern-card p-4 p-md-5 bg-white border-0 shadow-sm h-100 border-top border-primary border-5">
                    <h6 class="fw-800 text-dark mb-4 small text-uppercase tracking-wider text-center text-md-start">Formulir Pencetak</h6>
                    
                    <form action="<?= site_url('admin/export/print') ?>" method="GET" target="_blank">
                        <!-- Pencarian -->
                        <div class="mb-4">
                            <label class="form-label small fw-800 text-muted">Cari Nama Karyawan (yang dituju)</label>
                            <select name="search" id="search_pegawai" class="rounded-4">
                                <option value="">Semua Karyawan (Tanpa Filter Nama)</option>
                                <?php foreach($pegawaiList as $p): ?>
                                    <option value="<?= esc($p['nama']) ?>" <?= ($search ?? '') == $p['nama'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="form-label small fw-800 text-muted">Tanggal Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-4 ps-3"><i class="bi bi-calendar-event text-primary"></i></span>
                                    <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control py-3 bg-light border-0 rounded-end-4" value="<?= $tgl_mulai ?>" style="height: 55px;">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label small fw-800 text-muted">Tanggal Akhir</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 rounded-start-4 ps-3"><i class="bi bi-calendar-check text-primary"></i></span>
                                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control py-3 bg-light border-0 rounded-end-4" value="<?= $tgl_akhir ?>" style="height: 55px;">
                                </div>
                            </div>
                        </div>

                        <!-- Filter Tambahan -->
                        <div class="p-4 rounded-4 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <h6 class="fw-800 mb-3 small text-primary text-uppercase tracking-wider"><i class="bi bi-funnel-fill me-1"></i> Filter Data</h6>
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <label class="form-label extra-small fw-bold text-muted">Keperluan</label>
                                    <select name="keperluan" class="form-select bg-white border-0 shadow-sm">
                                        <option value="">Semua Keperluan</option>
                                        <option value="Layanan AHU">Layanan AHU</option>
                                        <option value="Layanan KI">Layanan KI</option>
                                        <option value="Layanan Peraturan Perundangan-undangan">Layanan Peraturan Perundangan-undangan</option>
                                        <option value="Layanan Umum">Layanan Umum</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label extra-small fw-bold text-muted">Status</label>
                                    <select name="status" class="form-select bg-white border-0 shadow-sm">
                                        <option value="">Semua Status</option>
                                        <option value="menunggu">Menunggu</option>
                                        <option value="berkunjung">Berkunjung</option>
                                        <option value="selesai">Selesai</option>
                                        <option value="dibatalkan">Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label extra-small fw-bold text-muted">Tahun</label>
                                    <select name="tahun" id="tahunFilter" class="form-select bg-white border-0 shadow-sm">
                                        <option value="">Pilih Tahun</option>
                                        <?php foreach($years as $y): ?>
                                            <option value="<?= $y ?>"><?= $y ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label extra-small fw-bold text-muted">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select bg-white border-0 shadow-sm">
                                        <option value="">Semua</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label extra-small fw-bold text-muted">Disabilitas</label>
                                    <select name="disabilitas" class="form-select bg-white border-0 shadow-sm">
                                        <option value="">Semua</option>
                                        <option value="Non Disabilitas">Non Disabilitas</option>
                                        <option value="Disabilitas">Disabilitas</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label extra-small fw-bold text-muted">Usia</label>
                                    <select name="usia" class="form-select bg-white border-0 shadow-sm">
                                        <option value="">Semua</option>
                                        <option value="15-20">15-20</option>
                                        <option value="21-30">21-30</option>
                                        <option value="31-40">31-40</option>
                                        <option value="41-50">41-50</option>
                                        <option value="50+">50+</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-3 bg-light rounded-4 mb-4 border-start border-primary border-3">
                            <p class="extra-small text-muted m-0 fw-500">
                                <span class="fw-800 text-primary">Penting:</span> Pasikan Printer Anda sudah terhubung dan ukuran kertas disetel ke A4 atau F4 untuk hasil cetak laporan terbaik.
                            </p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <button type="submit" name="format" value="print" class="btn-modern w-100 py-3 shadow fs-6 fw-800 transition-hover">
                                    <i class="bi bi-printer-fill me-2"></i> Print View
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="format" value="pdf" class="btn btn-danger w-100 py-3 shadow fs-6 fw-800 transition-hover rounded-4 border-0" style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);">
                                    <i class="bi bi-file-earmark-pdf-fill me-2"></i> Export PDF
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="format" value="excel" class="btn btn-success w-100 py-3 shadow fs-6 fw-800 transition-hover rounded-4 border-0" style="background: linear-gradient(135deg, #10b981 0%, #047857 100%);">
                                    <i class="bi bi-file-earmark-excel-fill me-2"></i> Export Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover { transition: 0.3s; }
    .transition-hover:hover { transform: scale(1.02); }
    .input-group-text { font-size: 1.1rem; }
    /* Tom Select Styling */
    .ts-control { border: none !important; padding: 15px 20px !important; border-radius: 16px !important; background-color: #f8fafc !important; font-weight: 600 !important; color: #334155 !important; min-height: 55px !important; }
    .ts-wrapper.single .ts-control { background-image: none !important; }
    .ts-wrapper.single .ts-control::after { content: "\F229"; font-family: "bootstrap-icons"; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #6366f1; font-weight: bold; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Inisialisasi Tom Select untuk Nama Karyawan
        new TomSelect("#search_pegawai", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    });

    document.getElementById('tahunFilter').addEventListener('change', function() {
        const year = this.value;
        if (year) {
            document.getElementById('tgl_mulai').value = `${year}-01-01`;
            document.getElementById('tgl_akhir').value = `${year}-12-31`;
        }
    });
</script>

<?= $this->include('admin/layout/footer') ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil - E-Tamu</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/modern.css') ?>" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fdfdff; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .success-card { max-width: 450px; width: 100%; }
        .antrian-number { font-size: 6rem; line-height: 1; margin-bottom: 1.5rem; background: var(--grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body>
    <div class="bg-animate"></div>
    <div class="success-card text-center">
        <div class="modern-card p-5 bg-white">
            <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-4" style="width:80px; height:80px;">
                <i class="bi bi-check-lg fs-1"></i>
            </div>
            <h3 class="fw-800 mb-2">Pendaftaran Berhasil!</h3>
            <p class="text-muted mb-4 small">Nomor antrian Anda telah diterbitkan.</p>
            
            <div class="antrian-number fw-800"><?= $tamu['no_antrian'] ?></div>
            
            <div class="text-start mb-4 p-4 rounded-4 bg-light border border-white">
                <div class="mb-3">
                    <small class="text-muted d-block uppercase tracking-wider" style="font-size:0.6rem; font-weight:700;">Nama Lengkap</small>
                    <div class="fw-bold fs-5 text-dark"><?= esc($tamu['nama']) ?></div>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block uppercase tracking-wider" style="font-size:0.6rem; font-weight:700;">Keperluan Kunjungan</small>
                    <div class="fw-bold text-dark mb-1"><?= esc($tamu['keperluan']) ?></div>
                    <div class="small text-muted italic">"<?= esc($tamu['keterangan']) ?>"</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block uppercase tracking-wider" style="font-size:0.6rem; font-weight:700;">Orang yang Dituju</small>
                    <div class="fw-bold text-dark"><?= esc($tamu['tujuan_orang'] ?? '-') ?></div>
                </div>
                <hr class="my-3 opacity-50">
                <div class="row g-2">
                    <div class="col-4">
                        <small class="text-muted d-block uppercase" style="font-size:0.55rem; font-weight:700;">Gender</small>
                        <div class="fw-bold text-dark small"><?= $tamu['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></div>
                    </div>
                    <div class="col-4 border-start ps-3">
                        <small class="text-muted d-block uppercase" style="font-size:0.55rem; font-weight:700;">Tipe</small>
                        <div class="fw-bold text-dark small"><?= esc($tamu['disabilitas']) ?></div>
                    </div>
                    <div class="col-4 border-start ps-3">
                        <small class="text-muted d-block uppercase" style="font-size:0.55rem; font-weight:700;">Usia</small>
                        <div class="fw-bold text-dark small"><?= esc($tamu['usia']) ?> Thn</div>
                    </div>
                </div>
            </div>
            
            <a href="<?= site_url('/') ?>" class="btn-modern w-100 py-3 text-decoration-none d-block">Kembali</a>
            <p class="mt-4 extra-small text-muted">Mohon tunjukkan nomor antrian ini kepada petugas.</p>
        </div>
    </div>
</body>
</html>

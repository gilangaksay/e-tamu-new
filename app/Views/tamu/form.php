<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $s['nama_instansi'] ?> - Digital Guest Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/modern.css') ?>" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', Times, serif; background: url('<?= base_url('assets/img/gedung.png') ?>') center/cover no-repeat fixed; min-height: 100vh; }
        .hero-section { position: relative; z-index: 2; padding: 60px 0 100px; color: white; background: rgba(15, 23, 42, 0.3); backdrop-filter: blur(15px); border-bottom: 1px solid rgba(255,255,255,0.1); }
        .hero-content { position: relative; z-index: 2; }
        .form-container { margin-top: -60px; position: relative; z-index: 10; padding-bottom: 50px; }
        .logo-img { width: 80px; height: 80px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); margin-bottom: 1.5rem; background: white; padding: 10px; object-fit: contain; }
        .modern-card { border-radius: 32px; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.08); }
        .form-label { font-weight: 700; color: #475569; margin-bottom: 0.5rem; font-size: 0.85rem; }
        .form-control, .form-select { background: #f1f5f9; border: 2px solid transparent; padding: 14px 20px; border-radius: 16px; font-weight: 500; }
        .form-control:focus { border-color: var(--primary); background: #fff; box-shadow: 0 10px 20px rgba(99,102,241,0.05); }
        .form-control.is-invalid { border-color: #ef4444; background: #fef2f2; }
        .form-control.is-invalid:focus { box-shadow: 0 10px 20px rgba(239, 68, 68, 0.05); }
        .camera-trigger { border: 2px dashed #cbd5e1; background: #f8fafc; border-radius: 24px; padding: 0; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); min-height: 180px; cursor: pointer; position: relative; overflow: hidden; }
        .camera-trigger:hover { border-color: var(--primary); background: white; }
        .preview-box { width: 100%; border-radius: 20px; border: 4px solid #fff; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        #video { width: 100%; border-radius: 24px; background: #000; transform: scaleX(-1); }
        .btn-capture { width: 70px; height: 70px; border-radius: 50%; background: #fff; border: 6px solid rgba(0,0,0,0.1); position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); box-shadow: 0 0 0 4px #fff; }
    </style>
</head>
<body>
    <div class="hero-section text-center">
        <div class="hero-content container">
            <img src="<?= base_url('assets/img/' . $s['logo']) ?>" alt="Logo" class="logo-img">
            <h1 class="display-5 fw-800 mb-2"><?= $s['nama_instansi'] ?></h1>
            <p class="opacity-75 lead"><?= $s['pesan_sambutan'] ?></p>
        </div>
    </div>

    <div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="modern-card p-4 p-md-5 bg-white mb-4">
                    <form action="<?= site_url('tamu/submit') ?>" method="POST" id="guestForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="foto" id="foto_data">

                        <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mb-5 text-center">
                            <h5 class="fw-800 mb-1">Informasi Kunjungan</h5>
                            <p class="text-muted small">Silakan lengkapi identitas Anda di bawah ini.</p>
                        </div>

                        <div class="space-y-4">
                            <div class="mb-4">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama sesuai KTP" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nomor Identitas (NIK/KTP)</label>
                                <input type="text" name="no_identitas" id="no_identitas" class="form-control" placeholder="16 Digit NIK" minlength="16" maxlength="16" pattern="\d{16}" title="NIK harus berjumlah 16 digit angka" oninput="validateNIK(this)" required>
                                <div id="nik-error" class="text-danger extra-small mt-2 fw-bold" style="display:none;">
                                    <i class="bi bi-exclamation-circle-fill me-1"></i> NIK harus berjumlah 16 digit angka
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nomor HP / WhatsApp</label>
                                <input type="tel" name="no_telp" class="form-control" placeholder="Contoh: 081234567890" required>
                            </div>

                            <!-- Kategori Section -->
                            <div class="p-4 rounded-4 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h6 class="fw-800 mb-3 small text-primary text-uppercase tracking-wider">Kategori Pengunjung</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label extra-small">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-select bg-white border-0 shadow-sm" required>
                                            <option value="" disabled selected>Pilih...</option>
                                            <option value="L">Laki-laki (L)</option>
                                            <option value="P">Perempuan (P)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label extra-small">Tipe Disabilitas</label>
                                        <select name="disabilitas" class="form-select bg-white border-0 shadow-sm" required>
                                            <option value="Non Disabilitas">Non Disabilitas</option>
                                            <option value="Disabilitas">Disabilitas</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label extra-small">Usia</label>
                                        <select name="usia" class="form-select bg-white border-0 shadow-sm" required>
                                            <option value="" disabled selected>Pilih...</option>
                                            <option value="15-20">15-20</option>
                                            <option value="21-30">21-30</option>
                                            <option value="31-40">31-40</option>
                                            <option value="41-50">41-50</option>
                                            <option value="50+">50+</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Asal Instansi / Organisasi</label>
                                <input type="text" name="instansi" class="form-control" placeholder="Nama kantor atau pribadi">
                            </div>

                             <div class="mb-4">
                                <label class="form-label">Apa Keperluan Anda?</label>
                                <select name="keperluan" class="form-select" required>
                                    <option value="" disabled selected>Pilih salah satu...</option>
                                    <option value="Layanan AHU">Layanan AHU</option>
                                    <option value="Layanan KI">Layanan KI</option>
                                    <option value="Layanan Peraturan Perundangan-undangan">Layanan Peraturan Perundangan-undangan</option>
                                    <option value="Layanan Umum">Layanan Umum</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Alasan Keperluan</label>
                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Jelaskan secara singkat alasan kunjungan Anda..." required></textarea>
                            </div>

                            <!-- Integrated Selfie Section -->
                            <div class="pt-2 text-center">
                                <label class="form-label d-block mb-1">Verifikasi Wajah (Selfie)</label>
                                
                                <!-- Alert: Foto Terambil (Now below the label) -->
                                <div id="successBadge" style="display:none" class="mb-3">
                                    <span class="badge bg-success rounded-pill px-3 py-2 fw-bold" style="font-size:0.65rem">
                                        <i class="bi bi-check-circle-fill me-1"></i> Foto Terambil
                                    </span>
                                </div>
                                
                                <div id="camTrigger" class="camera-trigger d-flex flex-column align-items-center justify-content-center" onclick="openCamera()">
                                    <!-- Dynamic Content -->
                                    <div id="initialContent">
                                        <div class="mb-3"><i class="bi bi-camera-fill fs-1 text-primary opacity-50"></i></div>
                                        <h6 class="fw-800 text-dark mb-1">Ambil Foto Selfie</h6>
                                        <p class="extra-small text-muted m-0">Pastikan wajah terlihat jelas</p>
                                    </div>
                                    
                                    <div id="resultContent" style="display:none" class="w-100 h-100">
                                        <img id="previewImg" class="preview-box">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div id="retakeContainer" style="display:none" class="mb-3 pt-3">
                                    <button type="button" class="btn btn-outline-primary w-100 py-3 text-uppercase fw-800 tracking-wider" onclick="openCamera()">
                                        <i class="bi bi-arrow-clockwise me-2"></i> Ambil Foto Ulang
                                    </button>
                                </div>
                                <button type="submit" class="btn-modern w-100 py-3 text-uppercase fw-800 tracking-wider shadow-lg">Konfirmasi Kedatangan</button>
                                

                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="text-center text-white-50 extra-small">
                    © <?= date('Y') ?> <?= $s['nama_instansi'] ?>. <?= $s['alamat'] ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Camera -->
    <div class="modal fade" id="cameraModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-5 overflow-hidden shadow-2xl">
                <div class="modal-body p-0 position-relative bg-black" style="min-height: 400px;">
                    <video id="video" autoplay playsinline class="w-100"></video>
                    <div class="btn-capture" onclick="capture()"></div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow" data-bs-dismiss="modal" onclick="stopCamera()"></button>
                </div>
                <div class="p-4 text-center bg-white">
                    <h6 class="fw-800 m-0 text-dark">Posisikan Wajah</h6>
                    <small class="text-muted">Klik tombol putih untuk mengambil gambar</small>
                </div>
            </div>
        </div>
    </div>

    <canvas id="canvas" style="display:none;"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let modal;
        let stream;
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const preview = document.getElementById('previewImg');
        const trigger = document.getElementById('camTrigger');
        const retakeBtn = document.getElementById('retakeContainer');
        const successBadge = document.getElementById('successBadge');
        const fotoInput = document.getElementById('foto_data');
        
        const initialContent = document.getElementById('initialContent');
        const resultContent = document.getElementById('resultContent');

        document.addEventListener('DOMContentLoaded', () => {
            modal = new bootstrap.Modal(document.getElementById('cameraModal'));
        });

        function validateNIK(input) {
            const errorDiv = document.getElementById('nik-error');
            // Hanya izinkan angka
            input.value = input.value.replace(/[^0-9]/g, '');
            
            if (input.value.length > 0 && input.value.length < 16) {
                errorDiv.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorDiv.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

        function openCamera() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } })
                .then(s => {
                    stream = s;
                    video.srcObject = s;
                    modal.show();
                })
                .catch(err => alert("Harap izinkan akses kamera di pengaturan browser Anda."));
        }

        function capture() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const data = canvas.toDataURL('image/jpeg');
            fotoInput.value = data;
            preview.src = data;
            
            // Switch orientation
            initialContent.style.display = 'none';
            resultContent.style.display = 'block';
            successBadge.style.display = 'block'; // Show under the label
            retakeBtn.style.display = 'block'; 
            
            stopCamera();
            modal.hide();
        }

        function stopCamera() {
            if (stream) { stream.getTracks().forEach(track => track.stop()); }
        }

        document.getElementById('guestForm').onsubmit = function() {
            const nikInput = document.getElementById('no_identitas');
            if(nikInput.value.length < 16) {
                alert("NIK harus berjumlah 16 digit angka.");
                nikInput.focus();
                return false;
            }
            if(!fotoInput.value) { alert("Harap ambil foto selfie terlebih dahulu."); return false; }
        };
    </script>
</body>
</html>

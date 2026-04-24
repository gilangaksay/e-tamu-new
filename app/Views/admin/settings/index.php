<?= $this->include('admin/layout/header') ?>

<div class="row mb-5">
    <div class="col-12">
        <div class="modern-card p-0 border-0 shadow-lg overflow-hidden position-relative" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); min-height: 160px;">
            <div class="p-4 p-md-5 position-relative" style="z-index: 3;">
                <div class="rounded-pill px-3 py-1 bg-white bg-opacity-20 d-inline-block small fw-bold text-white mb-3" style="backdrop-filter: blur(5px);">
                    <i class="bi bi-gear-fill me-1"></i> Konfigurasi Sistem
                </div>
                <h2 class="fw-800 text-white m-0">Pengaturan Instansi</h2>
                <p class="text-white text-opacity-75 small m-0">Kelola identitas visual dan informasi publik E-TAMU.</p>
            </div>
            <i class="bi bi-sliders position-absolute text-white opacity-10" style="right: 30px; bottom: -10px; font-size: 8rem;"></i>
        </div>
    </div>
</div>

<form action="<?= site_url('admin/settings/update') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row g-4">
        <!-- Brand & Identity (Left) -->
        <div class="col-lg-4">
            <div class="modern-card p-4 bg-white border-0 shadow-sm h-100 text-center border-top border-primary border-5">
                <h6 class="fw-800 text-dark mb-4 text-start small text-uppercase tracking-wider">Logo Instansi</h6>
                
                <div class="position-relative d-inline-block mb-4 mt-2">
                    <div class="rounded-5 border border-5 border-light shadow-sm overflow-hidden bg-white p-3 d-flex align-items-center justify-content-center" style="width: 180px; height: 180px;">
                        <img id="logoPreview" src="<?= base_url('assets/img/' . $s['logo']) ?>" class="w-100 h-100 object-fit-contain">
                    </div>
                    <label for="logoUp" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg border border-white border-3 transition-hover" style="width:45px; height:45px; cursor:pointer;">
                        <i class="bi bi-camera-fill fs-5"></i>
                    </label>
                    <input type="file" name="logo_file" id="logoUp" style="display:none" onchange="previewImage(this)">
                </div>
                
                <div class="p-3 bg-light rounded-4 text-start">
                    <p class="extra-small text-muted mb-0 fw-bold"><i class="bi bi-info-circle me-1"></i> Rekomendasi:</p>
                    <p class="extra-small text-muted m-0">Gunakan file PNG transparan dengan resolusi minimal 512x512 px untuk hasil terbaik.</p>
                </div>
            </div>
        </div>

        <!-- Detail Information (Right) -->
        <div class="col-lg-8">
            <div class="modern-card p-4 p-md-5 bg-white border-0 shadow-sm h-100 border-top border-primary border-5">
                <h6 class="fw-800 text-dark mb-4 small text-uppercase tracking-wider">Informasi Publik</h6>
                
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-800 text-muted">Nama Instansi / Perusahaan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4 ps-3"><i class="bi bi-building text-primary"></i></span>
                            <input type="text" name="nama_instansi" class="form-control rounded-end-4 py-3 bg-light border-0" value="<?= esc($s['nama_instansi']) ?>" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-800 text-muted">Motto / Pesan Selamat Datang</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4 ps-3"><i class="bi bi-chat-heart text-primary"></i></span>
                            <input type="text" name="pesan_sambutan" class="form-control rounded-end-4 py-3 bg-light border-0" value="<?= esc($s['pesan_sambutan']) ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-800 text-muted">Nomor Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4 ps-3"><i class="bi bi-telephone text-primary"></i></span>
                            <input type="text" name="telepon" class="form-control rounded-end-4 py-3 bg-light border-0" value="<?= esc($s['telepon'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-800 text-muted">Email Kantor</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4 ps-3"><i class="bi bi-envelope text-primary"></i></span>
                            <input type="email" name="email" class="form-control rounded-end-4 py-3 bg-light border-0" value="<?= esc($s['email'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-800 text-muted">Website Resmi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4 ps-3"><i class="bi bi-globe text-primary"></i></span>
                            <input type="text" name="website" class="form-control rounded-end-4 py-3 bg-light border-0" value="<?= esc($s['website'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-800 text-muted">Alamat Lokasi Kantor</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 rounded-start-4 ps-3 align-items-start pt-3"><i class="bi bi-geo-alt text-primary"></i></span>
                            <textarea name="alamat" class="form-control rounded-end-4 py-3 bg-light border-0" rows="3" required><?= esc($s['alamat']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" class="btn-modern w-100 py-3 shadow-lg fs-5 fw-800 transition-hover">
                            <i class="bi bi-check2-circle me-2"></i>Simpan Seluruh Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .transition-hover { transition: 0.3s; }
    .transition-hover:hover { transform: scale(1.02); }
    .input-group-text { font-size: 1.2rem; }
</style>

<?php if(session()->getFlashdata('success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
    });
</script>
<?php endif; ?>

<?= $this->include('admin/layout/footer') ?>

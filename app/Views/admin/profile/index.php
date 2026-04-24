<?= $this->include('admin/layout/header') ?>

<div class="row g-4">
    <!-- Left: Current Profile -->
    <div class="col-lg-5">
        <div class="modern-card p-4 bg-white border-0 h-100">
            <h6 class="fw-bold mb-4">Profil Saya</h6>
            <div class="text-center mb-4">
                <div class="position-relative d-inline-block">
                    <img src="<?= $me['foto'] ? base_url('uploads/admin/'.$me['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($me['nama_lengkap']).'&size=128&background=random' ?>" class="rounded-circle border border-5 border-white shadow" style="width:120px; height:120px; object-fit:cover;">
                    <label for="fotoInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width:35px; height:35px; cursor:pointer; border: 2px solid white;">
                        <i class="bi bi-camera-fill small"></i>
                    </label>
                </div>
                <h5 class="fw-bold mt-3 mb-0"><?= esc($me['nama_lengkap']) ?></h5>
                <p class="text-muted small"><?= esc($me['username']) ?> • <?= $me['role'] == 'admin' ? 'Super Admin' : 'Petugas Layanan' ?></p>
            </div>

            <form action="<?= site_url('admin/profile/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="file" name="foto" id="fotoInput" style="display:none" onchange="this.form.submit()">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= esc($me['nama_lengkap']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= esc($me['username']) ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Ganti Password (Kosongkan jika tidak ganti)</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••">
                </div>
                <button type="submit" class="btn-modern w-100 py-3">Update Profil Saya</button>
            </form>
        </div>
    </div>

    <?php if(session()->get('admin_role') == 'admin'): ?>
    <!-- Right: Admin List & Add New -->
    <div class="col-lg-7">
        <div class="modern-card p-4 bg-white border-0 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold m-0">Daftar Administrator</h6>
                <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalAddAdmin"><i class="bi bi-plus-lg me-1"></i> Tambah Admin</button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <tbody>
                        <?php foreach($admins as $a): ?>
                        <tr>
                            <td style="width:50px;">
                                <img src="<?= $a['foto'] ? base_url('uploads/admin/'.$a['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($a['nama_lengkap']).'&size=40&background=random' ?>" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
                            </td>
                            <td>
                                <div class="fw-bold small"><?= esc($a['nama_lengkap']) ?></div>
                                <div class="extra-small text-muted">@<?= esc($a['username']) ?> • <span class="badge <?= $a['role'] == 'admin' ? 'bg-primary' : 'bg-info' ?> bg-opacity-10 <?= $a['role'] == 'admin' ? 'text-primary' : 'text-info' ?> border-0 fw-bold" style="font-size:0.55rem;"><?= strtoupper($a['role'] ?? 'admin') ?></span></div>
                            </td>
                            <td class="text-end">
                                <?php if($a['id'] != session()->get('admin_id')): ?>
                                    <a href="<?= site_url('admin/profile/delete/'.$a['id']) ?>" class="btn btn-light btn-sm text-danger rounded-circle" onclick="return confirm('Hapus admin ini?')"><i class="bi bi-trash"></i></a>
                                <?php else: ?>
                                    <span class="badge bg-light text-primary rounded-pill small">Anda</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Add Admin -->
<div class="modal fade" id="modalAddAdmin" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h6 class="fw-bold m-0 fs-5">Tambah Administrator Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('admin/profile/create') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Initial Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role Access</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Administrator (Full Access)</option>
                            <option value="petugas">Petugas Layanan (Limited)</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Foto Profil (Optional)</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                </div>
                <div class="p-4 pt-0">
                    <button type="submit" class="btn-modern w-100 py-3">Daftarkan Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?= session()->getFlashdata('success') ?>', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
    });
</script>
<?php endif; ?>

<?= $this->include('admin/layout/footer') ?>

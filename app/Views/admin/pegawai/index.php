<?= $this->include('admin/layout/header') ?>

<div class="row mb-5 mt-2">
    <div class="col-12">
        <div class="modern-card p-4 bg-white border-0 shadow-sm border-start border-primary border-5 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-800 mb-1 text-dark">Manajemen Karyawan</h4>
                <p class="text-muted small m-0">Kelola data karyawan dan status keaktifan mereka dalam sistem.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2 shadow-sm fw-800" onclick="addPegawai()">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Karyawan</span>
            </button>
        </div>
    </div>
</div>

    <div class="modern-card bg-white border-0 shadow-sm overflow-hidden mb-5">
        <div class="p-4 bg-light bg-opacity-50 border-bottom">
            <form action="" method="GET" class="row g-3">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">
                <div class="col-md-5">
                    <label class="form-label extra-small fw-bold text-dark">Cari Nama/Jabatan/Unit</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari..." value="<?= $search ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label extra-small fw-bold text-dark">Filter Status</label>
                    <select name="status" class="form-select form-select-sm rounded-3">
                        <option value="">Semua Status</option>
                        <option value="1" <?= ($status ?? '') == '1' ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= ($status ?? '') == '0' ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fw-800">Terapkan Filter</button>
                    <a href="<?= site_url('admin/pegawai') ?>" class="btn btn-light btn-sm py-2 px-3 fw-800 border" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-800 text-muted" style="font-size: 0.65rem; width: 50px;">No</th>
                            <th class="py-3 text-uppercase small fw-800 text-muted" style="font-size: 0.65rem;">Nama Karyawan</th>
                            <th class="py-3 text-uppercase small fw-800 text-muted" style="font-size: 0.65rem;">Jabatan</th>
                            <th class="py-3 text-uppercase small fw-800 text-muted" style="font-size: 0.65rem;">Unit Kerja</th>
                            <th class="py-3 text-uppercase small fw-800 text-muted" style="font-size: 0.65rem;">Status</th>
                            <th class="pe-4 py-3 text-end text-uppercase small fw-800 text-muted" style="font-size: 0.65rem;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($pegawaiList)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-person-x fs-1 opacity-25"></i>
                                    <p class="mt-2">Belum ada data karyawan</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php 
                            $no = 1 + ($pager->getCurrentPage() - 1) * ($limit ?? 10);
                            foreach($pegawaiList as $p): 
                        ?>
                        <tr>
                            <td class="ps-4 text-muted fw-bold small"><?= $no++ ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                        <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                    </div>
                                    <div class="fw-bold text-dark"><?= esc($p['nama']) ?></div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark fw-500 rounded-pill px-3"><?= esc($p['jabatan']) ?></span></td>
                            <td><span class="text-secondary small"><?= esc($p['unit_kerja']) ?></span></td>
                            <td>
                                <?php if($p['aktif'] == 1): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill small">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-light btn-sm rounded-3 shadow-sm border" onclick="editPegawai(<?= htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8') ?>)" title="Edit">
                                        <i class="bi bi-pencil text-primary"></i>
                                    </button>
                                    <button class="btn btn-light btn-sm rounded-3 shadow-sm border" onclick="deletePegawai(<?= $p['id'] ?>)" title="Hapus">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end border-top">
            <?= $pager->links('default', 'boxed') ?>
        </div>
    </div>
</div>

<!-- Modal Pegawai -->
<div class="modal fade" id="modalPegawai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-800 m-0" id="modalTitle">Tambah Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formPegawai">
                    <input type="hidden" name="id" id="pegawai_id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" id="pegawai_nama" class="form-control rounded-3" placeholder="Masukkan nama karyawan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Jabatan</label>
                        <input type="text" name="jabatan" id="pegawai_jabatan" class="form-control rounded-3" placeholder="Contoh: Manager IT" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Unit Kerja</label>
                        <input type="text" name="unit_kerja" id="pegawai_unit_kerja" class="form-control rounded-3" placeholder="Contoh: Divisi Teknologi Informasi" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Status</label>
                        <select name="aktif" id="pegawai_aktif" class="form-select rounded-3">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold rounded-3 shadow-sm">
                            <i class="bi bi-save me-2"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let myModal;
    document.addEventListener('DOMContentLoaded', function() { 
        myModal = new bootstrap.Modal(document.getElementById('modalPegawai')); 
        
        // Handle form submission
        document.getElementById('formPegawai').addEventListener('submit', function(e) {
            e.preventDefault();
            savePegawai();
        });
    });

    function addPegawai() { 
        document.getElementById('formPegawai').reset(); 
        document.getElementById('pegawai_id').value = ''; 
        document.getElementById('pegawai_aktif').value = '1';
        document.getElementById('modalTitle').innerText = 'Tambah Karyawan'; 
        myModal.show(); 
    }

    function editPegawai(data) { 
        document.getElementById('formPegawai').reset();
        document.getElementById('pegawai_id').value = data.id; 
        document.getElementById('pegawai_nama').value = data.nama; 
        document.getElementById('pegawai_jabatan').value = data.jabatan; 
        document.getElementById('pegawai_unit_kerja').value = data.unit_kerja; 
        document.getElementById('pegawai_aktif').value = data.aktif;
        document.getElementById('modalTitle').innerText = 'Edit Karyawan'; 
        myModal.show(); 
    }

    function savePegawai() { 
        const id = document.getElementById('pegawai_id').value; 
        const url = id ? '<?= site_url('admin/pegawai/update') ?>' : '<?= site_url('admin/pegawai/store') ?>'; 
        const formData = new FormData(document.getElementById('formPegawai')); 
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>'); 
        
        // Disable button during save
        const btn = document.querySelector('#formPegawai button[type="submit"]');
        const originalBtnText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

        fetch(url, { 
            method: 'POST', 
            body: formData 
        })
        .then(r => r.json())
        .then(d => { 
            if(d.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: d.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: d.message || 'Terjadi kesalahan'
                });
                btn.disabled = false;
                btn.innerHTML = originalBtnText;
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan pada server.' });
            btn.disabled = false;
            btn.innerHTML = originalBtnText;
        }); 
    }

    function deletePegawai(id) { 
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data karyawan akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch('<?= site_url('admin/pegawai/delete') ?>', { 
                    method: 'POST', 
                    body: formData 
                })
                .then(r => r.json())
                .then(d => { 
                    if(d.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Dihapus',
                            text: d.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: d.message });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus data.' });
                }); 
            }
        });
    }
</script>
<?= $this->include('admin/layout/footer') ?>


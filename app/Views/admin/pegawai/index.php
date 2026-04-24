<?= $this->include('admin/layout/header') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="small text-muted m-0">Daftar pegawai kantor</p>
    <button class="btn btn-primary btn-sm" onclick="addPegawai()"><i class="bi bi-plus-lg"></i> Tambah Pegawai</button>
</div>
<div class="card-custom">
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead><tr><th>Nama</th><th>Jabatan</th><th>Unit Kerja</th><th>Aksi</th></tr></thead>
            <tbody><?php foreach($pegawaiList as $p): ?><tr><td><b><?= esc($p['nama']) ?></b></td><td><?= esc($p['jabatan']) ?></td><td><?= esc($p['unit_kerja']) ?></td><td><button class="btn btn-sm btn-info text-white me-1" onclick='editPegawai(<?= json_encode($p) ?>)'><i class="bi bi-pencil"></i></button><button class="btn btn-sm btn-danger" onclick="deletePegawai(<?= $p['id'] ?>)"><i class="bi bi-trash"></i></button></td></tr><?php endforeach; ?></tbody>
        </table>
    </div>
    <div class="mt-3"><?= $pager->links() ?></div>
</div>
<div class="modal fade" id="modalPegawai" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h6 class="modal-title" id="modalTitle">Tambah Pegawai</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><form id="formPegawai"><input type="hidden" name="id" id="pegawaiId"><div class="mb-3"><label class="small fw-bold">Nama</label><input type="text" name="nama" id="nama" class="form-control form-control-sm" required></div><div class="mb-3"><label class="small fw-bold">Jabatan</label><input type="text" name="jabatan" id="jabatan" class="form-control form-control-sm" required></div><div class="mb-3"><label class="small fw-bold">Unit Kerja</label><input type="text" name="unit_kerja" id="unit_kerja" class="form-control form-control-sm" required></div><button type="button" onclick="savePegawai()" class="btn btn-primary btn-sm w-100">Simpan</button></form></div></div></div>
</div>
<script>
    let myModal;
    document.addEventListener('DOMContentLoaded', function() { myModal = new bootstrap.Modal(document.getElementById('modalPegawai')); });
    function addPegawai() { document.getElementById('formPegawai').reset(); document.getElementById('pegawaiId').value = ''; document.getElementById('modalTitle').innerText = 'Tambah Pegawai'; myModal.show(); }
    function editPegawai(data) { document.getElementById('pegawaiId').value = data.id; document.getElementById('nama').value = data.nama; document.getElementById('jabatan').value = data.jabatan; document.getElementById('unit_kerja').value = data.unit_kerja; document.getElementById('modalTitle').innerText = 'Edit Pegawai'; myModal.show(); }
    function savePegawai() { const id = document.getElementById('pegawaiId').value; const url = id ? '<?= site_url('admin/pegawai/update') ?>' : '<?= site_url('admin/pegawai/store') ?>'; const formData = new FormData(document.getElementById('formPegawai')); formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>'); fetch(url, { method: 'POST', body: formData }).then(r => r.json()).then(d => { if(d.success) location.reload(); }); }
    function deletePegawai(id) { if(confirm('Hapus pegawai ini?')) fetch('<?= site_url('admin/pegawai/delete') ?>', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: `id=${id}&<?= csrf_token() ?>=<?= csrf_hash() ?>` }).then(r => r.json()).then(d => { if(d.success) location.reload(); }); }
</script>
<?= $this->include('admin/layout/footer') ?>

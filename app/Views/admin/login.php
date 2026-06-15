<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - E-Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/modern.css') ?>" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', Times, serif; background: url('<?= base_url('assets/img/login.png') ?>') center/cover no-repeat;
             height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; }
        body::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); z-index: 1; }
        .login-card { width: 100%; max-width: 400px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 32px; 
            padding: 3rem; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.3); position: relative; z-index: 2; }
        .form-label { font-weight: 700; color: #475569; font-size: 0.85rem; }
        .form-control { background: #f1f5f9; border: 2px solid transparent; padding: 12px 18px; border-radius: 14px; font-weight: 500; }
        .form-control:focus { border-color: var(--primary); background: white; }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <img src="<?= base_url('assets/img/kemenkum.png') ?>" alt="Logo" class="mb-4" style="width: 80px; height: auto;">
        <h4 class="fw-800 mb-1">Login Admin E-Tamu</h4>
        <p class="text-muted small mb-5">Masuk untuk mengelola data pengunjung</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger py-2 small mb-4 rounded-3"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= site_url('admin/login') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3 text-start">
                <label class="form-label">Nama Pengguna (Username)</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="mb-5 text-start">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-modern w-100 py-3 mb-4 shadow-lg">Masuk Sekarang</button>
        </form>
        
        <a href="<?= site_url('/') ?>" class="text-muted text-decoration-none small fw-bold"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
    </div>
</body>
</html>

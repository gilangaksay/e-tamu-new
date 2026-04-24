<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> - E-Tamu Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/modern.css') ?>" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .sidebar { position: fixed; top: 0; left: 0; width: 280px; height: 100vh; background: #0f172a; z-index: 1000; padding: 2rem 1.5rem; color: white; transition: all 0.3s; }
        .top-header { position: fixed; top: 0; left: 280px; right: 0; height: 70px; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; padding: 0 2rem; z-index: 999; }
        .main-content { margin-left: 280px; margin-top: 70px; padding: 2rem; }
        .nav-link-modern { color: #94a3b8; display: flex; align-items: center; gap: 1rem; padding: 12px 1rem; border-radius: 12px; text-decoration: none; margin-bottom: 0.5rem; font-weight: 500; transition: 0.3s; }
        .nav-link-modern:hover { color: white; background: rgba(255,255,255,0.05); }
        .nav-link-modern.active { background: var(--grad); color: white; box-shadow: 0 10px 20px rgba(99,102,241,0.2); }
        .badge-status { padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        @media (max-width: 991px) { .sidebar { left: -280px; } .top-header, .main-content { left: 0; margin-left: 0; } }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="d-flex align-items-center gap-3 mb-5">
            <div class="bg-primary rounded-3 text-white d-flex align-items-center justify-content-center" style="width:45px; height:45px; background:var(--grad) !important;">
                <i class="bi bi-grid-fill fs-4"></i>
            </div>
            <div>
                <h5 class="m-0 fw-800">E-Tamu</h5>
                <small class="text-white-50">Admin Panel</small>
            </div>
        </div>
        <nav>
            <p class="text-white-50 small fw-bold mb-3 mt-4 px-2 uppercase tracking-wider" style="font-size:0.65rem;">Main Menu</p>
            <a href="<?= site_url('admin/dashboard') ?>" class="nav-link-modern <?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-fill"></i> Ringkasan Utama
            </a>

            <a href="<?= site_url('admin/analitik') ?>" class="nav-link-modern <?= str_contains(uri_string(), 'analitik') ? 'active' : '' ?>">
                <i class="bi bi-cpu"></i> Analitik Pengunjung
            </a>
            <a href="<?= site_url('admin/data-tamu') ?>" class="nav-link-modern <?= str_contains(uri_string(), 'data-tamu') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> Managemen Tamu
            </a>
            <a href="<?= site_url('admin/laporan') ?>" class="nav-link-modern <?= str_contains(uri_string(), 'laporan') ? 'active' : '' ?>">
                <i class="bi bi-bar-chart"></i> Laporan Aktivitas
            </a>

            <?php if(session()->get('admin_role') == 'admin'): ?>
            <a href="<?= site_url('admin/export') ?>" class="nav-link-modern <?= str_contains(uri_string(), 'export') ? 'active' : '' ?>">
                <i class="bi bi-printer"></i> Cetak Laporan
            </a>
            <?php endif; ?>
            
            <a href="<?= site_url('admin/profile') ?>" class="nav-link-modern <?= str_contains(uri_string(), 'profile') ? 'active' : '' ?>">
                <i class="bi bi-person-circle"></i> Manajemen Profil
            </a>

            <?php if(session()->get('admin_role') == 'admin'): ?>
            <a href="<?= site_url('admin/settings') ?>" class="nav-link-modern <?= str_contains(uri_string(), 'settings') ? 'active' : '' ?>">
                <i class="bi bi-gear-fill"></i> Pengaturan Instansi
            </a>
            <?php endif; ?>
            
            <p class="text-white-50 small fw-bold mb-3 mt-5 px-2 uppercase tracking-wider" style="font-size:0.65rem;">Sistem</p>
            <a href="<?= site_url('admin/logout') ?>" class="nav-link-modern text-danger mt-auto">
                <i class="bi bi-power"></i> Log Out
            </a>
        </nav>
    </aside>

    <header class="top-header justify-content-between">
        <h5 class="m-0 fw-700"><?= esc($title ?? 'Dashboard') ?></h5>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-md-block">
                <p class="m-0 small fw-bold"><?= session()->get('admin_nama') ?></p>
                <p class="m-0 text-muted small" style="font-size:0.7rem;"><?= session()->get('admin_role') == 'admin' ? 'Administrator' : 'Petugas Layanan' ?></p>
            </div>
            <div class="rounded-circle border" style="width:40px; height:40px; background: url('<?= session()->get('admin_foto') ? base_url('uploads/admin/'.session()->get('admin_foto')) : 'https://ui-avatars.com/api/?name='.urlencode(session()->get('admin_nama')).'&background=random' ?>') center/cover;"></div>
        </div>
    </header>

    <main class="main-content">

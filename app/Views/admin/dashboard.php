<?= $this->include('admin/layout/header') ?>

<!-- Ultra-Modern Welcome Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="modern-card p-0 border-0 shadow-lg overflow-hidden position-relative" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); min-height: 200px;">
            <div class="p-4 p-md-5 position-relative" style="z-index: 3;">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-pill px-3 py-1 bg-white bg-opacity-20 small fw-bold text-white border border-white border-opacity-25" style="backdrop-filter: blur(5px);">
                        <i class="bi bi-stars me-1 text-warning"></i> Dashboard Aktivitas
                    </div>
                </div>
                <h1 class="display-6 fw-800 text-white mb-2">Halo, <?= explode(' ', session()->get('admin_nama'))[0] ?>! 👋</h1>
                <p class="text-white text-opacity-75 lead mb-0" style="font-size: 1.1rem;">Semua sistem berjalan <span class="badge bg-success bg-opacity-25 text-white border border-white border-opacity-25">Normal</span>. Ada <?= $statusCounts['waiting'] ?> tamu menunggu konfirmasi Anda.</p>
            </div>
            
            <!-- Abstract background shapes -->
            <div class="position-absolute" style="top: -50px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
            <div class="position-absolute" style="bottom: -20px; left: 10%; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius: 50%;"></div>
            <i class="bi bi-activity position-absolute text-white opacity-25" style="right: 30px; bottom: 20px; font-size: 6rem;"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Main Performance Chart -->
    <div class="col-lg-8">
        <div class="modern-card p-4 bg-white border-0 h-100 shadow-sm border-top border-primary border-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-800 m-0 text-dark">Data Pengunjung</h5>
                    <p class="text-muted extra-small m-0">Ringkasan grafik <?= ucfirst($currentRange) ?></p>
                </div>
                <div class="d-flex gap-1 bg-light p-1 rounded-3">
                    <a href="?range=harian" class="btn btn-sm <?= $currentRange == 'harian' ? 'btn-primary shadow-sm' : 'btn-light border-0' ?> fw-bold px-3">Harian</a>
                    <a href="?range=mingguan" class="btn btn-sm <?= $currentRange == 'mingguan' ? 'btn-primary shadow-sm' : 'btn-light border-0' ?> fw-bold px-3">Mingguan</a>
                    <a href="?range=bulanan" class="btn btn-sm <?= $currentRange == 'bulanan' ? 'btn-primary shadow-sm' : 'btn-light border-0' ?> fw-bold px-3">Bulanan</a>
                    <a href="?range=tahunan" class="btn btn-sm <?= $currentRange == 'tahunan' ? 'btn-primary shadow-sm' : 'btn-light border-0' ?> fw-bold px-3">Tahunan</a>
                </div>
            </div>
            <div style="height: 320px;">
                <canvas id="chartKunjungan"></canvas>
            </div>
        </div>
    </div>

    <!-- Status Doughnut & Quick Stats -->
    <div class="col-lg-4">
        <div class="modern-card p-4 bg-white border-0 h-100 shadow-sm border-top border-warning border-5">
            <h5 class="fw-800 mb-4 text-dark text-center">Status Antrian</h5>
            <div style="height: 220px;" class="mb-4">
                <canvas id="chartStatus"></canvas>
            </div>
            <div class="d-grid gap-3">
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 bg-warning rounded-3"><div class="rounded-circle bg-white" style="width:8px; height:8px;"></div></div>
                        <span class="small fw-bold text-muted uppercase">Menunggu</span>
                    </div>
                    <span class="fw-800 h5 mb-0 text-warning"><?= $statusCounts['waiting'] ?></span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 bg-success rounded-3"><div class="rounded-circle bg-white" style="width:8px; height:8px;"></div></div>
                        <span class="small fw-bold text-muted uppercase">Diterima</span>
                    </div>
                    <span class="fw-800 h5 mb-0 text-success"><?= $statusCounts['done'] ?></span>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 bg-danger rounded-3"><div class="rounded-circle bg-white" style="width:8px; height:8px;"></div></div>
                        <span class="small fw-bold text-muted uppercase">Dibatalkan</span>
                    </div>
                    <span class="fw-800 h5 mb-0 text-danger"><?= $statusCounts['cancelled'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Logs with more aesthetic list -->
    <div class="col-lg-12">
        <div class="modern-card p-4 bg-white border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-800 m-0 text-dark">Pendaftaran Terakhir</h5>
                <a href="<?= site_url('admin/data-tamu') ?>" class="small text-primary fw-bold text-decoration-none">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr style="font-size: 0.7rem;" class="text-uppercase text-muted fw-800 tracking-wider">
                            <th class="ps-4 border-0">Profil Pengunjung</th>
                            <th class="border-0">Keperluan</th>
                            <th class="border-0">Waktu</th>
                            <th class="pe-4 border-0 text-end">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(array_slice($tamuTerbaru, 0, 5) as $t): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle border d-flex align-items-center justify-content-center fw-800 text-white" style="width:40px; height:40px; background: linear-gradient(45deg, #4f46e5, #7c3aed); font-size:0.75rem;">
                                        <?= substr($t['nama'], 0, 1) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold small"><?= esc($t['nama']) ?></div>
                                        <div class="extra-small text-muted"><?= esc($t['instansi'] ?? 'Pribadi') ?> &bull; <?= esc($t['no_telp'] ?? '-') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small fw-800 text-dark"><?= esc($t['keperluan']) ?></div>
                                <div class="extra-small text-muted text-truncate" style="max-width:200px;"><?= esc($t['keterangan'] ?? '-') ?></div>
                            </td>
                            <td>
                                <div class="small fw-bold"><i class="bi bi-clock me-1 opacity-50"></i><?= date('H:i', strtotime($t['created_at'])) ?></div>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="<?= site_url('admin/data-tamu') ?>" class="btn btn-light btn-sm rounded-pill px-3 fw-bold" style="font-size:0.7rem;">Kelola</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart: Trend Mingguan
    const ctx = document.getElementById('chartKunjungan').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chartStats['labels']) ?>,
            datasets: [{
                label: 'Tamu',
                data: <?= json_encode($chartStats['data']) ?>,
                borderColor: '#4f46e5',
                borderWidth: 4,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4f46e5',
                pointBorderWidth: 2,
                fill: true,
                backgroundColor: gradient
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f5f9' }, ticks: { font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });

    // Donut Chart: Status Distribution
    new Chart(document.getElementById('chartStatus').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Selesai', 'Dibatalkan'],
            datasets: [{
                data: [<?= $statusCounts['waiting'] ?>, <?= $statusCounts['done'] ?>, <?= $statusCounts['cancelled'] ?>],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 8,
                borderColor: '#fff',
                hoverOffset: 15
            }]
        },
        options: {
            cutout: '80%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
</script>

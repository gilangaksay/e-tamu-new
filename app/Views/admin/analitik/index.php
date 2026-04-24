<?= $this->include('admin/layout/header') ?>

<!-- Aesthetic Header -->
<div class="row mb-5">
    <div class="col-12">
        <div class="modern-card p-0 border-0 shadow-lg overflow-hidden position-relative" style="background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); min-height: 160px;">
            <div class="p-4 p-md-5 position-relative" style="z-index: 3;">
                <div class="rounded-pill px-3 py-1 bg-white bg-opacity-20 d-inline-block small fw-bold text-white mb-3" style="backdrop-filter: blur(5px);">
                    <i class="bi bi-cpu-fill me-1"></i> Data Intelligence
                </div>
                <h2 class="fw-800 text-white m-0">Wawasan Pengunjung</h2>
                <p class="text-white text-opacity-75 small m-0">Analisis pola kunjungan dan distribusi keperluan tamu secara akurat.</p>
            </div>
            <i class="bi bi-pie-chart-fill position-absolute text-white opacity-10" style="right: 30px; bottom: -10px; font-size: 8rem;"></i>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Chart: Monthly Trend -->
    <div class="col-lg-8">
        <div class="modern-card p-4 bg-white border-0 shadow-sm h-100 border-top border-primary border-5">
            <h6 class="fw-800 text-dark mb-4 text-uppercase tracking-wider small">Tren Tamu Tahunan (<?= date('Y') ?>)</h6>
            <div style="height: 350px;">
                <canvas id="chartTahunan"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart: Peak Hours -->
    <div class="col-lg-4">
        <div class="modern-card p-4 bg-white border-0 shadow-sm h-100 border-top border-info border-5">
            <h6 class="fw-800 text-dark mb-4 text-uppercase tracking-wider small">Waktu Teramai</h6>
            <div class="space-y-4">
                <?php 
                    $colors = ['Pagi' => 'bg-primary', 'Siang' => 'bg-warning', 'Sore' => 'bg-danger'];
                    foreach($peakHours as $label => $val): 
                        $short = explode(' ', $label)[0];
                        $percent = array_sum($peakHours) > 0 ? round(($val / array_sum($peakHours)) * 100) : 0;
                ?>
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-end mb-1">
                        <span class="small fw-bold text-dark"><?= $label ?></span>
                        <span class="extra-small fw-800 text-muted"><?= $val ?> Kunjungan</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 10px; background: #f1f5f9;">
                        <div class="progress-bar <?= $colors[$short] ?? 'bg-primary' ?> rounded-pill" style="width: <?= $percent ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="p-3 bg-light rounded-4 mt-5">
                <p class="extra-small text-muted m-0"><i class="bi bi-lightbulb-fill text-warning me-1"></i> <b>Insight:</b> 
                    Waktu tersibuk berada di periode 
                    <?php 
                        arsort($peakHours);
                        echo key($peakHours);
                    ?>.
                </p>
            </div>
        </div>
    </div>

    <!-- Chart: Purposes Distribution -->
    <div class="col-12">
        <div class="modern-card p-5 bg-white border-0 shadow-sm border-top border-purple border-5">
            <div class="row align-items-center">
                <div class="col-md-5 mb-4 mb-md-0">
                    <h5 class="fw-800 mb-3">Kategori Keperluan</h5>
                    <p class="text-muted small">Distribusi alasan pengunjung datang ke kantor. Membantu identifikasi layanan yang paling banyak dicari.</p>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <?php foreach($purposes as $p): ?>
                            <span class="badge bg-light text-dark border p-2 px-3 rounded-pill fw-bold" style="font-size:0.65rem;"><?= $p['keperluan'] ?> (<?= $p['total'] ?>)</span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-7">
                    <div style="height: 300px;">
                        <canvas id="chartKeperluan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Annual Bar Chart
    new Chart(document.getElementById('chartTahunan').getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($monthly['labels']) ?>,
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: <?= json_encode($monthly['data']) ?>,
                backgroundColor: '#2563eb',
                borderRadius: 8,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { borderDash: [5, 5] }, beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });

    // Purposes Radar or Pie Chart
    new Chart(document.getElementById('chartKeperluan').getContext('2d'), {
        type: 'bar',
        data: {
            labels: [<?php foreach($purposes as $p) echo '"'.$p['keperluan'].'",'; ?>],
            datasets: [{
                data: [<?php foreach($purposes as $p) echo $p['total'].','; ?>],
                backgroundColor: ['#6366f1', '#a855f7', '#ec4899', '#f59e0b', '#10b981'],
                borderRadius: 10
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { display: false } }
            }
        }
    });
</script>

<?= $this->include('admin/layout/footer') ?>

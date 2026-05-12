<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan - <?= $s['nama_instansi'] ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; padding: 40px; line-height: 1.4; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 20px; margin-bottom: 30px; position: relative; }
        .header img { position: absolute; left: 0; top: 0; width: 80px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 14px; }
        .title { text-align: center; margin-bottom: 20px; }
        .title h3 { text-decoration: underline; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background: #f0f0f0; text-transform: uppercase; text-align: center; }
        .footer-sign { float: right; width: 250px; text-align: center; margin-top: 50px; }
        .footer-sign p { margin: 0; }
        .space { height: 80px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #333; color: #fff; padding: 15px; text-align: center; margin: -40px -40px 40px;">
        Halaman ini dioptimalkan untuk Pencetakan. Tekan <b>Ctrl + P</b> di keyboard Anda untuk mencetak.
        <button onclick="window.print()" style="margin-left: 20px; cursor: pointer; padding: 5px 15px;">CETAK SEKARANG</button>
    </div>

    <div class="header">
        <img src="<?= base_url('assets/img/' . $s['logo']) ?>" alt="Logo">
        <h2><?= $s['nama_instansi'] ?></h2>
        <p><?= $s['alamat'] ?></p>
        <p>Telepon: <?= $s['telepon'] ?? '-' ?> | Email: <?= $s['email'] ?? '-' ?> | Web: <?= $s['website'] ?? '-' ?></p>
    </div>

    <div class="title">
        <h3>LAPORAN KUNJUNGAN TAMU DIGITAL</h3>
        <p>Periode: <?= date('d/m/Y', strtotime($tgl_mulai)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
        <?php if(!empty($filterLabels)): ?>
        <p style="font-size: 12px; margin-top: 5px;">Filter: <?= implode(' | ', $filterLabels) ?></p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Waktu</th>
                <th width="120">Nama Pengunjung</th>
                <th width="120">Instansi / Alamat</th>
                <th width="120">Tujuan (Karyawan)</th>
                <th>Keperluan / Rincian</th>
                <th width="80">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($laporanTamu)): ?>
                <tr><td colspan="7" style="text-align:center;">Tidak ada data kunjungan pada periode ini.</td></tr>
            <?php endif; ?>
            <?php $no = 1; foreach($laporanTamu as $t): ?>
            <tr>
                <td style="text-align:center;"><?= $no++ ?></td>
                <td><?= date('d/m/y H:i', strtotime($t['created_at'])) ?></td>
                <td><b><?= esc($t['nama']) ?></b><br><small>NIK: <?= esc($t['no_identitas']) ?></small></td>
                <td><?= esc($t['instansi'] ?? '-') ?></td>
                <td><?= esc($t['tujuan_orang'] ?? '-') ?></td>
                <td>
                    <?php if(str_starts_with($t['keperluan'], 'Lainnya: ')): ?>
                        <b>Lainnya</b><br>
                        <i style="color: #4f46e5;"><?= esc(substr($t['keperluan'], 9)) ?></i>
                    <?php else: ?>
                        <b><?= esc($t['keperluan']) ?></b>
                    <?php endif; ?>
                    <br><?= esc($t['keterangan'] ?? '-') ?>
                </td>
                <td style="text-align:center; text-transform:uppercase;"><?= esc($t['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer-sign">
        <p><?= date('d F Y') ?></p>
        <p>Mengetahui,</p>
        <p>Petugas Administrator</p>
        <div class="space"></div>
        <p><b>( ____________________ )</b></p>
        <p>NIP. .........................</p>
    </div>

    <script>
        // Auto open print dialog
        // window.print();
    </script>
</body>
</html>

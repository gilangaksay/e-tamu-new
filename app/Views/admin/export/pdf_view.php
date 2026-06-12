<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan - <?= $s['nama_instansi'] ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; padding: 20px; line-height: 1.2; font-size: 10px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; position: relative; }
        .header img { position: absolute; left: 0; top: 0; width: 60px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 16px; }
        .header p { margin: 2px 0 0; font-size: 10px; }
        .title { text-align: center; margin-bottom: 15px; }
        .title h3 { text-decoration: underline; margin-bottom: 5px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f0f0f0; text-transform: uppercase; text-align: center; font-size: 9px; }
        .footer-sign { float: right; width: 200px; text-align: center; margin-top: 30px; font-size: 10px; }
        .footer-sign p { margin: 0; }
        .space { height: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <?php if(isset($logo_base64)): ?>
            <img src="<?= $logo_base64 ?>" alt="Logo">
        <?php endif; ?>
        <h2><?= $s['nama_instansi'] ?></h2>
        <p><?= $s['alamat'] ?></p>
        <p>Telepon: <?= $s['telepon'] ?? '-' ?> | Email: <?= $s['email'] ?? '-' ?></p>
    </div>

    <div class="title">
        <h3>LAPORAN KUNJUNGAN TAMU DIGITAL</h3>
        <p>Periode: <?= date('d/m/Y', strtotime($tgl_mulai)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
        <?php if(!empty($filterLabels)): ?>
        <p style="font-size: 9px; margin-top: 5px;">Filter: <?= implode(' | ', $filterLabels) ?></p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th width="20">No</th>
                <th width="70">Waktu</th>
                <th width="110">Nama Pengunjung</th>
                <th width="110">Instansi / Alamat</th>
                <th width="100">Tujuan</th>
                <th>Keperluan / Rincian</th>
                <th width="60">Status</th>
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
                <td><b><?= $t['nama'] ?></b><br>NIK: <?= $t['no_identitas'] ?></td>
                <td><?= $t['instansi'] ?? '-' ?></td>
                <td><?= $t['tujuan_orang'] ?? '-' ?></td>
                <td>
                    <?php if(str_starts_with($t['keperluan'], 'Lainnya: ')): ?>
                        <b>Lainnya</b><br>
                        <i style="color: #4f46e5;"><?= esc(substr($t['keperluan'], 9)) ?></i>
                    <?php else: ?>
                        <b><?= $t['keperluan'] ?></b>
                    <?php endif; ?>
                    <br><?= $t['keterangan'] ?? '-' ?>
                </td>
                <td style="text-align:center;"><?= strtoupper($t['status']) ?></td>
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
    </div>
</body>
</html>

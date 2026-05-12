<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .header { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        LAPORAN KUNJUNGAN TAMU DIGITAL<br>
        <?= $s['nama_instansi'] ?><br>
        Periode: <?= date('d/m/Y', strtotime($tgl_mulai)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?>
    </div>

    <?php if(!empty($filterLabels)): ?>
    <p>Filter: <?= implode(' | ', $filterLabels) ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Nama Pengunjung</th>
                <th>No. Identitas (NIK)</th>
                <th>Instansi / Alamat</th>
                <th>Keperluan</th>
                <th>Keterangan</th>
                <th>Orang yang Dituju</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($laporanTamu as $t): ?>
            <tr>
                <td style="text-align:center;"><?= $no++ ?></td>
                <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                <td><?= $t['nama'] ?></td>
                <td>&nbsp;<?= $t['no_identitas'] ?></td> <!-- Space to prevent Excel from scientific notation -->
                <td><?= $t['instansi'] ?? '-' ?></td>
                <td>
                    <?php if(str_starts_with($t['keperluan'], 'Lainnya: ')): ?>
                        Lainnya (<?= esc(substr($t['keperluan'], 9)) ?>)
                    <?php else: ?>
                        <?= $t['keperluan'] ?>
                    <?php endif; ?>
                </td>
                <td><?= $t['keterangan'] ?? '-' ?></td>
                <td><?= $t['tujuan_orang'] ?? '-' ?></td>
                <td><?= strtoupper($t['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php
/**
 * Script untuk memperbaiki database secara otomatis
 * Akses melalui browser: http://localhost/e-tamu/public/fix_db.php
 */

$host = "localhost";
$user = "root";
$pass = "";
$db   = "e_tamu";

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die("<div style='color:red; font-family:\"Times New Roman\", Times, serif; padding:20px; border:1px solid red; border-radius:10px; background:#fff1f1;'>
            <h3>Koneksi Database Gagal!</h3>
            <p>Pesan Error: " . $mysqli->connect_error . "</p>
            <p>Pastikan MySQL di XAMPP sudah menyala dan nama database sudah benar.</p>
         </div>");
}

$queries = [
    // Tambah kolom jika belum ada
    "ALTER TABLE tamu ADD COLUMN IF NOT EXISTS foto VARCHAR(255) DEFAULT NULL AFTER keterangan",
    "ALTER TABLE tamu ADD COLUMN IF NOT EXISTS jenis_kelamin VARCHAR(10) DEFAULT NULL AFTER foto",
    "ALTER TABLE tamu ADD COLUMN IF NOT EXISTS disabilitas VARCHAR(50) DEFAULT NULL AFTER jenis_kelamin",
    "ALTER TABLE tamu ADD COLUMN IF NOT EXISTS usia VARCHAR(10) DEFAULT NULL AFTER disabilitas"
];

echo "<div style='font-family:\"Times New Roman\", Times, serif; padding:20px; max-width:800px; margin:20px auto; border:1px solid #ddd; border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,0.05);'>";
echo "<h2 style='color:#4f46e5;'>Database Fixer</h2>";
echo "<p style='color:#666;'>Mengeksekusi pembaruan tabel tamu...</p><hr style='border:none; border-top:1px solid #eee; margin:20px 0;'>";

$success = true;
foreach ($queries as $q) {
    if ($mysqli->query($q)) {
        echo "<div style='padding:10px; margin-bottom:10px; background:#f0fdf4; border-left:4px solid #16a34a; color:#166534; font-size:14px;'>✓ Berhasil: " . htmlspecialchars($q) . "</div>";
    } else {
        $success = false;
        echo "<div style='padding:10px; margin-bottom:10px; background:#fef2f2; border-left:4px solid #dc2626; color:#991b1b; font-size:14px;'>✗ Gagal: " . htmlspecialchars($mysqli->error) . "</div>";
    }
}

if ($success) {
    echo "<div style='margin-top:20px; padding:15px; background:#4f46e5; color:white; border-radius:8px; text-align:center;'>
            <b>Selesai!</b> Database sekarang sudah lengkap. Silakan coba input data tamu kembali.
            <br><small style='opacity:0.8'>Hapus file fix_db.php ini setelah selesai digunakan.</small>
          </div>";
} else {
    echo "<div style='margin-top:20px; padding:15px; background:#f59e0b; color:white; border-radius:8px; text-align:center;'>
            <b>Peringatan!</b> Beberapa query gagal dieksekusi. Cek pesan error di atas.
          </div>";
}

echo "</div>";

$mysqli->close();

# E-Tamu - Sistem Buku Tamu & Antrean Digital

E-Tamu adalah aplikasi buku tamu digital modern berbasis web yang dibangun dengan framework **CodeIgniter 4**. Aplikasi ini dirancang untuk mempermudah instansi atau perusahaan dalam mengelola data pengunjung, mencatat keperluan kunjungan secara digital, mengelola antrean tamu, serta menyajikan analitik statistik kunjungan secara real-time.

---

## 🚀 Fitur Utama Aplikasi

1. **Registrasi Tamu Mandiri (Visitor Self-Registration)**
   - Formulir input identitas lengkap (Nama, NIK, WhatsApp, Instansi).
   - Verifikasi wajah terintegrasi menggunakan kamera/webcam (Selfie langsung).
   - Validasi ketat nomor identitas (NIK wajib 16 digit angka).
   - Klasifikasi khusus pengunjung (Jenis Kelamin, Disabilitas/Non-disabilitas, Rentang Usia).
   - Pilihan keperluan layanan yang dinamis beserta detail deskripsi alasan kunjungan.

2. **Sistem Antrean Otomatis**
   - Pembuatan nomor antrean otomatis dengan format `A001`, `A002`, dst., berdasarkan hari berjalan.
   - Halaman konfirmasi kedatangan instan setelah registrasi berhasil.

3. **Dashboard Ringkasan Utama & Analitik Visual**
   - Menampilkan total pengunjung dan status kunjungan (*Menunggu*, *Berkunjung*, *Selesai*, *Dibatalkan*).
   - Grafik analitik kunjungan interaktif dengan rentang waktu fleksibel (Harian, Mingguan, Bulanan, Tahunan).
   - Daftar 10 kunjungan terbaru untuk pemantauan cepat.

4. **Manajemen Tamu & Kendali Status**
   - Manajemen data kunjungan tamu di sisi administrator.
   - Perubahan status alur kunjungan secara real-time (*Menunggu* ➔ *Berkunjung* ➔ *Selesai*).

5. **Manajemen Data Karyawan (Pegawai)**
   - Manajemen data staf/karyawan tujuan kunjungan tamu.
   - Fitur pembatasan hak akses (**Role-Based Access Control**):
     - Akun dengan peran `admin` memiliki akses penuh untuk menambah, mengedit, atau menghapus data pegawai.
     - Akun dengan peran `petugas` dibatasi dan menu ini disembunyikan untuk menjaga keamanan data internal.

6. **Laporan Aktivitas & Multi-Filter Pintar**
   - Riwayat data kunjungan lengkap dengan sistem pencarian global.
   - Filter granular: rentang tanggal, status kunjungan, keperluan, jenis kelamin, status disabilitas, kelompok usia, serta pegawai tujuan.

7. **Cetak & Ekspor Laporan**
   - Pencetakan laporan kunjungan instan.
   - Ekspor data laporan ke format **PDF** dan **Excel (Spreadsheet)** untuk pengarsipan.

8. **Pengaturan Profil & Manajemen Akun Admin**
   - Mengubah data diri administrator yang sedang aktif, termasuk foto profil.
   - Manajemen akun admin/petugas baru (khusus peran `admin`).

9. **Pengaturan Instansi Dinamis**
   - Mengubah nama instansi/perusahaan, motto/pesan sambutan, alamat, email, telepon, website, hingga upload logo instansi secara dinamis untuk branding aplikasi.

---

## 📁 Struktur Direktori Proyek

Berikut adalah detail struktur file penting dalam proyek **E-Tamu**:

```text
E-tamu/
├── app/                        # Direktori utama kode aplikasi (MVC)
│   ├── Config/                 # Konfigurasi sistem CodeIgniter
│   │   ├── Database.php        # Konfigurasi koneksi database
│   │   ├── Filters.php         # Registrasi filter/middleware (termasuk AuthFilter)
│   │   └── Routes.php          # Routing URL aplikasi
│   ├── Controllers/            # Pengontrol logika bisnis (Controller)
│   │   ├── Admin.php           # Logika Dashboard Admin & Login/Logout
│   │   ├── AdminProfile.php    # Manajemen profil & akun admin/petugas
│   │   ├── Analitik.php        # Logika visualisasi grafik analitik pengunjung
│   │   ├── BaseController.php  # Controller induk untuk inisialisasi helper/session
│   │   ├── DataTamu.php        # Logika CRUD & kendali status kunjungan tamu
│   │   ├── Export.php          # Logika ekspor cetak, PDF, dan Excel
│   │   ├── Laporan.php         # Logika filter & tabel riwayat Laporan Aktivitas
│   │   ├── Pegawai.php         # Manajemen data karyawan (tujuan tamu)
│   │   ├── Pengaturan.php      # Konfigurasi branding & informasi instansi
│   │   └── Tamu.php            # Logika form registrasi tamu, webcam, & nomor antrean
│   ├── Filters/                # Middleware untuk keamanan request
│   │   └── AuthFilter.php      # Filter autentikasi untuk memproteksi halaman admin
│   ├── Models/                 # Abstraksi database dan query data (Model)
│   │   ├── AdminModel.php      # Model tabel `admin` (autentikasi & kelola admin)
│   │   ├── PegawaiModel.php    # Model tabel `pegawai` (staf instansi)
│   │   └── TamuModel.php       # Model tabel `tamu` (validasi, filter, statistik)
│   └── Views/                  # Template tampilan pengguna (Views)
│       ├── admin/              # Kumpulan view halaman panel admin
│       │   ├── analitik/       # Grafik analitik pengunjung
│       │   ├── export/         # Template cetak laporan
│       │   ├── laporan/        # Tabel laporan aktivitas & formulir filter
│       │   ├── layout/         # Header & Footer (sidebar & navigasi dinamis)
│       │   ├── pegawai/        # CRUD data karyawan
│       │   ├── profile/        # Manajemen akun administrator
│       │   ├── settings/       # Form pengaturan detail instansi & logo
│       │   ├── tamu/           # Detail tamu & kendali status
│       │   ├── dashboard.php   # Tampilan beranda dashboard admin
│       │   └── login.php       # Tampilan halaman login admin
│       └── tamu/               # Kumpulan view halaman pengunjung
│           ├── form.php        # Form pendaftaran tamu & selfie webcam
│           └── konfirmasi.php  # Konfirmasi sukses & cetak nomor antrean
├── public/                     # Direktori web root yang dapat diakses publik
│   ├── assets/                 # Aset statis aplikasi
│   │   ├── css/
│   │   │   └── modern.css      # Gaya visual kustom yang premium & responsif
│   │   ├── img/                # Penyimpanan gambar gedung & logo instansi
│   │   └── js/                 # Javascript pendukung
│   ├── uploads/                # Penyimpanan file unggahan (foto profil & selfie tamu)
│   └── index.php               # Entry point utama aplikasi CodeIgniter 4
├── .env                        # File konfigurasi environment (koneksi database & debug mode)
├── composer.json               # Dependensi php yang diatur oleh Composer
└── e_tamu.sql                  # Skema database MySQL awal beserta seed data awal
```

---

## 🛠️ Persyaratan Sistem

Untuk menjalankan aplikasi ini dengan lancar, pastikan server Anda memenuhi spesifikasi berikut:
- **PHP** versi 8.2 atau yang lebih baru.
- Ekstensi PHP yang harus aktif: `intl`, `mbstring`, `json`, `mysqlnd`, `libcurl`.
- **MySQL / MariaDB** untuk database server.
- Web server (seperti Apache/XAMPP, Nginx, atau IIS).
- **Composer** (opsional, untuk memperbarui dependensi framework jika diperlukan).

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

Berikut adalah langkah-langkah untuk menjalankan aplikasi E-Tamu di komputer lokal Anda menggunakan XAMPP:

### 1. Kloning atau Ekstrak Proyek
Pindahkan folder proyek E-Tamu ke dalam direktori server Anda (misalnya `C:\xampp\htdocs\E-tamu\`).

### 2. Konfigurasi Database
1. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Buat database baru dengan nama `e_tamu`.
3. Pilih database `e_tamu`, lalu **Import** file database `e_tamu.sql` yang terletak di root direktori proyek.

### 3. Konfigurasi Environment (`.env`)
1. Di root direktori proyek, salin file bernama `env` dan ubah namanya menjadi `.env` (atau edit langsung file `.env` jika sudah ada).
2. Sesuaikan konfigurasi berikut pada `.env` Anda:
   ```ini
   # Atur Base URL aplikasi Anda
   app.baseURL = 'http://localhost/E-tamu/public/'

   # Atur ke development jika ingin melihat error debug
   CI_ENVIRONMENT = development

   # Pengaturan Database
   database.default.hostname = localhost
   database.default.database = e_tamu
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

### 4. Menjalankan Aplikasi
Ada dua cara untuk mengakses aplikasi ini di browser Anda:

#### Cara A: Menggunakan Web Server Bawaan CodeIgniter (Direkomendasikan)
1. Buka terminal (Command Prompt/PowerShell) di direktori proyek `E-tamu`.
2. Jalankan perintah berikut:
   ```bash
   php spark serve
   ```
3. Aplikasi dapat diakses di browser melalui URL: `http://localhost:8080/`

#### Cara B: Melalui Virtual Host XAMPP / Path public/
Akses aplikasi melalui alamat apache lokal Anda:
`http://localhost/E-tamu/public/`

---

## 🔐 Akun Default Administrator

Untuk masuk ke panel admin, Anda dapat mengakses halaman login di:
`http://localhost:8080/admin/login` (atau `http://localhost/E-tamu/public/admin/login`)

Gunakan kredensial default berikut untuk masuk pertama kali:
- **Username:** `admin`
- **Password:** `admin123` *(jika Anda menggunakan database bawaan dari file e_tamu.sql)*
- **Role:** `admin` (Dapat membuat akun baru dengan role `petugas` atau `admin` lainnya dari menu Manajemen Profil).

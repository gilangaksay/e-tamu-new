CREATE DATABASE IF NOT EXISTS `e_tamu`;
USE `e_tamu`;

CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pegawai` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `jabatan` VARCHAR(100) NOT NULL,
  `unit_kerja` VARCHAR(100) NOT NULL,
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tamu` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `no_identitas` VARCHAR(20) NOT NULL,
  `instansi` VARCHAR(100) DEFAULT NULL,
  `no_telp` VARCHAR(20) DEFAULT NULL,
  `pegawai_id` INT(11) NOT NULL,
  `keperluan` VARCHAR(50) NOT NULL,
  `keterangan` TEXT DEFAULT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `jenis_kelamin` VARCHAR(10) DEFAULT NULL,
  `disabilitas` VARCHAR(50) DEFAULT NULL,
  `usia` VARCHAR(10) DEFAULT NULL,
  `status` ENUM('menunggu','berkunjung','selesai') NOT NULL DEFAULT 'menunggu',
  `no_antrian` VARCHAR(10) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_tamu_pegawai` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin` (`username`, `password`, `nama_lengkap`) VALUES
('admin', '$2y$10$BuJy3L6eScmIkr.V3Yno4uju80PHpDkt0hoQui0zwzrSG5f8DzdNy', 'Administrator Sistem');

INSERT INTO `pegawai` (`nama`, `jabatan`, `unit_kerja`, `aktif`) VALUES
('Dr. Hendra Wijaya, M.Si', 'Kepala Dinas', 'Pimpinan', 1),
('Ir. Siti Rahayu, M.T', 'Sekretaris Dinas', 'Sekretariat', 1),
('Bambang Suryanto, S.H', 'Kepala Bidang Hukum', 'Bidang Hukum', 1),
('Rina Kartika, S.E, M.M', 'Kepala Bidang Keuangan', 'Bidang Keuangan', 1),
('Ahmad Fauzi, S.Kom', 'Kepala Bidang IT', 'Bidang Teknologi Informasi', 1),
('Dewi Lestari, S.Sos', 'Kepala Sub Bagian Umum', 'Sub Bagian Umum', 1),
('Yusuf Maulana, S.T', 'Staff Teknis', 'Bidang Teknologi Informasi', 1),
('Fitri Handayani, S.Pd', 'Kepala Bidang Pendidikan', 'Bidang Pendidikan', 1),
('Agus Setiawan, S.IP', 'Kepala Bidang Pelayanan', 'Bidang Pelayanan Publik', 1);

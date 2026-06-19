-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2026 at 02:57 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simulasi_pbo_trpl1a_aylaazzura`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pendaftaran`
--

CREATE TABLE `tabel_pendaftaran` (
  `id_pendaftaran` int NOT NULL,
  `nama_calon` varchar(100) NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `nilai_ujian` decimal(5,2) NOT NULL,
  `biaya_pendaftaran_dasar` decimal(10,2) NOT NULL,
  `jalur_pendaftaran` enum('Reguler','Prestasi','Kedinasan') NOT NULL,
  `pilihan_prodi` varchar(50) DEFAULT NULL,
  `lokasi_kampus` varchar(50) DEFAULT NULL,
  `jenis_prestasi` varchar(50) DEFAULT NULL,
  `tingkat_prestasi` varchar(30) DEFAULT NULL,
  `sk_ikatan_dinas` varchar(50) DEFAULT NULL,
  `instansi_sponsor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_pendaftaran`
--

INSERT INTO `tabel_pendaftaran` (`id_pendaftaran`, `nama_calon`, `asal_sekolah`, `nilai_ujian`, `biaya_pendaftaran_dasar`, `jalur_pendaftaran`, `pilihan_prodi`, `lokasi_kampus`, `jenis_prestasi`, `tingkat_prestasi`, `sk_ikatan_dinas`, `instansi_sponsor`) VALUES
(2026001, 'Budi Santoso', 'SMAN 1 Jakarta', 85.50, 250000.00, 'Reguler', 'Teknik Informatika', 'Kampus Utama', NULL, NULL, NULL, NULL),
(2026002, 'Siti Aminah', 'MAN 2 Bandung', 88.00, 250000.00, 'Reguler', 'Sistem Informasi', 'Kampus Utama', NULL, NULL, NULL, NULL),
(2026003, 'Rian Hidayat', 'SMKN 1 Surabaya', 82.25, 250000.00, 'Reguler', 'Teknik Elektro', 'Kampus B', NULL, NULL, NULL, NULL),
(2026004, 'Dewi Lestari', 'SMAN 3 Yogyakarta', 90.00, 250000.00, 'Reguler', 'Kedokteran', 'Kampus Utama', NULL, NULL, NULL, NULL),
(2026005, 'Eko Prasetyo', 'SMAN 5 Semarang', 79.50, 250000.00, 'Reguler', 'Manajemen', 'Kampus B', NULL, NULL, NULL, NULL),
(2026006, 'Fitriani', 'SMAN 1 Medan', 86.75, 250000.00, 'Reguler', 'Akuntansi', 'Kampus Utama', NULL, NULL, NULL, NULL),
(2026007, 'Gilang Permana', 'SMK Telkom Malang', 84.00, 250000.00, 'Reguler', 'Teknik Komputer', 'Kampus B', NULL, NULL, NULL, NULL),
(2026008, 'Hendra Wijaya', 'SMAN 2 core', 92.00, 150000.00, 'Prestasi', 'Teknik Informatika', 'Kampus Utama', 'Olimpiade Matematika', 'Nasional', NULL, NULL),
(2026009, 'Indah Permatasari', 'SMAN 1 Surakarta', 91.50, 150000.00, 'Prestasi', 'Farmasi', 'Kampus Utama', 'FLS2N Menyanyi', 'Provinsi', NULL, NULL),
(2026010, 'Joko Tarub', 'SMAN 4 Denpasar', 89.00, 150000.00, 'Prestasi', 'Hukum', 'Kampus B', 'Juara 1 Pencak Silat', 'Nasional', NULL, NULL),
(2026011, 'Kevin Sanjaya', 'SMA Ragunan Jakarta', 80.00, 150000.00, 'Prestasi', 'Pendidikan Olahraga', 'Kampus B', 'Bulutangkis Tunggal Putra', 'Internasional', NULL, NULL),
(2026012, 'Larasati', 'SMAN 8 Jakarta', 95.00, 150000.00, 'Prestasi', 'Teknik Kimia', 'Kampus Utama', 'Karya Ilmiah Remaja', 'Nasional', NULL, NULL),
(2026013, 'Muhammad Rossi', 'SMKN 2 Pengasih', 83.50, 150000.00, 'Prestasi', 'Teknik Mesin', 'Kampus B', 'Lomba Kompetensi Siswa', 'Provinsi', NULL, NULL),
(2026014, 'Nadia Vega', 'SMA Kristen Petra', 93.20, 150000.00, 'Prestasi', 'Desain Komunikasi Visual', 'Kampus Utama', 'Lomba Desain Poster', 'Nasional', NULL, NULL),
(2026015, 'Oki Setiawan', 'SMAN 1 Taruna Nusantara', 87.50, 350000.00, 'Kedinasan', 'Ilmu Pemerintahan', 'Kampus Pusat Kedinasan', NULL, NULL, 'SK-DIK-2026-001', 'Kementerian Dalam Negeri'),
(2026016, 'Putri Rahayu', 'SMAN 2 Boyolali', 89.30, 350000.00, 'Kedinasan', 'Studi Demografi', 'Kampus Pusat Kedinasan', NULL, NULL, 'SK-BKKBN-X-2026', 'BKKBN'),
(2026017, 'Rizky Febrian', 'SMAN 3 Bandung', 86.00, 350000.00, 'Kedinasan', 'Sistem Informasi Publik', 'Kampus Pusat Kedinasan', NULL, NULL, 'SK-KOMINFO-092', 'Kementerian Kominfo'),
(2026018, 'Sinta Bella', 'SMAN 1 Makassar', 91.00, 350000.00, 'Kedinasan', 'Teknik Transportasi Darat', 'Kampus STTD', NULL, NULL, 'SK-HUB-2026-A', 'Kementerian Perhubungan'),
(2026019, 'Taufik Hidayat', 'MAN 1 Palembang', 85.10, 350000.00, 'Kedinasan', 'Hukum Tata Negara', 'Kampus Pusat Kedinasan', NULL, NULL, 'SK-KUMHAM-88', 'Kementerian Hukum dan HAM'),
(2026020, 'Vina Panduwinata', 'SMAN 1 Ambon', 88.40, 350000.00, 'Kedinasan', 'Administrasi Pajak', 'Kampus STAN', NULL, NULL, 'SK-KEMENKEU-2026', 'Kementerian Keuangan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2026021;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

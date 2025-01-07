-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Sep 2024 pada 16.22
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensigps1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `department`
--

CREATE TABLE `department` (
  `kode_dept` varchar(255) NOT NULL,
  `nama_dept` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `department`
--

INSERT INTO `department` (`kode_dept`, `nama_dept`) VALUES
('IT', 'Information Technology'),
('PTIP', 'Ruang PTIP');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` char(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat_malang` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `semester_saat_magang` int(11) DEFAULT NULL,
  `ipk_terakhir` decimal(3,2) DEFAULT NULL,
  `program_studi` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `perguruan_tinggi` varchar(255) DEFAULT NULL,
  `durasi_magang` int(11) DEFAULT NULL,
  `tanggal_mulai_magang` date DEFAULT NULL,
  `surat_pengantar_magang` text DEFAULT NULL,
  `proposal_magang` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `kode_dept` varchar(255) NOT NULL,
  `remembet_token` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_magang` enum('Calon','Ditolak','Aktif','Selesai','Blacklist') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat_malang`, `no_hp`, `semester_saat_magang`, `ipk_terakhir`, `program_studi`, `jurusan`, `perguruan_tinggi`, `durasi_magang`, `tanggal_mulai_magang`, `surat_pengantar_magang`, `proposal_magang`, `foto`, `password`, `kode_dept`, `remembet_token`, `updated_at`, `status_magang`) VALUES
('12345', 'Agung Rio', 'Laki-laki', 'Kota Malang', '2002-09-04', 'jalan sigura-gura 4', '087587840862', 7, '3.80', 'Teknik Informatika', 'Ilmu komputer', 'Polinema', 2, '2024-09-03', 'https://docs.google.com/document/d/1Jj56r11fBS--128eAaEw1s5M6spbdKbb/edit', 'https://drive.google.com/file/d/1MRtS9kqinV0mhEjBCyaziv1cx27i_x_L/view', NULL, '$2y$12$mTJGXNcltNEFCBCKQCx7VewJdDiyiluOkQDFLtyaGKJTCwnaJPkYq', 'IT', '', NULL, 'Lolos'),
('12346', 'Muhamad Al Faroby', 'Laki-laki', 'kab Malang', '2002-09-04', 'jalan sigura-gura 5', '089123456789', 5, '3.70', 'Sistem Informasi', 'Ilmu komputer', 'UB', 4, '2024-09-02', 'https://docs.google.com/document/d/1Jj56r11fBS--128eAaEw1s5M6spbdKbb/edit', 'https://drive.google.com/file/d/1MRtS9kqinV0mhEjBCyaziv1cx27i_x_L/view', '12346.png', '$2y$12$mTJGXNcltNEFCBCKQCx7VewJdDiyiluOkQDFLtyaGKJTCwnaJPkYq', 'PTIP', '', '2024-09-02 04:04:16', 'Lolos');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_izin`
--

CREATE TABLE `pengajuan_izin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` char(255) NOT NULL,
  `tgl_izin` date NOT NULL,
  `status` char(1) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `surat` varchar(30) DEFAULT NULL,
  `alasan` text DEFAULT NULL,
  `status_approved` char(1) DEFAULT NULL,
  `tgl_approved` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengajuan_izin`
--

INSERT INTO `pengajuan_izin` (`id`, `nim`, `tgl_izin`, `status`, `keterangan`, `surat`, `alasan`, `status_approved`, `tgl_approved`, `updated_at`) VALUES
(1, '12346', '2024-08-09', 'i', 'ket', NULL, NULL, '1', '2024-08-07 00:00:00', '2024-08-08 00:59:27'),
(2, '12346', '2024-08-12', 's', 'ket', NULL, NULL, '1', '2024-08-07 00:00:00', '2024-08-08 01:00:47'),
(3, '12346', '2024-08-13', 'i', 'keterangan izin', NULL, NULL, '1', '2024-08-08 00:00:00', '2024-08-08 02:23:15'),
(4, '12346', '2024-08-15', 'i', 'acara', NULL, NULL, '0', '2024-08-12 00:00:00', '2024-09-04 05:54:52'),
(5, '12346', '2024-08-16', 's', 'sakit', NULL, NULL, '0', '2024-08-12 00:00:00', '2024-08-22 01:03:42'),
(6, '12345', '2024-08-30', 's', 'test', NULL, NULL, '1', NULL, NULL),
(7, '12345', '2024-08-29', 'i', 'test', NULL, NULL, '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `nim` char(255) NOT NULL,
  `tgl_presensi` date NOT NULL,
  `jam_in` time NOT NULL,
  `jam_out` time DEFAULT NULL,
  `foto_in` varchar(255) NOT NULL,
  `foto_out` varchar(255) DEFAULT NULL,
  `lokasi_in` text NOT NULL,
  `lokasi_out` text DEFAULT NULL,
  `kegiatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `nim`, `tgl_presensi`, `jam_in`, `jam_out`, `foto_in`, `foto_out`, `lokasi_in`, `lokasi_out`, `kegiatan`) VALUES
(23, '12345', '2024-07-10', '15:51:52', '15:52:04', '12345-2024-07-10.png', '12345-2024-07-10.png', '-7.929967,112.649269', '-7.929967,112.649269', NULL),
(24, '12345', '2024-07-15', '15:28:56', '15:29:14', '12345-2024-07-15.png', '12345-2024-07-15.png', '-7.929926,112.649245', '-7.929926,112.649245', NULL),
(25, '12345', '2024-07-16', '13:11:22', '14:52:40', '12345-2024-07-16.png', '12345-2024-07-16.png', '-7.929978,112.649251', '-7.929904,112.649299', NULL),
(35, '12345', '2024-07-17', '10:51:11', '10:56:00', '12345-2024-07-17-in.png', '12345-2024-07-17-out.png', '-7.929883,112.649299', '-7.929922,112.649247', NULL),
(36, '12345', '2024-07-18', '07:41:30', '07:41:49', '12345-2024-07-18-in.png', '12345-2024-07-18-out.png', '-7.929967,112.649269', '-7.92994,112.64928', NULL),
(38, '12346', '2024-07-18', '07:16:42', '10:16:57', '12346-2024-07-18-in.png', '12346-2024-07-18-out.png', '-7.929933,112.649241', '-7.93,112.649247', NULL),
(39, '12345', '2024-07-23', '15:06:20', '15:06:37', '12345-2024-07-23-in.png', '12345-2024-07-23-out.png', '-7.929943,112.649284', '-7.929943,112.649284', NULL),
(40, '12345', '2024-07-26', '12:29:28', NULL, '12345-2024-07-26-in.png', NULL, '-7.929962,112.649282', NULL, NULL),
(42, '12345', '2024-07-30', '11:00:56', '11:02:13', '12345-2024-07-30-in.png', '12345-2024-07-30-out.png', '-7.92992,112.649289', '-7.930022,112.64925', NULL),
(43, '12345', '2024-08-05', '08:40:15', '08:43:56', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.9301572,112.6493728', '-7.9301768,112.6493849', 'Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtabl'),
(46, '12346', '2024-08-08', '09:20:53', '09:21:28', '12346-2024-08-08-in.png', '12346-2024-08-08-out.png', '-7.929943,112.649285', '-7.929943,112.649285', NULL),
(47, '12346', '2024-08-12', '08:20:16', '08:20:52', '12346-2024-08-12-in.png', '12346-2024-08-12-out.png', '-7.929909,112.64928', '-7.929909,112.64928', NULL),
(48, '12346', '2024-08-22', '07:55:37', '07:55:54', '12346-2024-08-22-in.png', '12346-2024-08-22-out.png', '-7.929938,112.6493', '-7.929938,112.6493', NULL),
(49, '12345', '2024-08-29', '06:43:55', '15:41:17', '12345-2024-08-29-in.png', '12345-2024-08-29-out.png', '-7.929907,112.649267', '-7.929986,112.649268', 'Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtabl'),
(50, '12346', '2024-08-29', '06:43:55', '13:19:22', '12346-2024-08-29-in.png', '12346-2024-08-29-out.png', '-7.929846,112.649316', '-7.929846,112.649316', NULL),
(51, '12345', '2024-08-30', '14:02:11', '14:03:04', '12345-2024-08-30-in.png', '12345-2024-08-30-out.png', '-7.929869,112.649281', '-7.929869,112.649281', 'Melakukan pengerjaan login mahaiswa, menambah  fitur tampil rekap presensi'),
(52, '12345', '2024-08-31', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahaiswa, menambah fitur tampil rekap presensi'),
(53, '12345', '2024-01-01', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(54, '12345', '2024-01-02', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(55, '12345', '2024-01-03', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(56, '12345', '2024-01-04', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(57, '12345', '2024-01-05', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(58, '12345', '2024-01-08', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(59, '12345', '2024-01-09', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(60, '12345', '2024-01-10', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(61, '12345', '2024-01-11', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(62, '12345', '2024-01-12', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(63, '12345', '2024-01-15', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(64, '12345', '2024-01-16', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(65, '12345', '2024-01-17', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(66, '12345', '2024-01-18', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(67, '12345', '2024-01-19', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(68, '12345', '2024-01-22', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(69, '12345', '2024-01-23', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(70, '12345', '2024-01-24', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(71, '12345', '2024-01-25', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(72, '12345', '2024-01-26', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(73, '12345', '2024-01-29', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(74, '12345', '2024-01-30', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(75, '12345', '2024-01-31', '07:28:57', '16:00:57', '12345-2024-08-05-in.png', '12345-2024-08-05-out.png', '-7.929909,112.64928', '-7.929909,112.64928', 'Melakukan pengerjaan login mahasiswa, menambah fitur tampil rekap presensi'),
(76, '12346', '2024-09-04', '12:09:48', '12:10:11', '12346-2024-09-04-in.png', '12346-2024-09-04-out.png', '-7.929877,112.6493', '-7.929877,112.6493', 'test test test test test test test test test test test test test test test test test test test test test test test test test test test test');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JeYXSdGobPZAFnLWMCYDxE9fNFnAFcqcb4juPsce', 12345, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 Edg/127.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZHB1TDlLNzZCVUgzU2VIQ2dPTzJBNlpxRkJSbmZSeHJLUzNnYVpocyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcmVzZW5zaS9oaXN0b3JpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3Byb3Nlc2xvZ291dCI7fXM6NTU6ImxvZ2luX2thcnlhd2FuXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTIzNDU7fQ==', 1722800792);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'user', 'user@gmail.com', NULL, '$2y$12$mTJGXNcltNEFCBCKQCx7VewJdDiyiluOkQDFLtyaGKJTCwnaJPkYq', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`kode_dept`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengajuan_izin`
--
ALTER TABLE `pengajuan_izin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_izin`
--
ALTER TABLE `pengajuan_izin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

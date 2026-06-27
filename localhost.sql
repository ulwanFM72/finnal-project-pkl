-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2026 at 09:15 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_eskul`
--
CREATE DATABASE IF NOT EXISTS `db_eskul` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_eskul`;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('833EqrrFiugrVT77hrTUity1OJcwQ0jcEHBxQHL4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJBOWEzbHdTQ29EdHd2RlVvdmJMUGxFd0t3cHZvajZacFcyVmFmVFdiIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776911031);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `pendaftaran_eskul`
--
CREATE DATABASE IF NOT EXISTS `pendaftaran_eskul` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `pendaftaran_eskul`;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekstrakurikuler`
--

CREATE TABLE `ekstrakurikuler` (
  `id_ekskul` int NOT NULL,
  `nama_ekskul` varchar(100) DEFAULT NULL,
  `id_pembina` int DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `foto_kegiatan` varchar(255) DEFAULT NULL,
  `jadwal` varchar(100) DEFAULT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ekstrakurikuler`
--

INSERT INTO `ekstrakurikuler` (`id_ekskul`, `nama_ekskul`, `id_pembina`, `foto`, `foto_kegiatan`, `jadwal`, `deskripsi`) VALUES
(1, 'Karawitan', 5, 'logo_1782475910_Logo_karawitan.png', 'kegiatan_1782475910_kegiatan_karawitan.jpeg', 'Rabu', 'Seni musik tradisional Jawa Barat menggunakan gendang, gong, saron dan bonang. Melestarikan budaya lokal dan melatih kepekaan seni.'),
(2, 'Paskibra', 8, 'logo_1782476119_Logo_paskibra.jpeg', 'kegiatan_paskibra.jpeg', 'Sabtu', 'Pasukan pengibar bendera — melatih kedisiplinan, ketangkasan baris berbaris, dan jiwa \r\nnasionalisme.'),
(3, 'Marching Band', 6, 'Logo_marching_band.jpeg', 'kegiatan_marching_band.jpeg', 'Sabtu', 'Paduan musik dan baris berbaris. Melatih kekompakan, koordinasi, dan penampilan di berbagai acara.'),
(4, 'Volly', 9, 'Logo_volly.jpeg', 'kegiatan_volly.jpeg', 'Senin܁Perempuan\\nSelasa܁Laki-laki', 'Olahraga permainan tim 6 vs 6. Melatih koordinasi gerak, reflek, stamina, dan komunikasi tim.'),
(5, 'Pramuka', 3, 'Logo_pramuka.jpeg', 'kegiatan_1782438179_kegiatan_pramuka2.jpeg', 'Jumat', 'Gerakan pramuka membangun karakter, kepemimpinan, kemandirian, dan kecintaan terhadap alam.'),
(6, 'Cinemak', 2, 'Logo_cinemak.jpeg', 'kegiatan_cinemak.jpeg', 'Senin', 'Sinema & fotografi — melatih kreativitas dalam dunia film pendek, editing video, Fotografi, dan dokumentasi.'),
(7, 'PMR', 4, 'Logo_pmr.jpeg', 'kegiatan_pmr.jpeg', 'Selasa', 'Palang Merah Remaja — melatih keterampilan pertolongan pertama, donor darah, dan kepedulian sosial.'),
(8, 'Rohis', 7, 'Logo_rohis.jpeg', 'kegiatan_rohis.jpeg', 'Rabu', 'Rohani Islam — wadah pengembangan spiritual, kajian agama, dan pembinaan akhlak siswa muslim.'),
(9, 'Futsal', 1, 'Logo_futsal.jpeg', 'kegiatan_futsal.jpeg', 'Rabu܁Laki-laki\\nKamis܁Perempuan', 'Olahraga permainan tim dengan 5 pemain di lapangan tertutup. Melatih kerjasama, kecepatan, dan strategi.');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int NOT NULL,
  `nama_level` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'siswa'),
(2, 'pembina'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000003_create_user_table', 1),
(5, '2024_01_01_000004_create_pembina_table', 1),
(6, '2024_01_01_000005_create_siswa_table', 1),
(7, '2024_01_01_000006_create_ekstrakurikuler_table', 1),
(8, '2024_01_01_000007_create_pendaftaran_table', 1),
(10, '2026_06_11_123116_create_level_table', 1),
(11, '2026_06_24_000001_add_detail_to_ekstrakurikuler_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembina`
--

CREATE TABLE `pembina` (
  `id_pembina` int NOT NULL,
  `nama_pembina` varchar(100) DEFAULT NULL,
  `nomor_handphone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembina`
--

INSERT INTO `pembina` (`id_pembina`, `nama_pembina`, `nomor_handphone`, `email`, `id_user`) VALUES
(1, 'Jaya Nursetia', '087848722377', '@jayanursetia', 1),
(2, 'Rahmat Setiawan', '085797227508', '@rahmatsetiawan', 2),
(3, 'Najib Aminullah', '0858-6021-8011', '@anajib', 3),
(4, 'Mega Murunisa', '085723154390', '@meganurunisa', 4),
(5, 'Yoga Agung', '083195944086', '@yogaagung', 5),
(6, 'Nurah Alwaini', '085817319887', '@nurahalwaini', 6),
(7, 'Asep Mukhlis', '085759950201', '@asepmukhlis', 7),
(8, 'Ende Iskandar', '085724623300', '@endeiskandar', 8),
(9, 'Dedi Sukardi', '085872331518', '@dedisukardi', 9);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int NOT NULL,
  `id_siswa` int DEFAULT NULL,
  `id_ekskul` int DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_siswa`, `id_ekskul`, `tanggal_daftar`) VALUES
(43, 14, 5, '2026-06-11'),
(45, 14, 8, '2026-06-11'),
(47, 14, 3, '2026-06-11'),
(49, 15, 3, '2026-06-12'),
(50, 15, 1, '2026-06-12'),
(51, 15, 6, '2026-06-12'),
(52, 15, 8, '2026-06-12'),
(53, 10, 8, '2026-06-12'),
(54, 10, 1, '2026-06-12'),
(55, 10, 4, '2026-06-12'),
(56, 10, 7, '2026-06-12'),
(57, 10, 9, '2026-06-12'),
(70, 17, 3, '2026-06-26'),
(71, 17, 1, '2026-06-26'),
(72, 17, 9, '2026-06-26'),
(74, 17, 5, '2026-06-26'),
(75, 17, 7, '2026-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `kelas_jurusan` varchar(50) DEFAULT NULL,
  `nomor_handphone` varchar(50) DEFAULT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_lengkap`, `kelas_jurusan`, `nomor_handphone`, `id_user`) VALUES
(10, 'dede', 'X RPL-B', '0858606393', 20),
(14, 'keysha azzahra', 'xii rpl2', '1234567890', 25),
(15, 'masriah', 'X RPL-A', '3724724342435', 26),
(17, 'fauzul muqtaf', 'X RPL-B', '12345678904', 28);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_level` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `id_level`) VALUES
(1, 'jaya nursetia', '$2y$12$sAfu7uSW6R6dJW4BOWbciu1jvP6r3BvTutvMAEoufyXq5QkDEqolK', 2),
(2, 'rahmat setiawan', '$2y$12$MM0rNyr0fEzseTlu4A5ioO0ZwOeECSzq0Cfbd8MifEWZfe73ilvO.', 2),
(3, 'najib', '$2y$12$DoTfWzTddRYV7m000fngT.UTHiHR9umKyyQh/.eBRriXkw1wfGLsi', 2),
(4, 'mega nurunisa', '$2y$12$UCzGqxPQKcbXbvoo6gcwTuKnIg7t4jYeGQ.otopqMaB0ULiH4dBSi', 2),
(5, 'yoga agung', '$2y$12$7bTNV2YohluruGs0mEroRu2BlNIE4KYUSTrqZG967npOZup/7aG.a', 2),
(6, 'nurah alwaini', '$2y$12$Am2mfv2r/OWFgE8rMk3tzOXUbL572kxQ8nPUm19XxdS2fHJ5TdgLK', 2),
(7, 'asep mukhlis', '$2y$12$pitkSFtztxIBt0DvKU.VKOl4dqZ/g9pRsixAuyDkBhrlhhxLPHTfG', 2),
(8, 'ende iskandar', '$2y$12$ghGwWvsfGqMe0Q7dK8Sq8eeZ/irRvzdKaB1Y2aAFq5hu2KEIgKzcy', 2),
(9, 'dedi sukardi', '$2y$12$EfII5ovBe3m.xEexNhOuhOgfc27KBn0t7TqdJX7c5T9gtEV261XDK', 2),
(10, 'admin', '$2y$12$2NWv8d/BrJbpvLnlXcNHaO0P4TbWOOn.NVtfcXHZ4VltikC5svB7O', 3),
(20, 'dede', '$2y$12$YemtTBW.mvqsdkscJb62DuZY31RfT5iXrLOK0ELdSWWWv7wFZRkLW', 1),
(25, 'keysha', '$2y$12$xe50oQRiDNuytXbNSV6hU.KD6JpYOhcgeAj7NcKGKwtD0E.j3GWr.', 1),
(26, 'masriah', '$2y$12$ekyCSf3DOeNnwe/wWJvhieAHqpEMPQ22MKLP0iGvVuJumYCkAmvCy', 1),
(28, 'fauzul', '$2y$12$yGuo3KiZM/elsIotR8q/oO/zh8kz3S8T4Z817U2piqTWL9syYk/zW', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD PRIMARY KEY (`id_ekskul`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembina`
--
ALTER TABLE `pembina`
  ADD PRIMARY KEY (`id_pembina`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  MODIFY `id_ekskul` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pembina`
--
ALTER TABLE `pembina`
  MODIFY `id_pembina` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `perpustakaan_db`
--
CREATE DATABASE IF NOT EXISTS `perpustakaan_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `perpustakaan_db`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'Administrator', 'admin.perpus', 'smkn1cijati26', 'admin@perpustakaan.sch.id', '2026-05-29 16:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `kode_buku` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `penulis` varchar(150) NOT NULL,
  `penerbit` varchar(150) NOT NULL,
  `tahun_terbit` year NOT NULL,
  `kategori` enum('Fiksi','Non-Fiksi','Sains','Matematika','Sejarah','Bahasa','Agama','Teknologi','Seni','Olahraga','Lainnya') NOT NULL DEFAULT 'Lainnya',
  `stok` int NOT NULL DEFAULT '1',
  `stok_tersedia` int NOT NULL DEFAULT '1',
  `cover` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `kode_buku`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `kategori`, `stok`, `stok_tersedia`, `cover`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'BK001', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', '2005', 'Fiksi', 5, 5, NULL, NULL, '2026-05-29 16:16:21', '2026-06-05 14:49:25'),
(2, 'BK002', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', '1980', 'Fiksi', 3, 3, NULL, NULL, '2026-05-29 16:16:21', '2026-06-06 08:16:12'),
(3, 'BK003', 'Matematika SMA Kelas X', 'Sukino', 'Erlangga', '2022', 'Matematika', 10, 10, NULL, NULL, '2026-05-29 16:16:21', '2026-05-29 16:16:21'),
(4, 'BK004', 'Fisika Dasar', 'Halliday & Resnick', 'Erlangga', '2020', 'Sains', 7, 7, NULL, NULL, '2026-05-29 16:16:21', '2026-05-29 16:16:21'),
(5, 'BK005', 'Sejarah Indonesia Modern', 'M.C. Ricklefs', 'Serambi', '2008', 'Sejarah', 4, 4, NULL, NULL, '2026-05-29 16:16:21', '2026-05-29 16:16:21'),
(6, 'BK006', 'Pemrograman Web', 'Abdul Kadir', 'Andi', '2021', 'Teknologi', 6, 6, NULL, NULL, '2026-05-29 16:16:21', '2026-06-06 08:16:10'),
(7, 'BK007', 'Bahasa Indonesia untuk SMA', 'Drs. Agus', 'Yudhistira', '2022', 'Bahasa', 8, 8, NULL, NULL, '2026-05-29 16:16:21', '2026-05-29 16:16:21'),
(8, 'BK008', 'Kimia Organik Dasar', 'Fessenden', 'Erlangga', '2019', 'Sains', 5, 5, NULL, NULL, '2026-05-29 16:16:21', '2026-05-29 16:16:21'),
(9, 'BK0009', 'MADILOG', 'Tan Malaka', 'Bentang Pustaka', '1938', 'Non-Fiksi', 1, 1, NULL, '', '2026-06-05 14:45:20', '2026-06-07 03:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `kode_pinjam` varchar(20) NOT NULL,
  `siswa_id` int NOT NULL,
  `buku_id` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan','terlambat') DEFAULT 'dipinjam',
  `denda` decimal(10,2) DEFAULT '0.00',
  `keterangan` text,
  `admin_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `kode_pinjam`, `siswa_id`, `buku_id`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_pengembalian`, `status`, `denda`, `keterangan`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'PJM2026060001', 1, 1, '2026-06-05', '2026-06-12', '2026-06-05', 'dikembalikan', 0.00, NULL, 1, '2026-06-05 14:41:48', '2026-06-05 14:49:25'),
(2, 'PJM2026060002', 5, 2, '2026-06-05', '2026-06-12', '2026-06-06', 'dikembalikan', 0.00, NULL, 1, '2026-06-05 14:42:40', '2026-06-06 08:16:06'),
(3, 'PJM2026060003', 11, 6, '2026-06-05', '2026-06-12', '2026-06-06', 'dikembalikan', 0.00, NULL, 1, '2026-06-05 14:42:47', '2026-06-06 08:16:10'),
(4, 'PJM2026060004', 6, 2, '2026-06-05', '2026-06-12', '2026-06-06', 'dikembalikan', 0.00, NULL, 1, '2026-06-05 14:42:55', '2026-06-06 08:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int NOT NULL,
  `nama_sekolah` varchar(200) DEFAULT 'SMA Negeri 1',
  `denda_per_hari` decimal(10,2) DEFAULT '1000.00',
  `maks_pinjam` int DEFAULT '3',
  `maks_hari` int DEFAULT '7',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_sekolah`, `denda_per_hari`, `maks_pinjam`, `maks_hari`, `updated_at`) VALUES
(1, 'SMK N 1 CIJATI', 1000.00, 3, 7, '2026-06-05 09:22:46');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jurusan`, `jenis_kelamin`, `telepon`, `alamat`, `status`, `created_at`, `updated_at`) VALUES
(1, '2024001', 'ulwan fauzul muqtaf', 'XII-B', 'RPL', 'L', NULL, NULL, 'aktif', '2026-05-29 16:16:42', '2026-06-05 09:26:37'),
(2, '2024002', 'dede silpiah', 'XII-B', 'RPL', 'P', NULL, NULL, 'aktif', '2026-05-29 16:16:42', '2026-06-05 09:26:37'),
(3, '2024003', 'satria mulyana', 'XII-B', 'RPL', 'L', NULL, NULL, 'aktif', '2026-05-29 16:16:42', '2026-06-05 09:26:37'),
(4, '2024004', 'tita rismayanti', 'XII-B', 'RPL', 'P', NULL, NULL, 'aktif', '2026-05-29 16:16:42', '2026-06-05 09:26:37'),
(5, '2024005', 'aura kasih', 'XII-B', 'RPL', 'P', NULL, NULL, 'aktif', '2026-05-29 16:16:42', '2026-06-05 10:14:58'),
(6, '2024006', 'rendyansah', 'XII-B', 'RPL', 'L', NULL, NULL, 'aktif', '2026-05-29 16:16:42', '2026-06-05 10:14:58'),
(7, '2024007', 'akmaludin', 'XII-B', 'RPL', 'L', NULL, NULL, 'aktif', '2026-05-29 16:16:42', '2026-06-05 09:26:37'),
(8, '2024008', 'firda lesmana', 'XII-B', 'RPL', 'L', NULL, NULL, 'aktif', '2026-05-29 16:16:42', '2026-06-05 10:14:58'),
(9, '92163491', 'cep ramdan', 'XII-A', 'RPL', 'L', '', '', 'aktif', '2026-06-05 10:20:52', '2026-06-05 10:22:58'),
(10, '2817342', 'uni reatu padilah', 'XII-A', 'RPL', 'P', '', '', 'aktif', '2026-06-05 10:24:28', '2026-06-05 10:25:10'),
(11, '34124361', 'fauzan sobari', 'XII-A', 'BDP', 'L', '', '', 'aktif', '2026-06-05 10:24:56', '2026-06-05 10:24:56'),
(12, '23845761', 'adira', 'XII-A', 'TKR', 'L', '', '', 'aktif', '2026-06-05 10:26:04', '2026-06-05 10:26:04'),
(13, '7912736', 'fahri', 'XII-A', 'APHP', 'L', '', '', 'aktif', '2026-06-05 10:26:26', '2026-06-05 10:26:26'),
(14, '421873413', 'lutfi', 'XII-B', 'BDP', 'L', '', '', 'aktif', '2026-06-05 10:26:58', '2026-06-05 10:26:58'),
(15, '80237513', 'lutfi', 'XII-A', 'TKR', 'L', '', '', 'aktif', '2026-06-05 10:27:17', '2026-06-05 10:27:17'),
(16, '123846751', 'desita', 'XII-B', 'BDP', 'P', '', '', 'aktif', '2026-06-05 10:28:19', '2026-06-05 10:28:19'),
(17, '12345457', 'ilma', 'XII-A', 'APHP', 'P', '', '', 'aktif', '2026-06-05 10:28:49', '2026-06-05 10:28:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_buku` (`kode_buku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pinjam` (`kode_pinjam`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `buku_id` (`buku_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

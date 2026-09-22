-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 22, 2026 at 06:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearningarrava`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `id_user` int NOT NULL,
  `waktu_absensi` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasilquizmodul`
--

CREATE TABLE `hasilquizmodul` (
  `id_hasil` int NOT NULL,
  `id_user` int NOT NULL,
  `id_quiz` int NOT NULL,
  `total_poin` int DEFAULT '0',
  `poin_didapat` int DEFAULT '0',
  `waktu_dapat` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_soal`
--

CREATE TABLE `jenis_soal` (
  `id_jenis_soal` int NOT NULL,
  `nama_jenis_soal` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_soal`
--

INSERT INTO `jenis_soal` (`id_jenis_soal`, `nama_jenis_soal`, `created_at`, `updated_at`) VALUES
(1, 'Pilihan Ganda', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(2, 'Essay', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(3, 'Benar/Salah', '2026-09-22 03:45:17', '2026-09-22 03:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `jenjang`
--

CREATE TABLE `jenjang` (
  `id_jenjang` int NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenjang`
--

INSERT INTO `jenjang` (`id_jenjang`, `nama_tipe`, `created_at`, `updated_at`) VALUES
(1, 'SD', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(2, 'SMP', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(3, 'SMA', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(4, 'guru', '2026-09-22 03:45:17', '2026-09-22 03:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `logaktivitas`
--

CREATE TABLE `logaktivitas` (
  `id_logaktivitas` int NOT NULL,
  `waktu_kegiataan` datetime NOT NULL,
  `id_user` int NOT NULL,
  `kegiatan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materi_video`
--

CREATE TABLE `materi_video` (
  `id_materi` int UNSIGNED NOT NULL,
  `id_modul` int UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `durasi` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` smallint UNSIGNED NOT NULL DEFAULT '1',
  `status` enum('aktif','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2026_09_20_000001_create_jenjang_table', 1),
(2, '2026_09_20_000002_create_tipeuser_table', 1),
(3, '2026_09_20_000003_create_tipemodul_table', 1),
(4, '2026_09_20_000004_create_tipequiz_table', 1),
(5, '2026_09_20_000005_create_tingkatquiz_table', 1),
(6, '2026_09_20_000006_create_jenis_soal_table', 1),
(7, '2026_09_20_000007_create_quiz_table', 1),
(8, '2026_09_20_000008_create_modul_table', 1),
(9, '2026_09_20_000009_create_user_table', 1),
(10, '2026_09_20_000010_create_absensi_table', 1),
(11, '2026_09_20_000011_create_soal_table', 1),
(12, '2026_09_20_000012_create_hasilquizmodul_table', 1),
(13, '2026_09_20_000013_create_logaktivitas_table', 1),
(14, '2026_09_20_000014_create_pencapaianuser_table', 1),
(15, '2026_09_21_131805_create_sessions_table', 1),
(16, '2026_09_22_035942_create_pilihan_soal_table', 2),
(17, '2026_09_22_035943_create_materi_video_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id_modul` int NOT NULL,
  `judul_modul` varchar(255) NOT NULL,
  `file_materi` varchar(255) DEFAULT NULL,
  `tipe_file` varchar(50) DEFAULT NULL,
  `id_tipemodul` int NOT NULL,
  `id_jenjang` int NOT NULL,
  `id_quiz` int DEFAULT NULL,
  `progressModul` varchar(255) DEFAULT NULL,
  `foto_modul` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pencapaianuser`
--

CREATE TABLE `pencapaianuser` (
  `id_pencapaian` int NOT NULL,
  `id_user` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `waktu_pencapaian` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pilihan_soal`
--

CREATE TABLE `pilihan_soal` (
  `id_pilihan` int UNSIGNED NOT NULL,
  `id_soal` int UNSIGNED NOT NULL,
  `label` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teks_pilihan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `id_tipequiz` int NOT NULL,
  `id_tingkatquiz` int NOT NULL,
  `hasil_quiz` varchar(255) DEFAULT NULL,
  `proggressQuiz` varchar(255) DEFAULT NULL,
  `foto_quiz` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id_soal` int NOT NULL,
  `id_quiz` int NOT NULL,
  `id_jenjang` int NOT NULL,
  `id_jenis_soal` int DEFAULT NULL,
  `pertanyaan` text NOT NULL,
  `jawaban_benar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tingkatquiz`
--

CREATE TABLE `tingkatquiz` (
  `id_tingkatquiz` int NOT NULL,
  `nama_tingkat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tingkatquiz`
--

INSERT INTO `tingkatquiz` (`id_tingkatquiz`, `nama_tingkat`, `created_at`, `updated_at`) VALUES
(1, 'Mudah', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(2, 'Sedang', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(3, 'Sulit', '2026-09-22 03:45:17', '2026-09-22 03:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `tipemodul`
--

CREATE TABLE `tipemodul` (
  `id_tipemodul` int NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tipemodul`
--

INSERT INTO `tipemodul` (`id_tipemodul`, `nama_tipe`, `created_at`, `updated_at`) VALUES
(1, 'Video', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(2, 'PDF', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(3, 'Artikel', '2026-09-22 03:45:17', '2026-09-22 03:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `tipequiz`
--

CREATE TABLE `tipequiz` (
  `id_tipequiz` int NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tipequiz`
--

INSERT INTO `tipequiz` (`id_tipequiz`, `nama_tipe`, `created_at`, `updated_at`) VALUES
(1, 'Harian', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(2, 'Ulangan', '2026-09-22 03:45:17', '2026-09-22 03:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `tipeuser`
--

CREATE TABLE `tipeuser` (
  `id_tipeUser` int NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tipeuser`
--

INSERT INTO `tipeuser` (`id_tipeUser`, `nama_tipe`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(2, 'guru', '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(3, 'siswa', '2026-09-22 03:45:17', '2026-09-22 03:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_tipeuser` int NOT NULL,
  `id_jenjang` int NOT NULL,
  `total_poin` int DEFAULT '0',
  `status_akun` varchar(50) DEFAULT NULL,
  `id_modul` int DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `id_tipeuser`, `id_jenjang`, `total_poin`, `status_akun`, `id_modul`, `foto_profil`, `created_at`, `updated_at`) VALUES
(1, 'amru', 'a@gmail.com', '$2y$12$s.9sfbaTB8UJqDEfcr.Aa.IFvgaj0HauclAuMuBdGrJnTREVGUuIu', 1, 1, 0, NULL, NULL, NULL, '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(2, 'dd', 'dd@gmail.com', '$2y$12$bMg7QisuoSwdeDo54/4XguqvpKqdPB8MYKLp9x/QDPJzXBC8/dm0W', 3, 1, 0, NULL, NULL, NULL, '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(3, 'amru', 'e@gmail.com', '$2y$12$YL5663BruJVMlnyDVMABGOJ8fjLbsb/n8Vyf0eALO01sqJjptsP5G', 1, 2, 0, NULL, NULL, NULL, '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(4, '2', 'amru@gmail.com', '$2y$12$rfwsONGAQ7WA6zLnOKpv9.DAzg1wvnV81RP75M0ag5y6a8FNgvV92', 3, 2, 0, NULL, NULL, NULL, '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(7, 'rizki', 'rizki@gmail.com', '$2y$12$2OuIcfn3cygbtrtKnRcad.aJZ.DH62nGHvORt4cp91m9onqZcdquq', 1, 2, 0, NULL, NULL, NULL, '2026-09-22 03:45:17', '2026-09-22 03:45:17'),
(8, 'boy', 'siswa@gmail.com', '$2y$12$6X.Mf49zimgpYs7RFvVqn.VIt5ulSe7t0cZ0vrXTGdT3KuWI.bvpq', 3, 3, 0, NULL, NULL, NULL, '2026-09-21 21:20:43', '2026-09-21 21:20:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `hasilquizmodul`
--
ALTER TABLE `hasilquizmodul`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_quiz` (`id_quiz`);

--
-- Indexes for table `jenis_soal`
--
ALTER TABLE `jenis_soal`
  ADD PRIMARY KEY (`id_jenis_soal`);

--
-- Indexes for table `jenjang`
--
ALTER TABLE `jenjang`
  ADD PRIMARY KEY (`id_jenjang`);

--
-- Indexes for table `logaktivitas`
--
ALTER TABLE `logaktivitas`
  ADD PRIMARY KEY (`id_logaktivitas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `materi_video`
--
ALTER TABLE `materi_video`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`),
  ADD KEY `id_tipemodul` (`id_tipemodul`),
  ADD KEY `id_jenjang` (`id_jenjang`),
  ADD KEY `id_quiz` (`id_quiz`);

--
-- Indexes for table `pencapaianuser`
--
ALTER TABLE `pencapaianuser`
  ADD PRIMARY KEY (`id_pencapaian`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pilihan_soal`
--
ALTER TABLE `pilihan_soal`
  ADD PRIMARY KEY (`id_pilihan`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `id_tipequiz` (`id_tipequiz`),
  ADD KEY `id_tingkatquiz` (`id_tingkatquiz`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `id_quiz` (`id_quiz`),
  ADD KEY `id_jenjang` (`id_jenjang`),
  ADD KEY `id_jenis_soal` (`id_jenis_soal`);

--
-- Indexes for table `tingkatquiz`
--
ALTER TABLE `tingkatquiz`
  ADD PRIMARY KEY (`id_tingkatquiz`);

--
-- Indexes for table `tipemodul`
--
ALTER TABLE `tipemodul`
  ADD PRIMARY KEY (`id_tipemodul`);

--
-- Indexes for table `tipequiz`
--
ALTER TABLE `tipequiz`
  ADD PRIMARY KEY (`id_tipequiz`);

--
-- Indexes for table `tipeuser`
--
ALTER TABLE `tipeuser`
  ADD PRIMARY KEY (`id_tipeUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_tipeuser` (`id_tipeuser`),
  ADD KEY `id_jenjang` (`id_jenjang`),
  ADD KEY `id_modul` (`id_modul`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasilquizmodul`
--
ALTER TABLE `hasilquizmodul`
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_soal`
--
ALTER TABLE `jenis_soal`
  MODIFY `id_jenis_soal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenjang`
--
ALTER TABLE `jenjang`
  MODIFY `id_jenjang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logaktivitas`
--
ALTER TABLE `logaktivitas`
  MODIFY `id_logaktivitas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi_video`
--
ALTER TABLE `materi_video`
  MODIFY `id_materi` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id_modul` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pencapaianuser`
--
ALTER TABLE `pencapaianuser`
  MODIFY `id_pencapaian` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pilihan_soal`
--
ALTER TABLE `pilihan_soal`
  MODIFY `id_pilihan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tingkatquiz`
--
ALTER TABLE `tingkatquiz`
  MODIFY `id_tingkatquiz` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipemodul`
--
ALTER TABLE `tipemodul`
  MODIFY `id_tipemodul` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipequiz`
--
ALTER TABLE `tipequiz`
  MODIFY `id_tipequiz` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tipeuser`
--
ALTER TABLE `tipeuser`
  MODIFY `id_tipeUser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `hasilquizmodul`
--
ALTER TABLE `hasilquizmodul`
  ADD CONSTRAINT `hasilquizmodul_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasilquizmodul_ibfk_2` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE;

--
-- Constraints for table `logaktivitas`
--
ALTER TABLE `logaktivitas`
  ADD CONSTRAINT `logaktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `modul`
--
ALTER TABLE `modul`
  ADD CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`id_tipemodul`) REFERENCES `tipemodul` (`id_tipemodul`),
  ADD CONSTRAINT `modul_ibfk_2` FOREIGN KEY (`id_jenjang`) REFERENCES `jenjang` (`id_jenjang`),
  ADD CONSTRAINT `modul_ibfk_3` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE SET NULL;

--
-- Constraints for table `pencapaianuser`
--
ALTER TABLE `pencapaianuser`
  ADD CONSTRAINT `pencapaianuser_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`id_tipequiz`) REFERENCES `tipequiz` (`id_tipequiz`),
  ADD CONSTRAINT `quiz_ibfk_2` FOREIGN KEY (`id_tingkatquiz`) REFERENCES `tingkatquiz` (`id_tingkatquiz`);

--
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_ibfk_1` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE,
  ADD CONSTRAINT `soal_ibfk_2` FOREIGN KEY (`id_jenjang`) REFERENCES `jenjang` (`id_jenjang`),
  ADD CONSTRAINT `soal_ibfk_3` FOREIGN KEY (`id_jenis_soal`) REFERENCES `jenis_soal` (`id_jenis_soal`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_tipeuser`) REFERENCES `tipeuser` (`id_tipeUser`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_jenjang`) REFERENCES `jenjang` (`id_jenjang`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`id_modul`) REFERENCES `modul` (`id_modul`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

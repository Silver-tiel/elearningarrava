-- =====================================================================
-- elearningarrava - VERSI PERBAIKAN
-- Diperbaiki dari dump asli tanggal 18 Sep 2026
--
-- RINGKASAN PERBAIKAN (lihat komentar -- FIX: di setiap bagian):
-- 1. Hapus kolom `user.id_absensi` (circular FK, tidak diperlukan
--    karena relasi absensi->user sudah one-to-many via absensi.id_user)
-- 2. Hapus tabel `users` bawaan Laravel yang tidak dipakai (duplikat
--    dengan tabel `user` custom yang sudah dipakai aplikasi)
-- 3. Ubah `modul.id_quiz` menjadi NULLABLE (modul boleh belum punya quiz)
-- 4. Ubah `soal.jenis_soal` (varchar) -> `soal.id_jenis_soal` (int, FK
--    ke tabel jenis_soal) sesuai ERD, supaya tabel jenis_soal terpakai
-- 5. Tambahkan `created_at` / `updated_at` di semua tabel bisnis utama
--    untuk keperluan audit/tracking data
-- 6. Tambahkan data awal (seed) untuk tabel jenis_soal, tingkatquiz,
--    tipemodul, tipequiz yang sebelumnya kosong (supaya dropdown di
--    aplikasi tidak kosong saat pertama kali dipakai)
-- 7. Perbaiki id_tipeuser yang NULL pada data user id=2
-- 8. Hapus semua tabel bawaan Laravel yang tidak ada di ERD gambar:
--    cache, cache_locks, failed_jobs, jobs, job_batches, migrations,
--    password_reset_tokens, sessions, users.
--    File ini sekarang HANYA berisi 14 tabel sesuai ERD.
--    CATATAN: karena migrations & sessions dihapus, file ini murni
--    untuk struktur data bisnis saja, TIDAK BISA dipakai langsung
--    sebagai database Laravel yang jalan (login session, queue,
--    password reset akan error jika masih pakai Laravel auth bawaan).
-- 9. Tambah kolom foto/gambar (varchar, menyimpan path/nama file):
--    - user.foto_profil   -> foto profil user
--    - quiz.foto_quiz     -> gambar sampul quiz
--    - modul.foto_modul   -> gambar sampul modul
-- =====================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `elearningarrava` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `elearningarrava`;

-- --------------------------------------------------------
-- Tabel wajib Laravel untuk SESSION_DRIVER=database
-- --------------------------------------------------------
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Tabel master (tidak bergantung tabel lain) dibuat lebih dulu
-- --------------------------------------------------------

CREATE TABLE `jenjang` (
  `id_jenjang` int NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `jenjang` (`id_jenjang`, `nama_tipe`) VALUES
(1, 'SD'),
(2, 'SMP'),
(3, 'SMA'),
(4, 'guru'),
(5, 'admin');

-- --------------------------------------------------------

CREATE TABLE `tipeuser` (
  `id_tipeUser` int NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tipeuser` (`id_tipeUser`, `nama_tipe`) VALUES
(1, 'admin'),
(2, 'guru'),
(3, 'siswa');

-- --------------------------------------------------------

CREATE TABLE `tipemodul` (
  `id_tipemodul` int NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- FIX 6: seed data awal supaya tidak kosong
INSERT INTO `tipemodul` (`id_tipemodul`, `nama_tipe`) VALUES
(1, 'Video'),
(2, 'PDF'),
(3, 'Artikel');

-- --------------------------------------------------------

CREATE TABLE `tipequiz` (
  `id_tipequiz` int NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- FIX 6: seed data awal supaya tidak kosong
INSERT INTO `tipequiz` (`id_tipequiz`, `nama_tipe`) VALUES
(1, 'Harian'),
(2, 'Ulangan');

-- --------------------------------------------------------

CREATE TABLE `tingkatquiz` (
  `id_tingkatquiz` int NOT NULL,
  `nama_tingkat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- FIX 6: seed data awal supaya tidak kosong
INSERT INTO `tingkatquiz` (`id_tingkatquiz`, `nama_tingkat`) VALUES
(1, 'Mudah'),
(2, 'Sedang'),
(3, 'Sulit');

-- --------------------------------------------------------

CREATE TABLE `jenis_soal` (
  `id_jenis_soal` int NOT NULL,
  `nama_jenis_soal` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- FIX 6: seed data awal supaya tidak kosong
INSERT INTO `jenis_soal` (`id_jenis_soal`, `nama_jenis_soal`) VALUES
(1, 'Pilihan Ganda'),
(2, 'Essay'),
(3, 'Benar/Salah');

-- --------------------------------------------------------
-- Tabel quiz (butuh tipequiz & tingkatquiz)
-- --------------------------------------------------------

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
-- Tabel modul (butuh tipemodul, jenjang, quiz)
-- FIX 3: id_quiz dibuat NULLABLE, modul boleh belum punya quiz
-- --------------------------------------------------------

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
-- Tabel user (custom, dipakai aplikasi)
-- FIX 1: kolom id_absensi DIHAPUS (circular FK tidak diperlukan;
--        relasi absensi -> user sudah cukup lewat absensi.id_user)
-- --------------------------------------------------------

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

-- FIX 7: id_tipeuser user id=2 yang tadinya NULL, diisi default 3 (siswa)
INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `id_tipeuser`, `id_jenjang`, `total_poin`, `status_akun`, `id_modul`, `foto_profil`) VALUES
(1, 'amru', 'a@gmail.com', '$2y$12$s.9sfbaTB8UJqDEfcr.Aa.IFvgaj0HauclAuMuBdGrJnTREVGUuIu', 1, 1, 0, NULL, NULL, NULL),
(2, 'dd', 'dd@gmail.com', '$2y$12$bMg7QisuoSwdeDo54/4XguqvpKqdPB8MYKLp9x/QDPJzXBC8/dm0W', 3, 1, 0, NULL, NULL, NULL),
(3, 'amru', 'e@gmail.com', '$2y$12$YL5663BruJVMlnyDVMABGOJ8fjLbsb/n8Vyf0eALO01sqJjptsP5G', 1, 2, 0, NULL, NULL, NULL),
(4, '2', 'amru@gmail.com', '$2y$12$rfwsONGAQ7WA6zLnOKpv9.DAzg1wvnV81RP75M0ag5y6a8FNgvV92', 3, 2, 0, NULL, NULL, NULL),
(7, 'rizki', 'rizki@gmail.com', '$2y$12$2OuIcfn3cygbtrtKnRcad.aJZ.DH62nGHvORt4cp91m9onqZcdquq', 1, 2, 0, NULL, NULL, NULL);

-- --------------------------------------------------------
-- Tabel absensi (butuh user)
-- --------------------------------------------------------

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `id_user` int NOT NULL,
  `waktu_absensi` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Tabel soal (butuh quiz, jenis_soal)
-- FIX 4: jenis_soal (varchar) -> id_jenis_soal (int, FK)
-- --------------------------------------------------------

CREATE TABLE `soal` (
  `id_soal` int NOT NULL,
  `id_quiz` int NOT NULL,
  `id_jenis_soal` int DEFAULT NULL,
  `pertanyaan` text NOT NULL,
  `jawaban_benar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Tabel hasilquizmodul (butuh user, quiz)
-- --------------------------------------------------------

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
-- Tabel logaktivitas (butuh user)
-- --------------------------------------------------------

CREATE TABLE `logaktivitas` (
  `id_logaktivitas` int NOT NULL,
  `waktu_kegiataan` datetime NOT NULL,
  `id_user` int NOT NULL,
  `kegiatan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Tabel pencapaianuser (butuh user)
-- --------------------------------------------------------

CREATE TABLE `pencapaianuser` (
  `id_pencapaian` int NOT NULL,
  `id_user` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `waktu_pencapaian` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- =====================================================================
-- PRIMARY KEYS
-- =====================================================================

ALTER TABLE `jenjang`        ADD PRIMARY KEY (`id_jenjang`);
ALTER TABLE `tipeuser`       ADD PRIMARY KEY (`id_tipeUser`);
ALTER TABLE `tipemodul`      ADD PRIMARY KEY (`id_tipemodul`);
ALTER TABLE `tipequiz`       ADD PRIMARY KEY (`id_tipequiz`);
ALTER TABLE `tingkatquiz`    ADD PRIMARY KEY (`id_tingkatquiz`);
ALTER TABLE `jenis_soal`     ADD PRIMARY KEY (`id_jenis_soal`);

ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `id_tipequiz` (`id_tipequiz`),
  ADD KEY `id_tingkatquiz` (`id_tingkatquiz`);

ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`),
  ADD KEY `id_tipemodul` (`id_tipemodul`),
  ADD KEY `id_jenjang` (`id_jenjang`),
  ADD KEY `id_quiz` (`id_quiz`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_tipeuser` (`id_tipeuser`),
  ADD KEY `id_jenjang` (`id_jenjang`),
  ADD KEY `id_modul` (`id_modul`);

ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_user` (`id_user`);

ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `id_quiz` (`id_quiz`),
  ADD KEY `id_jenis_soal` (`id_jenis_soal`);

ALTER TABLE `hasilquizmodul`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_quiz` (`id_quiz`);

ALTER TABLE `logaktivitas`
  ADD PRIMARY KEY (`id_logaktivitas`),
  ADD KEY `id_user` (`id_user`);

ALTER TABLE `pencapaianuser`
  ADD PRIMARY KEY (`id_pencapaian`),
  ADD KEY `id_user` (`id_user`);

-- =====================================================================
-- AUTO_INCREMENT
-- =====================================================================

ALTER TABLE `jenjang`     MODIFY `id_jenjang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `tipeuser`    MODIFY `id_tipeUser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `tipemodul`   MODIFY `id_tipemodul` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `tipequiz`    MODIFY `id_tipequiz` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `tingkatquiz` MODIFY `id_tingkatquiz` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `jenis_soal`  MODIFY `id_jenis_soal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `quiz`        MODIFY `id_quiz` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `modul`       MODIFY `id_modul` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `user`        MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `absensi`     MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `soal`        MODIFY `id_soal` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `hasilquizmodul` MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `logaktivitas`   MODIFY `id_logaktivitas` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `pencapaianuser` MODIFY `id_pencapaian` int NOT NULL AUTO_INCREMENT;

-- =====================================================================
-- FOREIGN KEY CONSTRAINTS
-- (FIX 1: fk_user_absensi dihapus karena kolom user.id_absensi dihapus)
-- =====================================================================

ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`id_tipequiz`) REFERENCES `tipequiz` (`id_tipequiz`),
  ADD CONSTRAINT `quiz_ibfk_2` FOREIGN KEY (`id_tingkatquiz`) REFERENCES `tingkatquiz` (`id_tingkatquiz`);

ALTER TABLE `modul`
  ADD CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`id_tipemodul`) REFERENCES `tipemodul` (`id_tipemodul`),
  ADD CONSTRAINT `modul_ibfk_2` FOREIGN KEY (`id_jenjang`) REFERENCES `jenjang` (`id_jenjang`),
  ADD CONSTRAINT `modul_ibfk_3` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE SET NULL;

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_tipeuser`) REFERENCES `tipeuser` (`id_tipeUser`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_jenjang`) REFERENCES `jenjang` (`id_jenjang`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`id_modul`) REFERENCES `modul` (`id_modul`) ON DELETE SET NULL;

ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

ALTER TABLE `soal`
  ADD CONSTRAINT `soal_ibfk_1` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE,
  ADD CONSTRAINT `soal_ibfk_2` FOREIGN KEY (`id_jenis_soal`) REFERENCES `jenis_soal` (`id_jenis_soal`);

ALTER TABLE `hasilquizmodul`
  ADD CONSTRAINT `hasilquizmodul_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasilquizmodul_ibfk_2` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE;

ALTER TABLE `logaktivitas`
  ADD CONSTRAINT `logaktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

ALTER TABLE `pencapaianuser`
  ADD CONSTRAINT `pencapaianuser_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- Skrip Pembersihan Dungeon & Mapel Tidak Terpakai
-- Jalankan di phpMyAdmin atau MySQL CLI jika Laragon MySQL sudah aktif

START TRANSACTION;

-- 1. Kumpulkan ID Kuis yang tidak terpakai ke tabel sementara
DROP TEMPORARY TABLE IF EXISTS tmp_unused_quiz;
CREATE TEMPORARY TABLE tmp_unused_quiz AS
SELECT id_quiz FROM quiz
WHERE id_mapel IS NULL
   OR id_mapel NOT IN (1, 2, 3, 4, 5, 11, 12, 13)
   OR (id_jenjang = 3 AND id_mapel IN (4, 5))
   OR judul LIKE '%Pendidikan Agama%'
   OR judul LIKE '%Pendidikan Pancasila%'
   OR judul LIKE '%PJOK%'
   OR judul LIKE '%Sejarah Indonesia%';

-- 2. Kumpulkan ID Soal yang tidak terpakai
DROP TEMPORARY TABLE IF EXISTS tmp_unused_soal;
CREATE TEMPORARY TABLE tmp_unused_soal AS
SELECT id_soal FROM soal
WHERE id_quiz IN (SELECT id_quiz FROM tmp_unused_quiz)
   OR (id_quiz IS NULL AND (
        id_mapel IS NULL 
        OR id_mapel NOT IN (1, 2, 3, 4, 5, 11, 12, 13)
        OR (id_jenjang = 3 AND id_mapel IN (4, 5))
   ));

-- 3. Hapus relasi anak soal
DELETE FROM dungeon_sesi_soal WHERE id_soal IN (SELECT id_soal FROM tmp_unused_soal);
DELETE FROM dungeon_riwayat_soal WHERE id_soal IN (SELECT id_soal FROM tmp_unused_soal);
DELETE FROM dungeon_laporan_soal WHERE id_soal IN (SELECT id_soal FROM tmp_unused_soal);
DELETE FROM pilihan_soal WHERE id_soal IN (SELECT id_soal FROM tmp_unused_soal);

-- Putuskan parent_soal_id jika ada
UPDATE soal SET parent_soal_id = NULL WHERE parent_soal_id IN (SELECT id_soal FROM tmp_unused_soal);

-- Hapus soal
DELETE FROM soal WHERE id_soal IN (SELECT id_soal FROM tmp_unused_soal);

-- 4. Hapus sesi dungeon tidak aktif
DELETE FROM dungeon_sesi 
WHERE id_mapel NOT IN (1, 2, 3, 4, 5, 11, 12, 13)
   OR (id_jenjang = 3 AND id_mapel IN (4, 5));

-- 5. Hapus riwayat quiz & putuskan modul
DELETE FROM hasilquizmodul WHERE id_quiz IN (SELECT id_quiz FROM tmp_unused_quiz);
UPDATE modul SET id_quiz = NULL WHERE id_quiz IN (SELECT id_quiz FROM tmp_unused_quiz);

-- Hapus quiz
DELETE FROM quiz WHERE id_quiz IN (SELECT id_quiz FROM tmp_unused_quiz);

-- 6. Hapus mapel tidak terpakai
DELETE FROM mapel WHERE id_mapel NOT IN (1, 2, 3, 4, 5, 11, 12, 13);

COMMIT;

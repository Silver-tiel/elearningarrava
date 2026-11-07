<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $mapels = [
            // Mapel Umum / Lintas Jenjang
            ['id_mapel' => 1, 'nama_mapel' => 'Matematika', 'id_jenjang' => null, 'deskripsi' => 'Pelajaran matematika, logika berhitung, dan geometri.', 'icon' => 'calculator', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 2, 'nama_mapel' => 'Bahasa Indonesia', 'id_jenjang' => null, 'deskripsi' => 'Tata bahasa, literasi, dan sastra Indonesia.', 'icon' => 'book-open', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 3, 'nama_mapel' => 'Bahasa Inggris', 'id_jenjang' => null, 'deskripsi' => 'Komunikasi, tata bahasa, dan kosakata bahasa Inggris.', 'icon' => 'globe', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 4, 'nama_mapel' => 'Ilmu Pengetahuan Alam (IPA)', 'id_jenjang' => null, 'deskripsi' => 'Sains dasar, makhluk hidup, alam, dan lingkungan sekitar.', 'icon' => 'flask', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 5, 'nama_mapel' => 'Ilmu Pengetahuan Sosial (IPS)', 'id_jenjang' => null, 'deskripsi' => 'Masyarakat, geografi dasar, sejarah, dan ekonomi.', 'icon' => 'users', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 6, 'nama_mapel' => 'Pendidikan Pancasila & Kewarganegaraan', 'id_jenjang' => null, 'deskripsi' => 'Nilai-nilai Pancasila, hukum, dan kewarganegaraan.', 'icon' => 'shield', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 7, 'nama_mapel' => 'Pendidikan Agama & Budi Pekerti', 'id_jenjang' => null, 'deskripsi' => 'Pembentukan karakter, moral, dan ajaran agama.', 'icon' => 'sun', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 8, 'nama_mapel' => 'Informatika & TIK', 'id_jenjang' => null, 'deskripsi' => 'Teknologi informasi, komputasi, dan literasi digital.', 'icon' => 'cpu', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 9, 'nama_mapel' => 'Seni Budaya & Prakarya', 'id_jenjang' => null, 'deskripsi' => 'Kesenian, kerajinan tangan, dan apresiasi budaya.', 'icon' => 'palette', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 10, 'nama_mapel' => 'PJOK (Olahraga)', 'id_jenjang' => null, 'deskripsi' => 'Pendidikan jasmani, olahraga, kebugaran, dan kesehatan.', 'icon' => 'activity', 'created_at' => $now, 'updated_at' => $now],

            // Mapel Peminatan SMA (id_jenjang = 3)
            ['id_mapel' => 11, 'nama_mapel' => 'Fisika', 'id_jenjang' => 3, 'deskripsi' => 'Hukum gerak, energi, gelombang, dan kelistrikan.', 'icon' => 'zap', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 12, 'nama_mapel' => 'Kimia', 'id_jenjang' => 3, 'deskripsi' => 'Struktur zat, reaksi kimia, dan unsur periodik.', 'icon' => 'droplet', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 13, 'nama_mapel' => 'Biologi', 'id_jenjang' => 3, 'deskripsi' => 'Keanekaragaman hayati, sel, genetika, dan ekosistem.', 'icon' => 'heart', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 14, 'nama_mapel' => 'Ekonomi & Akuntansi', 'id_jenjang' => 3, 'deskripsi' => 'Perilaku pasar, manajemen keuangan, dan pembukuan.', 'icon' => 'dollar-sign', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 15, 'nama_mapel' => 'Geografi', 'id_jenjang' => 3, 'deskripsi' => 'Pemetaan wilayah, iklim, dinamika bumi, dan geosfer.', 'icon' => 'map', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 16, 'nama_mapel' => 'Sosiologi', 'id_jenjang' => 3, 'deskripsi' => 'Hubungan antar manusia, stratifikasi, dan perubahan sosial.', 'icon' => 'message-circle', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 17, 'nama_mapel' => 'Sejarah Indonesia', 'id_jenjang' => null, 'deskripsi' => 'Peristiwa penting, perjuangan kemerdekaan, dan sejarah nasional.', 'icon' => 'clock', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('mapel')->insertOrIgnore($mapels);
    }
}


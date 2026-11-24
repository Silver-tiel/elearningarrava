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
            // Mapel Umum / Lintas Jenjang (SD, SMP, SMA)
            ['id_mapel' => 1, 'nama_mapel' => 'Matematika', 'id_jenjang' => null, 'deskripsi' => 'Pelajaran matematika, logika berhitung, dan geometri.', 'icon' => 'calculator', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 2, 'nama_mapel' => 'Bahasa Indonesia', 'id_jenjang' => null, 'deskripsi' => 'Tata bahasa, literasi, dan sastra Indonesia.', 'icon' => 'book-open', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 3, 'nama_mapel' => 'Bahasa Inggris', 'id_jenjang' => null, 'deskripsi' => 'Komunikasi, tata bahasa, dan kosakata bahasa Inggris.', 'icon' => 'globe', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 4, 'nama_mapel' => 'Ilmu Pengetahuan Alam (IPA)', 'id_jenjang' => null, 'deskripsi' => 'Sains dasar, makhluk hidup, alam, dan lingkungan sekitar.', 'icon' => 'flask', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 5, 'nama_mapel' => 'Ilmu Pengetahuan Sosial (IPS)', 'id_jenjang' => null, 'deskripsi' => 'Masyarakat, geografi dasar, sejarah, dan ekonomi.', 'icon' => 'users', 'created_at' => $now, 'updated_at' => $now],

            // Mapel Spesialisasi SMA (Fisika, Kimia, Biologi - pemisahan dari IPA)
            ['id_mapel' => 11, 'nama_mapel' => 'Fisika', 'id_jenjang' => 3, 'deskripsi' => 'Hukum gerak, energi, gelombang, dan kelistrikan.', 'icon' => 'zap', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 12, 'nama_mapel' => 'Kimia', 'id_jenjang' => 3, 'deskripsi' => 'Struktur zat, reaksi kimia, dan unsur periodik.', 'icon' => 'droplet', 'created_at' => $now, 'updated_at' => $now],
            ['id_mapel' => 13, 'nama_mapel' => 'Biologi', 'id_jenjang' => 3, 'deskripsi' => 'Keanekaragaman hayati, sel, genetika, dan ekosistem.', 'icon' => 'heart', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('mapel')->insertOrIgnore($mapels);
    }
}


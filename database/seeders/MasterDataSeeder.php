<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('jenjang')->insertOrIgnore([
            ['id_jenjang' => 1, 'nama_tipe' => 'SD', 'created_at' => $now, 'updated_at' => $now],
            ['id_jenjang' => 2, 'nama_tipe' => 'SMP', 'created_at' => $now, 'updated_at' => $now],
            ['id_jenjang' => 3, 'nama_tipe' => 'SMA', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('tipeuser')->insertOrIgnore([
            ['id_tipeUser' => 1, 'nama_tipe' => 'admin', 'created_at' => $now, 'updated_at' => $now],
            ['id_tipeUser' => 2, 'nama_tipe' => 'guru', 'created_at' => $now, 'updated_at' => $now],
            ['id_tipeUser' => 3, 'nama_tipe' => 'siswa', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('tipemodul')->insertOrIgnore([
            ['id_tipemodul' => 1, 'nama_tipe' => 'Video', 'created_at' => $now, 'updated_at' => $now],
            ['id_tipemodul' => 2, 'nama_tipe' => 'PDF', 'created_at' => $now, 'updated_at' => $now],
            ['id_tipemodul' => 3, 'nama_tipe' => 'Artikel', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('tipequiz')->insertOrIgnore([
            ['id_tipequiz' => 1, 'nama_tipe' => 'Harian', 'created_at' => $now, 'updated_at' => $now],
            ['id_tipequiz' => 2, 'nama_tipe' => 'Ulangan', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('tingkatquiz')->insertOrIgnore([
            ['id_tingkatquiz' => 1, 'nama_tingkat' => 'Mudah', 'created_at' => $now, 'updated_at' => $now],
            ['id_tingkatquiz' => 2, 'nama_tingkat' => 'Sedang', 'created_at' => $now, 'updated_at' => $now],
            ['id_tingkatquiz' => 3, 'nama_tingkat' => 'Sulit', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('jenis_soal')->insertOrIgnore([
            ['id_jenis_soal' => 1, 'nama_jenis_soal' => 'Pilihan Ganda', 'created_at' => $now, 'updated_at' => $now],
            ['id_jenis_soal' => 2, 'nama_jenis_soal' => 'Essay', 'created_at' => $now, 'updated_at' => $now],
            ['id_jenis_soal' => 3, 'nama_jenis_soal' => 'Benar/Salah', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

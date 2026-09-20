<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenjang')->insert([
            ['id_jenjang' => 1, 'nama_tipe' => 'SD'],
            ['id_jenjang' => 2, 'nama_tipe' => 'SMP'],
            ['id_jenjang' => 3, 'nama_tipe' => 'SMA'],
            ['id_jenjang' => 4, 'nama_tipe' => 'guru'],
            ['id_jenjang' => 5, 'nama_tipe' => 'admin'],
        ]);

        DB::table('tipeuser')->insert([
            ['id_tipeUser' => 1, 'nama_tipe' => 'admin'],
            ['id_tipeUser' => 2, 'nama_tipe' => 'guru'],
            ['id_tipeUser' => 3, 'nama_tipe' => 'siswa'],
        ]);

        DB::table('tipemodul')->insert([
            ['id_tipemodul' => 1, 'nama_tipe' => 'Video'],
            ['id_tipemodul' => 2, 'nama_tipe' => 'PDF'],
            ['id_tipemodul' => 3, 'nama_tipe' => 'Artikel'],
        ]);

        DB::table('tipequiz')->insert([
            ['id_tipequiz' => 1, 'nama_tipe' => 'Harian'],
            ['id_tipequiz' => 2, 'nama_tipe' => 'Ulangan'],
        ]);

        DB::table('tingkatquiz')->insert([
            ['id_tingkatquiz' => 1, 'nama_tingkat' => 'Mudah'],
            ['id_tingkatquiz' => 2, 'nama_tingkat' => 'Sedang'],
            ['id_tingkatquiz' => 3, 'nama_tingkat' => 'Sulit'],
        ]);

        DB::table('jenis_soal')->insert([
            ['id_jenis_soal' => 1, 'nama_jenis_soal' => 'Pilihan Ganda'],
            ['id_jenis_soal' => 2, 'nama_jenis_soal' => 'Essay'],
            ['id_jenis_soal' => 3, 'nama_jenis_soal' => 'Benar/Salah'],
        ]);
    }
}

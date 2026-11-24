<?php

namespace Database\Seeders;

use App\Models\TingkatKelas;
use Illuminate\Database\Seeder;

class TingkatKelasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // SD (id_jenjang: 1)
            ['id_jenjang' => 1, 'nama' => 'Kelas 1', 'urutan' => 1, 'aktif' => true],
            ['id_jenjang' => 1, 'nama' => 'Kelas 2', 'urutan' => 2, 'aktif' => true],
            ['id_jenjang' => 1, 'nama' => 'Kelas 3', 'urutan' => 3, 'aktif' => true],
            ['id_jenjang' => 1, 'nama' => 'Kelas 4', 'urutan' => 4, 'aktif' => true],
            ['id_jenjang' => 1, 'nama' => 'Kelas 5', 'urutan' => 5, 'aktif' => true],
            ['id_jenjang' => 1, 'nama' => 'Kelas 6', 'urutan' => 6, 'aktif' => true],

            // SMP (id_jenjang: 2)
            ['id_jenjang' => 2, 'nama' => 'Kelas 7', 'urutan' => 7, 'aktif' => true],
            ['id_jenjang' => 2, 'nama' => 'Kelas 8', 'urutan' => 8, 'aktif' => true],
            ['id_jenjang' => 2, 'nama' => 'Kelas 9', 'urutan' => 9, 'aktif' => true],

            // SMA (id_jenjang: 3)
            ['id_jenjang' => 3, 'nama' => 'Kelas 10', 'urutan' => 10, 'aktif' => true],
            ['id_jenjang' => 3, 'nama' => 'Kelas 11', 'urutan' => 11, 'aktif' => true],
            ['id_jenjang' => 3, 'nama' => 'Kelas 12', 'urutan' => 12, 'aktif' => true],
        ];

        foreach ($data as $item) {
            TingkatKelas::firstOrCreate(
                [
                    'id_jenjang' => $item['id_jenjang'],
                    'nama' => $item['nama'],
                ],
                [
                    'urutan' => $item['urutan'],
                    'aktif' => $item['aktif'],
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\CatatanModul;
use App\Models\Modul;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulSeeder extends Seeder
{
    public function run(): void
    {
        $moduls = [
            [
                'judul_modul' => 'Dasar-Dasar Matematika SD',
                'id_jenjang' => 1,
                'id_tipemodul' => 1,
                'file_materi' => 'https://youtu.be/P88N7DmPiX8?si=9GP0EDNTi1TXBXVu',
                'tipe_file' => 'link',
                'progressModul' => 'Tersedia',
                'catatan' => [
                    [
                        'judul' => 'Rangkuman Penjumlahan Dasar',
                        'isi' => 'Penjumlahan adalah operasi aritmatika dasar menggabungkan dua bilangan atau lebih.',
                        'urutan' => 1,
                    ],
                ],
            ],
            [
                'judul_modul' => 'Ilmu Pengetahuan Alam SMP: Ekosistem',
                'id_jenjang' => 2,
                'id_tipemodul' => 1,
                'file_materi' => 'https://youtu.be/IVm9sgRVp-0?si=ABHhq7avku8nfHQj',
                'tipe_file' => 'link',
                'progressModul' => 'Tersedia',
                'catatan' => [
                    [
                        'judul' => 'Poin Kunci Komponen Ekosistem',
                        'isi' => 'Komponen biotik mencakup produsen, konsumen, dan dekomposer.',
                        'urutan' => 1,
                    ],
                ],
            ],
            [
                'judul_modul' => 'Fisika SMA: Kinematika Gerak Lurus',
                'id_jenjang' => 3,
                'id_tipemodul' => 1,
                'file_materi' => 'https://youtu.be/5ikiX0gv5w4?si=Uz2COASiezVgFUvh',
                'tipe_file' => 'link',
                'progressModul' => 'Tersedia',
                'catatan' => [
                    [
                        'judul' => 'Rumus Utama GLB & GLBB',
                        'isi' => 'GLB: s = v * t. GLBB: vt = v0 + a * t, s = v0 * t + 0.5 * a * t^2.',
                        'urutan' => 1,
                    ],
                ],
            ],
        ];

        DB::transaction(function () use ($moduls) {
            foreach ($moduls as $data) {
                $catatanList = $data['catatan'] ?? [];
                unset($data['catatan']);

                $quizTerkait = Quiz::where('id_jenjang', $data['id_jenjang'])->first();
                $data['id_quiz'] = $quizTerkait?->id_quiz;

                $modul = Modul::firstOrCreate(
                    ['judul_modul' => $data['judul_modul']],
                    $data
                );

                foreach ($catatanList as $catatan) {
                    CatatanModul::firstOrCreate(
                        [
                            'id_modul' => $modul->id_modul,
                            'judul' => $catatan['judul'],
                        ],
                        [
                            'isi' => $catatan['isi'],
                            'urutan' => $catatan['urutan'],
                        ]
                    );
                }
            }
        });
    }
}

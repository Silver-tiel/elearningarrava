<?php

namespace Database\Seeders;

use App\Models\CatatanModul;
use App\Models\MateriVideo;
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
                'file_materi' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'tipe_file' => 'link',
                'progressModul' => 'Tersedia',
                'videos' => [
                    [
                        'judul' => 'Pengenalan Bilangan dan Penjumlahan',
                        'deskripsi' => 'Materi pengenalan bilangan bulat dasar dan operasi penjumlahan.',
                        'file_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'durasi' => '10:00',
                        'urutan' => 1,
                    ],
                ],
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
                'file_materi' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'tipe_file' => 'link',
                'progressModul' => 'Tersedia',
                'videos' => [
                    [
                        'judul' => 'Interaksi Makhluk Hidup dengan Lingkungan',
                        'deskripsi' => 'Pelajari komponen biotik dan abiotik dalam rantai makanan.',
                        'file_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'durasi' => '12:30',
                        'urutan' => 1,
                    ],
                ],
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
                'file_materi' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'tipe_file' => 'link',
                'progressModul' => 'Tersedia',
                'videos' => [
                    [
                        'judul' => 'Gerak Lurus Beraturan (GLB) & GLBB',
                        'deskripsi' => 'Konsep kecepatan konstan dan percepatan konstan pada lintasan lurus.',
                        'file_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'durasi' => '15:00',
                        'urutan' => 1,
                    ],
                ],
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
                $videos = $data['videos'] ?? [];
                $catatanList = $data['catatan'] ?? [];
                unset($data['videos'], $data['catatan']);

                $quizTerkait = Quiz::where('id_jenjang', $data['id_jenjang'])->first();
                $data['id_quiz'] = $quizTerkait?->id_quiz;

                $modul = Modul::firstOrCreate(
                    ['judul_modul' => $data['judul_modul']],
                    $data
                );

                foreach ($videos as $video) {
                    MateriVideo::firstOrCreate(
                        [
                            'id_modul' => $modul->id_modul,
                            'judul' => $video['judul'],
                        ],
                        [
                            'deskripsi' => $video['deskripsi'],
                            'file_video' => $video['file_video'],
                            'durasi' => $video['durasi'],
                            'urutan' => $video['urutan'],
                            'status' => 'aktif',
                        ]
                    );
                }

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

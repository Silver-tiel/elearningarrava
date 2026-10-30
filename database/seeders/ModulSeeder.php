<?php

namespace Database\Seeders;

use App\Models\CatatanModul;
use App\Models\Modul;
use App\Models\ModulSoal;
use App\Models\ModulSoalPilihan;
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
                'soal_modul' => [
                    [
                        'pertanyaan' => 'Berapakah hasil dari operasi penjumlahan 45 + 55?',
                        'poin' => 10,
                        'urutan' => 1,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => '90', 'is_benar' => false],
                            ['label' => 'B', 'teks_pilihan' => '100', 'is_benar' => true],
                            ['label' => 'C', 'teks_pilihan' => '110', 'is_benar' => false],
                            ['label' => 'D', 'teks_pilihan' => '80', 'is_benar' => false],
                        ],
                    ],
                    [
                        'pertanyaan' => 'Berapakah hasil operasi perkalian dari 7 x 8?',
                        'poin' => 10,
                        'urutan' => 2,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => '48', 'is_benar' => false],
                            ['label' => 'B', 'teks_pilihan' => '54', 'is_benar' => false],
                            ['label' => 'C', 'teks_pilihan' => '56', 'is_benar' => true],
                            ['label' => 'D', 'teks_pilihan' => '64', 'is_benar' => false],
                        ],
                    ],
                    [
                        'pertanyaan' => 'Bangun datar yang memiliki 4 sisi sama panjang dan 4 sudut siku-siku adalah...',
                        'poin' => 10,
                        'urutan' => 3,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Persegi', 'is_benar' => true],
                            ['label' => 'B', 'teks_pilihan' => 'Segitiga', 'is_benar' => false],
                            ['label' => 'C', 'teks_pilihan' => 'Trapesium', 'is_benar' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Jajar Genjang', 'is_benar' => false],
                        ],
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
                'soal_modul' => [
                    [
                        'pertanyaan' => 'Organisme yang mampu memproduksi makanannya sendiri melalui proses fotosintesis disebut...',
                        'poin' => 10,
                        'urutan' => 1,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Konsumen', 'is_benar' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Produsen', 'is_benar' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Pengurai', 'is_benar' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Predator', 'is_benar' => false],
                        ],
                    ],
                    [
                        'pertanyaan' => 'Hubungan timbal balik antara makhluk hidup dengan komponen lingkungannya disebut...',
                        'poin' => 10,
                        'urutan' => 2,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Habitat', 'is_benar' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Ekosistem', 'is_benar' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Komunitas', 'is_benar' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Bioma', 'is_benar' => false],
                        ],
                    ],
                    [
                        'pertanyaan' => 'Bakteri pembusuk dan jamur dalam suatu rantai makanan berperan penting sebagai...',
                        'poin' => 10,
                        'urutan' => 3,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Produsen', 'is_benar' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Dekomposer (Pengurai)', 'is_benar' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Konsumen Puncak', 'is_benar' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Karnivora', 'is_benar' => false],
                        ],
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
                'soal_modul' => [
                    [
                        'pertanyaan' => 'Pada Gerak Lurus Beraturan (GLB), besaran fisika yang bernilai konstan atau tetap adalah...',
                        'poin' => 10,
                        'urutan' => 1,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Percepatan', 'is_benar' => false],
                            ['label' => 'B', 'teks_pilihan' => 'Kecepatan', 'is_benar' => true],
                            ['label' => 'C', 'teks_pilihan' => 'Posisi', 'is_benar' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Gaya', 'is_benar' => false],
                        ],
                    ],
                    [
                        'pertanyaan' => 'Sebuah mobil melaju dengan kecepatan tetap 20 m/s selama 10 detik. Jarak tempuh mobil tersebut adalah...',
                        'poin' => 10,
                        'urutan' => 2,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => '100 meter', 'is_benar' => false],
                            ['label' => 'B', 'teks_pilihan' => '200 meter', 'is_benar' => true],
                            ['label' => 'C', 'teks_pilihan' => '300 meter', 'is_benar' => false],
                            ['label' => 'D', 'teks_pilihan' => '400 meter', 'is_benar' => false],
                        ],
                    ],
                    [
                        'pertanyaan' => 'Satuan internasional (SI) standar yang digunakan untuk menyatakan percepatan adalah...',
                        'poin' => 10,
                        'urutan' => 3,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'm/s', 'is_benar' => false],
                            ['label' => 'B', 'teks_pilihan' => 'm/s²', 'is_benar' => true],
                            ['label' => 'C', 'teks_pilihan' => 'km/jam', 'is_benar' => false],
                            ['label' => 'D', 'teks_pilihan' => 'Joule', 'is_benar' => false],
                        ],
                    ],
                ],
            ],
        ];

        DB::transaction(function () use ($moduls) {
            foreach ($moduls as $data) {
                $catatanList = $data['catatan'] ?? [];
                $soalList = $data['soal_modul'] ?? [];
                unset($data['catatan'], $data['soal_modul']);

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

                // Buat soal kuis evaluasi modul
                foreach ($soalList as $sData) {
                    $pilihanList = $sData['pilihan'] ?? [];
                    unset($sData['pilihan']);

                    $sData['id_modul'] = $modul->id_modul;

                    $soal = ModulSoal::firstOrCreate(
                        [
                            'id_modul' => $modul->id_modul,
                            'pertanyaan' => $sData['pertanyaan'],
                        ],
                        $sData
                    );

                    foreach ($pilihanList as $pData) {
                        ModulSoalPilihan::firstOrCreate(
                            [
                                'id_soal' => $soal->id_soal,
                                'label' => $pData['label'],
                            ],
                            [
                                'teks_pilihan' => $pData['teks_pilihan'],
                                'is_benar' => $pData['is_benar'],
                            ]
                        );
                    }
                }
            }
        });
    }
}

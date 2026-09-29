<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\PilihanSoal;
use App\Models\Jenjang;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tabel jenjang memiliki data 1 sampai 3 (SD, SMP, SMA)
        $jenjangIds = [1, 2, 3];
        $namaJenjang = [
            1 => 'SD',
            2 => 'SMP',
            3 => 'SMA'
        ];

        DB::transaction(function () use ($jenjangIds, $namaJenjang) {
            foreach ($jenjangIds as $idJenjang) {
                // Buat 3 Quiz per Jenjang
                for ($i = 1; $i <= 3; $i++) {
                    $quiz = Quiz::create([
                        'judul' => 'Quiz Latihan ' . $i . ' - ' . $namaJenjang[$idJenjang],
                        'id_jenjang' => $idJenjang,
                        'id_tipequiz' => 1,
                        'id_tingkatquiz' => $i, // 1: Mudah, 2: Sedang, 3: Sulit
                        'mode_pengerjaan' => 'wayground',
                        'durasi_total_menit' => null,
                        'proggressQuiz' => 'Tersedia',
                        'waktu_kadaluarsa' => null,
                    ]);

                    // Tambahkan 2 Soal untuk setiap quiz

                    // Soal 1: Pilihan Ganda (id_jenis_soal = 1)
                    $soal1 = Soal::create([
                        'id_quiz' => $quiz->id_quiz,
                        'id_jenjang' => $idJenjang,
                        'id_jenis_soal' => 1,
                        'pertanyaan' => 'Apa ibukota dari Indonesia? (Soal Pilihan Ganda untuk ' . $namaJenjang[$idJenjang] . ')',
                        'jawaban_benar' => 'A',
                        'poin' => 10,
                        'durasi_detik' => 20,
                    ]);

                    $pilihanGanda = [
                        ['label' => 'A', 'teks_pilihan' => 'Jakarta', 'is_correct' => true],
                        ['label' => 'B', 'teks_pilihan' => 'Bandung', 'is_correct' => false],
                        ['label' => 'C', 'teks_pilihan' => 'Surabaya', 'is_correct' => false],
                        ['label' => 'D', 'teks_pilihan' => 'Medan', 'is_correct' => false],
                    ];

                    foreach ($pilihanGanda as $pilihan) {
                        PilihanSoal::create([
                            'id_soal' => $soal1->id_soal,
                            'label' => $pilihan['label'],
                            'teks_pilihan' => $pilihan['teks_pilihan'],
                            'is_correct' => $pilihan['is_correct'],
                        ]);
                    }

                    // Soal 2: Benar/Salah (id_jenis_soal = 3)
                    $soal2 = Soal::create([
                        'id_quiz' => $quiz->id_quiz,
                        'id_jenjang' => $idJenjang,
                        'id_jenis_soal' => 3,
                        'pertanyaan' => 'Matahari terbit dari sebelah barat. (Benar/Salah)',
                        'jawaban_benar' => 'B', // B untuk Salah
                        'poin' => 10,
                        'durasi_detik' => 10,
                    ]);

                    $pilihanBenarSalah = [
                        ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => false],
                        ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => true],
                    ];

                    foreach ($pilihanBenarSalah as $pilihan) {
                        PilihanSoal::create([
                            'id_soal' => $soal2->id_soal,
                            'label' => $pilihan['label'],
                            'teks_pilihan' => $pilihan['teks_pilihan'],
                            'is_correct' => $pilihan['is_correct'],
                        ]);
                    }
                }
            }
        });
    }
}

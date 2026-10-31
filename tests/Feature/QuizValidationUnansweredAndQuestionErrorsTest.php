<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\PilihanSoal;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;

class QuizValidationUnansweredAndQuestionErrorsTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_kuis_mode_biasa_ditolak_jika_ada_soal_yang_belum_dijawab(): void
    {
        $this->seed(MasterDataSeeder::class);

        $siswa = User::create([
            'nama' => 'Siswa Normal Mode',
            'email' => 'siswa-normal@example.com',
            'nisn' => '1122334455',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'total_poin' => 0,
        ]);

        $quizBiasa = Quiz::create([
            'judul' => 'Kuis Mode Biasa 3 Soal',
            'id_jenjang' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 20,
            'proggressQuiz' => 'Tersedia',
        ]);

        $soal1 = Soal::create([
            'id_quiz' => $quizBiasa->id_quiz,
            'id_jenjang' => 1,
            'pertanyaan' => 'Soal nomor satu?',
            'jawaban_benar' => 'A',
            'poin' => 10,
        ]);
        PilihanSoal::create(['id_soal' => $soal1->id_soal, 'label' => 'A', 'teks_pilihan' => 'Ya', 'is_correct' => true]);
        PilihanSoal::create(['id_soal' => $soal1->id_soal, 'label' => 'B', 'teks_pilihan' => 'Tidak', 'is_correct' => false]);

        $soal2 = Soal::create([
            'id_quiz' => $quizBiasa->id_quiz,
            'id_jenjang' => 1,
            'pertanyaan' => 'Soal nomor dua?',
            'jawaban_benar' => 'B',
            'poin' => 10,
        ]);
        PilihanSoal::create(['id_soal' => $soal2->id_soal, 'label' => 'A', 'teks_pilihan' => 'Mungkin', 'is_correct' => false]);
        PilihanSoal::create(['id_soal' => $soal2->id_soal, 'label' => 'B', 'teks_pilihan' => 'Pasti', 'is_correct' => true]);

        // Simulasikan siswa memulai kuis
        $attemptKey = 'quiz_attempt.' . $siswa->id_user . '.' . $quizBiasa->id_quiz;
        session([$attemptKey => now()->timestamp]);

        // Siswa hanya menjawab soal 1, soal 2 dikosongkan
        $response = $this->actingAs($siswa)
            ->from(route('siswa.quiz.kerjakan', $quizBiasa->id_quiz))
            ->post(route('siswa.quiz.submit', $quizBiasa->id_quiz), [
                'jawaban' => [
                    $soal1->id_soal => 'A',
                    // soal 2 sengaja tidak diisi
                ],
                'is_timeout' => '0',
            ]);

        // Harus dialihkan kembali dengan pesan error menyebutkan soal nomor 2
        $response->assertRedirect(route('siswa.quiz.kerjakan', $quizBiasa->id_quiz));
        $response->assertSessionHasErrors(['quiz']);
        
        $errorMsg = session('errors')->first('quiz');
        $this->assertStringContainsString('nomor 2 belum dijawab', $errorMsg);

        // Jika semua soal telah dijawab, submit berhasil
        $responseSukses = $this->actingAs($siswa)
            ->post(route('siswa.quiz.submit', $quizBiasa->id_quiz), [
                'jawaban' => [
                    $soal1->id_soal => 'A',
                    $soal2->id_soal => 'B',
                ],
                'is_timeout' => '0',
            ]);

        $responseSukses->assertSessionHas('quiz_result');
    }

    public function test_error_validasi_tambah_soal_menyebutkan_nomor_soal(): void
    {
        $this->seed(MasterDataSeeder::class);

        $admin = User::create([
            'nama' => 'Admin Penguji',
            'email' => 'admin-val@example.com',
            'nisn' => '9998887776',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);

        // Kirim request buat kuis dengan Soal #2 memiliki kesalahan (pertanyaan kosong / pilihan tidak lengkap)
        $response = $this->actingAs($admin)
            ->post(route('admin.quiz.store'), [
                'action_type' => 'publish',
                'judul' => 'Quiz Uji Error Nomor Soal',
                'id_jenjang' => 1,
                'id_tipequiz' => 1,
                'id_tingkatquiz' => 1,
                'mode_pengerjaan' => 'biasa',
                'durasi_total_menit' => 30,
                'soal' => [
                    // Soal 1 valid
                    [
                        'jenis_soal' => 'kuis',
                        'pertanyaan' => 'Pertanyaan soal pertama?',
                        'poin' => 10,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Opsi A', 'is_correct' => 1],
                            ['label' => 'B', 'teks_pilihan' => 'Opsi B', 'is_correct' => 0],
                        ],
                    ],
                    // Soal 2 tidak valid (pilihan ganda tidak punya kunci jawaban)
                    [
                        'jenis_soal' => 'kuis',
                        'pertanyaan' => 'Pertanyaan soal kedua tanpa kunci?',
                        'poin' => 10,
                        'pilihan' => [
                            ['label' => 'A', 'teks_pilihan' => 'Opsi A', 'is_correct' => 0],
                            ['label' => 'B', 'teks_pilihan' => 'Opsi B', 'is_correct' => 0],
                        ],
                    ],
                ],
            ]);

        $response->assertSessionHasErrors();
        $allErrors = session('errors')->all();

        // Cari error yang menyebutkan Soal #2
        $hasSoal2Error = false;
        foreach ($allErrors as $msg) {
            if (str_contains($msg, 'Soal #2:')) {
                $hasSoal2Error = true;
                break;
            }
        }

        $this->assertTrue($hasSoal2Error, "Pesan error harus secara spesifik menyebutkan 'Soal #2:'");
    }
}

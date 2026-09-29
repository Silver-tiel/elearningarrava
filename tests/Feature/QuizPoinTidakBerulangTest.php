<?php

namespace Tests\Feature;

use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QuizPoinTidakBerulangTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_hanya_mendapatkan_poin_satu_kali_per_quiz_meski_mengerjakan_ulang(): void
    {
        DB::table('jenjang')->insert([
            'id_jenjang' => 1,
            'nama_tipe' => 'SMA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tipeuser')->insert([
            'id_tipeUser' => 3,
            'nama_tipe' => 'Siswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tipequiz')->insert([
            'id_tipequiz' => 1,
            'nama_tipe' => 'Latihan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tingkatquiz')->insert([
            'id_tingkatquiz' => 1,
            'nama_tingkat' => 'Dasar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::create([
            'nama' => 'Siswa Test',
            'email' => 'siswa@example.com',
            'nisn' => '1000000001',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Quiz Uji Coba',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'id_jenjang' => 1,
            'waktu_kadaluarsa' => now()->addDay(),
            'hasil_quiz' => 'Selesai',
            'proggressQuiz' => 'Tersedia',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'pertanyaan' => '2 + 2 = ?',
            'jawaban_benar' => 'A',
            'poin' => 10,
        ]);

        PilihanSoal::create([
            'id_soal' => $soal->id_soal,
            'label' => 'A',
            'teks_pilihan' => '4',
            'is_correct' => true,
        ]);

        PilihanSoal::create([
            'id_soal' => $soal->id_soal,
            'label' => 'B',
            'teks_pilihan' => '5',
            'is_correct' => false,
        ]);

        $this->actingAs($user);

        $this->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))->assertOk();
        $this->travel(20)->seconds();
        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'A'],
        ]);

        $this->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))->assertOk();
        $this->travel(20)->seconds();
        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'A'],
        ]);

        $this->assertSame(10, User::find($user->id_user)->total_poin);
    }

    public function test_submit_kuis_boleh_kosong_dan_mendapat_nol_poin(): void
    {
        DB::table('jenjang')->insert([
            'id_jenjang' => 1,
            'nama_tipe' => 'SMA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tipeuser')->insert([
            'id_tipeUser' => 3,
            'nama_tipe' => 'Siswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tipequiz')->insert([
            'id_tipequiz' => 1,
            'nama_tipe' => 'Latihan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tingkatquiz')->insert([
            'id_tingkatquiz' => 1,
            'nama_tingkat' => 'Dasar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::create([
            'nama' => 'Siswa Kosong',
            'email' => 'siswa-kosong@example.com',
            'nisn' => '1000000002',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Quiz Wajib Isi',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'id_jenjang' => 1,
            'waktu_kadaluarsa' => now()->addDay(),
            'hasil_quiz' => 'Selesai',
            'proggressQuiz' => 'Tersedia',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'pertanyaan' => '3 + 3 = ?',
            'jawaban_benar' => 'A',
            'poin' => 10,
        ]);

        PilihanSoal::create([
            'id_soal' => $soal->id_soal,
            'label' => 'A',
            'teks_pilihan' => '6',
            'is_correct' => true,
        ]);

        $this->actingAs($user)
            ->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk();
        $this->travel(20)->seconds();

        $response = $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [],
        ]);

        $response->assertSessionHas('quiz_result');
        $this->assertSame(0, session('quiz_result')['poin_didapat']);
    }

    public function test_quiz_kadaluarsa_tidak_bisa_dibuka_atau_disubmit(): void
    {
        DB::table('jenjang')->insert([
            'id_jenjang' => 1,
            'nama_tipe' => 'SMA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('jenjang')->insert([
            ['id_jenjang' => 2, 'nama_tipe' => 'SMP', 'created_at' => now(), 'updated_at' => now()],
            ['id_jenjang' => 3, 'nama_tipe' => 'SD', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('tipeuser')->insert([
            'id_tipeUser' => 3,
            'nama_tipe' => 'Siswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tipequiz')->insert([
            'id_tipequiz' => 1,
            'nama_tipe' => 'Latihan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tingkatquiz')->insert([
            'id_tingkatquiz' => 1,
            'nama_tingkat' => 'Dasar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tingkatquiz')->insert([
            ['id_tingkatquiz' => 2, 'nama_tingkat' => 'Sedang', 'created_at' => now(), 'updated_at' => now()],
            ['id_tingkatquiz' => 3, 'nama_tingkat' => 'Sulit', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $user = User::create([
            'nama' => 'Siswa Expired',
            'email' => 'siswa-expired@example.com',
            'nisn' => '1000000003',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Quiz Expired',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'id_jenjang' => 1,
            'waktu_kadaluarsa' => now()->subMinute(),
        ]);

        Quiz::create([
            'judul' => 'Quiz SD Mudah',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'id_jenjang' => 1,
        ]);

        Quiz::create([
            'judul' => 'Quiz SMA Sulit',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 3,
            'id_jenjang' => 3,
        ]);

        $this->actingAs($user);

        $this->get(route('siswa.quiz', ['jenjang' => 1, 'tingkat' => 1]))
            ->assertOk()
            ->assertSee('Quiz SD Mudah')
            ->assertDontSee('Quiz SMA Sulit')
            ->assertDontSee('Quiz Expired');

        $this->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertRedirect(route('siswa.quiz'))
            ->assertSessionHasErrors('quiz');

        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), ['jawaban' => []])
            ->assertRedirect(route('siswa.quiz'))
            ->assertSessionHasErrors('quiz');

        $this->assertDatabaseCount('hasilquizmodul', 0);

        $quizBiasa = Quiz::create([
            'judul' => 'Quiz Biasa Berwaktu',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 1,
        ]);

        $attemptKey = 'quiz_attempt.' . $user->id_user . '.' . $quizBiasa->id_quiz;
        $this->get(route('siswa.quiz.kerjakan', $quizBiasa->id_quiz))->assertOk();
        $this->assertNotNull(session($attemptKey));
        $this->assertSame('biasa', $quizBiasa->mode_pengerjaan);
        $this->assertSame(1, $quizBiasa->durasi_total_menit);

        $this->travel(61)->seconds();
        $this->assertGreaterThan(60, now()->timestamp - (int) session($attemptKey));
        $this->post(route('siswa.quiz.submit', $quizBiasa->id_quiz), ['jawaban' => []])
            ->assertRedirect(route('siswa.quiz'))
            ->assertSessionHasErrors('quiz');

        $this->assertDatabaseCount('hasilquizmodul', 0);
    }
}

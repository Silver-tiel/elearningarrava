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

        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'A'],
        ]);

        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'A'],
        ]);

        $this->assertSame(10, User::find($user->id_user)->total_poin);
    }

    public function test_submit_kuis_tidak_boleh_kosong(): void
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

        $this->actingAs($user);

        $response = $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [],
        ]);

        $response->assertSessionHasErrors('jawaban');
    }
}

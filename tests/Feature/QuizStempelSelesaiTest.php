<?php

namespace Tests\Feature;

use App\Models\HasilQuizModul;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuizStempelSelesaiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser')->nullable();
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->integer('total_poin')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('kode_quiz')->nullable();
            $table->string('judul');
            $table->unsignedInteger('id_tipequiz')->nullable();
            $table->unsignedInteger('id_tingkatquiz')->nullable();
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->dateTime('waktu_kadaluarsa')->nullable();
            $table->string('mode_pengerjaan')->nullable();
            $table->integer('durasi_total_menit')->nullable();
            $table->string('token')->nullable();
            $table->string('hasil_quiz')->nullable();
            $table->string('proggressQuiz')->nullable();
            $table->string('foto_quiz')->nullable();
            $table->string('opsi_preview')->nullable();
            $table->timestamps();
        });

        Schema::create('soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->string('kode_soal')->nullable();
            $table->unsignedInteger('id_quiz');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->text('pertanyaan');
            $table->text('jawaban_benar');
            $table->integer('poin')->default(10);
            $table->unsignedSmallInteger('durasi_detik')->default(20);
            $table->timestamps();
        });

        Schema::create('pilihan_soal', function (Blueprint $table) {
            $table->increments('id_pilihan');
            $table->unsignedInteger('id_soal');
            $table->string('label');
            $table->text('teks_pilihan');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('hasilquizmodul', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_quiz');
            $table->integer('total_poin')->default(0);
            $table->integer('poin_didapat')->default(0);
            $table->boolean('is_lulus')->default(false);
            $table->timestamp('waktu_dapat')->nullable();
            $table->timestamps();
        });

        Schema::create('tingkatquiz', function (Blueprint $table) {
            $table->increments('id_tingkatquiz');
            $table->string('nama_tingkat');
            $table->timestamps();
        });

        Schema::create('tipequiz', function (Blueprint $table) {
            $table->increments('id_tipequiz');
            $table->string('nama_tipe');
            $table->timestamps();
        });

        Schema::create('jenis_soal', function (Blueprint $table) {
            $table->increments('id_jenis');
            $table->string('nama_jenis');
            $table->timestamps();
        });
    }

    public function test_stempel_tidak_muncul_jika_tidak_lulus_dan_tidak_dapat_poin(): void
    {
        $user = User::create([
            'nama' => 'Siswa Belum Lulus',
            'email' => 'belumlulus@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Uji Kelulusan',
            'mode_pengerjaan' => 'wayground',
        ]);

        // 2 soal, 1 benar 1 salah = 50% (dibawah 70% lulus)
        $soal1 = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Soal 1',
            'jawaban_benar' => 'A',
            'poin' => 10,
            'durasi_detik' => 10,
        ]);
        $soal2 = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Soal 2',
            'jawaban_benar' => 'B',
            'poin' => 10,
            'durasi_detik' => 10,
        ]);

        $this->actingAs($user)
            ->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk();

        // Jawab soal 1 benar
        $this->travel(5)->seconds();
        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal1->id_soal => 'A'],
        ])->assertRedirect(route('siswa.quiz.kerjakan', $quiz->id_quiz));

        // Jawab soal 2 salah
        $this->travel(5)->seconds();
        $response = $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal2->id_soal => 'X'],
        ]);

        $response->assertRedirect(route('siswa.quiz'));
        $response->assertSessionHas('quiz_result', function (array $result): bool {
            return $result['poin_didapat'] === 10
                && $result['poin_diberikan'] === 0
                && $result['is_lulus'] === false;
        });

        // Banner submit tidak boleh menampilkan stempel berhasil karena kuis tidak memberikan poin
        $pageResponse = $this->get(route('siswa.quiz'));
        $pageResponse->assertOk();
        $pageResponse->assertDontSee('alt="Stempel Berhasil"', false);

        // Pada kartu kuis, modalData harus menunjukkan kuis belum selesai dan belum dapat poin
        $pageResponse->assertSee('"sudah_selesai":false', false);
        $pageResponse->assertSee('"poin_didapat_tertinggi":0', false);

        // Halaman detail juga tidak boleh menampilkan stempel selesai
        $detailResponse = $this->get(route('siswa.quiz.detail', $quiz->id_quiz));
        $detailResponse->assertOk();
        $detailResponse->assertDontSee('quizBerhasilStempel.webp');
        $detailResponse->assertDontSee('Anda Telah Menyelesaikan Kuis Ini');
    }

    public function test_stempel_muncul_jika_lulus_dan_diberikan_poin(): void
    {
        $user = User::create([
            'nama' => 'Siswa Berhasil Lulus',
            'email' => 'lulus@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Lulus',
            'mode_pengerjaan' => 'wayground',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Soal 1',
            'jawaban_benar' => 'A',
            'poin' => 20,
            'durasi_detik' => 10,
        ]);

        $this->actingAs($user)
            ->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk();

        $this->travel(5)->seconds();
        $response = $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'A'],
        ]);

        $response->assertRedirect(route('siswa.quiz'));
        $response->assertSessionHas('quiz_result', function (array $result): bool {
            return $result['poin_diberikan'] === 20
                && $result['is_lulus'] === true;
        });

        // Banner hasil submit dan kartu kuis menampilkan stempel
        $pageResponse = $this->get(route('siswa.quiz'));
        $pageResponse->assertOk();
        $pageResponse->assertSee('quizBerhasilStempel.webp');

        // Halaman detail kuis menampilkan stempel dan info penyelesaian
        $detailResponse = $this->get(route('siswa.quiz.detail', $quiz->id_quiz));
        $detailResponse->assertOk();
        $detailResponse->assertSee('quizBerhasilStempel.webp');
        $detailResponse->assertSee('Anda Telah Menyelesaikan Kuis Ini');
    }

    public function test_stempel_banner_tidak_muncul_saat_mengerjakan_ulang_kuis_yang_sudah_lulus(): void
    {
        $user = User::create([
            'nama' => 'Siswa Mengulang',
            'email' => 'mengulang@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 20,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Pengulangan',
            'mode_pengerjaan' => 'wayground',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Soal 1',
            'jawaban_benar' => 'A',
            'poin' => 20,
            'durasi_detik' => 10,
        ]);

        // Sudah lulus sebelumnya
        HasilQuizModul::create([
            'id_user' => $user->id_user,
            'id_quiz' => $quiz->id_quiz,
            'total_poin' => 20,
            'poin_didapat' => 20,
            'is_lulus' => true,
            'waktu_dapat' => now()->subDay(),
        ]);

        // Kerjakan ulang
        $this->actingAs($user)
            ->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk();

        $this->travel(5)->seconds();
        $response = $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'A'],
        ]);

        $response->assertRedirect(route('siswa.quiz'));
        $response->assertSessionHas('quiz_result', function (array $result): bool {
            return $result['poin_didapat'] === 20
                && $result['poin_diberikan'] === 0
                && $result['is_lulus'] === true;
        });

        // Banner hasil submit pengerjaan ulang TIDAK menampilkan stempel berhasil karena percobaan ini tidak memberi poin
        $pageResponse = $this->get(route('siswa.quiz'));
        $pageResponse->assertOk();
        $pageResponse->assertDontSee('alt="Stempel Berhasil"', false);
    }
}

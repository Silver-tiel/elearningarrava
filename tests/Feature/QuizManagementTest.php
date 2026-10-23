<?php

namespace Tests\Feature;

use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuizManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser')->nullable();
            $table->integer('total_poin')->default(0);
            $table->timestamps();
        });
        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });
        Schema::create('tipequiz', function (Blueprint $table) {
            $table->increments('id_tipequiz');
            $table->string('nama_tipe');
        });
        Schema::create('tingkatquiz', function (Blueprint $table) {
            $table->increments('id_tingkatquiz');
            $table->string('nama_tingkat');
        });
        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('kode_quiz')->nullable();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('id_tipequiz')->default(1);
            $table->unsignedInteger('id_tingkatquiz')->default(1);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->dateTime('waktu_kadaluarsa')->nullable();
            $table->string('mode_pengerjaan')->nullable();
            $table->integer('durasi_total_menit')->nullable();
            $table->string('token')->nullable();
            $table->string('proggressQuiz')->nullable();
            $table->timestamps();
        });
        Schema::create('soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->string('kode_soal')->nullable();
            $table->unsignedInteger('id_quiz');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->unsignedInteger('id_jenis_soal')->nullable();
            $table->text('pertanyaan');
            $table->text('jawaban_benar');
            $table->string('foto_soal')->nullable();
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

        \Illuminate\Support\Facades\DB::table('jenjang')->insert(['id_jenjang' => 1, 'nama_tipe' => 'SMA']);
        \Illuminate\Support\Facades\DB::table('tipequiz')->insert(['id_tipequiz' => 1, 'nama_tipe' => 'Harian']);
        \Illuminate\Support\Facades\DB::table('tingkatquiz')->insert(['id_tingkatquiz' => 1, 'nama_tingkat' => 'Mudah']);
    }

    public function test_admin_can_edit_an_expired_quiz_and_its_questions(): void
    {
        $this->actingAs($this->makeAdmin());
        $quiz = Quiz::create([
            'judul' => 'Quiz Lama',
            'id_jenjang' => 1,
            'waktu_kadaluarsa' => now()->subDay(),
            'mode_pengerjaan' => 'wayground',
            'proggressQuiz' => 'Tersedia',
        ]);
        Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Soal yang dapat diedit',
            'jawaban_benar' => 'A',
        ]);

        $this->get(route('admin.quiz.edit', $quiz->id_quiz))
            ->assertOk()
            ->assertSee('Quiz Lama')
            ->assertSee('Soal yang dapat diedit');

        $this->put(route('admin.quiz.update', $quiz->id_quiz), [
            'judul' => 'Quiz Diperbarui',
            'id_jenjang' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'waktu_kadaluarsa' => now()->subDay()->format('Y-m-d H:i:s'),
            'mode_pengerjaan' => 'wayground',
            'soal' => [[
                'jenis_soal' => 'true_false',
                'pertanyaan' => 'Soal terbaru',
                'poin' => 15,
                'durasi_detik' => 10,
                'pilihan' => [
                    ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => '1'],
                    ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => '0'],
                    ['label' => 'C', 'teks_pilihan' => 'Tersisa', 'is_correct' => '1'],
                    ['label' => 'D', 'teks_pilihan' => '', 'is_correct' => '0'],
                ],
            ]],
        ])->assertRedirect(route('admin.quiz'));

        $this->assertSame('Quiz Diperbarui', $quiz->fresh()->judul);
        $this->assertTrue($quiz->fresh()->sudahKadaluarsa());
        $soal = $quiz->soal()->with('pilihanSoal')->firstOrFail();
        $this->assertSame(3, $soal->id_jenis_soal);
        $this->assertSame('A', $soal->jawaban_benar);
        $this->assertSame(['A', 'B'], $soal->pilihanSoal->pluck('label')->all());
    }

    public function test_admin_quiz_list_shows_expired_and_available_statuses(): void
    {
        $this->actingAs($this->makeAdmin());
        Quiz::create(['judul' => 'Quiz Sudah Lewat', 'waktu_kadaluarsa' => now()->subMinute()]);
        Quiz::create(['judul' => 'Quiz Masih Aktif', 'waktu_kadaluarsa' => now()->addHour()]);

        $this->get(route('admin.quiz'))
            ->assertOk()
            ->assertSee('Quiz Sudah Lewat')
            ->assertSee('Quiz Masih Aktif')
            ->assertSee('Kadaluarsa')
            ->assertSee('Tersedia');
    }

    public function test_admin_can_delete_quiz_with_its_questions_and_choices(): void
    {
        $this->actingAs($this->makeAdmin());
        $quiz = Quiz::create(['judul' => 'Quiz Untuk Dihapus']);
        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Soal untuk dihapus',
            'jawaban_benar' => 'A',
        ]);
        PilihanSoal::create([
            'id_soal' => $soal->id_soal,
            'label' => 'A',
            'teks_pilihan' => 'Jawaban A',
            'is_correct' => true,
        ]);

        $this->delete(route('admin.quiz.destroy', $quiz->id_quiz))
            ->assertRedirect(route('admin.quiz'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('quiz', 0);
        $this->assertDatabaseCount('soal', 0);
        $this->assertDatabaseCount('pilihan_soal', 0);
    }

    public function test_invalid_quiz_input_displays_a_human_readable_warning(): void
    {
        $this->actingAs($this->makeAdmin());

        $this->from(route('admin.quiz.create'))->post(route('admin.quiz.store'), [
            'judul' => '',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'soal' => [[
                'jenis_soal' => 'kuis',
                'pertanyaan' => 'Pertanyaan valid',
                'poin' => 10,
                'durasi_detik' => 10,
                'pilihan' => [
                    ['label' => 'A', 'teks_pilihan' => 'Opsi A', 'is_correct' => '1'],
                    ['label' => 'B', 'teks_pilihan' => 'Opsi B', 'is_correct' => '0'],
                ],
            ]],
        ])->assertRedirect(route('admin.quiz.create'))
            ->assertSessionHasErrors('judul');

        $this->withViewErrors(['judul' => 'Judul quiz wajib diisi.'])
            ->get(route('admin.quiz.create'))
            ->assertOk()
            ->assertSee('Input quiz belum valid. Periksa kembali:')
            ->assertSee('Judul quiz wajib diisi.');
    }

    public function test_admin_can_create_quiz_with_deskripsi_and_token(): void
    {
        $this->actingAs($this->makeAdmin());

        $this->post(route('admin.quiz.store'), [
            'judul' => 'Quiz Berdeskripsi Dan Token',
            'deskripsi' => 'Ini adalah petunjuk pengerjaan quiz lengkap.',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'use_token' => '1',
            'token' => 'ARRAVA99',
            'soal' => [[
                'jenis_soal' => 'kuis',
                'pertanyaan' => 'Pertanyaan uji coba token',
                'poin' => 10,
                'durasi_detik' => 20,
                'pilihan' => [
                    ['label' => 'A', 'teks_pilihan' => 'Pilihan A', 'is_correct' => '1'],
                    ['label' => 'B', 'teks_pilihan' => 'Pilihan B', 'is_correct' => '0'],
                ],
            ]],
        ])->assertRedirect(route('admin.quiz'));

        $quiz = Quiz::where('judul', 'Quiz Berdeskripsi Dan Token')->firstOrFail();
        $this->assertSame('Ini adalah petunjuk pengerjaan quiz lengkap.', $quiz->deskripsi);
        $this->assertSame('ARRAVA99', $quiz->token);
        $this->assertTrue($quiz->perluToken());
    }

    public function test_siswa_sees_preview_and_must_submit_valid_token_before_taking_quiz(): void
    {
        $siswa = User::create([
            'nama' => 'Siswa Test',
            'email' => 'siswa-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
        ]);
        $this->actingAs($siswa);

        $quiz = Quiz::create([
            'judul' => 'Quiz Rahasia',
            'deskripsi' => 'Harap kerjakan mandiri tanpa melihat buku.',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'token' => 'LULUS2026',
            'proggressQuiz' => 'Tersedia',
        ]);
        Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pertanyaan rahasia?',
            'jawaban_benar' => 'A',
            'durasi_detik' => 20,
        ]);

        // Siswa can view preview/detail with description
        $this->get(route('siswa.quiz.detail', $quiz->id_quiz))
            ->assertOk()
            ->assertSee('Quiz Rahasia')
            ->assertSee('Harap kerjakan mandiri tanpa melihat buku.')
            ->assertSee('Masukkan Token Kuis');

        // Siswa attempting to access kerjakan directly without token verification gets redirected to detail
        $this->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertRedirect(route('siswa.quiz.detail', $quiz->id_quiz))
            ->assertSessionHasErrors('token');

        // Siswa submits wrong token
        $this->post(route('siswa.quiz.mulai', $quiz->id_quiz), ['token' => 'SALAH123'])
            ->assertSessionHasErrors('token');

        // Siswa submits correct token (case-insensitive)
        $this->post(route('siswa.quiz.mulai', $quiz->id_quiz), ['token' => 'lulus2026'])
            ->assertRedirect(route('siswa.quiz.kerjakan', $quiz->id_quiz));

        // Now siswa can access the quiz solver room
        $this->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk()
            ->assertSee('Pertanyaan rahasia?');
    }

    private function makeAdmin(): User
    {
        return User::create([
            'nama' => 'Admin Kuis',
            'email' => 'admin-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);
    }
}

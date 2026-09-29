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
            $table->string('judul');
            $table->unsignedInteger('id_tipequiz')->default(1);
            $table->unsignedInteger('id_tingkatquiz')->default(1);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->dateTime('waktu_kadaluarsa')->nullable();
            $table->string('mode_pengerjaan')->nullable();
            $table->integer('durasi_total_menit')->nullable();
            $table->string('proggressQuiz')->nullable();
            $table->timestamps();
        });
        Schema::create('soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->unsignedInteger('id_quiz');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->unsignedInteger('id_jenis_soal')->nullable();
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

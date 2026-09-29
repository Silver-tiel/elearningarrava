<?php

namespace Tests\Feature;

use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuestionIntegrityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });
        Schema::create('jenis_soal', function (Blueprint $table) {
            $table->increments('id_jenis_soal');
            $table->string('nama_jenis_soal');
            $table->timestamps();
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
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser')->nullable();
            $table->integer('total_poin')->default(0);
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

        Schema::table('jenjang', function (Blueprint $table) {
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('jenjang')->insert([
            'id_jenjang' => 1,
            'nama_tipe' => 'SMA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \Illuminate\Support\Facades\DB::table('jenis_soal')->insert([
            ['id_jenis_soal' => 1, 'nama_jenis_soal' => 'Pilihan Ganda', 'created_at' => now(), 'updated_at' => now()],
            ['id_jenis_soal' => 2, 'nama_jenis_soal' => 'Essay', 'created_at' => now(), 'updated_at' => now()],
            ['id_jenis_soal' => 3, 'nama_jenis_soal' => 'Benar/Salah', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function test_quiz_creation_persists_the_question_type_and_one_correct_option(): void
    {
        $this->post(route('admin.quiz.store'), $this->quizPayload([[
            'jenis_soal' => 'kuis',
            'pertanyaan' => 'Pilih jawaban benar',
            'poin' => 10,
            'durasi_detik' => 10,
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Salah', 'is_correct' => '0'],
                ['label' => 'B', 'teks_pilihan' => 'Benar', 'is_correct' => '1'],
                ['label' => 'C', 'teks_pilihan' => '', 'is_correct' => '0'],
                ['label' => 'D', 'teks_pilihan' => '', 'is_correct' => '0'],
            ],
        ]]))->assertRedirect(route('admin.quiz'));

        $soal = Soal::with('pilihanSoal')->firstOrFail();
        $this->assertSame(1, $soal->id_jenis_soal);
        $this->assertSame('B', $soal->jawaban_benar);
        $this->assertSame(['B'], $soal->pilihanSoal->where('is_correct', true)->pluck('label')->all());
    }

    public function test_quiz_creation_rejects_a_correct_key_on_an_empty_option(): void
    {
        $this->from('/admin/quiz/create')->post(route('admin.quiz.store'), $this->quizPayload([[
            'jenis_soal' => 'kuis',
            'pertanyaan' => 'Pilihan benar kosong',
            'poin' => 10,
            'durasi_detik' => 10,
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => '', 'is_correct' => '1'],
                ['label' => 'B', 'teks_pilihan' => 'Pilihan tersedia', 'is_correct' => '0'],
                ['label' => 'C', 'teks_pilihan' => '', 'is_correct' => '0'],
                ['label' => 'D', 'teks_pilihan' => '', 'is_correct' => '0'],
            ],
        ]]))->assertSessionHasErrors('soal.0.pilihan');

        $this->assertDatabaseCount('quiz', 0);
        $this->assertDatabaseCount('soal', 0);
    }

    public function test_quiz_question_image_is_uploaded_and_saved(): void
    {
        Storage::fake('public');
        $payload = $this->quizPayload([[
            'jenis_soal' => 'kuis',
            'pertanyaan' => 'Soal dengan gambar',
            'poin' => 10,
            'durasi_detik' => 10,
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Opsi A', 'is_correct' => '1'],
                ['label' => 'B', 'teks_pilihan' => 'Opsi B', 'is_correct' => '0'],
            ],
            'foto_soal' => UploadedFile::fake()->image('diagram.png', 200, 200),
        ]]);

        $this->post(route('admin.quiz.store'), $payload)
            ->assertRedirect(route('admin.quiz'));

        $path = Soal::firstOrFail()->foto_soal;
        $this->assertNotNull($path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_true_false_discards_stale_hidden_options_and_persists_its_type(): void
    {
        $this->post(route('admin.quiz.store'), $this->quizPayload([[
            'jenis_soal' => 'true_false',
            'pertanyaan' => 'Pernyataan benar',
            'poin' => 10,
            'durasi_detik' => 10,
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => '0'],
                ['label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => '1'],
                ['label' => 'C', 'teks_pilihan' => 'Pilihan sisa', 'is_correct' => '1'],
                ['label' => 'D', 'teks_pilihan' => 'Pilihan sisa lain', 'is_correct' => '0'],
            ],
        ]]))->assertRedirect(route('admin.quiz'));

        $soal = Soal::with('pilihanSoal')->firstOrFail();
        $this->assertSame(3, $soal->id_jenis_soal);
        $this->assertSame('B', $soal->jawaban_benar);
        $this->assertSame(['A', 'B'], $soal->pilihanSoal->pluck('label')->all());
        $this->assertSame(['B'], $soal->pilihanSoal->where('is_correct', true)->pluck('label')->all());
    }

    public function test_short_answer_question_type_is_persisted(): void
    {
        $this->post(route('admin.quiz.store'), $this->quizPayload([[
            'jenis_soal' => 'isian_singkat',
            'pertanyaan' => 'Apa ibu kota Indonesia?',
            'jawaban_singkat' => 'Jakarta',
            'poin' => 10,
            'durasi_detik' => 10,
        ]]))->assertRedirect(route('admin.quiz'));

        $soal = Soal::firstOrFail();
        $this->assertSame(2, $soal->id_jenis_soal);
        $this->assertSame('Jakarta', $soal->jawaban_benar);
        $this->assertDatabaseCount('pilihan_soal', 0);
    }

    public function test_answer_key_conflict_does_not_make_an_incorrect_option_correct(): void
    {
        $user = User::create([
            'nama' => 'Siswa Konflik',
            'email' => 'key-conflict@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);
        $quiz = Quiz::create(['judul' => 'Kuis Kunci Bertentangan', 'mode_pengerjaan' => 'biasa']);
        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pilih opsi yang benar',
            'jawaban_benar' => 'A',
        ]);
        PilihanSoal::create(['id_soal' => $soal->id_soal, 'label' => 'A', 'teks_pilihan' => 'Opsi A', 'is_correct' => false]);
        PilihanSoal::create(['id_soal' => $soal->id_soal, 'label' => 'B', 'teks_pilihan' => 'Opsi B', 'is_correct' => true]);

        $this->actingAs($user)->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'A'],
        ])->assertSessionHas('quiz_result', function (array $result): bool {
            return $result['benar'] === 0 && $result['poin_didapat'] === 0;
        });
    }

    public function test_multiple_legacy_correct_flags_are_not_accepted_as_multiple_answers(): void
    {
        $user = User::create([
            'nama' => 'Siswa Kunci Ganda',
            'email' => 'multiple-keys@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);
        $quiz = Quiz::create(['judul' => 'Kuis Kunci Ganda', 'mode_pengerjaan' => 'biasa']);
        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Hanya satu pilihan yang boleh benar',
            'jawaban_benar' => 'A',
        ]);
        PilihanSoal::create(['id_soal' => $soal->id_soal, 'label' => 'A', 'teks_pilihan' => 'Opsi A', 'is_correct' => true]);
        PilihanSoal::create(['id_soal' => $soal->id_soal, 'label' => 'B', 'teks_pilihan' => 'Opsi B', 'is_correct' => true]);

        $this->actingAs($user)->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'A'],
        ])->assertSessionHas('quiz_result', function (array $result): bool {
            return $result['benar'] === 0 && $result['poin_didapat'] === 0;
        });
    }

    public function test_manual_question_update_synchronizes_answer_key_and_option_rows(): void
    {
        $quiz = Quiz::create(['judul' => 'Kuis Manual']);
        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pertanyaan lama',
            'jawaban_benar' => 'B',
        ]);
        PilihanSoal::create(['id_soal' => $soal->id_soal, 'label' => 'A', 'teks_pilihan' => 'Lama A', 'is_correct' => false]);
        PilihanSoal::create(['id_soal' => $soal->id_soal, 'label' => 'B', 'teks_pilihan' => 'Lama B', 'is_correct' => true]);

        $this->put(route('soal.update', $soal->id_soal), [
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pertanyaan baru',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Baru A'],
                ['label' => 'B', 'teks_pilihan' => 'Baru B'],
                ['label' => 'C', 'teks_pilihan' => ''],
                ['label' => 'D', 'teks_pilihan' => ''],
            ],
        ])->assertRedirect(route('admin.soal'));

        $soal->refresh();
        $this->assertSame('A', $soal->jawaban_benar);
        $this->assertSame('Pertanyaan baru', $soal->pertanyaan);
        $this->assertSame(['A'], $soal->pilihanSoal()->where('is_correct', true)->pluck('label')->all());
        $this->assertSame(['Baru A', 'Baru B'], $soal->pilihanSoal()->orderBy('label')->pluck('teks_pilihan')->all());
    }

    private function quizPayload(array $questions): array
    {
        return [
            'judul' => 'Kuis Integritas',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'soal' => $questions,
        ];
    }
}

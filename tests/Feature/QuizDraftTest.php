<?php

namespace Tests\Feature;

use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuizDraftTest extends TestCase
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
            $table->unsignedInteger('id_jenjang')->nullable();
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

        Schema::create('jenis_soal', function (Blueprint $table) {
            $table->increments('id_jenis_soal');
            $table->string('nama_jenis');
            $table->timestamps();
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
            $table->string('foto_quiz')->nullable();
            $table->string('opsi_preview')->default('lengkap');
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

        Schema::create('hasilquizmodul', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_quiz');
            $table->integer('total_poin')->default(0);
            $table->integer('poin_didapat')->default(0);
            $table->boolean('is_lulus')->default(false);
            $table->dateTime('waktu_dapat')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('jenjang')->insert(['id_jenjang' => 1, 'nama_tipe' => 'SMA']);
        \Illuminate\Support\Facades\DB::table('tipequiz')->insert(['id_tipequiz' => 1, 'nama_tipe' => 'Harian']);
        \Illuminate\Support\Facades\DB::table('tingkatquiz')->insert(['id_tingkatquiz' => 1, 'nama_tingkat' => 'Mudah']);
    }

    public function test_admin_can_save_quiz_as_draft_without_questions(): void
    {
        $this->actingAs($this->makeAdmin());

        $response = $this->post(route('admin.quiz.store'), [
            'action_type' => 'draft',
            'judul' => 'Quiz Draf Belum Lengkap',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
        ]);

        $response->assertRedirect(route('admin.quiz'));
        $response->assertSessionHas('success');

        $quiz = Quiz::where('judul', 'Quiz Draf Belum Lengkap')->first();
        $this->assertNotNull($quiz);
        $this->assertTrue($quiz->isDraft());
        $this->assertSame('Draft', $quiz->proggressQuiz);
        $this->assertCount(0, $quiz->soal);
    }

    public function test_admin_can_save_quiz_as_draft_with_incomplete_questions(): void
    {
        $this->actingAs($this->makeAdmin());

        $response = $this->post(route('admin.quiz.store'), [
            'action_type' => 'draft',
            'judul' => 'Quiz Draf Setengah Jadi',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'Pertanyaan belum ada jawaban',
                    'poin' => 10,
                    'durasi_detik' => 15,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => '', 'is_correct' => 0],
                        ['label' => 'B', 'teks_pilihan' => '', 'is_correct' => 0],
                    ],
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.quiz'));
        $quiz = Quiz::where('judul', 'Quiz Draf Setengah Jadi')->first();
        $this->assertNotNull($quiz);
        $this->assertTrue($quiz->isDraft());
        $this->assertCount(1, $quiz->soal);
    }

    public function test_admin_publishing_quiz_requires_questions_and_correct_answers(): void
    {
        $this->actingAs($this->makeAdmin());

        // Publish with no questions -> fails validation
        $response = $this->post(route('admin.quiz.store'), [
            'action_type' => 'publish',
            'judul' => 'Quiz Mau Dipublish Tapi Tanpa Soal',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
        ]);

        $response->assertSessionHasErrors('soal');
    }

    public function test_admin_can_update_draft_quiz_to_published(): void
    {
        $this->actingAs($this->makeAdmin());

        $quiz = Quiz::create([
            'judul' => 'Quiz Draf Awal',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'proggressQuiz' => 'Draft',
        ]);

        $response = $this->put(route('admin.quiz.update', $quiz->id_quiz), [
            'action_type' => 'publish',
            'judul' => 'Quiz Sekarang Dipublikasikan',
            'id_jenjang' => 1,
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'wayground',
            'soal' => [
                [
                    'jenis_soal' => 'kuis',
                    'pertanyaan' => 'Ibu kota Indonesia?',
                    'poin' => 10,
                    'durasi_detik' => 20,
                    'pilihan' => [
                        ['label' => 'A', 'teks_pilihan' => 'Nusantara', 'is_correct' => 1],
                        ['label' => 'B', 'teks_pilihan' => 'Bandung', 'is_correct' => 0],
                    ],
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.quiz'));
        $quiz->refresh();
        $this->assertTrue($quiz->isPublished());
        $this->assertSame('Tersedia', $quiz->proggressQuiz);
        $this->assertCount(1, $quiz->soal);
    }

    public function test_admin_can_change_published_quiz_back_to_draft(): void
    {
        $this->actingAs($this->makeAdmin());

        $quiz = Quiz::create([
            'judul' => 'Quiz Sempat Tayang',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'proggressQuiz' => 'Tersedia',
        ]);

        $response = $this->put(route('admin.quiz.update', $quiz->id_quiz), [
            'action_type' => 'draft',
            'judul' => 'Quiz Ditarik Kembali Ke Draf',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
        ]);

        $response->assertRedirect(route('admin.quiz'));
        $quiz->refresh();
        $this->assertTrue($quiz->isDraft());
        $this->assertSame('Draft', $quiz->proggressQuiz);
    }

    public function test_draft_quiz_is_hidden_from_siswa_quiz_list(): void
    {
        $siswa = User::create([
            'nama' => 'Siswa Belajar',
            'email' => 'siswa-draft-view@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        Quiz::create([
            'judul' => 'Quiz Publik Yang Tayang',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'proggressQuiz' => 'Tersedia',
        ]);

        Quiz::create([
            'judul' => 'Quiz Rahasia Yang Draf',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'proggressQuiz' => 'Draft',
        ]);

        $this->actingAs($siswa);

        $response = $this->get(route('siswa.quiz'));
        $response->assertOk();
        $response->assertSee('Quiz Publik Yang Tayang');
        $response->assertDontSee('Quiz Rahasia Yang Draf');
    }

    public function test_siswa_cannot_access_draft_quiz_detail_or_kerjakan(): void
    {
        $siswa = User::create([
            'nama' => 'Siswa Penguji',
            'email' => 'siswa-forbidden-draft@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        $quizDraft = Quiz::create([
            'judul' => 'Quiz Dalam Draf',
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'proggressQuiz' => 'Draft',
        ]);

        $this->actingAs($siswa);

        // Accessing detail of draft quiz is blocked
        $this->get(route('siswa.quiz.detail', $quizDraft->id_quiz))
            ->assertRedirect(route('siswa.quiz'))
            ->assertSessionHasErrors('quiz');

        // Accessing kerjakan of draft quiz is blocked
        $this->get(route('siswa.quiz.kerjakan', $quizDraft->id_quiz))
            ->assertRedirect(route('siswa.quiz'))
            ->assertSessionHasErrors('quiz');
    }

    public function test_admin_can_filter_quizzes_by_status(): void
    {
        $this->actingAs($this->makeAdmin());

        Quiz::create([
            'judul' => 'Kuis Aktif Publik',
            'proggressQuiz' => 'Tersedia',
            'waktu_kadaluarsa' => now()->addHour(),
        ]);

        Quiz::create([
            'judul' => 'Kuis Konsep Draf',
            'proggressQuiz' => 'Draft',
        ]);

        // Filter: draft
        $this->get(route('admin.quiz', ['status' => 'draft']))
            ->assertOk()
            ->assertSee('Kuis Konsep Draf')
            ->assertDontSee('Kuis Aktif Publik');

        // Filter: published
        $this->get(route('admin.quiz', ['status' => 'published']))
            ->assertOk()
            ->assertSee('Kuis Aktif Publik')
            ->assertDontSee('Kuis Konsep Draf');
    }

    public function test_admin_can_preview_draft_quiz(): void
    {
        $this->actingAs($this->makeAdmin());

        $quizDraft = Quiz::create([
            'judul' => 'Preview Kuis Draf',
            'proggressQuiz' => 'Draft',
        ]);
        Soal::create([
            'id_quiz' => $quizDraft->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Soal pratinjau draf pertama',
            'jawaban_benar' => 'A',
            'durasi_detik' => 20,
        ]);

        $this->get(route('admin.quiz.preview', $quizDraft->id_quiz))
            ->assertOk()
            ->assertSee('Preview Kuis Draf')
            ->assertSee('Soal pratinjau draf pertama');
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

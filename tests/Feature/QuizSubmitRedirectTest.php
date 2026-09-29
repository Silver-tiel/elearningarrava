<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuizSubmitRedirectTest extends TestCase
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
            $table->integer('total_poin')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('judul');
            $table->dateTime('waktu_kadaluarsa')->nullable();
            $table->string('mode_pengerjaan')->nullable();
            $table->integer('durasi_total_menit')->nullable();
            $table->timestamps();
        });

        Schema::create('soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->unsignedInteger('id_quiz');
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
    }

    public function test_submit_redirects_to_quiz_list_instead_of_reopening_same_quiz(): void
    {
        $user = User::create([
            'nama' => 'Siswa Submit',
            'email' => 'submit-check@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Redirect',
            'mode_pengerjaan' => 'wayground',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Apa ini?',
            'jawaban_benar' => 'Benar',
            'poin' => 10,
        ]);

        $this->actingAs($user)
            ->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk();
        $this->travel(20)->seconds();

        $response = $this->post('/siswa/quiz/' . $quiz->id_quiz . '/submit', [
            'jawaban' => [
                $soal->id_soal => 'Benar',
            ],
        ]);

        $response->assertRedirect(route('siswa.quiz'));
    }

    public function test_wayground_submit_is_rejected_before_server_timer_expires(): void
    {
        $user = User::create([
            'nama' => 'Siswa Timer',
            'email' => 'timer-check@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Timer Server',
            'mode_pengerjaan' => 'wayground',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Apa ini?',
            'jawaban_benar' => 'Benar',
            'poin' => 10,
            'durasi_detik' => 20,
        ]);

        $this->actingAs($user)
            ->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk();

        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'Benar'],
        ])
            ->assertRedirect(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertSessionHasErrors('quiz');

        $this->assertDatabaseCount('hasilquizmodul', 0);
        $this->assertSame(0, User::find($user->id_user)->total_poin);
    }

    public function test_wayground_reveals_and_accepts_only_the_server_timed_active_question(): void
    {
        $user = User::create([
            'nama' => 'Siswa Berurutan',
            'email' => 'sequence-check@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Berurutan',
            'mode_pengerjaan' => 'wayground',
        ]);

        $firstQuestion = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Pertanyaan pertama khusus',
            'jawaban_benar' => 'Benar',
            'poin' => 10,
            'durasi_detik' => 10,
        ]);
        $secondQuestion = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Pertanyaan kedua khusus',
            'jawaban_benar' => 'Benar',
            'poin' => 10,
            'durasi_detik' => 10,
        ]);

        $this->actingAs($user);
        $this->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk()
            ->assertSee('Pertanyaan pertama khusus')
            ->assertDontSee('Pertanyaan kedua khusus');

        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [
                $firstQuestion->id_soal => 'Benar',
                $secondQuestion->id_soal => 'Benar',
            ],
        ])
            ->assertRedirect(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertSessionHasErrors('quiz');
        $this->assertDatabaseCount('hasilquizmodul', 0);

        $this->travel(10)->seconds();
        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [
                $firstQuestion->id_soal => 'Benar',
                $secondQuestion->id_soal => 'Benar',
            ],
        ])->assertRedirect(route('siswa.quiz.kerjakan', $quiz->id_quiz));

        $this->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk()
            ->assertSee('Pertanyaan kedua khusus')
            ->assertDontSee('Pertanyaan pertama khusus');

        $this->travel(10)->seconds();
        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$secondQuestion->id_soal => 'Salah'],
        ])->assertRedirect(route('siswa.quiz'))
            ->assertSessionHas('quiz_result', function (array $result): bool {
                $this->assertSame(1, $result['benar']);
                $this->assertSame(10, $result['poin_didapat']);
                $this->assertFalse($result['is_lulus']);

                return true;
            });

        $this->assertDatabaseCount('hasilquizmodul', 1);
        $this->assertSame(0, User::find($user->id_user)->total_poin);
    }

    public function test_wayground_discards_answers_submitted_after_question_deadline(): void
    {
        $user = User::create([
            'nama' => 'Siswa Terlambat',
            'email' => 'late-answer@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Batas Jawaban',
            'mode_pengerjaan' => 'wayground',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Jawaban setelah deadline',
            'jawaban_benar' => 'Benar',
            'poin' => 10,
            'durasi_detik' => 10,
        ]);

        $this->actingAs($user)
            ->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk();

        $this->travel(21)->seconds();
        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'Benar'],
        ])->assertRedirect(route('siswa.quiz'))
            ->assertSessionHas('quiz_result', function (array $result): bool {
                return $result['benar'] === 0 && $result['poin_didapat'] === 0;
            });

        $this->assertSame(0, User::find($user->id_user)->total_poin);
    }

    public function test_wayground_accepts_auto_submit_with_minor_network_delay(): void
    {
        $user = User::create([
            'nama' => 'Siswa Latensi',
            'email' => 'latency-check@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Toleransi Latensi',
            'mode_pengerjaan' => 'wayground',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Jawaban dengan latensi',
            'jawaban_benar' => 'Benar',
            'poin' => 10,
            'durasi_detik' => 10,
        ]);

        $this->actingAs($user)
            ->get(route('siswa.quiz.kerjakan', $quiz->id_quiz))
            ->assertOk();

        $this->travel(18)->seconds();
        $this->post(route('siswa.quiz.submit', $quiz->id_quiz), [
            'jawaban' => [$soal->id_soal => 'Benar'],
        ])->assertRedirect(route('siswa.quiz'))
            ->assertSessionHas('quiz_result', function (array $result): bool {
                return $result['benar'] === 1 && $result['poin_didapat'] === 10 && $result['is_lulus'];
            });

        $this->assertSame(10, User::find($user->id_user)->total_poin);
    }
}

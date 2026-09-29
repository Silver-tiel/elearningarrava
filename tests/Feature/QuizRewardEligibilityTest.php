<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use App\Models\HasilQuizModul;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuizRewardEligibilityTest extends TestCase
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

    public function test_failed_attempt_does_not_block_future_reward(): void
    {
        $user = User::create([
            'nama' => 'Siswa Uji',
            'email' => 'reward@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'total_poin' => 0,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Kuis Uji Reward',
            'mode_pengerjaan' => 'wayground',
        ]);

        $soal = Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Apa ini?',
            'jawaban_benar' => 'Benar',
            'poin' => 10,
        ]);

        HasilQuizModul::create([
            'id_user' => $user->id_user,
            'id_quiz' => $quiz->id_quiz,
            'total_poin' => 10,
            'poin_didapat' => 5,
            'is_lulus' => false,
            'waktu_dapat' => now(),
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

        $response->assertSessionHas('quiz_result');
        $this->assertSame(10, User::find($user->id_user)->total_poin);
        $this->assertTrue(HasilQuizModul::where('id_user', $user->id_user)->where('id_quiz', $quiz->id_quiz)->where('is_lulus', true)->exists());
    }
}

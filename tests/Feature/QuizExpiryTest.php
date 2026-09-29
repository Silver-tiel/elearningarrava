<?php

namespace Tests\Feature;

use App\Models\Quiz;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuizExpiryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('judul');
            $table->dateTime('waktu_kadaluarsa')->nullable();
            $table->string('mode_pengerjaan')->nullable();
            $table->integer('durasi_total_menit')->nullable();
            $table->timestamps();
        });
    }

    public function test_expired_quiz_is_not_available_for_selection(): void
    {
        $activeQuiz = Quiz::create([
            'judul' => 'Quiz Aktif',
            'waktu_kadaluarsa' => now()->addHour(),
        ]);

        $expiredQuiz = Quiz::create([
            'judul' => 'Quiz Kadaluarsa',
            'waktu_kadaluarsa' => now()->subHour(),
        ]);

        $this->assertFalse($activeQuiz->sudahKadaluarsa());
        $this->assertTrue($expiredQuiz->sudahKadaluarsa());

        $available = Quiz::belumKadaluarsa()->pluck('judul')->all();

        $this->assertContains('Quiz Aktif', $available);
        $this->assertNotContains('Quiz Kadaluarsa', $available);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminQuizPreviewTest extends TestCase
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
            $table->timestamps();
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('judul');
            $table->timestamps();
        });

        Schema::create('soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->unsignedInteger('id_quiz');
            $table->text('pertanyaan');
            $table->text('jawaban_benar');
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
    }

    public function test_admin_can_open_quiz_preview(): void
    {
        $user = User::create([
            'nama' => 'Admin Uji',
            'email' => 'admin-preview@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);

        $quiz = Quiz::create([
            'judul' => 'Preview Quiz Admin',
        ]);

        Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Apa yang dimaksud dengan preview?',
            'jawaban_benar' => 'Membuka tampilan soal tanpa menjawab',
        ]);
        Soal::create([
            'id_quiz' => $quiz->id_quiz,
            'pertanyaan' => 'Soal kedua untuk preview',
            'jawaban_benar' => 'Jawaban kedua',
        ]);

        $this->actingAs($user);

        $response = $this->get('/admin/quiz/' . $quiz->id_quiz . '/preview');

        $response->assertStatus(200);
        $response->assertSeeText('Mode Preview');
        $response->assertSeeText('Soal kedua untuk preview');
    }
}

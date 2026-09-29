<?php

namespace Tests\Feature;

use App\Models\Soal;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SoalUploadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_jenjang');
        });

        Schema::create('jenis_soal', function (Blueprint $table) {
            $table->increments('id_jenis_soal');
            $table->string('nama_jenis');
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('judul_quiz');
            $table->unsignedInteger('id_jenjang')->nullable();
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

        DB::table('jenjang')->insert(['id_jenjang' => 1, 'nama_jenjang' => 'SMA']);
        DB::table('jenis_soal')->insert(['id_jenis_soal' => 1, 'nama_jenis' => 'Pilihan Ganda']);
        DB::table('quiz')->insert(['id_quiz' => 1, 'judul_quiz' => 'Quiz test', 'id_jenjang' => 1]);
    }

    public function test_valid_photo_is_saved_for_new_soal(): void
    {
        $this->withoutMiddleware();

        $response = $this->post('/admin/soal/store', [
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Apa itu Laravel?',
            'jawaban_benar' => 'Framework PHP',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Framework PHP'],
                ['label' => 'B', 'teks_pilihan' => 'Bahasa pemrograman'],
            ],
            'foto_soal' => UploadedFile::fake()->image('soal.jpg', 300, 300),
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('soal', [
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Apa itu Laravel?',
        ]);

        $soal = Soal::first();
        $this->assertNotNull($soal->foto_soal);
    }

    public function test_invalid_photo_type_is_rejected(): void
    {
        $this->withoutMiddleware();

        $response = $this->from('/admin/soal/create')->post('/admin/soal/store', [
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Apa itu Laravel?',
            'jawaban_benar' => 'Framework PHP',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Framework PHP'],
                ['label' => 'B', 'teks_pilihan' => 'Bahasa pemrograman'],
            ],
            'foto_soal' => UploadedFile::fake()->create('bukan-gambar.pdf', 200, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors(['foto_soal']);
    }
}

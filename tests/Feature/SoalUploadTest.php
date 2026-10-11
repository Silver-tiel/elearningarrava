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
            $table->string('kode_quiz')->nullable();
            $table->string('judul_quiz');
            $table->unsignedInteger('id_jenjang')->nullable();
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

    public function test_cannot_reupload_identical_photo_on_same_soal(): void
    {
        $this->withoutMiddleware();
        \Illuminate\Support\Facades\Storage::fake('public');

        $image = UploadedFile::fake()->image('soal1.jpg', 300, 300);
        $path = $image->store('soal/foto', 'public');

        $soal = Soal::create([
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Soal dengan foto',
            'jawaban_benar' => 'A',
            'foto_soal' => $path,
        ]);

        $response = $this->from("/admin/soal/{$soal->id_soal}/edit")->put("/admin/soal/{$soal->id_soal}", [
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Soal dengan foto diupdate',
            'jawaban_benar' => 'A',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Opsi A'],
                ['label' => 'B', 'teks_pilihan' => 'Opsi B'],
            ],
            'foto_soal' => $image,
        ]);

        $response->assertSessionHasErrors(['foto_soal']);
    }

    public function test_different_soals_in_same_quiz_can_use_identical_photo(): void
    {
        $this->withoutMiddleware();
        \Illuminate\Support\Facades\Storage::fake('public');

        $image = UploadedFile::fake()->image('peta.jpg', 300, 300);

        // Soal pertama
        $this->post('/admin/soal/store', [
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pertanyaan 1 tentang peta',
            'jawaban_benar' => 'A',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Opsi 1'],
                ['label' => 'B', 'teks_pilihan' => 'Opsi 2'],
            ],
            'foto_soal' => $image,
        ])->assertSessionHas('success');

        // Soal kedua dalam kuis yang sama dengan foto yang sama
        $this->post('/admin/soal/store', [
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pertanyaan 2 tentang peta yang sama',
            'jawaban_benar' => 'B',
            'correct_choice' => 'B',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Opsi 1'],
                ['label' => 'B', 'teks_pilihan' => 'Opsi 2'],
            ],
            'foto_soal' => $image,
        ])->assertSessionHas('success');

        $this->assertSame(2, Soal::where('id_quiz', 1)->count());
    }

    public function test_duplicate_question_text_in_same_quiz_is_rejected(): void
    {
        $this->withoutMiddleware();

        Soal::create([
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pertanyaan unik pertama',
            'jawaban_benar' => 'A',
        ]);

        $response = $this->from('/admin/soal/create')->post('/admin/soal/store', [
            'id_quiz' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pertanyaan unik pertama',
            'jawaban_benar' => 'A',
            'correct_choice' => 'A',
            'pilihan' => [
                ['label' => 'A', 'teks_pilihan' => 'Opsi 1'],
                ['label' => 'B', 'teks_pilihan' => 'Opsi 2'],
            ],
        ]);

        $response->assertSessionHasErrors(['pertanyaan']);
    }
}

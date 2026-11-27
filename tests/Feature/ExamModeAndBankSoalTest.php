<?php

namespace Tests\Feature;

use App\Models\HasilQuizModul;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ExamModeAndBankSoalTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        RateLimiter::clear('quiz-token-1-2');

        Schema::create('tipeuser', function (Blueprint $table) {
            $table->increments('id_tipeuser');
            $table->string('nama_tipe');
        });
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser')->nullable();
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->integer('total_poin')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });
        Schema::create('mapel', function (Blueprint $table) {
            $table->increments('id_mapel');
            $table->string('kode_mapel')->nullable();
            $table->string('nama_mapel');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
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
            $table->unsignedInteger('id_mapel')->nullable();
            $table->unsignedInteger('id_pembuat')->nullable();
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_kadaluarsa')->nullable();
            $table->string('mode_pengerjaan')->nullable();
            $table->integer('durasi_total_menit')->nullable();
            $table->string('token')->nullable();
            $table->string('foto_quiz')->nullable();
            $table->string('opsi_preview')->default('lengkap');
            $table->boolean('acak_soal')->default(false);
            $table->unsignedSmallInteger('batas_percobaan')->nullable();
            $table->boolean('tampilkan_hasil_ujian')->default(false);
            $table->string('proggressQuiz')->nullable();
            $table->timestamps();
        });
        Schema::create('soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->string('kode_soal')->nullable();
            $table->unsignedInteger('id_quiz')->nullable();
            $table->unsignedInteger('id_mapel')->nullable();
            $table->unsignedInteger('parent_soal_id')->nullable();
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->unsignedInteger('id_jenis_soal')->nullable();
            $table->string('tingkat_soal')->nullable();
            $table->string('kategori_bank', 20)->default('umum');
            $table->unsignedInteger('id_penulis')->nullable();
            $table->boolean('aktif')->default(true);
            $table->text('pertanyaan')->nullable();
            $table->text('jawaban_benar')->nullable();
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
            $table->boolean('tetap_di_bawah')->default(false);
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
        Schema::create('logaktivitas', function (Blueprint $table) {
            $table->increments('id_log');
            $table->unsignedInteger('id_user');
            $table->text('aktivitas');
            $table->dateTime('waktu')->nullable();
        });

        DB::table('tipeuser')->insert([
            ['id_tipeuser' => 1, 'nama_tipe' => 'Admin'],
            ['id_tipeuser' => 2, 'nama_tipe' => 'Guru'],
            ['id_tipeuser' => 3, 'nama_tipe' => 'Siswa'],
        ]);
        DB::table('jenjang')->insert(['id_jenjang' => 1, 'nama_tipe' => 'SMA']);
        DB::table('mapel')->insert(['id_mapel' => 1, 'kode_mapel' => 'MTK', 'nama_mapel' => 'Matematika', 'id_jenjang' => 1]);
        DB::table('tipequiz')->insert([
            ['id_tipequiz' => 1, 'nama_tipe' => 'Harian'],
            ['id_tipequiz' => 2, 'nama_tipe' => 'Ulangan'],
            ['id_tipequiz' => 3, 'nama_tipe' => 'Dungeon'],
        ]);
        DB::table('tingkatquiz')->insert(['id_tingkatquiz' => 1, 'nama_tingkat' => 'Mudah']);
        DB::table('jenis_soal')->insert([
            ['id_jenis_soal' => 1, 'nama_jenis' => 'Pilihan Ganda'],
            ['id_jenis_soal' => 2, 'nama_jenis' => 'Essay'],
            ['id_jenis_soal' => 3, 'nama_jenis' => 'Benar/Salah'],
        ]);
    }

    private function makeAdmin(): User
    {
        return User::create([
            'id_user' => 1,
            'nama' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'id_tipeuser' => 1,
            'total_poin' => 0,
        ]);
    }

    private function makeStudent(int $id = 2): User
    {
        return User::create([
            'id_user' => $id,
            'nama' => 'Siswa ' . $id,
            'email' => "siswa{$id}@test.com",
            'password' => bcrypt('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'total_poin' => 0,
        ]);
    }

    public function test_exam_mode_hides_token_from_student_html_and_api_and_enforces_schedule_and_single_attempt(): void
    {
        $student = $this->makeStudent(2);
        $admin = $this->makeAdmin();

        $exam = Quiz::create([
            'judul' => 'Ujian Tengah Semester Rahasia',
            'id_tipequiz' => 1, // bahkan jika tidak diset manual ke 2, resolveExamMode atau token mengaktifkannya
            'id_tingkatquiz' => 1,
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'token' => 'UJIAN2026',
            'waktu_mulai' => now()->addHour(),
            'waktu_kadaluarsa' => now()->addHours(3),
            'opsi_preview' => 'lengkap', // harus dipaksa ke tipe_saja oleh model isPreviewLengkap
            'acak_soal' => true,
            'tampilkan_hasil_ujian' => false,
            'proggressQuiz' => 'Tersedia',
        ]);

        Soal::create([
            'id_quiz' => $exam->id_quiz,
            'id_mapel' => 1,
            'id_jenjang' => 1,
            'id_jenis_soal' => 2,
            'pertanyaan' => 'Soal Rahasia Ujian Nomor 1',
            'jawaban_benar' => '42',
            'poin' => 10,
        ]);

        $this->assertTrue($exam->isModeUjian());
        $this->assertTrue($exam->belumDimulai());
        $this->assertFalse($exam->isPreviewLengkap());

        // 1. HTML daftar quiz siswa TIDAK boleh membocorkan token via data-token atau teks halaman
        $this->actingAs($student);
        $listHtml = $this->get(route('siswa.quiz'))->assertOk();
        $listHtml->assertDontSee('UJIAN2026');
        $listHtml->assertDontSee('data-token');

        // 2. API quizzes menyembunyikan token dari siswa, namun menampilkan ke admin
        $studentJson = $this->getJson('/api/quizzes')->assertOk();
        $studentQuiz = collect($studentJson->json('data'))->firstWhere('id_quiz', $exam->id_quiz);
        $this->assertNotNull($studentQuiz);
        $this->assertNull($studentQuiz['token']);
        $this->assertTrue($studentQuiz['is_exam_mode']);

        $this->actingAs($admin);
        $adminJson = $this->getJson('/api/quizzes')->assertOk();
        $adminQuiz = collect($adminJson->json('data'))->firstWhere('id_quiz', $exam->id_quiz);
        $this->assertNotNull($adminQuiz);
        $this->assertSame('UJIAN2026', $adminQuiz['token']);

        // 3. Siswa tidak bisa mulai atau verifikasi token sebelum waktu_mulai
        $this->actingAs($student);
        $this->postJson("/api/quizzes/{$exam->id_quiz}/verify-token", ['token' => 'UJIAN2026'])
            ->assertStatus(422)
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('data.valid', false);

        // 4. Buka jadwal ujian (sedang berlangsung) -> token salah berulang kali memicu rate limiter
        $exam->update(['waktu_mulai' => now()->subMinutes(10)]);
        for ($i = 0; $i < 5; $i++) {
            $this->postJson("/api/quizzes/{$exam->id_quiz}/verify-token", ['token' => 'SALAH'])
                ->assertStatus(422);
        }
        $this->postJson("/api/quizzes/{$exam->id_quiz}/verify-token", ['token' => 'UJIAN2026'])
            ->assertStatus(429);

        RateLimiter::clear("quiz-token-{$exam->id_quiz}-{$student->id_user}");

        // 5. Submit 1x lewat API dengan evaluasi disembunyikan (tampilkan_hasil_ujian = false & masih aktif)
        $soal = $exam->soal()->firstOrFail();
        $submitRes = $this->postJson("/api/quizzes/{$exam->id_quiz}/submit", [
            'answers' => [$soal->id_soal => '42'],
        ])->assertOk();

        $this->assertTrue($submitRes->json('data.evaluasi_disembunyikan'));
        $this->assertSame([], $submitRes->json('data.evaluasi_jawaban'));

        // 6. Mode Ujian membatasi 1 kali percobaan -> percobaan kedua ditolak
        $this->postJson("/api/quizzes/{$exam->id_quiz}/verify-token", ['token' => 'UJIAN2026'])
            ->assertStatus(422);
        $this->postJson("/api/quizzes/{$exam->id_quiz}/submit", [
            'answers' => [$soal->id_soal => '42'],
        ])->assertStatus(422);

        // 7. Token quiz tetap kadaluarsa saat melewati waktu_kadaluarsa
        $exam->update(['waktu_kadaluarsa' => now()->subMinute()]);
        $this->assertTrue($exam->fresh()->sudahKadaluarsa());
    }

    public function test_exam_mode_shuffles_questions_deterministically_per_student(): void
    {
        $studentA = $this->makeStudent(10);
        $studentB = $this->makeStudent(11);

        $exam = Quiz::create([
            'judul' => 'Ujian Acak Deterministik',
            'id_tipequiz' => 2,
            'id_tingkatquiz' => 1,
            'token' => 'ACAK99',
            'acak_soal' => true,
        ]);

        foreach (range(1, 8) as $num) {
            Soal::create([
                'id_quiz' => $exam->id_quiz,
                'id_jenis_soal' => 2,
                'pertanyaan' => "Soal {$num}",
                'jawaban_benar' => (string) $num,
            ]);
        }

        $firstOrderA = $exam->getOrderedSoalForUser($studentA->id_user)->pluck('id_soal')->all();
        $secondOrderA = $exam->getOrderedSoalForUser($studentA->id_user)->pluck('id_soal')->all();
        $orderB = $exam->getOrderedSoalForUser($studentB->id_user)->pluck('id_soal')->all();

        $this->assertSame($firstOrderA, $secondOrderA);
        $this->assertNotSame($firstOrderA, $orderB);
    }

    public function test_bank_soal_quality_gate_isolation_and_crud_operations(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin);

        // 1. Quality Gate: PG tanpa opsi/kunci dianggap tidak layak
        $incomplete = Soal::create([
            'id_quiz' => null,
            'id_mapel' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Soal PG belum lengkap',
            'jawaban_benar' => '',
        ]);
        $checkIncomplete = $incomplete->cekKelayakan();
        $this->assertFalse($checkIncomplete['layak']);
        $this->assertNotEmpty($checkIncomplete['masalah']);

        // 2. Store Batch via Kahoot Bank Builder mengisi jawaban_benar PG + kategori_bank
        $this->post(route('soal.store'), [
            'id_mapel' => 1,
            'id_jenjang' => 1,
            'kategori_bank' => 'ujian',
            'soal' => [[
                'pertanyaan' => 'Berapa 5 + 5?',
                'jenis_soal' => 'kuis',
                'tingkat_soal' => 'mudah',
                'poin' => 10,
                'durasi_detik' => 20,
                'pilihan' => [
                    ['label' => 'A', 'teks_pilihan' => '9', 'is_correct' => '0'],
                    ['label' => 'B', 'teks_pilihan' => '10', 'is_correct' => '1'],
                    ['label' => 'C', 'teks_pilihan' => '11', 'is_correct' => '0'],
                    ['label' => 'D', 'teks_pilihan' => '12', 'is_correct' => '0'],
                ],
            ]],
        ])->assertRedirect(route('admin.soal'));

        $soalUjian = Soal::where('pertanyaan', 'Berapa 5 + 5?')->firstOrFail();
        $this->assertSame('B', $soalUjian->jawaban_benar);
        $this->assertSame('ujian', $soalUjian->kategori_bank);
        $this->assertTrue($soalUjian->cekKelayakan()['layak']);

        // 3. Buat soal umum lewat Import CSV (cek kunci PG tersimpan sebagai label 'C', Benar/Salah 'A', & tolak duplikat)
        $csv = "pertanyaan;jenis;tingkat;opsi_a;opsi_b;opsi_c;opsi_d;kunci;poin;durasi;peruntukan\n"
            . "Hasil 3 x 4 adalah;pilihan_ganda;mudah;9;10;12;14;C;10;20;umum\n"
            . "Hasil  3 x 4  adalah;pilihan_ganda;mudah;9;10;12;14;C;10;20;umum\n"
            . "Indonesia terletak di Asia Tenggara;benar_salah;mudah;Benar;Salah;;;Benar;10;20;umum\n";
        $csvFile = UploadedFile::fake()->createWithContent('import.csv', $csv);

        $this->post(route('soal.import.csv'), [
            'csv_file' => $csvFile,
            'id_mapel' => 1,
            'id_jenjang' => 1,
            'kategori_bank' => 'umum',
        ])->assertRedirect(route('admin.soal'));

        $soalPgCsv = Soal::where('pertanyaan', 'Hasil 3 x 4 adalah')->firstOrFail();
        $this->assertSame('C', $soalPgCsv->jawaban_benar);
        $this->assertSame(1, Soal::where('pertanyaan', 'like', '%3 x 4%')->count()); // duplikat spasi ditolak

        $soalTfCsv = Soal::where('pertanyaan', 'Indonesia terletak di Asia Tenggara')->firstOrFail();
        $this->assertSame('A', $soalTfCsv->jawaban_benar);

        // 4. apiBankSoal?for_dungeon=1 mengecualikan soal Khusus Ujian
        $dungeonApi = $this->getJson('/api/soal/bank-data?sumber=bank&for_dungeon=1')->assertOk();
        $returnedIds = collect($dungeonApi->json('data'))->pluck('id_soal')->all();
        $this->assertNotContains($soalUjian->id_soal, $returnedIds);
        $this->assertContains($soalPgCsv->id_soal, $returnedIds);

        // 5. Assign ke Dungeon memblokir soal Khusus Ujian, namun mengizinkan soal Umum
        $dungeonQuiz = Quiz::create([
            'judul' => 'Dungeon Matematika',
            'id_tipequiz' => 3,
            'id_mapel' => 1,
            'id_jenjang' => 1,
        ]);

        $this->postJson('/api/soal/assign-to-quiz', [
            'id_quiz' => $dungeonQuiz->id_quiz,
            'soal_ids' => [$soalUjian->id_soal, $soalPgCsv->id_soal],
        ])->assertOk()->assertJsonPath('inserted', 1)->assertJsonPath('skipped', 1);

        // 6. Filter unused_only tidak lagi menampilkan soal yang sudah dipakai di kuis
        $unusedApi = $this->getJson('/api/soal/bank-data?sumber=bank&unused_only=1')->assertOk();
        $unusedIds = collect($unusedApi->json('data'))->pluck('id_soal')->all();
        $this->assertNotContains($soalPgCsv->id_soal, $unusedIds);
        $this->assertContains($soalUjian->id_soal, $unusedIds);

        // 7. Batch update & duplicate
        $this->post(route('soal.batch.update'), [
            'soal_ids' => [$soalTfCsv->id_soal],
            'kategori_bank' => 'ujian',
        ])->assertRedirect();
        $this->assertSame('ujian', $soalTfCsv->fresh()->kategori_bank);

        $this->post(route('soal.duplicate', $soalUjian->id_soal))->assertRedirect();
        $this->assertTrue(Soal::where('pertanyaan', '[Salinan] Berapa 5 + 5?')->where('kategori_bank', 'ujian')->exists());
    }
}


<?php

namespace Tests\Feature;

use App\Models\Jenjang;
use App\Models\Modul;
use App\Models\ModulSoal;
use App\Models\ModulSoalPilihan;
use App\Models\ProgresModulSiswa;
use App\Models\TipeModul;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ModulQuizIntegrationTest extends TestCase
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

        Schema::create('tipemodul', function (Blueprint $table) {
            $table->increments('id_tipemodul');
            $table->string('nama_tipe');
        });

        Schema::create('modul', function (Blueprint $table) {
            $table->increments('id_modul');
            $table->string('judul_modul');
            $table->string('file_materi')->nullable();
            $table->string('tipe_file', 50)->nullable();
            $table->unsignedInteger('id_tipemodul')->default(1);
            $table->unsignedInteger('id_jenjang');
            $table->unsignedInteger('id_quiz')->nullable();
            $table->string('progressModul')->nullable();
            $table->integer('kkm_quiz')->default(70);
            $table->integer('poin_modul')->default(50);
            $table->string('foto_modul')->nullable();
            $table->timestamps();
        });

        Schema::create('modul_soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->unsignedInteger('id_modul');
            $table->text('pertanyaan');
            $table->integer('poin')->default(10);
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });

        Schema::create('modul_soal_pilihan', function (Blueprint $table) {
            $table->increments('id_pilihan');
            $table->unsignedInteger('id_soal');
            $table->string('label', 10)->nullable();
            $table->text('teks_pilihan');
            $table->boolean('is_benar')->default(false);
            $table->timestamps();
        });

        Schema::create('progres_modul_siswa', function (Blueprint $table) {
            $table->increments('id_progres');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_modul');
            $table->boolean('materi_selesai')->default(false);
            $table->boolean('quiz_selesai')->default(false);
            $table->boolean('quiz_lulus')->default(false);
            $table->integer('nilai_quiz')->default(0);
            $table->boolean('is_tuntas')->default(false);
            $table->integer('poin_didapat')->default(0);
            $table->dateTime('waktu_materi_selesai')->nullable();
            $table->dateTime('waktu_quiz_selesai')->nullable();
            $table->dateTime('waktu_tuntas')->nullable();
            $table->timestamps();
            $table->unique(['id_user', 'id_modul']);
        });

        \Illuminate\Support\Facades\DB::table('jenjang')->insert([
            ['id_jenjang' => 1, 'nama_tipe' => 'SD'],
            ['id_jenjang' => 2, 'nama_tipe' => 'SMP'],
            ['id_jenjang' => 3, 'nama_tipe' => 'SMA'],
        ]);

        \Illuminate\Support\Facades\DB::table('tipemodul')->insert([
            ['id_tipemodul' => 1, 'nama_tipe' => 'Video'],
            ['id_tipemodul' => 2, 'nama_tipe' => 'PDF'],
        ]);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('progres_modul_siswa');
        Schema::dropIfExists('modul_soal_pilihan');
        Schema::dropIfExists('modul_soal');
        Schema::dropIfExists('modul');
        Schema::dropIfExists('tipemodul');
        Schema::dropIfExists('jenjang');
        Schema::dropIfExists('user');

        parent::tearDown();
    }

    public function test_admin_dapat_membuat_modul_dengan_soal_kuis_evaluasi(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin);

        $payload = [
            'action_type' => 'publish',
            'judul_modul' => 'Matematika Aljabar Dasar',
            'id_jenjang' => 2,
            'id_tipemodul' => 1,
            'file_link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'poin_modul' => 80,
            'kkm_quiz' => 75,
            'soal' => [
                [
                    'pertanyaan' => 'Berapa nilai x jika 2x + 4 = 10?',
                    'kunci' => 1, // Opsi B (index 1) adalah benar
                    'pilihan' => [
                        ['teks' => '2'],
                        ['teks' => '3'],
                        ['teks' => '4'],
                        ['teks' => '5'],
                    ],
                ],
                [
                    'pertanyaan' => 'Hasil dari 5 x 6 adalah...',
                    'kunci' => 2, // Opsi C (index 2) adalah benar
                    'pilihan' => [
                        ['teks' => '25'],
                        ['teks' => '28'],
                        ['teks' => '30'],
                        ['teks' => '35'],
                    ],
                ],
            ],
        ];

        $response = $this->post(route('admin.modul.store'), $payload);
        $response->assertRedirect(route('admin.modul'));

        $modul = Modul::where('judul_modul', 'Matematika Aljabar Dasar')->first();
        $this->assertNotNull($modul);
        $this->assertSame(80, (int) $modul->poin_modul);
        $this->assertSame(75, (int) $modul->kkm_quiz);
        $this->assertTrue($modul->hasQuizModul());

        // Verifikasi soal tersimpan di tabel modul_soal
        $soalList = ModulSoal::where('id_modul', $modul->id_modul)->orderBy('urutan')->get();
        $this->assertCount(2, $soalList);

        // Verifikasi pilihan dan kunci jawaban soal #1
        $soal1 = $soalList[0];
        $this->assertSame('Berapa nilai x jika 2x + 4 = 10?', $soal1->pertanyaan);
        $pilihan1 = ModulSoalPilihan::where('id_soal', $soal1->id_soal)->get();
        $this->assertCount(4, $pilihan1);
        $kunci1 = $pilihan1->firstWhere('is_benar', true);
        $this->assertNotNull($kunci1);
        $this->assertSame('3', $kunci1->teks_pilihan);
    }

    public function test_admin_dapat_memperbarui_soal_kuis_modul(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin);

        $modul = Modul::create([
            'judul_modul' => 'IPA Tata Surya',
            'id_jenjang' => 1,
            'id_tipemodul' => 1,
            'progressModul' => 'Tersedia',
            'poin_modul' => 50,
            'kkm_quiz' => 70,
        ]);

        $updatePayload = [
            'action_type' => 'publish',
            'judul_modul' => 'IPA Tata Surya Revisi',
            'id_jenjang' => 1,
            'id_tipemodul' => 1,
            'poin_modul' => 100,
            'kkm_quiz' => 80,
            'soal' => [
                [
                    'pertanyaan' => 'Planet terdekat dari matahari adalah...',
                    'kunci' => 0, // Merkurius (A)
                    'pilihan' => [
                        ['teks' => 'Merkurius'],
                        ['teks' => 'Venus'],
                        ['teks' => 'Bumi'],
                        ['teks' => 'Mars'],
                    ],
                ],
            ],
        ];

        $response = $this->put(route('admin.modul.update', $modul->id_modul), $updatePayload);
        $response->assertRedirect(route('admin.modul'));

        $modul->refresh();
        $this->assertSame('IPA Tata Surya Revisi', $modul->judul_modul);
        $this->assertSame(100, (int) $modul->poin_modul);
        $this->assertSame(80, (int) $modul->kkm_quiz);

        $soalList = ModulSoal::where('id_modul', $modul->id_modul)->get();
        $this->assertCount(1, $soalList);
        $this->assertSame('Planet terdekat dari matahari adalah...', $soalList->first()->pertanyaan);
    }

    public function test_modul_dengan_kuis_belum_tuntas_jika_hanya_materi_selesai(): void
    {
        $siswa = $this->makeSiswa(1, 0);
        $this->actingAs($siswa);

        $modul = $this->createModulWithQuiz(1, 60, 70);

        // Siswa menandai materi selesai
        $response = $this->post(route('siswa.modul.selesai_materi', $modul->id_modul));
        $response->assertSessionHas('success');

        $progres = ProgresModulSiswa::where('id_user', $siswa->id_user)
            ->where('id_modul', $modul->id_modul)
            ->first();

        $this->assertNotNull($progres);
        $this->assertTrue($progres->materi_selesai);
        $this->assertFalse($progres->quiz_lulus);
        $this->assertFalse($progres->is_tuntas); // Belum tuntas karena ada kuis modul!
        $this->assertSame(0, (int) $siswa->fresh()->total_poin); // Poin belum diberikan!
    }

    public function test_siswa_gagal_kuis_jika_skor_dibawah_kkm_dan_tidak_dapat_poin(): void
    {
        $siswa = $this->makeSiswa(1, 0);
        $this->actingAs($siswa);

        $modul = $this->createModulWithQuiz(1, 50, 70);
        $soal = $modul->soalModul->first();
        $pilihanSalah = $soal->pilihan->firstWhere('is_benar', false);

        // Siswa submit jawaban salah
        $response = $this->post(route('siswa.modul.kuis_submit', $modul->id_modul), [
            'jawaban' => [
                $soal->id_soal => $pilihanSalah->id_pilihan,
            ],
        ]);

        $response->assertSessionHas('error');

        $progres = ProgresModulSiswa::where('id_user', $siswa->id_user)
            ->where('id_modul', $modul->id_modul)
            ->first();

        $this->assertNotNull($progres);
        $this->assertFalse($progres->quiz_lulus);
        $this->assertSame(0, (int) $progres->nilai_quiz);
        $this->assertFalse($progres->is_tuntas);
        $this->assertSame(0, (int) $siswa->fresh()->total_poin);
    }

    public function test_modul_tuntas_sempurna_dan_dapat_poin_saat_materi_selesai_dan_kuis_lulus(): void
    {
        $siswa = $this->makeSiswa(1, 100);
        $this->actingAs($siswa);

        $modul = $this->createModulWithQuiz(1, 50, 70);
        $soal = $modul->soalModul->first();
        $pilihanBenar = $soal->pilihan->firstWhere('is_benar', true);

        // 1. Siswa selesaikan materi
        $this->post(route('siswa.modul.selesai_materi', $modul->id_modul));

        // 2. Siswa kerjakan kuis dan lulus KKM (100 >= 70)
        $response = $this->post(route('siswa.modul.kuis_submit', $modul->id_modul), [
            'jawaban' => [
                $soal->id_soal => $pilihanBenar->id_pilihan,
            ],
        ]);

        $response->assertSessionHas('success');

        $progres = ProgresModulSiswa::where('id_user', $siswa->id_user)
            ->where('id_modul', $modul->id_modul)
            ->first();

        $this->assertNotNull($progres);
        $this->assertTrue($progres->materi_selesai);
        $this->assertTrue($progres->quiz_lulus);
        $this->assertSame(100, (int) $progres->nilai_quiz);
        $this->assertTrue($progres->is_tuntas); // Keduanya terpenuhi -> Modul Tuntas!
        $this->assertSame(50, (int) $progres->poin_didapat);

        // Poin siswa bertambah dari 100 + 50 = 150
        $this->assertSame(150, (int) $siswa->fresh()->total_poin);
    }

    public function test_mengerjakan_ulang_kuis_setelah_tuntas_tidak_memberikan_poin_ganda(): void
    {
        $siswa = $this->makeSiswa(1, 200);
        $this->actingAs($siswa);

        $modul = $this->createModulWithQuiz(1, 50, 70);
        $soal = $modul->soalModul->first();
        $pilihanBenar = $soal->pilihan->firstWhere('is_benar', true);

        // Langkah 1: Tuntaskan materi dan kuis pertama kali
        $this->post(route('siswa.modul.selesai_materi', $modul->id_modul));
        $this->post(route('siswa.modul.kuis_submit', $modul->id_modul), [
            'jawaban' => [$soal->id_soal => $pilihanBenar->id_pilihan],
        ]);

        $this->assertSame(250, (int) $siswa->fresh()->total_poin);

        // Langkah 2: Siswa mengulang kuis dan lulus lagi
        $this->post(route('siswa.modul.kuis_submit', $modul->id_modul), [
            'jawaban' => [$soal->id_soal => $pilihanBenar->id_pilihan],
        ]);

        // Poin harus tetap 250 (tidak ada exploit farming)
        $this->assertSame(250, (int) $siswa->fresh()->total_poin);
    }

    public function test_modul_tanpa_kuis_langsung_tuntas_saat_materi_selesai(): void
    {
        $siswa = $this->makeSiswa(1, 50);
        $this->actingAs($siswa);

        $modul = Modul::create([
            'judul_modul' => 'Modul Bacaan Ringan',
            'id_jenjang' => 1,
            'id_tipemodul' => 2,
            'progressModul' => 'Tersedia',
            'poin_modul' => 30,
        ]);

        // Karena tidak punya soal kuis modul, menandai materi langsung menuntaskan modul
        $response = $this->post(route('siswa.modul.selesai_materi', $modul->id_modul));
        $response->assertSessionHas('success');

        $progres = ProgresModulSiswa::where('id_user', $siswa->id_user)
            ->where('id_modul', $modul->id_modul)
            ->first();

        $this->assertNotNull($progres);
        $this->assertTrue($progres->materi_selesai);
        $this->assertTrue($progres->is_tuntas);
        $this->assertSame(80, (int) $siswa->fresh()->total_poin); // 50 + 30
    }

    private function createModulWithQuiz(int $idJenjang = 1, int $poinModul = 50, int $kkm = 70): Modul
    {
        $modul = Modul::create([
            'judul_modul' => 'Modul Biologi Sel ' . uniqid(),
            'id_jenjang' => $idJenjang,
            'id_tipemodul' => 1,
            'progressModul' => 'Tersedia',
            'poin_modul' => $poinModul,
            'kkm_quiz' => $kkm,
        ]);

        $soal = ModulSoal::create([
            'id_modul' => $modul->id_modul,
            'pertanyaan' => 'Organel sel yang berfungsi sebagai pembangkit energi adalah?',
            'poin' => 10,
            'urutan' => 1,
        ]);

        ModulSoalPilihan::create([
            'id_soal' => $soal->id_soal,
            'label' => 'A',
            'teks_pilihan' => 'Mitokondria',
            'is_benar' => true,
        ]);

        ModulSoalPilihan::create([
            'id_soal' => $soal->id_soal,
            'label' => 'B',
            'teks_pilihan' => 'Ribosom',
            'is_benar' => false,
        ]);

        return $modul->load('soalModul.pilihan');
    }

    private function makeAdmin(): User
    {
        return User::create([
            'nama' => 'Admin Pengelola Modul',
            'email' => 'admin-modul-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 1,
        ]);
    }

    private function makeSiswa(int $jenjang = 1, int $initialPoin = 0): User
    {
        return User::create([
            'nama' => 'Siswa Belajar Modul',
            'email' => 'siswa-modul-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => 3,
            'id_jenjang' => $jenjang,
            'total_poin' => $initialPoin,
        ]);
    }
}

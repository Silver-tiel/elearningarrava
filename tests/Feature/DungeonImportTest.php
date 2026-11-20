<?php

namespace Tests\Feature;

use App\Models\JenisSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeQuiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use Database\Seeders\MapelSeeder;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DungeonImportTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $guru;
    protected User $siswa;
    protected Mapel $mapelMatematika;
    protected Jenjang $jenjangSd;
    protected Quiz $regularQuiz;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(MasterDataSeeder::class);
        $this->seed(MapelSeeder::class);

        $this->jenjangSd = Jenjang::find(1);
        $this->mapelMatematika = Mapel::find(1);

        $this->admin = User::create([
            'nama' => 'Admin Import',
            'email' => 'admin-import@example.com',
            'nisn' => 'ADM991',
            'password' => Hash::make('password'),
            'id_tipeuser' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->guru = User::create([
            'nama' => 'Guru Import',
            'email' => 'guru-import@example.com',
            'nisn' => 'GRU991',
            'password' => Hash::make('password'),
            'id_tipeuser' => 2,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->siswa = User::create([
            'nama' => 'Siswa Test',
            'email' => 'siswa-import@example.com',
            'nisn' => 'SIS991',
            'password' => Hash::make('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        // Buat Kuis Biasa dengan 3 soal (2 PG, 1 Benar/Salah)
        $tipeKuisBiasa = TipeQuiz::firstOrCreate(['nama_tipe' => 'Latihan Harian']);
        $tingkatSedang = TingkatQuiz::where('id_tingkatquiz', 2)->first() ?? TingkatQuiz::first();

        $this->regularQuiz = Quiz::create([
            'judul' => 'Kuis Harian Operasi Hitung SD',
            'deskripsi' => 'Latihan penjumlahan',
            'id_tipequiz' => $tipeKuisBiasa->id_tipequiz,
            'id_tingkatquiz' => $tingkatSedang->id_tingkatquiz,
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'id_pembuat' => $this->guru->id_user,
            'durasi_total_menit' => 20,
            'proggressQuiz' => 'Tersedia',
        ]);

        $soal1 = Soal::create([
            'id_quiz' => $this->regularQuiz->id_quiz,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Berapa 12 + 15?',
            'jawaban_benar' => '27',
            'poin' => 10,
            'durasi_detik' => 20,
        ]);
        PilihanSoal::create(['id_soal' => $soal1->id_soal, 'label' => 'A', 'teks_pilihan' => '25', 'is_correct' => false]);
        PilihanSoal::create(['id_soal' => $soal1->id_soal, 'label' => 'B', 'teks_pilihan' => '27', 'is_correct' => true]);

        $soal2 = Soal::create([
            'id_quiz' => $this->regularQuiz->id_quiz,
            'id_jenis_soal' => 3, // Benar/Salah
            'pertanyaan' => '20 adalah bilangan genap.',
            'jawaban_benar' => 'Benar',
            'poin' => 10,
            'durasi_detik' => 15,
        ]);
        PilihanSoal::create(['id_soal' => $soal2->id_soal, 'label' => 'A', 'teks_pilihan' => 'Benar', 'is_correct' => true]);
        PilihanSoal::create(['id_soal' => $soal2->id_soal, 'label' => 'B', 'teks_pilihan' => 'Salah', 'is_correct' => false]);
    }

    public function test_guru_can_import_questions_from_regular_quiz_into_dungeon(): void
    {
        $this->actingAs($this->guru);

        $response = $this->post(route('dungeon.impor', $this->mapelMatematika->id_mapel), [
            'id_jenjang' => 1,
            'id_quiz_asal' => $this->regularQuiz->id_quiz,
            'tingkat_soal' => 'otomatis',
        ]);

        $response->assertRedirect(route('dungeon.index', ['jenjang' => 1]));
        $response->assertSessionHas('success');

        // Pastikan kuis dungeon Matematika SD terisi 2 soal
        $dungeonQuiz = Quiz::where('id_mapel', 1)
            ->where('id_jenjang', 1)
            ->whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
            ->first();

        $this->assertNotNull($dungeonQuiz);
        $this->assertEquals(2, $dungeonQuiz->soal()->count());

        // Soal PG otomatis mendapat tingkat 'sedang' (mengikuti tingkat kuis asal)
        $soalPg = $dungeonQuiz->soal()->where('id_jenis_soal', 1)->first();
        $this->assertEquals('sedang', $soalPg->tingkat_soal);
        $this->assertEquals($this->guru->id_user, $soalPg->id_penulis);
        $this->assertTrue((bool) $soalPg->aktif);

        // Soal Benar/Salah otomatis dipaksa menjadi tingkat 'mudah' sesuai aturan Dungeon
        $soalBs = $dungeonQuiz->soal()->where('id_jenis_soal', 3)->first();
        $this->assertEquals('mudah', $soalBs->tingkat_soal);
    }

    public function test_siswa_cannot_import_questions_to_dungeon(): void
    {
        $this->actingAs($this->siswa);

        $response = $this->post(route('dungeon.impor', $this->mapelMatematika->id_mapel), [
            'id_jenjang' => 1,
            'id_quiz_asal' => $this->regularQuiz->id_quiz,
            'tingkat_soal' => 'mudah',
        ]);

        $response->assertStatus(403);
    }
}

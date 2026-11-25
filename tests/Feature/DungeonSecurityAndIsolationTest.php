<?php

namespace Tests\Feature;

use App\Models\Jenjang;
use App\Models\JenisSoal;
use App\Models\Mapel;
use App\Models\Modul;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeModul;
use App\Models\TipeQuiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DungeonSecurityAndIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected User $siswa;
    protected User $guru;
    protected User $admin;
    protected Quiz $regularQuiz;
    protected Quiz $dungeonQuiz;
    protected Soal $dungeonSoal;
    protected Soal $regularSoal;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);

        // Pastikan TipeQuiz 'Dungeon' dan 'Harian' ada
        $tipeDungeon = TipeQuiz::firstOrCreate(['nama_tipe' => 'Dungeon']);
        $tipeKuis = TipeQuiz::where('nama_tipe', '!=', 'Dungeon')->first() 
            ?? TipeQuiz::create(['nama_tipe' => 'Harian']);
        $tingkatMudah = TingkatQuiz::first();
        $jenisPG = JenisSoal::first();

        $sd = Jenjang::where('id_jenjang', 1)->first() ?? Jenjang::create(['nama_tipe' => 'SD']);
        $mapel = Mapel::first() ?? Mapel::create(['nama_mapel' => 'Matematika', 'id_jenjang' => 1]);

        // 1 = Admin, 2 = Guru, 3 = Siswa
        $this->admin = User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin-dungeon@example.com',
            'nisn' => 'ADM001',
            'password' => Hash::make('password'),
            'id_tipeuser' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->guru = User::create([
            'nama' => 'Guru Penguji',
            'email' => 'guru-dungeon@example.com',
            'nisn' => 'GRU001',
            'password' => Hash::make('password'),
            'id_tipeuser' => 2,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->siswa = User::create([
            'nama' => 'Siswa Penguji',
            'email' => 'siswa-dungeon@example.com',
            'nisn' => 'SIS001',
            'password' => Hash::make('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        // Buat Kuis Biasa
        $this->regularQuiz = Quiz::create([
            'judul' => 'Kuis Biasa Matematika SD',
            'deskripsi' => 'Kuis latihan biasa',
            'id_tipequiz' => $tipeKuis->id_tipequiz,
            'id_tingkatquiz' => $tingkatMudah->id_tingkatquiz,
            'id_jenjang' => 1,
            'id_mapel' => $mapel->id_mapel,
            'id_pembuat' => $this->guru->id_user,
            'durasi_total_menit' => 15,
            'proggressQuiz' => 'Tersedia',
        ]);

        $this->regularSoal = Soal::create([
            'id_quiz' => $this->regularQuiz->id_quiz,
            'id_jenissoal' => $jenisPG->id_jenis_soal,
            'pertanyaan' => 'Berapa 1 + 1?',
            'jawaban_benar' => '2',
            'poin' => 10,
            'durasi_detik' => 20,
        ]);

        PilihanSoal::create([
            'id_soal' => $this->regularSoal->id_soal,
            'label' => 'A',
            'teks_pilihan' => '2',
            'is_correct' => true,
        ]);

        PilihanSoal::create([
            'id_soal' => $this->regularSoal->id_soal,
            'label' => 'B',
            'teks_pilihan' => '3',
            'is_correct' => false,
        ]);

        // Buat Kuis Dungeon
        $this->dungeonQuiz = Quiz::create([
            'judul' => 'Dungeon Matematika SD',
            'deskripsi' => 'Dungeon Soal Matematika SD',
            'id_tipequiz' => $tipeDungeon->id_tipequiz,
            'id_tingkatquiz' => $tingkatMudah->id_tingkatquiz,
            'id_jenjang' => 1,
            'id_mapel' => $mapel->id_mapel,
            'id_pembuat' => $this->admin->id_user,
            'durasi_total_menit' => 0,
            'proggressQuiz' => 'Tersedia',
        ]);

        $this->dungeonSoal = Soal::create([
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenissoal' => $jenisPG->id_jenis_soal,
            'pertanyaan' => 'Berapa 5 x 5 di Dungeon?',
            'jawaban_benar' => '25',
            'tingkat_soal' => 'mudah',
            'aktif' => true,
            'poin' => 10,
            'durasi_detik' => 20,
        ]);

        PilihanSoal::create([
            'id_soal' => $this->dungeonSoal->id_soal,
            'label' => 'A',
            'teks_pilihan' => '25',
            'is_correct' => true,
        ]);

        PilihanSoal::create([
            'id_soal' => $this->dungeonSoal->id_soal,
            'label' => 'B',
            'teks_pilihan' => '20',
            'is_correct' => false,
        ]);
    }

    public function test_katalog_quiz_web_tidak_menampilkan_kuis_dungeon(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.quiz'));

        $response->assertStatus(200);
        $response->assertSee('Kuis Biasa Matematika SD');
        $response->assertDontSee('Dungeon Matematika SD');
    }

    public function test_siswa_tidak_bisa_mengakses_detail_kuis_dungeon(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.quiz.detail', $this->dungeonQuiz->id_quiz));

        $response->assertStatus(404);
    }

    public function test_siswa_tidak_bisa_memulai_kuis_dungeon_lewat_jalur_biasa(): void
    {
        $response = $this->actingAs($this->siswa)->post(route('siswa.quiz.mulai', $this->dungeonQuiz->id_quiz));

        $response->assertStatus(404);
    }

    public function test_siswa_tidak_bisa_mengerjakan_kuis_dungeon_lewat_jalur_biasa(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.quiz.kerjakan', $this->dungeonQuiz->id_quiz));

        $response->assertStatus(404);
    }

    public function test_api_quizzes_tidak_memuat_kuis_dungeon(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/quizzes');

        $response->assertStatus(200);
        $response->assertJsonMissing(['judul' => 'Dungeon Matematika SD']);
        $response->assertJsonFragment(['judul' => 'Kuis Biasa Matematika SD']);
    }

    public function test_api_show_kuis_dungeon_mengembalikan_404_untuk_siswa(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/quizzes/' . $this->dungeonQuiz->id_quiz);

        $response->assertStatus(404);
    }

    public function test_api_question_bank_tidak_membocorkan_soal_dungeon(): void
    {
        $response = $this->actingAs($this->guru, 'sanctum')->getJson('/api/quizzes/questions/bank');

        $response->assertStatus(200);
        $response->assertJsonMissing(['pertanyaan' => 'Berapa 5 x 5 di Dungeon?']);
    }

    public function test_api_verify_token_menolak_kuis_dungeon(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->postJson('/api/quizzes/' . $this->dungeonQuiz->id_quiz . '/verify-token', [
            'token' => 'ABCDEF',
        ]);

        $response->assertStatus(404);
    }

    public function test_api_submit_quiz_menolak_kuis_dungeon(): void
    {
        $response = $this->actingAs($this->siswa, 'sanctum')->postJson('/api/quizzes/' . $this->dungeonQuiz->id_quiz . '/submit', [
            'answers' => [],
        ]);

        $response->assertStatus(404);
    }

    public function test_modul_menolak_dikaitkan_dengan_kuis_dungeon(): void
    {
        $tipeModul = TipeModul::first() ?? TipeModul::create(['nama_tipe' => 'Materi Pokok']);

        // Web store attempt
        $responseWeb = $this->actingAs($this->guru)->post(route('admin.modul.store'), [
            'judul_modul' => 'Modul Uji Dungeon',
            'id_tipemodul' => $tipeModul->id_tipemodul,
            'id_jenjang' => 1,
            'id_quiz' => $this->dungeonQuiz->id_quiz,
        ]);

        $responseWeb->assertSessionHasErrors(['id_quiz']);

        // API store attempt
        $responseApi = $this->actingAs($this->guru, 'sanctum')->postJson('/api/modules', [
            'judul_modul' => 'Modul API Uji Dungeon',
            'id_tipemodul' => $tipeModul->id_tipemodul,
            'id_jenjang' => 1,
            'id_quiz' => $this->dungeonQuiz->id_quiz,
        ]);

        $responseApi->assertStatus(422);
    }

    public function test_api_show_tidak_membocorkan_kunci_jawaban_kepada_siswa(): void
    {
        // Siswa memanggil API show kuis biasa
        $responseSiswa = $this->actingAs($this->siswa, 'sanctum')->getJson('/api/quizzes/' . $this->regularQuiz->id_quiz);

        $responseSiswa->assertStatus(200);
        $dataSiswa = $responseSiswa->json('data.soal.0');

        $this->assertNull($dataSiswa['jawaban_benar'], 'Jawaban benar harus null untuk siswa');
        foreach ($dataSiswa['pilihan'] as $pilihan) {
            $this->assertFalse($pilihan['is_correct'], 'is_correct harus false untuk siswa');
        }

        // Guru memanggil API show kuis biasa
        $responseGuru = $this->actingAs($this->guru, 'sanctum')->getJson('/api/quizzes/' . $this->regularQuiz->id_quiz);

        $responseGuru->assertStatus(200);
        $dataGuru = $responseGuru->json('data.soal.0');

        $this->assertEquals('2', $dataGuru['jawaban_benar'], 'Guru harus tetap dapat melihat jawaban benar');
        $correctChoice = collect($dataGuru['pilihan'])->firstWhere('label', 'A');
        $this->assertTrue($correctChoice['is_correct'], 'Guru harus tetap dapat melihat kunci jawaban di pilihan');
    }
}

<?php

namespace Tests\Feature;

use App\Models\DungeonPengaturan;
use App\Models\DungeonSesi;
use App\Models\DungeonSesiSoal;
use App\Models\JenisSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeQuiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DungeonEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected User $siswa;
    protected User $guru;
    protected User $admin;
    protected Jenjang $jenjangSd;
    protected Mapel $mapelIpa;
    protected Quiz $dungeonQuiz;
    protected Quiz $regularQuiz;
    protected TipeQuiz $tipeDungeon;
    protected JenisSoal $jenisPG;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);

        $this->tipeDungeon = TipeQuiz::firstOrCreate(['nama_tipe' => 'Dungeon']);
        $tipeHarian = TipeQuiz::where('nama_tipe', '!=', 'Dungeon')->first() ?? TipeQuiz::create(['nama_tipe' => 'Harian']);
        $tingkat = TingkatQuiz::first();
        $this->jenisPG = JenisSoal::where('id_jenis_soal', 1)->first() ?? JenisSoal::first();

        $this->jenjangSd = Jenjang::where('id_jenjang', 1)->first() ?? Jenjang::create(['nama_tipe' => 'SD']);
        $this->mapelIpa = Mapel::create(['nama_mapel' => 'IPA', 'id_jenjang' => $this->jenjangSd->id_jenjang]);

        $this->admin = User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin-dungeon-ep@example.com',
            'nisn' => 'ADM888',
            'password' => Hash::make('password'),
            'id_tipeuser' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->guru = User::create([
            'nama' => 'Guru Penguji',
            'email' => 'guru-dungeon-ep@example.com',
            'nisn' => 'GRU888',
            'password' => Hash::make('password'),
            'id_tipeuser' => 2,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->siswa = User::create([
            'nama' => 'Siswa Penguji',
            'email' => 'siswa-dungeon-ep@example.com',
            'nisn' => 'SIS888',
            'password' => Hash::make('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
            'total_poin' => 0,
        ]);

        // Kuis Dungeon
        $this->dungeonQuiz = Quiz::create([
            'judul' => 'Dungeon IPA SD',
            'deskripsi' => 'Dungeon Soal IPA SD',
            'id_tipequiz' => $this->tipeDungeon->id_tipequiz,
            'id_tingkatquiz' => $tingkat->id_tingkatquiz,
            'id_jenjang' => $this->jenjangSd->id_jenjang,
            'id_mapel' => $this->mapelIpa->id_mapel,
            'id_pembuat' => $this->admin->id_user,
            'durasi_total_menit' => 0,
            'proggressQuiz' => 'Tersedia',
        ]);

        // Kuis Biasa
        $this->regularQuiz = Quiz::create([
            'judul' => 'Kuis Harian IPA SD',
            'deskripsi' => 'Kuis harian biasa',
            'id_tipequiz' => $tipeHarian->id_tipequiz,
            'id_tingkatquiz' => $tingkat->id_tingkatquiz,
            'id_jenjang' => $this->jenjangSd->id_jenjang,
            'id_mapel' => $this->mapelIpa->id_mapel,
            'id_pembuat' => $this->guru->id_user,
            'durasi_total_menit' => 15,
            'proggressQuiz' => 'Tersedia',
        ]);

        // Buat minimal 30 soal (10 mudah, 10 sedang, 10 sulit) agar dungeon terbuka
        $this->isiBankSoalDungeon(10, 10, 10);
    }

    protected function isiBankSoalDungeon(int $mudah = 10, int $sedang = 10, int $sulit = 10): void
    {
        $tingkatList = ['mudah' => $mudah, 'sedang' => $sedang, 'sulit' => $sulit];

        foreach ($tingkatList as $tingkat => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $soal = Soal::create([
                    'id_quiz' => $this->dungeonQuiz->id_quiz,
                    'id_jenis_soal' => $this->jenisPG->id_jenis_soal,
                    'pertanyaan' => "Soal IPA {$tingkat} nomor {$i}",
                    'tingkat_soal' => $tingkat,
                    'jawaban_benar' => 'A',
                    'id_penulis' => $this->admin->id_user,
                    'aktif' => true,
                    'poin' => 10,
                ]);

                for ($p = 0; $p < 4; $p++) {
                    PilihanSoal::create([
                        'id_soal' => $soal->id_soal,
                        'label' => chr(65 + $p),
                        'teks_pilihan' => "Opsi {$tingkat} {$i} - " . chr(65 + $p),
                        'is_correct' => ($p === 0),
                        'tetap_di_bawah' => ($p === 3),
                    ]);
                }
            }
        }
    }

    public function test_api_requires_sanctum_authentication(): void
    {
        $response = $this->getJson('/api/dungeon');
        $response->assertStatus(401);

        $responseMulai = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/mulai");
        $responseMulai->assertStatus(401);
    }

    public function test_api_index_and_status_return_dungeon_info(): void
    {
        Sanctum::actingAs($this->siswa);

        $response = $this->getJson('/api/dungeon');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'id_jenjang',
                'dungeons' => [
                    '*' => ['id_mapel', 'nama_mapel', 'terbuka', 'total_soal', 'rekor_skor', 'lantai_tertinggi']
                ]
            ]);

        $responseStatus = $this->getJson("/api/dungeon/{$this->mapelIpa->id_mapel}");
        $responseStatus->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('status_dungeon.terbuka', true)
            ->assertJsonPath('mapel.nama_mapel', 'IPA');
    }

    public function test_web_index_and_show_accessible_by_student(): void
    {
        $this->actingAs($this->siswa);

        $response = $this->get('/dungeon');
        $response->assertStatus(200);
        $response->assertSee('id="mainSidebar"', false);

        $responseShow = $this->get("/dungeon/{$this->mapelIpa->id_mapel}");
        $responseShow->assertStatus(200);
        $responseShow->assertSee('sidebar-hidden');
        $responseShow->assertDontSee('id="mainSidebar"', false);
    }

    public function test_happy_path_full_round_via_api(): void
    {
        Sanctum::actingAs($this->siswa);

        // 1. Mulai petualangan
        $resMulai = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/mulai");
        $resMulai->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('sesi.nyawa', 3)
            ->assertJsonPath('is_resume', false);

        $sesiId = $resMulai->json('sesi.id');
        $soal = $resMulai->json('soal');
        $this->assertNotNull($soal);
        $this->assertArrayNotHasKey('is_correct', $soal);
        $this->assertArrayNotHasKey('jawaban_benar', $soal);

        // 2. Jawab benar soal pertama
        $pilihanBenar = PilihanSoal::where('id_soal', $soal['id_soal'])->where('is_correct', true)->first();
        $resJawab1 = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/jawab", [
            'id_soal' => $soal['id_soal'],
            'jawaban' => $pilihanBenar->id_pilihan,
        ]);

        $resJawab1->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('hasil.is_benar', true)
            ->assertJsonPath('hasil.status_sesi.nyawa', 3)
            ->assertJsonPath('hasil.status_sesi.jumlah_benar', 1);

        $soalBerikutnya = $resJawab1->json('hasil.soal_berikutnya');
        $this->assertNotNull($soalBerikutnya);

        // 3. Jawab salah 1x (nyawa 3 -> 2)
        $pilihanSalah1 = PilihanSoal::where('id_soal', $soalBerikutnya['id_soal'])->where('is_correct', false)->first();
        $resJawab2 = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/jawab", [
            'id_soal' => $soalBerikutnya['id_soal'],
            'jawaban' => $pilihanSalah1->id_pilihan,
        ]);

        $resJawab2->assertStatus(200)
            ->assertJsonPath('hasil.is_benar', false)
            ->assertJsonPath('hasil.status_sesi.nyawa', 2);

        $soalBerikutnya2 = $resJawab2->json('hasil.soal_berikutnya');
        $this->assertNotNull($soalBerikutnya2);

        // 4. Jawab salah ke-2x (nyawa 2 -> 1)
        $pilihanSalah2 = PilihanSoal::where('id_soal', $soalBerikutnya2['id_soal'])->where('is_correct', false)->first();
        $resJawab3 = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/jawab", [
            'id_soal' => $soalBerikutnya2['id_soal'],
            'jawaban' => $pilihanSalah2->id_pilihan,
        ]);

        $resJawab3->assertStatus(200)
            ->assertJsonPath('hasil.is_benar', false)
            ->assertJsonPath('hasil.status_sesi.nyawa', 1);

        $soalBerikutnya3 = $resJawab3->json('hasil.soal_berikutnya');
        $this->assertNotNull($soalBerikutnya3);

        // 5. Jawab salah ke-3x (nyawa 1 -> 0: Game Over / Petualangan Berakhir)
        $pilihanSalah3 = PilihanSoal::where('id_soal', $soalBerikutnya3['id_soal'])->where('is_correct', false)->first();
        $resJawab4 = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/jawab", [
            'id_soal' => $soalBerikutnya3['id_soal'],
            'jawaban' => $pilihanSalah3->id_pilihan,
        ]);

        $resJawab4->assertStatus(200)
            ->assertJsonPath('hasil.is_benar', false)
            ->assertJsonPath('hasil.status_sesi.nyawa', 0)
            ->assertJsonPath('hasil.status_sesi.selesai', true)
            ->assertJsonPath('hasil.status_sesi.alasan_selesai', 'nyawa_habis');

        // Pastikan di database sesi ditandai selesai dan kunci_aktif NULL
        $sesiDb = DungeonSesi::find($sesiId);
        $this->assertNotNull($sesiDb->selesai);
        $this->assertNull($sesiDb->kunci_aktif);
        $this->assertEquals('nyawa_habis', $sesiDb->alasan_selesai);
    }

    public function test_resume_active_session_when_started_again(): void
    {
        Sanctum::actingAs($this->siswa);

        $res1 = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/mulai");
        $res1->assertStatus(200)->assertJsonPath('is_resume', false);
        $sesiId1 = $res1->json('sesi.id');

        // Mulai lagi saat sesi masih berjalan
        $res2 = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/mulai");
        $res2->assertStatus(200)->assertJsonPath('is_resume', true);
        $this->assertEquals($sesiId1, $res2->json('sesi.id'));
    }

    public function test_rejects_expired_or_timeout_answer(): void
    {
        Sanctum::actingAs($this->siswa);

        $resMulai = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/mulai");
        $sesiId = $resMulai->json('sesi.id');
        $soal = $resMulai->json('soal');

        // Manipulasi waktu batas soal di database menjadi lampau
        DungeonSesiSoal::where('id_sesi', $sesiId)
            ->where('id_soal', $soal['id_soal'])
            ->update([
                'batas_waktu' => now()->subSeconds(30),
            ]);

        $pilihanBenar = PilihanSoal::where('id_soal', $soal['id_soal'])->where('is_correct', true)->first();

        $resJawab = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/jawab", [
            'id_soal' => $soal['id_soal'],
            'jawaban' => $pilihanBenar->id_pilihan,
        ]);

        $resJawab->assertStatus(200)
            ->assertJsonPath('hasil.is_benar', false)
            ->assertJsonPath('hasil.is_timeout', true);
    }

    public function test_player_can_abandon_session(): void
    {
        Sanctum::actingAs($this->siswa);

        $resMulai = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/mulai");
        $sesiId = $resMulai->json('sesi.id');

        $resSelesai = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/selesai");
        $resSelesai->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('sesi.alasan_selesai', 'keluar');

        $sesiDb = DungeonSesi::find($sesiId);
        $this->assertNotNull($sesiDb->selesai);
        $this->assertEquals('keluar', $sesiDb->alasan_selesai);
        $this->assertNull($sesiDb->kunci_aktif);
    }

    public function test_report_question_endpoint(): void
    {
        Sanctum::actingAs($this->siswa);

        $soal = Soal::where('id_quiz', $this->dungeonQuiz->id_quiz)->first();

        $response = $this->postJson("/api/dungeon/{$this->mapelIpa->id_mapel}/lapor", [
            'id_soal' => $soal->id_soal,
            'alasan' => 'Terdapat kesalahan pada opsi jawaban',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('dungeon_laporan_soal', [
            'id_soal' => $soal->id_soal,
            'id_user' => $this->siswa->id_user,
            'alasan' => 'Terdapat kesalahan pada opsi jawaban',
        ]);
    }

    public function test_riwayat_endpoint_and_standard_leaderboard_integration(): void
    {
        Sanctum::actingAs($this->siswa);

        // Buat sesi selesai untuk siswa
        DungeonSesi::create([
            'id_user' => $this->siswa->id_user,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapelIpa->id_mapel,
            'ronde_ke' => 1,
            'mulai' => now()->subHour(),
            'selesai' => now()->subMinutes(30),
            'alasan_selesai' => 'keluar',
            'jumlah_benar' => 10,
            'jumlah_salah' => 1,
            'nyawa' => 2,
            'lantai_tertinggi' => 3,
            'skor_dungeon' => 150,
            'multiplier_akhir' => 1.5,
            'poin_profil_didapat' => 15,
            'poin_sudah_diberikan' => true,
        ]);

        $resRiwayat = $this->getJson('/api/dungeon/riwayat');
        $resRiwayat->assertStatus(200)->assertJsonPath('success', true);

        // Peringkat menggunakan leaderboard reguler aplikasi (/leaderboard)
        $resStandardLeaderboard = $this->getJson('/api/leaderboard');
        $resStandardLeaderboard->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use App\Models\DungeonLaporanSoal;
use App\Models\DungeonSesi;
use App\Models\JenisSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\OrangtuaSiswa;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeQuiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DungeonAdminAndModerationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $guru;
    protected User $siswa;
    protected User $orangtua;
    protected Mapel $mapel;
    protected Quiz $dungeonQuiz;
    protected Quiz $regularQuiz;
    protected Soal $soal;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);

        $tipeDungeon = TipeQuiz::firstOrCreate(['nama_tipe' => 'Dungeon']);
        $tipeHarian = TipeQuiz::where('nama_tipe', '!=', 'Dungeon')->first() ?? TipeQuiz::create(['nama_tipe' => 'Harian']);
        $tingkat = TingkatQuiz::first();
        $jenisPG = JenisSoal::first();

        $jenjang = Jenjang::where('id_jenjang', 1)->first() ?? Jenjang::create(['nama_tipe' => 'SD']);
        $this->mapel = Mapel::first() ?? Mapel::create(['nama_mapel' => 'Matematika', 'id_jenjang' => 1]);

        $this->admin = User::create([
            'nama' => 'Admin Dungeon',
            'email' => 'admin-mod@example.com',
            'nisn' => 'ADM777',
            'password' => Hash::make('password'),
            'id_tipeuser' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->guru = User::create([
            'nama' => 'Guru Dungeon',
            'email' => 'guru-mod@example.com',
            'nisn' => 'GRU777',
            'password' => Hash::make('password'),
            'id_tipeuser' => 2,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->siswa = User::create([
            'nama' => 'Siswa Dungeon',
            'email' => 'siswa-mod@example.com',
            'nisn' => 'SIS777',
            'password' => Hash::make('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->orangtua = User::create([
            'nama' => 'Orangtua Siswa',
            'email' => 'ortu-mod@example.com',
            'nisn' => 'ORT777',
            'password' => Hash::make('password'),
            'id_tipeuser' => 4,
            'status_akun' => 'Aktif',
        ]);

        OrangtuaSiswa::create([
            'id_orangtua' => $this->orangtua->id_user,
            'id_siswa' => $this->siswa->id_user,
        ]);

        $this->dungeonQuiz = Quiz::create([
            'judul' => 'Dungeon Matematika SD',
            'id_tipequiz' => $tipeDungeon->id_tipequiz,
            'id_tingkatquiz' => $tingkat->id_tingkatquiz,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapel->id_mapel,
            'id_pembuat' => $this->admin->id_user,
            'durasi_total_menit' => 0,
            'proggressQuiz' => 'Tersedia',
        ]);

        $this->regularQuiz = Quiz::create([
            'judul' => 'Kuis Harian Biasa',
            'id_tipequiz' => $tipeHarian->id_tipequiz,
            'id_tingkatquiz' => $tingkat->id_tingkatquiz,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapel->id_mapel,
            'id_pembuat' => $this->guru->id_user,
            'durasi_total_menit' => 10,
            'proggressQuiz' => 'Tersedia',
        ]);

        $this->soal = Soal::create([
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenis_soal' => $jenisPG->id_jenis_soal,
            'pertanyaan' => 'Pertanyaan yang akan dilaporkan',
            'tingkat_soal' => 'mudah',
            'jawaban_benar' => 'A',
            'id_penulis' => $this->admin->id_user,
            'aktif' => true,
        ]);
    }

    public function test_admin_and_guru_can_access_dungeon_management(): void
    {
        $this->actingAs($this->admin);
        $resAdmin = $this->get('/admin/dungeon/bank');
        $resAdmin->assertStatus(200);

        $resLapAdmin = $this->get('/admin/dungeon/laporan');
        $resLapAdmin->assertStatus(200);

        $this->actingAs($this->guru);
        $resGuru = $this->get('/admin/dungeon/bank');
        $resGuru->assertStatus(200);

        // Guru dan Admin juga langsung melihat panel manajemen & tombol Tambah Soal di halaman /dungeon
        $resDungeonGuru = $this->get('/dungeon?jenjang=1');
        $resDungeonGuru->assertStatus(200);
        $resDungeonGuru->assertSee('Tambah Soal');
        $resDungeonGuru->assertSee('Mudah');
        $resDungeonGuru->assertSee('Sedang');
        $resDungeonGuru->assertSee('Sulit');
    }

    public function test_student_cannot_access_admin_dungeon_management(): void
    {
        $this->actingAs($this->siswa);

        $resBank = $this->get('/admin/dungeon/bank');
        $resBank->assertStatus(403);
    }

    public function test_admin_can_resolve_reported_question(): void
    {
        $this->actingAs($this->admin);

        $laporan = DungeonLaporanSoal::create([
            'id_soal' => $this->soal->id_soal,
            'id_user' => $this->siswa->id_user,
            'alasan' => 'Ada kesalahan kunci',
            'status' => 'menunggu',
        ]);

        // Nonaktifkan
        $response = $this->postJson("/admin/dungeon/laporan/{$laporan->id}/putuskan", [
            'tindakan' => 'nonaktifkan',
            'catatan' => 'Disetujui untuk dinonaktifkan',
        ]);

        $response->assertStatus(200)->assertJsonPath('success', true);
        $this->assertEquals('diterima', $laporan->fresh()->status);
        $this->assertFalse((bool) $this->soal->fresh()->aktif);

        // Pulihkan
        $resPulihkan = $this->postJson("/admin/dungeon/laporan/{$laporan->id}/putuskan", [
            'tindakan' => 'pulihkan',
        ]);
        $resPulihkan->assertStatus(200)->assertJsonPath('success', true);
        $this->assertEquals('dipulihkan', $laporan->fresh()->status);
        $this->assertTrue((bool) $this->soal->fresh()->aktif);
    }

    public function test_admin_can_toggle_soal_status(): void
    {
        $this->actingAs($this->admin);

        $this->assertTrue((bool) $this->soal->aktif);

        // Toggle to false
        $res = $this->postJson("/admin/dungeon/soal/{$this->soal->id_soal}/toggle");
        $res->assertStatus(200)->assertJsonPath('aktif', false);
        $this->assertFalse((bool) $this->soal->fresh()->aktif);

        // Toggle back to true
        $res2 = $this->postJson("/admin/dungeon/soal/{$this->soal->id_soal}/toggle");
        $res2->assertStatus(200)->assertJsonPath('aktif', true);
        $this->assertTrue((bool) $this->soal->fresh()->aktif);
    }

    public function test_parent_dashboard_excludes_dungeon_from_available_quizzes(): void
    {
        $this->actingAs($this->orangtua);

        $response = $this->get('/orangtua/dashboard');
        $response->assertStatus(200);

        // Total kuis ada 2 di database: 1 biasa, 1 dungeon.
        // Dashboard orang tua harus menghitung kuis tersedia = 1 (karena bukanDungeon).
        $data = $response->viewData('stats');
        $this->assertEquals(1, $data['total_quiz_tersedia']);
    }

    public function test_weekly_report_command_runs_successfully(): void
    {
        $this->artisan('dungeon:weekly-report')
            ->assertExitCode(0);
    }
}

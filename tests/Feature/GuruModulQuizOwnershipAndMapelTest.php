<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\ModulSeeder;
use Database\Seeders\QuizSeeder;
use Database\Seeders\UserAwalSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GuruModulQuizOwnershipAndMapelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    private function createUserWithRole(int $tipeUser, string $nama, string $email, string $nisn, ?int $jenjang = 1): User
    {
        $user = User::create([
            'nama' => $nama,
            'email' => $email,
            'password' => Hash::make('password'),
            'nisn' => $nisn,
            'id_tipeuser' => $tipeUser,
            'id_jenjang' => $jenjang,
            'status_akun' => 'Aktif',
        ]);

        if ($tipeUser === 2) {
            Guru::create([
                'nama' => $nama,
                'nik' => $nisn,
                'no_telepon' => '081234567890',
            ]);
        }

        return $user;
    }

    public function test_seeder_modul_memiliki_mapel_dan_terhubung_ke_akun_guru(): void
    {
        $this->seed(UserAwalSeeder::class);
        $this->seed(QuizSeeder::class);
        $this->seed(ModulSeeder::class);

        $guruUser = User::where('id_tipeuser', 2)->firstOrFail();

        $modulSd = Modul::where('judul_modul', 'Dasar-Dasar Matematika SD')->firstOrFail();
        $modulSmp = Modul::where('judul_modul', 'Ilmu Pengetahuan Alam SMP: Ekosistem')->firstOrFail();
        $modulSma = Modul::where('judul_modul', 'Fisika SMA: Kinematika Gerak Lurus')->firstOrFail();

        $this->assertSame(1, (int) $modulSd->id_mapel);
        $this->assertSame(4, (int) $modulSmp->id_mapel);
        $this->assertSame(11, (int) $modulSma->id_mapel);

        $this->assertSame((int) $guruUser->id_user, (int) $modulSd->id_pembuat);
        $this->assertSame((int) $guruUser->id_user, (int) $modulSmp->id_pembuat);
        $this->assertSame((int) $guruUser->id_user, (int) $modulSma->id_pembuat);

        $this->assertTrue(Quiz::where('id_pembuat', $guruUser->id_user)->exists());
        $this->assertSame(3, $guruUser->modulsDibuat()->count());
        $this->assertSame(3, $guruUser->guru->moduls()->count());

        $siswaSd = User::where('id_tipeuser', 3)->where('id_jenjang', 1)->firstOrFail();
        $siswaPage = $this->actingAs($siswaSd)->get(route('siswa.modul'));
        $siswaPage->assertOk();
        $siswaPage->assertSee('Matematika');
        $siswaPage->assertSee('Semua Mapel');
    }

    public function test_guru_membuat_modul_dan_quiz_otomatis_tersambung_dan_terisolasi_per_guru(): void
    {
        $guruA = $this->createUserWithRole(2, 'Guru Alpha', 'alpha@arrava.test', '3201000000000101');
        $guruB = $this->createUserWithRole(2, 'Guru Beta', 'beta@arrava.test', '3201000000000102');

        $this->actingAs($guruA)->post(route('admin.modul.store'), [
            'judul_modul' => 'Modul Milik Alpha',
            'id_tipemodul' => 1,
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'file_link' => 'https://youtu.be/dQw4w9WgXcQ',
            'action_type' => 'publish',
        ])->assertRedirect(route('admin.modul'));

        $this->actingAs($guruA)->post(route('admin.quiz.store'), [
            'judul' => 'Quiz Milik Alpha',
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'id_tingkatquiz' => 1,
            'mode_pengerjaan' => 'wayground',
            'action_type' => 'draft',
        ])->assertRedirect(route('admin.quiz'));

        $modulAlpha = Modul::where('judul_modul', 'Modul Milik Alpha')->firstOrFail();
        $quizAlpha = Quiz::where('judul', 'Quiz Milik Alpha')->firstOrFail();

        $this->assertSame((int) $guruA->id_user, (int) $modulAlpha->id_pembuat);
        $this->assertSame((int) $guruA->id_user, (int) $quizAlpha->id_pembuat);

        // Modul milik Beta untuk uji isolasi
        $modulBeta = Modul::create([
            'judul_modul' => 'Modul Milik Beta',
            'id_tipemodul' => 1,
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'id_pembuat' => $guruB->id_user,
            'progressModul' => 'Tersedia',
        ]);

        // Guru Alpha melihat modul & quiz miliknya sendiri, tidak melihat milik Beta
        $modulIndexAlpha = $this->actingAs($guruA)->get(route('admin.modul'));
        $modulIndexAlpha->assertOk();
        $modulIndexAlpha->assertSee('Modul Milik Alpha');
        $modulIndexAlpha->assertSee('Guru Alpha');
        $modulIndexAlpha->assertDontSee('Modul Milik Beta');

        $quizIndexAlpha = $this->actingAs($guruA)->get(route('admin.quiz'));
        $quizIndexAlpha->assertOk();
        $quizIndexAlpha->assertSee('Quiz Milik Alpha');
        $quizIndexAlpha->assertSee('Guru Alpha');

        // Dashboard /admin milik Alpha terfilter hanya kontennya
        $dashboardAlpha = $this->actingAs($guruA)->get(route('admin'));
        $dashboardAlpha->assertOk();
        $dashboardAlpha->assertViewHas('modulCount', 1);
        $dashboardAlpha->assertViewHas('quizCount', 1);

        // Guru Alpha tidak boleh mengedit modul milik Beta
        $this->actingAs($guruA)->get(route('admin.modul.edit', $modulBeta->id_modul))->assertForbidden();
    }

    public function test_admin_dapat_menugaskan_pembuat_guru_dan_halaman_guru_menampilkan_jumlah_konten(): void
    {
        $admin = $this->createUserWithRole(1, 'Admin Utama', 'admin.owner@arrava.test', 'ADM-OWN-001', null);
        $guru = $this->createUserWithRole(2, 'Guru Assigned', 'assigned@arrava.test', '3201000000000201');

        $this->actingAs($admin)->post(route('admin.modul.store'), [
            'judul_modul' => 'Modul Penugasan Admin',
            'id_tipemodul' => 1,
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'id_pembuat' => $guru->id_user,
            'file_link' => 'https://youtu.be/9bZkp7q19f0',
            'action_type' => 'publish',
        ])->assertRedirect(route('admin.modul'));

        $this->actingAs($admin)->post(route('admin.quiz.store'), [
            'judul' => 'Quiz Penugasan Admin',
            'id_jenjang' => 1,
            'id_mapel' => 1,
            'id_tingkatquiz' => 1,
            'id_pembuat' => $guru->id_user,
            'mode_pengerjaan' => 'wayground',
            'action_type' => 'draft',
        ])->assertRedirect(route('admin.quiz'));

        $guruPage = $this->actingAs($admin)->get(route('admin.guru'));
        $guruPage->assertOk();
        $guruPage->assertSee('Guru Assigned');

        $apiTeachers = $this->actingAs($admin, 'sanctum')->getJson('/api/teachers');
        $apiTeachers->assertOk()
            ->assertJsonFragment([
                'nama' => 'Guru Assigned',
                'jumlah_modul' => 1,
                'jumlah_quiz' => 1,
            ]);
    }
}


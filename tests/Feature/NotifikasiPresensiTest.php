<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\OrangtuaSiswa;
use App\Models\Presensi;
use App\Models\SesiPresensi;
use App\Models\User;
use App\Services\NotifikasiPresensiService;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotifikasiPresensiTest extends TestCase
{
    use RefreshDatabase;

    private User $siswa;
    private User $orangtua;
    private User $admin;
    private Kelas $kelas;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(MasterDataSeeder::class);

        // 1. Buat User Siswa (id_jenjang = 1)
        $this->siswa = User::create([
            'nama' => 'Budi Siswa',
            'username' => 'budi_siswa',
            'email' => 'budi@test.com',
            'nisn' => '1234567890',
            'password' => bcrypt('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        // 2. Buat User Orang Tua (id_tipeuser = 4)
        $this->orangtua = User::create([
            'nama' => 'Pak Joko',
            'username' => 'pak_joko',
            'email' => 'joko@test.com',
            'nisn' => '9876543210',
            'password' => bcrypt('password'),
            'id_tipeuser' => 4,
            'status_akun' => 'Aktif',
        ]);

        // Hubungkan orang tua dengan siswa
        OrangtuaSiswa::create([
            'id_orangtua' => $this->orangtua->id_user,
            'id_siswa' => $this->siswa->id_user,
        ]);

        // 3. Buat User Admin
        $this->admin = User::create([
            'nama' => 'Admin Arrava',
            'username' => 'admin_arrava',
            'email' => 'admin@test.com',
            'nisn' => '1122334455',
            'password' => bcrypt('password'),
            'id_tipeuser' => 1,
            'status_akun' => 'Aktif',
        ]);

        // 4. Buat Kelas Aktif Hari Ini (hari = empty string / null = setiap hari)
        $this->kelas = Kelas::create([
            'nama' => 'Kelas 1 SD - Matematika',
            'id_jenjang' => 1,
            'tahun_ajaran' => '2026/2027',
            'aktif' => true,
            'hari' => null, // setiap hari aktif
            'jam_batas' => '08:00',
        ]);
    }

    public function test_notifikasi_menandakan_absen_muncul_jika_kelas_aktif_hari_ini_dan_belum_absen(): void
    {
        $notifs = NotifikasiPresensiService::untukSiswa($this->siswa);

        $this->assertNotEmpty($notifs);
        $hariIniNotif = collect($notifs)->firstWhere('kategori', 'hari_ini');
        $this->assertNotNull($hariIniNotif);
        $this->assertSame('Presensi Kelas Hari Ini', $hariIniNotif['judul']);
        $this->assertStringContainsString('Kelas 1 SD - Matematika', $hariIniNotif['pesan']);
    }

    public function test_notifikasi_menandakan_absen_tidak_muncul_jika_siswa_sudah_hadir(): void
    {
        // Buat sesi hari ini dan rekam kehadiran siswa
        $sesi = SesiPresensi::create([
            'id_kelas' => $this->kelas->id_kelas,
            'id_guru' => $this->admin->id_user,
            'judul' => 'Presensi Hari Ini',
            'pertemuan_ke' => 1,
            'tanggal' => now()->toDateString(),
            'status' => 'buka',
        ]);

        Presensi::create([
            'id_sesi' => $sesi->id_sesi,
            'id_siswa' => $this->siswa->id_user,
            'id_guru_pemindai' => $this->admin->id_user,
            'status' => 'hadir',
            'waktu_scan' => now(),
        ]);

        $notifs = NotifikasiPresensiService::untukSiswa($this->siswa);
        $hariIniNotif = collect($notifs)->firstWhere('kategori', 'hari_ini');
        $this->assertNull($hariIniNotif, 'Notifikasi hari ini tidak boleh muncul jika siswa sudah hadir');
    }

    public function test_notifikasi_melewatkan_absensi_muncul_jika_sesi_kemarin_tidak_dihadiri(): void
    {
        // Buat sesi kemarin yang tidak ada data scan siswa
        $sesiKemarin = SesiPresensi::create([
            'id_kelas' => $this->kelas->id_kelas,
            'id_guru' => $this->admin->id_user,
            'judul' => 'Presensi Kemarin',
            'pertemuan_ke' => 1,
            'tanggal' => now()->subDay()->toDateString(),
            'status' => 'buka',
        ]);

        $notifs = NotifikasiPresensiService::untukSiswa($this->siswa);
        $terlewatNotif = collect($notifs)->firstWhere('kategori', 'terlewat');

        $this->assertNotNull($terlewatNotif);
        $this->assertSame('Melewatkan Presensi', $terlewatNotif['judul']);
        $this->assertStringContainsString('Kamu melewatkan presensi', $terlewatNotif['pesan']);
    }

    public function test_notifikasi_orangtua_memantau_presensi_ananda(): void
    {
        $notifs = NotifikasiPresensiService::untukOrangtua($this->orangtua);

        $this->assertNotEmpty($notifs);
        $notifAnak = collect($notifs)->firstWhere('anak_id', $this->siswa->id_user);
        $this->assertNotNull($notifAnak);
        $this->assertStringContainsString('Budi Siswa', $notifAnak['judul']);
    }

    public function test_dashboard_siswa_menampilkan_widget_notifikasi_presensi(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('notifikasiPresensiRoot');
        $response->assertSee('Notifikasi Presensi');
        $response->assertSee('niere-mark-read-btn');
        $response->assertSee('Tandai Telah Dibaca');
    }

    public function test_dashboard_orangtua_menampilkan_widget_notifikasi_presensi(): void
    {
        $response = $this->actingAs($this->orangtua)->get(route('orangtua.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('notifikasiPresensiRoot');
        $response->assertSee('Notifikasi Presensi');
    }

    public function test_dashboard_orangtua_tanpa_siswa_terhubung_berhasil_render(): void
    {
        $orangtuaBaru = User::create([
            'nama' => 'Orangtua Tanpa Anak',
            'username' => 'orangtua_tanpa_anak',
            'email' => 'orangtua.alone@example.com',
            'nisn' => '9998887776',
            'password' => bcrypt('password'),
            'id_tipeuser' => 4,
            'status_akun' => 'Aktif',
        ]);

        $response = $this->actingAs($orangtuaBaru)->get(route('orangtua.dashboard'));

        $response->assertStatus(200);
    }

    public function test_halaman_admin_tidak_menampilkan_icon_notifikasi(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin'));

        $response->assertStatus(200);
        $response->assertDontSee('Icon Notifikasi');
        $response->assertDontSee('notifikasiPresensiRoot');
    }

    public function test_halaman_lain_siswa_tidak_menampilkan_widget_notifikasi(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.modul'));

        $response->assertStatus(200);
        $response->assertDontSee('notifikasiPresensiRoot');
    }

    public function test_halaman_quiz_siswa_tidak_menampilkan_niere(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('siswa.quiz'));

        $response->assertStatus(200);
        $response->assertDontSee('niere-widget-container');
    }

    public function test_endpoint_check_notifikasi_realtime_mengembalikan_json(): void
    {
        $response = $this->actingAs($this->siswa)->get(route('notifikasi.check'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'userId',
            'userName',
            'role',
            'notifikasi',
            'serverReadIds',
        ]);
    }

    public function test_endpoint_mark_read_notifikasi_berhasil(): void
    {
        $response = $this->actingAs($this->siswa)->postJson(route('notifikasi.mark_read'), [
            'id' => 'absen-today-1-2026-11-08',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }
}

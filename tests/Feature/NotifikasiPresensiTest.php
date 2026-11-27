<?php

namespace Tests\Feature;

use App\Models\HasilQuizModul;
use App\Models\Kelas;
use App\Models\Modul;
use App\Models\OrangtuaSiswa;
use App\Models\Presensi;
use App\Models\ProgresModulSiswa;
use App\Models\Quiz;
use App\Models\SesiPresensi;
use App\Models\User;
use App\Services\NotifikasiPresensiService;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
        $response->assertSee('data-dashboard-tab="overview"', false);
        $response->assertSee('data-dashboard-tab="siswa"', false);
        $response->assertSee('data-dashboard-tab="guru"', false);
    }

    public function test_dashboard_hanya_mengambil_query_yang_dibutuhkan_oleh_tampilan(): void
    {
        DB::enableQueryLog();

        try {
            DB::flushQueryLog();
            $this->actingAs($this->admin)->get(route('admin'))->assertOk();
            $overviewQueries = strtolower(implode(' ', array_column(DB::getQueryLog(), 'query')));

            $this->assertStringNotContainsString('hasilquizmodul', $overviewQueries);
            $this->assertStringNotContainsString('progres_modul_siswa', $overviewQueries);
            $this->assertStringNotContainsString('sesi_presensi', $overviewQueries);

            DB::flushQueryLog();
            $this->actingAs($this->admin)->get(route('admin', ['view' => 'siswa']))->assertOk();
            $studentQueries = strtolower(implode(' ', array_column(DB::getQueryLog(), 'query')));

            $this->assertStringContainsString('hasilquizmodul', $studentQueries);
            $this->assertStringContainsString('progres_modul_siswa', $studentQueries);
            $this->assertStringContainsString('sesi_presensi', $studentQueries);
        } finally {
            DB::disableQueryLog();
        }
    }

    public function test_dashboard_admin_menghitung_penyelesaian_siswa_per_hari_dalam_minggu_kalender(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-11-18 12:00:00'));

        try {
            $quiz = Quiz::create([
                'judul' => 'Kuis Grafik Mingguan',
                'id_tipequiz' => 1,
                'id_tingkatquiz' => 1,
                'id_jenjang' => 1,
            ]);

            foreach ([
                ['user' => $this->siswa, 'waktu' => '2026-11-16 08:00:00'],
                ['user' => $this->siswa, 'waktu' => '2026-11-16 09:00:00'],
                ['user' => $this->siswa, 'waktu' => '2026-11-22 18:00:00'],
                ['user' => $this->siswa, 'waktu' => '2026-11-15 23:59:00'],
                ['user' => $this->orangtua, 'waktu' => '2026-11-17 10:00:00'],
            ] as $hasil) {
                HasilQuizModul::create([
                    'id_user' => $hasil['user']->id_user,
                    'id_quiz' => $quiz->id_quiz,
                    'total_poin' => 10,
                    'poin_didapat' => 8,
                    'is_lulus' => true,
                    'waktu_dapat' => $hasil['waktu'],
                ]);
            }

            foreach ([
                ['judul' => 'Modul Grafik Selasa', 'waktu' => '2026-11-17 11:00:00'],
                ['judul' => 'Modul Grafik Jumat', 'waktu' => '2026-11-20 11:00:00'],
                ['judul' => 'Modul di Luar Minggu', 'waktu' => '2026-11-15 11:00:00'],
            ] as $item) {
                $modul = Modul::create([
                    'judul_modul' => $item['judul'],
                    'id_tipemodul' => 1,
                    'id_jenjang' => 1,
                ]);

                ProgresModulSiswa::create([
                    'id_user' => $this->siswa->id_user,
                    'id_modul' => $modul->id_modul,
                    'is_tuntas' => true,
                    'waktu_tuntas' => $item['waktu'],
                ]);
            }

            $this->actingAs($this->admin)
                ->get(route('admin', ['view' => 'siswa']))
                ->assertOk()
                ->assertSee('Penyelesaian Belajar Minggu Ini')
                ->assertSee('Senin sampai Minggu')
                ->assertViewHas('grafikPenyelesaianMingguan', function ($hari): bool {
                    $this->assertSame([
                        '2026-11-16',
                        '2026-11-17',
                        '2026-11-18',
                        '2026-11-19',
                        '2026-11-20',
                        '2026-11-21',
                        '2026-11-22',
                    ], $hari->pluck('tanggal')->all());
                    $this->assertSame([2, 0, 0, 0, 0, 0, 1], $hari->pluck('kuis')->all());
                    $this->assertSame([0, 1, 0, 0, 1, 0, 0], $hari->pluck('modul')->all());

                    return true;
                });
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_dashboard_admin_merangkum_nilai_keaktifan_progres_presensi_dan_pendaftaran(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-11-18 12:00:00'));

        try {
            $this->siswa->forceFill([
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ])->save();

            $siswaKedua = User::create([
                'nama' => 'Siswa Kedua',
                'username' => 'siswa_kedua',
                'email' => 'siswa.kedua@test.com',
                'nisn' => '1234567891',
                'password' => bcrypt('password'),
                'id_tipeuser' => 3,
                'id_jenjang' => 1,
                'status_akun' => 'Aktif',
            ]);
            $quiz = Quiz::create([
                'judul' => 'Kuis Statistik Dashboard',
                'id_tipequiz' => 1,
                'id_tingkatquiz' => 1,
                'id_jenjang' => 1,
            ]);

            foreach ([
                ['siswa' => $this->siswa, 'nilai' => 80, 'lulus' => true],
                ['siswa' => $this->siswa, 'nilai' => 40, 'lulus' => false],
                ['siswa' => $siswaKedua, 'nilai' => 60, 'lulus' => false],
            ] as $hasil) {
                HasilQuizModul::create([
                    'id_user' => $hasil['siswa']->id_user,
                    'id_quiz' => $quiz->id_quiz,
                    'total_poin' => 100,
                    'poin_didapat' => $hasil['nilai'],
                    'is_lulus' => $hasil['lulus'],
                    'waktu_dapat' => now()->subDay(),
                ]);
            }

            $modulPertama = Modul::create([
                'judul_modul' => 'Modul Tuntas Statistik',
                'id_tipemodul' => 1,
                'id_jenjang' => 1,
                'progressModul' => 'Tersedia',
            ]);
            Modul::create([
                'judul_modul' => 'Modul Belum Tuntas Statistik',
                'id_tipemodul' => 1,
                'id_jenjang' => 1,
                'progressModul' => 'Tersedia',
            ]);
            ProgresModulSiswa::create([
                'id_user' => $this->siswa->id_user,
                'id_modul' => $modulPertama->id_modul,
                'is_tuntas' => true,
                'waktu_tuntas' => now()->subDay(),
            ]);

            $sesiSelesai = SesiPresensi::create([
                'id_kelas' => $this->kelas->id_kelas,
                'id_guru' => $this->admin->id_user,
                'judul' => 'Sesi Selesai',
                'pertemuan_ke' => 1,
                'tanggal' => now()->subDay()->toDateString(),
                'status' => 'tutup',
            ]);
            SesiPresensi::create([
                'id_kelas' => $this->kelas->id_kelas,
                'id_guru' => $this->admin->id_user,
                'judul' => 'Sesi Belum Selesai',
                'pertemuan_ke' => 2,
                'tanggal' => now()->toDateString(),
                'status' => 'buka',
            ]);
            Presensi::create([
                'id_sesi' => $sesiSelesai->id_sesi,
                'id_siswa' => $this->siswa->id_user,
                'id_guru_pemindai' => $this->admin->id_user,
                'status' => 'hadir',
                'waktu_scan' => now()->subDay(),
            ]);

            $this->actingAs($this->admin)
                ->get(route('admin', ['view' => 'siswa']))
                ->assertOk()
                ->assertViewHas('jumlahSubmitKuis', 3)
                ->assertViewHas('rataNilaiKuis', 60.0)
                ->assertViewHas('persentaseLulusKuis', 33.3)
                ->assertViewHas('siswaAktifMingguIni', 2)
                ->assertViewHas('siswaAktif14HariIni', 2)
                ->assertViewHas('siswaTidakAktif14Hari', 0)
                ->assertViewHas('jumlahSiswaAktif', 2)
                ->assertViewHas('sesiPresensiSelesai', 1)
                ->assertViewHas('persentaseHadirMingguan', 50.0)
                ->assertViewHas('progressPerJenjang', function ($progress): bool {
                    $sd = $progress->firstWhere('jenjang', 'SD');
                    $this->assertSame(25.0, $sd['persentase']);
                    $this->assertSame(2, $sd['jumlah_siswa']);
                    $this->assertSame(2, $sd['jumlah_modul']);

                    return true;
                })
                ->assertSee('Hasil Kuis Minggu Ini')
                ->assertSee('Keaktifan Siswa')
                ->assertSee('Progres Modul per Jenjang')
                ->assertSee('Kehadiran Minggu Ini')
                ->assertDontSee('Pertumbuhan Pendaftaran');

            $this->actingAs($this->admin)
                ->get(route('admin', ['view' => 'overview']))
                ->assertOk()
                ->assertSee('Overview')
                ->assertSee('Pertumbuhan Pendaftaran')
                ->assertDontSee('Hasil Kuis Minggu Ini')
                ->assertViewHas('registrasiBulanan', function ($registration): bool {
                    $bulanIni = $registration->last();
                    $this->assertSame(2, $bulanIni['siswa']);
                    $this->assertSame(0, $bulanIni['guru']);

                    return true;
                });

            $this->actingAs($this->admin)
                ->get(route('admin', ['view' => 'guru', 'fragment' => 1]))
                ->assertOk()
                ->assertSee('id="dashboard-panel"', false)
                ->assertSee('Ringkasan Guru')
                ->assertSee('Pendaftaran Guru')
                ->assertDontSee('Hasil Kuis Minggu Ini');
        } finally {
            Carbon::setTestNow();
        }
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

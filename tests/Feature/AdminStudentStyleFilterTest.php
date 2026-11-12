<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminStudentStyleFilterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    private function createAdmin(): User
    {
        return User::create([
            'nama' => 'Admin Filter',
            'email' => 'admin.filter@arrava.test',
            'password' => Hash::make('password'),
            'nisn' => 'ADM-FILT-001',
            'id_tipeuser' => 1,
            'status_akun' => 'Aktif',
        ]);
    }

    public function test_halaman_modul_admin_menampilkan_filter_gaya_siswa_dan_mendukung_filter_mapel(): void
    {
        $admin = $this->createAdmin();

        $mapel = Mapel::first() ?? Mapel::create([
            'nama_mapel' => 'Matematika',
            'id_jenjang' => 1,
        ]);

        Modul::create([
            'judul_modul' => 'Modul Pecahan Terbit',
            'id_tipemodul' => 1,
            'id_jenjang' => 1,
            'id_mapel' => $mapel->id_mapel,
            'progressModul' => 'published',
        ]);

        Modul::create([
            'judul_modul' => 'Modul Aljabar Draft',
            'id_tipemodul' => 2,
            'id_jenjang' => 2,
            'progressModul' => 'draft',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.modul'));

        $response->assertOk();
        $response->assertSee('bg-[#007FBE]', false);
        $response->assertSee('border-[#DCEFFF]', false);
        $response->assertSee('Modul Pecahan Terbit');
        $response->assertSee('Modul Aljabar Draft');
        $response->assertSee('Semua Mapel');
        $response->assertSee($mapel->nama_mapel);

        $filteredByMapel = $this->actingAs($admin)->get(route('admin.modul', [
            'mapel' => $mapel->id_mapel,
        ]));

        $filteredByMapel->assertOk();
        $filteredByMapel->assertSee('Modul Pecahan Terbit');
        $filteredByMapel->assertDontSee('Modul Aljabar Draft');
    }

    public function test_halaman_guru_admin_menampilkan_filter_gaya_siswa_dan_atribut_kontak(): void
    {
        $admin = $this->createAdmin();

        Guru::create([
            'nama' => 'Guru Aktif Uji',
            'nik' => '3201000000000001',
            'no_telepon' => '081234567890',
        ]);

        User::create([
            'nama' => 'Guru Aktif Uji',
            'email' => 'guru.aktif@arrava.test',
            'password' => Hash::make('password'),
            'nisn' => '3201000000000001',
            'id_tipeuser' => 2,
            'status_akun' => 'Aktif',
        ]);

        Guru::create([
            'nama' => 'Guru Tanpa Akun Uji',
            'nik' => '3201000000000002',
            'no_telepon' => '',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.guru'));

        $response->assertOk();
        $response->assertSee('Guru Aktif Uji');
        $response->assertSee('Guru Tanpa Akun Uji');
        $response->assertSee('Tanpa Akun');
        $response->assertSee('Ada Email');
        $response->assertSee('Ada Telepon');
        $response->assertSee('data-has-email="1"', false);
        $response->assertSee('data-has-telepon="1"', false);
    }

    public function test_halaman_daftar_siswa_menampilkan_choice_chip_dan_mendukung_filter_umum_serta_nisn(): void
    {
        $admin = $this->createAdmin();

        User::create([
            'nama' => 'Siswa SD Uji',
            'email' => 'siswa.sd@arrava.test',
            'password' => Hash::make('password'),
            'nisn' => '10000001',
            'kelas' => '4 SD',
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
        ]);

        User::create([
            'nama' => 'Siswa Umum Nonaktif',
            'email' => 'siswa.umum@arrava.test',
            'password' => Hash::make('password'),
            'nisn' => '99008877',
            'kelas' => null,
            'id_tipeuser' => 3,
            'id_jenjang' => null,
            'status_akun' => 'Nonaktif',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.daftar_siswa'));
        $response->assertOk();
        $response->assertSee('Semua Jenjang');
        $response->assertSee('Semua Status');
        $response->assertSee('Umum');
        $response->assertSee('Siswa SD Uji');
        $response->assertSee('Siswa Umum Nonaktif');

        $umumOnly = $this->actingAs($admin)->get(route('admin.daftar_siswa', [
            'kelas' => 'Umum',
            'status' => 'Nonaktif',
        ]));
        $umumOnly->assertOk();
        $umumOnly->assertSee('Siswa Umum Nonaktif');
        $umumOnly->assertDontSee('Siswa SD Uji');

        $byNisn = $this->actingAs($admin)->get(route('admin.daftar_siswa', [
            'search' => '99008877',
        ]));
        $byNisn->assertOk();
        $byNisn->assertSee('Siswa Umum Nonaktif');
        $byNisn->assertDontSee('Siswa SD Uji');
    }

    public function test_halaman_quiz_admin_menampilkan_choice_chip_dan_mendukung_filter_mode_serta_umum(): void
    {
        $admin = $this->createAdmin();

        Quiz::create([
            'kode_quiz' => 'QZ-WG01',
            'judul' => 'Kuis Wayground SD',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'proggressQuiz' => 'published',
        ]);

        Quiz::create([
            'kode_quiz' => 'QZ-KL01',
            'judul' => 'Kuis Klasik Umum',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 2,
            'id_jenjang' => null,
            'mode_pengerjaan' => 'biasa',
            'durasi_total_menit' => 15,
            'proggressQuiz' => 'published',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.quiz'));
        $response->assertOk();
        $response->assertSee('Wayground');
        $response->assertSee('Klasik');
        $response->assertSee('Semua Tingkat');
        $response->assertSee('Semua Mapel');
        $response->assertSee('Matematika');
        $response->assertSee('Kuis Wayground SD');
        $response->assertSee('Kuis Klasik Umum');

        $filteredModeAndUmum = $this->actingAs($admin)->get(route('admin.quiz', [
            'mode' => 'biasa',
            'jenjang' => 'umum',
        ]));
        $filteredModeAndUmum->assertOk();
        $filteredModeAndUmum->assertSee('Kuis Klasik Umum');
        $filteredModeAndUmum->assertDontSee('Kuis Wayground SD');
    }

    public function test_halaman_bank_soal_menampilkan_filter_gaya_siswa_dan_semua_tipe_soal(): void
    {
        $admin = $this->createAdmin();

        $quiz = Quiz::create([
            'kode_quiz' => 'QZ-SOAL1',
            'judul' => 'Kuis Bank Soal',
            'id_tipequiz' => 1,
            'id_tingkatquiz' => 1,
            'id_jenjang' => 1,
            'mode_pengerjaan' => 'wayground',
            'proggressQuiz' => 'published',
        ]);

        Soal::create([
            'kode_soal' => 'SL-001',
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 1,
            'pertanyaan' => 'Pertanyaan Pilihan Ganda Uji',
            'jawaban_benar' => 'A',
        ]);

        Soal::create([
            'kode_soal' => 'SL-002',
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 3,
            'pertanyaan' => 'Pertanyaan Benar Salah Uji',
            'jawaban_benar' => 'Benar',
        ]);

        Soal::create([
            'kode_soal' => 'SL-003',
            'id_quiz' => $quiz->id_quiz,
            'id_jenjang' => 1,
            'id_jenis_soal' => 2,
            'pertanyaan' => 'Pertanyaan Isian Bergambar Uji',
            'jawaban_benar' => 'Jakarta',
            'foto_soal' => 'soal/contoh.png',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.soal'));

        $response->assertOk();
        $response->assertSee('Pilihan Ganda');
        $response->assertSee('Benar/Salah');
        $response->assertSee('Isian');
        $response->assertSee('Bergambar');
        $response->assertSee('Pertanyaan Pilihan Ganda Uji');
        $response->assertSee('Pertanyaan Benar Salah Uji');
        $response->assertSee('Pertanyaan Isian Bergambar Uji');
        $response->assertSee('data-type="pilihan_ganda"', false);
        $response->assertSee('data-type="benar_salah"', false);
        $response->assertSee('data-type="isian"', false);
        $response->assertSee('data-has-image="1"', false);
    }
}


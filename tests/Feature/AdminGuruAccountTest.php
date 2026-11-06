<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminGuruAccountTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nisn')->unique();
            $table->string('nomor_hp')->nullable();
            $table->unsignedInteger('id_tipeuser')->default(1);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->integer('total_poin')->default(0);
            $table->string('status_akun', 50)->default('Aktif');
            $table->unsignedInteger('id_modul')->nullable();
            $table->string('foto_profil')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('guru', function (Blueprint $table) {
            $table->increments('id_guru');
            $table->string('nama', 100);
            $table->string('nik', 16)->unique();
            $table->string('no_telepon', 13);
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        Storage::fake('public');
    }

    private function createAdmin(): User
    {
        return User::create([
            'nama' => 'Admin Test',
            'email' => 'admin_' . Str::random(8) . '@arrava.id',
            'password' => Hash::make('password'),
            'nisn' => 'ADM-' . Str::random(8),
            'id_tipeuser' => 1, // Admin
            'status_akun' => 'Aktif',
        ]);
    }

    public function test_admin_dapat_melihat_halaman_tambah_guru_dengan_input_akun(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.guru.create'));

        $response->assertOk();
        $response->assertSee('Email Login');
        $response->assertSee('Password Akun');
        $response->assertSee('Foto Guru');
    }

    public function test_admin_berhasil_membuat_guru_dan_akun_user_guru_terbuat_dengan_foto(): void
    {
        $admin = $this->createAdmin();

        $nik = '3201' . str_pad((string) rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
        $email = 'guru_' . Str::random(8) . '@arrava.id';
        $foto = UploadedFile::fake()->image('guru_foto.jpg', 300, 300);

        $data = [
            'nama' => 'Budi Santoso',
            'nik' => $nik,
            'no_telepon' => '081234567890',
            'email' => $email,
            'password' => 'rahasia123',
            'foto' => $foto,
        ];

        $response = $this->actingAs($admin)->post(route('admin.guru.store'), $data);

        $response->assertRedirect(route('admin.guru'));
        $response->assertSessionHas('success');

        // Pastikan tabel guru tersimpan
        $this->assertDatabaseHas('guru', [
            'nama' => 'Budi Santoso',
            'nik' => $nik,
            'no_telepon' => '081234567890',
        ]);

        // Pastikan tabel user tersimpan dengan role Guru (id_tipeuser = 2)
        $this->assertDatabaseHas('user', [
            'nama' => 'Budi Santoso',
            'email' => $email,
            'nisn' => $nik,
            'nomor_hp' => '081234567890',
            'id_tipeuser' => 2,
            'status_akun' => 'Aktif',
        ]);

        // Cek relasi dan foto tersimpan
        $guru = Guru::where('nik', $nik)->first();
        $this->assertNotNull($guru);
        $this->assertNotNull($guru->foto);
        $this->assertNotNull($guru->user);
        $this->assertSame($guru->foto, $guru->user->foto_profil);
        Storage::disk('public')->assertExists($guru->foto);
    }

    public function test_guru_yang_dibuat_admin_dapat_login_ke_sistem(): void
    {
        $admin = $this->createAdmin();

        $nik = '3201' . str_pad((string) rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
        $email = 'siti_' . Str::random(8) . '@arrava.id';

        $data = [
            'nama' => 'Siti Aminah',
            'nik' => $nik,
            'no_telepon' => '081234567891',
            'email' => $email,
            'password' => 'guruhebat123',
        ];

        $this->actingAs($admin)->post(route('admin.guru.store'), $data);

        // Logout admin
        $this->post(route('logout'));

        // Coba login sebagai guru baru via endpoint login
        $this->post(route('login.submit'), [
            'email' => $email,
            'password' => 'guruhebat123',
        ]);

        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isGuru());
    }

    public function test_admin_dapat_mengupdate_guru_dan_akun_login(): void
    {
        $admin = $this->createAdmin();

        $nik = '3201' . str_pad((string) rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
        $emailLama = 'rudi_' . Str::random(8) . '@arrava.id';

        $dataAwal = [
            'nama' => 'Rudi Hartono',
            'nik' => $nik,
            'no_telepon' => '081234567892',
            'email' => $emailLama,
            'password' => 'passlama123',
        ];

        $this->actingAs($admin)->post(route('admin.guru.store'), $dataAwal);
        $guru = Guru::where('nik', $nik)->first();

        // Update data guru dan email
        $emailBaru = 'rudi_baru_' . Str::random(8) . '@arrava.id';
        $fotoBaru = UploadedFile::fake()->image('rudi_baru.png', 400, 400);

        $dataBaru = [
            'nama' => 'Rudi Hartono S.Pd',
            'nik' => $nik,
            'no_telepon' => '081299998888',
            'email' => $emailBaru,
            'password' => 'passbaru123',
            'foto' => $fotoBaru,
        ];

        $response = $this->actingAs($admin)->put(route('admin.guru.update', $guru->id_guru), $dataBaru);

        $response->assertRedirect(route('admin.guru'));

        $this->assertDatabaseHas('guru', [
            'id_guru' => $guru->id_guru,
            'nama' => 'Rudi Hartono S.Pd',
            'no_telepon' => '081299998888',
        ]);

        $this->assertDatabaseHas('user', [
            'email' => $emailBaru,
            'nama' => 'Rudi Hartono S.Pd',
            'nomor_hp' => '081299998888',
        ]);

        $guru->refresh();
        Storage::disk('public')->assertExists($guru->foto);
    }

    public function test_admin_menghapus_guru_dan_akun_user_ikut_terhapus(): void
    {
        $admin = $this->createAdmin();

        $nik = '3201' . str_pad((string) rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
        $email = 'dewi_' . Str::random(8) . '@arrava.id';
        $foto = UploadedFile::fake()->image('dewi.jpg', 200, 200);

        $data = [
            'nama' => 'Dewi Sartika',
            'nik' => $nik,
            'no_telepon' => '081234567893',
            'email' => $email,
            'password' => 'password123',
            'foto' => $foto,
        ];

        $this->actingAs($admin)->post(route('admin.guru.store'), $data);
        $guru = Guru::where('nik', $nik)->first();
        $fotoPath = $guru->foto;

        Storage::disk('public')->assertExists($fotoPath);

        $response = $this->actingAs($admin)->delete(route('admin.guru.destroy', $guru->id_guru));

        $response->assertRedirect(route('admin.guru'));

        $this->assertDatabaseMissing('guru', [
            'nik' => $nik,
        ]);

        $this->assertDatabaseMissing('user', [
            'email' => $email,
        ]);

        Storage::disk('public')->assertMissing($fotoPath);
    }

    public function test_halaman_index_guru_menampilkan_tampilan_card_photo(): void
    {
        $admin = $this->createAdmin();

        $nik = '3201' . str_pad((string) rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
        $email = 'guru_card_' . Str::random(8) . '@arrava.id';

        Guru::create([
            'nama' => 'Kakashi Hatake',
            'nik' => $nik,
            'no_telepon' => '081299988877',
        ]);

        User::create([
            'nama' => 'Kakashi Hatake',
            'email' => $email,
            'password' => Hash::make('password123'),
            'nisn' => $nik,
            'nomor_hp' => '081299988877',
            'id_tipeuser' => 2,
            'status_akun' => 'Aktif',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.guru'));

        $response->assertOk();
        $response->assertSee('Kakashi Hatake');
        $response->assertSee($email);
        $response->assertSee('Pengajar');
        $response->assertSee('guru-card');
    }
}

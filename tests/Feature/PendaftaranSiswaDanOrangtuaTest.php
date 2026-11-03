<?php

namespace Tests\Feature;

use App\Models\Jenjang;
use App\Models\OrangtuaSiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PendaftaranSiswaDanOrangtuaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Siapkan tipe user (1: admin, 2: guru, 3: siswa, 4: orangtua)
        \Illuminate\Support\Facades\DB::table('tipeuser')->insertOrIgnore([
            ['id_tipeUser' => 1, 'nama_tipe' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipeUser' => 2, 'nama_tipe' => 'guru', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipeUser' => 3, 'nama_tipe' => 'siswa', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipeUser' => 4, 'nama_tipe' => 'orangtua', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Siapkan jenjang pendidikan
        Jenjang::firstOrCreate(
            ['id_jenjang' => 1],
            ['nama_tipe' => 'SMA']
        );
    }

    public function test_halaman_pendaftaran_dapat_dibuka_dan_menampilkan_stepper(): void
    {
        $response = $this->get('/pendaftaran');

        $response->assertStatus(200);
        $response->assertSee('Informasi Akun Siswa');
        $response->assertSee('Data Siswa');
        $response->assertSee('Data Orang Tua');
        $response->assertSee('Akun Monitoring Orang Tua');
        $response->assertSee('Lanjut: Data Orang Tua');
    }

    public function test_pendaftaran_berhasil_membuat_akun_siswa_dan_akun_orangtua_terhubung(): void
    {
        $payload = [
            // Langkah 1: Siswa
            'nama' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@example.com',
            'nisn' => '0098765432',
            'id_jenjang' => 1,
            'nomor_handphone' => '081234567890',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',

            // Langkah 2: Orang Tua
            'nama_orangtua' => 'Bapak Fauzi',
            'email_orangtua' => 'fauzi.orangtua@example.com',
            'nomor_hp_orangtua' => '081298765432',
            'password_orangtua' => '', // Menggunakan password siswa
        ];

        $response = $this->post('/pendaftaran', $payload);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success');

        // Pastikan akun siswa dibuat
        $siswa = User::where('email', 'ahmad.fauzi@example.com')->first();
        $this->assertNotNull($siswa);
        $this->assertEquals('Ahmad Fauzi', $siswa->nama);
        $this->assertEquals('0098765432', $siswa->nisn);
        $this->assertEquals(3, (int) $siswa->id_tipeuser);
        $this->assertEquals('081234567890', $siswa->nomor_hp);
        $this->assertTrue(Hash::check('Password123!', $siswa->password));

        // Pastikan akun orang tua dibuat
        $orangtua = User::where('email', 'fauzi.orangtua@example.com')->first();
        $this->assertNotNull($orangtua);
        $this->assertEquals('Bapak Fauzi', $orangtua->nama);
        $this->assertEquals(4, (int) $orangtua->id_tipeuser);
        $this->assertEquals('081298765432', $orangtua->nomor_hp);
        $this->assertStringStartsWith('OT-', $orangtua->nisn);
        $this->assertTrue(Hash::check('Password123!', $orangtua->password));

        // Pastikan relasi orangtua_siswa terhubung
        $relasi = OrangtuaSiswa::where('id_orangtua', $orangtua->id_user)
            ->where('id_siswa', $siswa->id_user)
            ->first();
        $this->assertNotNull($relasi);
    }

    public function test_pendaftaran_dengan_password_khusus_orang_tua(): void
    {
        $payload = [
            'nama' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@example.com',
            'nisn' => '0011223344',
            'id_jenjang' => 1,
            'nomor_handphone' => '081345678901',
            'password' => 'SiswaSecret99',
            'password_confirmation' => 'SiswaSecret99',

            'nama_orangtua' => 'Ibu Haliza',
            'email_orangtua' => 'ibu.haliza@example.com',
            'nomor_hp_orangtua' => '081399887766',
            'password_orangtua' => 'OrtuSecret88',
        ];

        $response = $this->post('/pendaftaran', $payload);

        $response->assertRedirect('/login');

        $siswa = User::where('email', 'siti.nurhaliza@example.com')->first();
        $orangtua = User::where('email', 'ibu.haliza@example.com')->first();

        $this->assertTrue(Hash::check('SiswaSecret99', $siswa->password));
        $this->assertTrue(Hash::check('OrtuSecret88', $orangtua->password));
    }

    public function test_validasi_menolak_jika_email_orang_tua_sama_dengan_siswa(): void
    {
        $payload = [
            'nama' => 'Dewi Sartika',
            'email' => 'dewi@example.com',
            'nisn' => '0055667788',
            'id_jenjang' => 1,
            'nomor_handphone' => '081200112233',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',

            'nama_orangtua' => 'Ibu Sartika',
            'email_orangtua' => 'dewi@example.com', // Sama dengan siswa!
            'nomor_hp_orangtua' => '081299887766',
        ];

        $response = $this->from('/pendaftaran')->post('/pendaftaran', $payload);

        $response->assertSessionHasErrors(['email_orangtua']);
    }
}

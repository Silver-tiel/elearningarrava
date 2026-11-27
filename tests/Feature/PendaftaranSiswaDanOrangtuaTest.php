<?php

namespace Tests\Feature;

use App\Models\Jenjang;
use App\Models\OrangtuaSiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        $this->post('/pendaftaran', $payload)->assertRedirect(route('pendaftaran.otp'));
        $this->assertDatabaseMissing('user', ['email' => $payload['email_orangtua']]);
        $messages = Mail::mailer('array')->getSymfonyTransport()->messages();
        $this->assertCount(1, $messages);
        $this->assertSame($payload['email'], $messages->first()->getOriginalMessage()->getTo()[0]->getAddress());
        $response = $this->post(route('pendaftaran.otp.verify'), ['code' => $this->latestRegistrationCode()]);

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

        $this->post('/pendaftaran', $payload)->assertRedirect(route('pendaftaran.otp'));
        $response = $this->post(route('pendaftaran.otp.verify'), ['code' => $this->latestRegistrationCode()]);

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

    public function test_pendaftaran_api_memverifikasi_kode_dan_menolak_kode_lama(): void
    {
        $payload = [
            'nama' => 'Siswa Mobile',
            'email' => 'siswa.mobile@example.com',
            'nisn' => '0001234567',
            'id_jenjang' => 1,
            'nomor_handphone' => '081234567890',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'nama_orangtua' => 'Wali Mobile',
            'email_orangtua' => 'wali.mobile@example.com',
            'nomor_hp_orangtua' => '081298765432',
        ];
        $path = '/api/pendaftaran';
        $this->getJson($path.'/jenjang')->assertOk()
            ->assertJsonFragment(['id_jenjang' => 1, 'nama_tipe' => 'SMA']);

        $start = $this->postJson($path, $payload)->assertCreated()
            ->assertJsonPath('email', $payload['email'])
            ->assertJsonPath('retry_after', 60)
            ->assertJsonMissingPath('code');
        $challenge = ['registration_id' => $start->json('registration_id')];
        $this->assertDatabaseMissing('user', ['email' => $payload['email']]);
        $this->assertDatabaseMissing('user', ['email' => $payload['email_orangtua']]);

        $messages = Mail::mailer('array')->getSymfonyTransport()->messages();
        $this->assertCount(1, $messages);
        $this->assertSame($payload['email'], $messages->first()->getOriginalMessage()->getTo()[0]->getAddress());
        $firstCode = $this->latestRegistrationCode();
        $wrong = $firstCode === '012345' ? '012346' : '012345';
        $this->postJson($path.'/otp', $challenge + ['code' => $wrong])->assertUnprocessable()
            ->assertJsonPath('message', 'Kode OTP salah. Periksa email lalu coba lagi.');

        $this->travel(59)->seconds();
        $this->postJson($path.'/otp/kirim-ulang', $challenge)->assertTooManyRequests()
            ->assertJsonPath('retry_after', 1);
        $this->travel(1)->seconds();
        $this->postJson($path.'/otp/kirim-ulang', $challenge)->assertOk()->assertJsonPath('retry_after', 60);
        $secondCode = $this->latestRegistrationCode();
        $this->assertNotSame($firstCode, $secondCode);
        $this->postJson($path.'/otp', $challenge + ['code' => $firstCode])->assertUnprocessable()
            ->assertJsonPath('message', 'Kode OTP salah. Periksa email lalu coba lagi.');

        $this->travel(5)->minutes();
        $this->postJson($path.'/otp', $challenge + ['code' => $secondCode])->assertUnprocessable()
            ->assertJsonPath('message', 'Kode OTP kedaluwarsa. Minta kode baru.');
        $this->assertDatabaseMissing('user', ['email' => $payload['email']]);

        $this->postJson($path.'/otp/kirim-ulang', $challenge)->assertOk();
        $code = ['code' => $this->latestRegistrationCode()];
        $this->postJson($path.'/otp', $challenge + $code)->assertOk()->assertJsonPath('success', true);
        $this->postJson($path.'/otp', $challenge + $code)->assertGone();
        $this->assertDatabaseHas('user', ['email' => $payload['email'], 'id_tipeuser' => 3]);
        $this->assertDatabaseHas('user', ['email' => $payload['email_orangtua'], 'id_tipeuser' => 4]);
        $login = $this->postJson('/api/login', ['email' => $payload['email'], 'password' => $payload['password']])
            ->assertOk();
        $this->getJson('/api/me', ['Authorization' => 'Bearer '.$login->json('token')])
            ->assertOk()->assertJsonPath('user.email', $payload['email']);
    }
}

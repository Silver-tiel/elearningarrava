<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\SesiPresensi;
use App\Models\User;
use App\Support\QrToken;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PresensiQrTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->string('status_akun')->default('Aktif');
            $table->char('qr_token', 36)->nullable()->unique();
            $table->timestamp('qr_dibuat_pada')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->increments('id_kelas');
            $table->string('nama');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kelas');
            $table->unsignedInteger('id_siswa');
            $table->timestamps();
            $table->unique(['id_kelas', 'id_siswa']);
        });
        Schema::create('kelas_guru', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kelas');
            $table->unsignedInteger('id_guru');
            $table->timestamps();
            $table->unique(['id_kelas', 'id_guru']);
        });
        Schema::create('sesi_presensi', function (Blueprint $table) {
            $table->increments('id_sesi');
            $table->unsignedInteger('id_kelas');
            $table->unsignedInteger('id_guru');
            $table->string('judul');
            $table->unsignedSmallInteger('pertemuan_ke')->nullable();
            $table->date('tanggal');
            $table->dateTime('batas_tepat_waktu')->nullable();
            $table->string('status')->default('buka');
            $table->timestamps();
        });
        Schema::create('presensi', function (Blueprint $table) {
            $table->increments('id_presensi');
            $table->unsignedInteger('id_sesi');
            $table->unsignedInteger('id_siswa');
            $table->unsignedInteger('id_guru_pemindai');
            $table->string('status');
            $table->dateTime('waktu_scan');
            $table->timestamps();
            $table->unique(['id_sesi', 'id_siswa']);
        });
        Schema::create('log_pemindaian', function (Blueprint $table) {
            $table->increments('id_log');
            $table->unsignedInteger('id_sesi')->nullable();
            $table->unsignedInteger('id_guru');
            $table->unsignedInteger('id_siswa')->nullable();
            $table->char('token_hash', 64)->nullable();
            $table->string('hasil');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    // ---------- helper ----------

    private function user(int $tipe, string $nama): User
    {
        return User::create([
            'nama' => $nama,
            'email' => strtolower(str_replace(' ', '', $nama)) . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => $tipe,
        ]);
    }

    private function skenario(): array
    {
        $guru = $this->user(2, 'Guru A');
        $siswa = $this->user(3, 'Siswa Satu');
        $kelas = Kelas::create(['nama' => 'Kelas X – Matematika', 'aktif' => true]);
        $kelas->guru()->attach($guru->id_user);
        $kelas->siswa()->attach($siswa->id_user);
        $sesi = SesiPresensi::create([
            'id_kelas' => $kelas->id_kelas,
            'id_guru' => $guru->id_user,
            'judul' => 'Pertemuan 3',
            'tanggal' => now()->toDateString(),
            'status' => 'buka',
        ]);

        return compact('guru', 'siswa', 'kelas', 'sesi');
    }

    private function scan(User $guru, SesiPresensi $sesi, string $token)
    {
        return $this->actingAs($guru)->postJson(route('guru.presensi.proses', $sesi->id_sesi), ['token' => $token]);
    }

    // ---------- QR token ----------

    public function test_siswa_baru_otomatis_punya_token_dan_isi_qr_tanpa_data_pribadi(): void
    {
        $siswa = $this->user(3, 'Budi Santoso');

        $this->assertNotEmpty($siswa->qr_token);
        $payload = $siswa->qrPayload();

        $this->assertStringStartsWith('ARV1.', $payload);
        $this->assertStringNotContainsString('Budi', $payload);
        $this->assertStringNotContainsString('example.com', $payload);
        $this->assertSame($siswa->qr_token, QrToken::uuidDariPayload($payload));
        $this->assertArrayNotHasKey('qr_token', $siswa->toArray());
    }

    public function test_guru_dan_admin_tidak_diberi_token(): void
    {
        $this->assertNull($this->user(2, 'Guru Z')->qr_token);
        $this->assertNull($this->user(1, 'Admin Z')->qr_token);
    }

    public function test_payload_yang_diubah_atau_palsu_ditolak(): void
    {
        $siswa = $this->user(3, 'Siswa Dua');
        $payload = $siswa->qrPayload();

        $this->assertNull(QrToken::uuidDariPayload(substr($payload, 0, -1) . (substr($payload, -1) === 'a' ? 'b' : 'a')));
        $this->assertNull(QrToken::uuidDariPayload('ARV1.' . $siswa->qr_token . '.0000000000000000'));
        $this->assertNull(QrToken::uuidDariPayload('sembarang-teks'));
        $this->assertNull(QrToken::uuidDariPayload(''));
    }

    // ---------- scan ----------

    public function test_scan_valid_mencatat_hadir_dan_log(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-29 08:00:00'));
        ['guru' => $guru, 'siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();
        $sesi->update(['batas_tepat_waktu' => '2026-10-29 08:15:00']);

        $this->scan($guru, $sesi, $siswa->qrPayload())
            ->assertOk()
            ->assertJsonPath('status', 'hadir')
            ->assertJsonPath('siswa.nama', 'Siswa Satu');

        $this->assertDatabaseHas('presensi', ['id_sesi' => $sesi->id_sesi, 'id_siswa' => $siswa->id_user, 'status' => 'hadir']);
        $this->assertDatabaseHas('log_pemindaian', ['id_sesi' => $sesi->id_sesi, 'id_guru' => $guru->id_user, 'hasil' => 'hadir']);
    }

    public function test_scan_setelah_batas_dicatat_terlambat(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-29 09:00:00'));
        ['guru' => $guru, 'siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();
        $sesi->update(['batas_tepat_waktu' => '2026-10-29 08:15:00']);

        $this->scan($guru, $sesi, $siswa->qrPayload())->assertOk()->assertJsonPath('status', 'terlambat');
    }

    public function test_scan_kedua_tidak_menduplikasi(): void
    {
        ['guru' => $guru, 'siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();

        $this->scan($guru, $sesi, $siswa->qrPayload())->assertJsonPath('status', 'hadir');
        $this->scan($guru, $sesi, $siswa->qrPayload())
            ->assertOk()
            ->assertJsonPath('status', 'duplikat');

        $this->assertSame(1, DB::table('presensi')->count());
    }

    public function test_token_palsu_ditolak_dan_log_hanya_menyimpan_hash(): void
    {
        ['guru' => $guru, 'sesi' => $sesi] = $this->skenario();
        $palsu = 'ARV1.' . \Illuminate\Support\Str::uuid() . '.0000000000000000';

        $this->scan($guru, $sesi, $palsu)->assertStatus(422)->assertJsonPath('status', 'tidak_valid');

        $log = DB::table('log_pemindaian')->first();
        $this->assertSame('tidak_valid', $log->hasil);
        $this->assertSame(QrToken::hash($palsu), $log->token_hash);
        $this->assertStringNotContainsString($palsu, json_encode($log));
        $this->assertSame(0, DB::table('presensi')->count());
    }

    public function test_siswa_bukan_anggota_kelas_ditolak(): void
    {
        ['guru' => $guru, 'sesi' => $sesi] = $this->skenario();
        $orangLuar = $this->user(3, 'Siswa Luar');

        $this->scan($guru, $sesi, $orangLuar->qrPayload())
            ->assertStatus(422)
            ->assertJsonPath('status', 'bukan_anggota');
        $this->assertSame(0, DB::table('presensi')->count());
    }

    public function test_guru_kelas_lain_tidak_bisa_memindai_idor(): void
    {
        ['siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();
        $guruLain = $this->user(2, 'Guru B');

        $this->scan($guruLain, $sesi, $siswa->qrPayload())->assertStatus(403);
        $this->assertSame(0, DB::table('presensi')->count());
    }

    public function test_sesi_ditutup_menolak_scan(): void
    {
        ['guru' => $guru, 'siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();
        $sesi->update(['status' => 'tutup']);

        $this->scan($guru, $sesi, $siswa->qrPayload())->assertStatus(422)->assertJsonPath('status', 'sesi_ditutup');
    }

    public function test_siswa_nonaktif_ditolak(): void
    {
        ['guru' => $guru, 'siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();
        $siswa->forceFill(['status_akun' => 'Nonaktif'])->save();

        $this->scan($guru, $sesi, $siswa->qrPayload())->assertStatus(422)->assertJsonPath('status', 'tidak_aktif');
    }

    public function test_siswa_tidak_boleh_memanggil_endpoint_scan(): void
    {
        ['siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();

        $this->actingAs($siswa)
            ->postJson(route('guru.presensi.proses', $sesi->id_sesi), ['token' => $siswa->qrPayload()])
            ->assertStatus(403);
    }

    public function test_kegagalan_berulang_dibatasi_rate_limit(): void
    {
        ['guru' => $guru, 'sesi' => $sesi] = $this->skenario();

        for ($i = 0; $i < 10; $i++) {
            $this->scan($guru, $sesi, 'acak-' . $i)->assertStatus(422);
        }

        $this->scan($guru, $sesi, 'acak-lagi')->assertStatus(429)->assertJsonPath('status', 'dibatasi');
    }

    // ---------- regenerate ----------

    public function test_regenerate_mencabut_token_lama(): void
    {
        ['guru' => $guru, 'siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();
        $admin = $this->user(1, 'Admin Satu');
        $lama = $siswa->qrPayload();

        $this->actingAs($admin)->post(route('admin.qr.regenerate', $siswa->id_user))->assertRedirect();

        $this->scan($guru, $sesi, $lama)->assertStatus(422)->assertJsonPath('status', 'tidak_valid');
        $this->scan($guru, $sesi, $siswa->fresh()->qrPayload())->assertOk()->assertJsonPath('status', 'hadir');
    }

    public function test_guru_dan_siswa_tidak_bisa_regenerate(): void
    {
        ['guru' => $guru, 'siswa' => $siswa] = $this->skenario();
        $tokenAwal = $siswa->qr_token;

        $this->actingAs($guru)->post(route('admin.qr.regenerate', $siswa->id_user))->assertStatus(403);
        $this->actingAs($siswa)->post(route('admin.qr.regenerate', $siswa->id_user))->assertStatus(403);

        $this->assertSame($tokenAwal, $siswa->fresh()->qr_token);
    }

    // ---------- role ----------

    public function test_guru_tidak_bisa_masuk_area_admin_saja(): void
    {
        ['guru' => $guru] = $this->skenario();

        foreach (['/admin/guru', '/admin/data', '/admin/achievement', '/admin/kelas', '/admin/qr'] as $url) {
            $this->actingAs($guru)->get($url)->assertStatus(403);
        }
    }

    public function test_orangtua_dan_siswa_tidak_bisa_membuka_dasbor_admin(): void
    {
        $this->actingAs($this->user(4, 'Orang Tua'))->get('/admin')->assertStatus(403);
        $this->actingAs($this->user(3, 'Siswa Tiga'))->get('/admin')->assertStatus(403);
    }

    public function test_siswa_tidak_bisa_membuka_halaman_presensi_guru(): void
    {
        ['siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();

        $this->actingAs($siswa)->get(route('guru.presensi.index'))->assertStatus(403);
        $this->actingAs($siswa)->get(route('guru.presensi.rekap', $sesi->id_sesi))->assertStatus(403);
    }

    public function test_guru_tidak_bisa_membuat_sesi_untuk_kelas_yang_tidak_diampu(): void
    {
        ['guru' => $guru] = $this->skenario();
        $kelasLain = Kelas::create(['nama' => 'Kelas Lain', 'aktif' => true]);

        $this->actingAs($guru)->post(route('guru.presensi.sesi.store'), [
            'id_kelas' => $kelasLain->id_kelas,
            'judul' => 'Pertemuan 1',
            'tanggal' => now()->toDateString(),
        ])->assertStatus(403);
    }

    // ---------- Policy konten ----------

    public function test_policy_modul_dan_quiz_membatasi_guru_ke_konten_sendiri(): void
    {
        $guruA = $this->user(2, 'Guru A');
        $guruB = $this->user(2, 'Guru B');
        $admin = $this->user(1, 'Admin Satu');

        $modul = new Modul();
        $modul->id_pembuat = $guruA->id_user;
        $quiz = new Quiz();
        $quiz->id_pembuat = $guruA->id_user;

        foreach ([$modul, $quiz] as $konten) {
            $this->assertTrue(Gate::forUser($guruA)->allows('update', $konten));
            $this->assertTrue(Gate::forUser($guruA)->allows('delete', $konten));
            $this->assertFalse(Gate::forUser($guruB)->allows('update', $konten));
            $this->assertFalse(Gate::forUser($guruB)->allows('delete', $konten));
            $this->assertTrue(Gate::forUser($admin)->allows('update', $konten));
        }

        // Konten lama tanpa pemilik: hanya admin.
        $lama = new Modul();
        $this->assertFalse(Gate::forUser($guruA)->allows('update', $lama));
        $this->assertTrue(Gate::forUser($admin)->allows('update', $lama));

        // Siswa tidak boleh membuat/mengubah apa pun.
        $siswa = $this->user(3, 'Siswa Empat');
        $this->assertFalse(Gate::forUser($siswa)->allows('create', Modul::class));
        $this->assertFalse(Gate::forUser($siswa)->allows('update', $modul));
    }
}

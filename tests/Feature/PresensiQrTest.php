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

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });
        DB::table('jenjang')->insert(['nama_tipe' => 'SD']);

        Schema::create('kelas', function (Blueprint $table) {
            $table->increments('id_kelas');
            $table->string('nama');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->string('hari', 20)->nullable();
            $table->date('berlaku_dari')->nullable();
            $table->date('berlaku_sampai')->nullable();
            $table->time('jam_batas')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
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
            $table->string('kunci_otomatis', 40)->nullable()->unique();
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

    private function user(int $tipe, string $nama, ?int $jenjang = null): User
    {
        return User::create([
            'nama' => $nama,
            'email' => strtolower(str_replace(' ', '', $nama)) . '@example.com',
            'password' => bcrypt('password123'),
            'id_tipeuser' => $tipe,
            'id_jenjang' => $jenjang,
        ]);
    }

    private function skenario(): array
    {
        $guru = $this->user(2, 'Guru A');
        $siswa = $this->user(3, 'Siswa Satu', 1); // jenjang 1
        $kelas = Kelas::create(['nama' => 'Kelas X – Matematika', 'id_jenjang' => 1, 'aktif' => true]);
        $kelas->guru()->attach($guru->id_user);
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
        $orangLuar = $this->user(3, 'Siswa Luar', 2); // jenjang berbeda

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

    public function test_siswa_jenjang_sama_otomatis_peserta_tanpa_didaftarkan(): void
    {
        ['guru' => $guru, 'sesi' => $sesi] = $this->skenario();
        $baru = $this->user(3, 'Siswa Baru Sejenjang', 1); // dibuat SETELAH kelas, tanpa input manual

        $this->scan($guru, $sesi, $baru->qrPayload())->assertOk()->assertJsonPath('status', 'hadir');
    }

    public function test_kelas_tanpa_jenjang_tidak_punya_peserta(): void
    {
        ['guru' => $guru, 'siswa' => $siswa, 'kelas' => $kelas, 'sesi' => $sesi] = $this->skenario();
        $kelas->update(['id_jenjang' => null]);

        $this->scan($guru, $sesi, $siswa->qrPayload())->assertStatus(422)->assertJsonPath('status', 'bukan_anggota');
    }

    public function test_peserta_kelas_hanya_siswa_aktif_sejenjang(): void
    {
        ['kelas' => $kelas] = $this->skenario(); // Siswa Satu (jenjang 1, aktif)
        $this->user(3, 'Siswa Beda', 2);
        $nonaktif = $this->user(3, 'Siswa Nonaktif', 1);
        $nonaktif->forceFill(['status_akun' => 'Nonaktif'])->save();
        $this->user(2, 'Guru Sejenjang', 1);

        $this->assertSame(['Siswa Satu'], $kelas->anggota()->pluck('nama')->all());
    }

    // ---------- kedaluwarsa per hari ----------

    public function test_sesi_kemarin_kedaluwarsa_scan_ditolak_dan_data_tetap_ada(): void
    {
        ['guru' => $guru, 'siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();

        // Siswa sudah tercatat saat sesi masih berlaku (hari ini).
        $this->scan($guru, $sesi, $siswa->qrPayload())->assertJsonPath('status', 'hadir');

        // Besoknya: tanggal sesi menjadi "kemarin".
        $sesi->update(['tanggal' => now()->subDay()->toDateString()]);
        $sesi = $sesi->fresh();

        $this->assertTrue($sesi->kedaluwarsa());
        $this->assertFalse($sesi->bisaDipindai());
        $this->assertSame('kedaluwarsa', $sesi->statusTampil());

        $lain = $this->user(3, 'Siswa Terlambat Datang', 1);
        $this->scan($guru, $sesi, $lain->qrPayload())
            ->assertStatus(422)
            ->assertJsonPath('status', 'kedaluwarsa');

        // Data lama tidak hilang, dan percobaan tercatat di log.
        $this->assertDatabaseHas('presensi', ['id_sesi' => $sesi->id_sesi, 'id_siswa' => $siswa->id_user]);
        $this->assertSame(1, DB::table('presensi')->count());
        $this->assertDatabaseHas('log_pemindaian', ['id_sesi' => $sesi->id_sesi, 'hasil' => 'kedaluwarsa']);
    }

    public function test_halaman_scan_sesi_kedaluwarsa_dialihkan_ke_rekap(): void
    {
        ['guru' => $guru, 'sesi' => $sesi] = $this->skenario();
        $sesi->update(['tanggal' => now()->subDay()->toDateString()]);

        $this->actingAs($guru)
            ->get(route('guru.presensi.scan', $sesi->id_sesi))
            ->assertRedirect(route('guru.presensi.rekap', $sesi->id_sesi));
    }

    public function test_sesi_hari_ini_masih_bisa_dipindai_dan_berlaku_sampai_akhir_hari(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-29 23:59:00'));
        ['guru' => $guru, 'siswa' => $siswa, 'sesi' => $sesi] = $this->skenario();

        $this->assertTrue($sesi->fresh()->bisaDipindai());
        $this->scan($guru, $sesi, $siswa->qrPayload())->assertOk();

        // Lewat tengah malam: otomatis kedaluwarsa tanpa perlu ditutup manual.
        Carbon::setTestNow(Carbon::parse('2026-10-30 00:01:00'));
        $lain = $this->user(3, 'Siswa Lewat Tengah Malam', 1);
        $this->scan($guru, $sesi->fresh(), $lain->qrPayload())->assertStatus(422)->assertJsonPath('status', 'kedaluwarsa');
    }

    // ---------- kelas aktif hari ini (jadwal & masa berlaku) ----------

    public function test_aturan_aktif_pada_tanggal(): void
    {
        $kelas = new Kelas(['aktif' => true]);
        $this->assertTrue($kelas->aktifPadaTanggal(now()), 'tanpa jadwal = setiap hari');

        $kelas = new Kelas(['aktif' => true, 'hari' => '1,3', 'berlaku_dari' => '2026-11-01', 'berlaku_sampai' => '2026-11-30']);
        $this->assertTrue($kelas->aktifPadaTanggal(Carbon::parse('2026-11-02')), 'Senin dalam masa berlaku');
        $this->assertFalse($kelas->aktifPadaTanggal(Carbon::parse('2026-11-03')), 'Selasa bukan jadwal');
        $this->assertFalse($kelas->aktifPadaTanggal(Carbon::parse('2026-12-07')), 'Senin tetapi di luar masa berlaku');
        $this->assertTrue($kelas->aktifPadaTanggal(Carbon::parse('2026-11-30 23:59')), 'hari terakhir masa berlaku (Senin) masih termasuk');
    }

    // ---------- sesi presensi otomatis ----------

    public function test_admin_membuat_kelas_sesi_hari_ini_langsung_dibuat_otomatis(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-11-04 07:00:00')); // Rabu
        $admin = $this->user(1, 'Admin Kelas');

        $this->actingAs($admin)->post(route('admin.kelas.store'), [
            'nama' => 'Kelas Baru',
            'id_jenjang' => 1,
            'jam_batas' => '08:15',
        ])->assertSessionHasNoErrors()->assertRedirect();

        $kelas = Kelas::where('nama', 'Kelas Baru')->firstOrFail();
        $sesi = SesiPresensi::where('id_kelas', $kelas->id_kelas)->firstOrFail();

        $this->assertSame('2026-11-04', $sesi->tanggal->toDateString());
        $this->assertSame('buka', $sesi->status);
        $this->assertSame('2026-11-04 08:15:00', $sesi->batas_tepat_waktu->format('Y-m-d H:i:s'));
        $this->assertNotNull($sesi->kunci_otomatis);
        $this->assertTrue($sesi->bisaDipindai());
    }

    public function test_kelas_baru_di_luar_jadwal_hari_ini_tidak_langsung_punya_sesi(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-11-04 07:00:00')); // Rabu = 3
        $admin = $this->user(1, 'Admin Jadwal Lain');

        $this->actingAs($admin)->post(route('admin.kelas.store'), [
            'nama' => 'Kelas Kamis',
            'id_jenjang' => 1,
            'hari' => [4], // Kamis saja
        ])->assertSessionHasNoErrors();

        $kelas = Kelas::where('nama', 'Kelas Kamis')->firstOrFail();
        $this->assertSame(0, SesiPresensi::where('id_kelas', $kelas->id_kelas)->count());

        // Hari Kamis berikutnya: sesi dibuat otomatis.
        $sesi = SesiPresensi::pastikanUntuk($kelas, Carbon::parse('2026-11-05'), $admin->id_user);
        $this->assertNotNull($sesi);
        $this->assertSame('2026-11-05', $sesi->tanggal->toDateString());
    }

    public function test_pastikan_sesi_idempoten_dan_tidak_menggandakan_sesi_manual(): void
    {
        ['guru' => $guru, 'kelas' => $kelas, 'sesi' => $manual] = $this->skenario(); // sesi hari ini (manual)

        $a = SesiPresensi::pastikanUntuk($kelas, now(), $guru->id_user);
        $b = SesiPresensi::pastikanUntuk($kelas, now(), $guru->id_user);

        $this->assertSame($manual->id_sesi, $a->id_sesi);
        $this->assertSame($manual->id_sesi, $b->id_sesi);
        $this->assertSame(1, SesiPresensi::where('id_kelas', $kelas->id_kelas)->count());

        $lain = Kelas::create(['nama' => 'Kelas Lain', 'id_jenjang' => 1, 'aktif' => true]);
        $c = SesiPresensi::pastikanUntuk($lain, now(), $guru->id_user);
        $d = SesiPresensi::pastikanUntuk($lain, now(), $guru->id_user);
        $this->assertSame($c->id_sesi, $d->id_sesi);
        $this->assertSame(1, SesiPresensi::where('id_kelas', $lain->id_kelas)->count());
    }

    public function test_sesi_otomatis_tidak_dibuat_untuk_kelas_yang_tidak_aktif_hari_ini(): void
    {
        ['guru' => $guru] = $this->skenario();
        $besokHari = now()->dayOfWeekIso % 7 + 1;

        $kasus = [
            'bukan hari jadwal' => ['hari' => (string) $besokHari],
            'masa berlaku habis' => ['berlaku_sampai' => now()->subDay()->toDateString()],
            'belum mulai berlaku' => ['berlaku_dari' => now()->addDay()->toDateString()],
            'nonaktif' => ['aktif' => false],
        ];

        foreach ($kasus as $nama => $atribut) {
            $kelas = Kelas::create(array_merge(['nama' => 'Kelas ' . $nama, 'id_jenjang' => 1, 'aktif' => true], $atribut));
            $this->assertNull(SesiPresensi::pastikanUntuk($kelas, now(), $guru->id_user), $nama);
            $this->assertSame(0, SesiPresensi::where('id_kelas', $kelas->id_kelas)->count(), $nama);
        }
    }

    public function test_scan_ditolak_jika_kelas_tidak_lagi_aktif_walau_sesi_hari_ini_ada(): void
    {
        ['guru' => $guru, 'siswa' => $siswa, 'kelas' => $kelas, 'sesi' => $sesi] = $this->skenario();
        $kelas->update(['berlaku_sampai' => now()->subDay()->toDateString()]);

        $this->assertFalse($sesi->fresh()->bisaDipindai());
        $this->scan($guru, $sesi, $siswa->qrPayload())
            ->assertStatus(422)
            ->assertJsonPath('status', 'kelas_nonaktif');
        $this->assertSame(0, DB::table('presensi')->count());
    }

    public function test_pembuatan_sesi_manual_sudah_dihapus(): void
    {
        ['guru' => $guru, 'kelas' => $kelas] = $this->skenario();

        $this->actingAs($guru)
            ->post('/guru/presensi/sesi', ['id_kelas' => $kelas->id_kelas, 'judul' => 'Manual'])
            ->assertNotFound();
    }

    // ---------- halaman Presensi: kelas hari ini + riwayat berfilter ----------

    private function sesiLama(Kelas $kelas, User $guru, string $judul, string $tanggal): SesiPresensi
    {
        return SesiPresensi::create([
            'id_kelas' => $kelas->id_kelas,
            'id_guru' => $guru->id_user,
            'judul' => $judul,
            'tanggal' => $tanggal,
            'status' => 'buka',
        ]);
    }

    public function test_halaman_presensi_menampilkan_kelas_hari_ini_dan_riwayat_minggu_ini(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-11-04 10:00:00')); // Rabu; minggu ini mulai Senin 2 Nov
        ['guru' => $guru, 'kelas' => $kelas] = $this->skenario();

        $this->sesiLama($kelas, $guru, 'Sesi Senin Ini', '2026-11-02');
        $this->sesiLama($kelas, $guru, 'Sesi Selasa Lalu', '2026-10-27');
        $this->sesiLama($kelas, $guru, 'Sesi Dua Minggu Lalu', '2026-10-15');
        $this->sesiLama($kelas, $guru, 'Sesi Terlalu Lama', '2026-09-20');

        $this->actingAs($guru)->get(route('guru.presensi.index'))
            ->assertOk()
            ->assertSee('Kelas hari ini')
            ->assertSee('Kelas X – Matematika')
            ->assertSee('Sesi Senin Ini')
            ->assertDontSee('Sesi Selasa Lalu')
            ->assertDontSee('Sesi Dua Minggu Lalu')
            ->assertDontSee('Sesi Terlalu Lama')
            ->assertDontSee('Buat Sesi');
    }

    public function test_riwayat_satu_bulan_dan_filter_hari(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-11-04 10:00:00'));
        ['guru' => $guru, 'kelas' => $kelas] = $this->skenario();

        $this->sesiLama($kelas, $guru, 'Sesi Senin Ini', '2026-11-02');      // Senin
        $this->sesiLama($kelas, $guru, 'Sesi Selasa Lalu', '2026-10-27');    // Selasa
        $this->sesiLama($kelas, $guru, 'Sesi Kamis Lama', '2026-10-15');     // Kamis
        $this->sesiLama($kelas, $guru, 'Sesi Terlalu Lama', '2026-09-20');   // > 30 hari

        $this->actingAs($guru)->get(route('guru.presensi.index', ['rentang' => 'bulan']))
            ->assertOk()
            ->assertSee('Sesi Senin Ini')
            ->assertSee('Sesi Selasa Lalu')
            ->assertSee('Sesi Kamis Lama')
            ->assertDontSee('Sesi Terlalu Lama');

        $this->actingAs($guru)->get(route('guru.presensi.index', ['rentang' => 'bulan', 'hari' => 4]))
            ->assertOk()
            ->assertSee('Sesi Kamis Lama')
            ->assertDontSee('Sesi Senin Ini')
            ->assertDontSee('Sesi Selasa Lalu');

        // Filter hari pada tampilan minggu ini.
        $this->actingAs($guru)->get(route('guru.presensi.index', ['hari' => 2]))
            ->assertOk()
            ->assertDontSee('Sesi Senin Ini')
            ->assertSee('Tidak ada riwayat');
    }

    public function test_guru_tidak_melihat_kelas_lain_di_halaman_presensi(): void
    {
        ['guru' => $guru] = $this->skenario();
        Kelas::create(['nama' => 'Kelas Rahasia Lain', 'id_jenjang' => 1, 'aktif' => true]);

        $this->actingAs($guru)->get(route('guru.presensi.index'))
            ->assertOk()
            ->assertDontSee('Kelas Rahasia Lain');
    }

    public function test_membuka_halaman_presensi_membuat_sesi_hari_ini_untuk_kelas_yang_diampu(): void
    {
        $guru = $this->user(2, 'Guru Otomatis');
        $kelas = Kelas::create(['nama' => 'Kelas Otomatis', 'id_jenjang' => 1, 'aktif' => true]);
        $kelas->guru()->attach($guru->id_user);
        $this->assertSame(0, SesiPresensi::count());

        $this->actingAs($guru)->get(route('guru.presensi.index'))->assertOk()->assertSee('Kelas Otomatis');

        $this->assertSame(1, SesiPresensi::where('id_kelas', $kelas->id_kelas)->count());
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

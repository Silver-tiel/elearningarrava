<?php

namespace Tests\Feature;

use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class AttendanceMentorTest extends TestCase
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
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('token', 64)->unique();
            $table->unsignedInteger('created_by');
            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->unsignedSmallInteger('late_after_minutes')->nullable();
            $table->enum('status', ['active', 'closed', 'expired'])->default('active');
            $table->timestamps();
        });

        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_session_id');
            $table->unsignedInteger('user_id');
            $table->dateTime('checked_in_at');
            $table->enum('status', ['hadir', 'terlambat']);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->unique(['attendance_session_id', 'user_id']);
        });
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    // ---------- helper ----------

    private function user(int $tipe, string $nama, string $password = 'password123'): User
    {
        return User::create([
            'nama' => $nama,
            'email' => strtolower(str_replace(' ', '', $nama)) . '@example.com',
            'password' => bcrypt($password),
            'id_tipeuser' => $tipe,
        ]);
    }

    private function admin(): User
    {
        return $this->user(1, 'Admin Satu');
    }

    private function guru(string $nama = 'Guru Satu'): User
    {
        return $this->user(2, $nama);
    }

    private function sesi(array $ubah = []): AttendanceSession
    {
        return AttendanceSession::create(array_merge([
            'title' => 'Absensi Senin',
            'token' => Str::random(64),
            'created_by' => 1,
            'starts_at' => now()->subMinutes(5),
            'expires_at' => now()->addHour(),
            'late_after_minutes' => null,
            'status' => 'active',
        ], $ubah));
    }

    private function checkIn(User $user, string $token)
    {
        return $this->actingAs($user)->postJson(route('attendance.check-in'), ['token' => $token]);
    }

    // ---------- Admin: membuat sesi & QR ----------

    public function test_admin_bisa_membuat_sesi_dan_melihat_qr(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.attendance.store'), [
            'title' => 'Absensi Mentor Pagi',
            'starts_at' => now()->format('Y-m-d\TH:i'),
            'expires_at' => now()->addHours(2)->format('Y-m-d\TH:i'),
            'late_after_minutes' => 15,
        ])->assertSessionHasNoErrors()->assertRedirect();

        $sesi = AttendanceSession::where('title', 'Absensi Mentor Pagi')->firstOrFail();
        $this->assertMatchesRegularExpression('/^[A-Za-z0-9]{64}$/', $sesi->token);
        $this->assertSame($admin->id_user, (int) $sesi->created_by);
        $this->assertSame('active', $sesi->status);
        $this->assertSame(15, $sesi->late_after_minutes);

        $this->actingAs($admin)->get(route('admin.attendance.qr', $sesi))
            ->assertOk()
            ->assertSee('<svg', false)
            ->assertSee($sesi->token);
    }

    public function test_validasi_pembuatan_sesi(): void
    {
        $admin = $this->admin();
        $mulai = now()->addHour();

        // judul wajib
        $this->actingAs($admin)->post(route('admin.attendance.store'), [
            'starts_at' => $mulai->format('Y-m-d\TH:i'),
            'expires_at' => $mulai->copy()->addHour()->format('Y-m-d\TH:i'),
        ])->assertSessionHasErrors('title');

        // berakhir harus setelah mulai
        $this->actingAs($admin)->post(route('admin.attendance.store'), [
            'title' => 'X',
            'starts_at' => $mulai->format('Y-m-d\TH:i'),
            'expires_at' => $mulai->format('Y-m-d\TH:i'),
        ])->assertSessionHasErrors('expires_at');

        // tanggal tidak valid
        $this->actingAs($admin)->post(route('admin.attendance.store'), [
            'title' => 'X', 'starts_at' => 'bukan-tanggal', 'expires_at' => 'juga-bukan',
        ])->assertSessionHasErrors(['starts_at', 'expires_at']);

        // batas terlambat melewati jam berakhir
        $this->actingAs($admin)->post(route('admin.attendance.store'), [
            'title' => 'X',
            'starts_at' => $mulai->format('Y-m-d\TH:i'),
            'expires_at' => $mulai->copy()->addMinutes(30)->format('Y-m-d\TH:i'),
            'late_after_minutes' => 60,
        ])->assertSessionHasErrors('late_after_minutes');

        $this->assertSame(0, AttendanceSession::count());
    }

    public function test_token_tidak_ikut_terserialisasi(): void
    {
        $sesi = $this->sesi();

        $this->assertArrayNotHasKey('token', $sesi->toArray());
        $this->assertStringNotContainsString($sesi->token, $sesi->toJson());
    }

    public function test_admin_bisa_melihat_daftar_sesi(): void
    {
        $this->sesi(['title' => 'Sesi Terlihat Admin']);

        $this->actingAs($this->admin())->get(route('admin.attendance.index'))
            ->assertOk()
            ->assertSee('Sesi Terlihat Admin');
    }

    public function test_admin_bisa_menutup_sesi(): void
    {
        $sesi = $this->sesi();

        $this->actingAs($this->admin())->patch(route('admin.attendance.close', $sesi))->assertRedirect();

        $this->assertSame('closed', $sesi->fresh()->status);
    }

    // ---------- Hak akses ----------

    public function test_guru_tidak_bisa_mengelola_sesi(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi();

        $this->actingAs($guru)->get(route('admin.attendance.index'))->assertForbidden();
        $this->actingAs($guru)->get(route('admin.attendance.create'))->assertForbidden();
        $this->actingAs($guru)->post(route('admin.attendance.store'), ['title' => 'X'])->assertForbidden();
        $this->actingAs($guru)->get(route('admin.attendance.qr', $sesi))->assertForbidden();
        $this->actingAs($guru)->get(route('admin.attendance.report', $sesi))->assertForbidden();
        $this->actingAs($guru)->get(route('admin.attendance.export', $sesi))->assertForbidden();
        $this->actingAs($guru)->patch(route('admin.attendance.close', $sesi))->assertForbidden();

        $this->assertSame('active', $sesi->fresh()->status);
    }

    public function test_siswa_dan_orangtua_tidak_punya_akses_sama_sekali(): void
    {
        $sesi = $this->sesi();

        foreach ([$this->user(3, 'Siswa Uji'), $this->user(4, 'Orang Tua Uji')] as $u) {
            $this->actingAs($u)->get(route('admin.attendance.index'))->assertForbidden();
            $this->actingAs($u)->get(route('admin.attendance.qr', $sesi))->assertForbidden();
            $this->actingAs($u)->get(route('attendance.scan'))->assertForbidden();
            $this->actingAs($u)->get(route('attendance.check-in.link', ['token' => $sesi->token]))->assertForbidden();
            $this->checkIn($u, $sesi->token)->assertForbidden();
        }

        $this->assertSame(0, AttendanceRecord::count());
    }

    public function test_admin_tidak_bisa_check_in(): void
    {
        $sesi = $this->sesi();

        $this->checkIn($this->admin(), $sesi->token)->assertForbidden();
        $this->assertSame(0, AttendanceRecord::count());
    }

    // ---------- Check-in ----------

    public function test_guru_bisa_check_in_dengan_token_valid(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi();

        $this->checkIn($guru, $sesi->token)
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('status', 'hadir');

        $rec = AttendanceRecord::firstOrFail();
        $this->assertSame($sesi->id, (int) $rec->attendance_session_id);
        $this->assertSame($guru->id_user, (int) $rec->user_id);
        $this->assertNotNull($rec->ip_address);
    }

    public function test_check_in_lewat_form_biasa_mengalihkan_dengan_pesan(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi();

        $this->actingAs($guru)->post(route('attendance.check-in'), ['token' => $sesi->token])
            ->assertRedirect(route('attendance.scan'))
            ->assertSessionHas('success');

        $this->assertSame(1, AttendanceRecord::count());
    }

    public function test_check_in_dari_tab_presensi_kembali_ke_tab_absen_mentor(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi();

        $this->actingAs($guru)->post(route('attendance.check-in'), [
            'token' => $sesi->token,
            'return_to' => 'presensi',
        ])
            ->assertRedirect(route('guru.presensi.index', ['tab' => 'mentor']))
            ->assertSessionHas('success');

        $this->assertSame(1, AttendanceRecord::count());
    }

    public function test_tautan_penuh_hasil_scan_juga_diterima(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi();

        $this->checkIn($guru, $sesi->checkInUrl())->assertOk()->assertJsonPath('success', true);
    }

    public function test_user_id_dari_request_diabaikan(): void
    {
        $pelaku = $this->guru('Guru Pelaku');
        $korban = $this->guru('Guru Korban');
        $sesi = $this->sesi();

        $this->actingAs($pelaku)->postJson(route('attendance.check-in'), [
            'token' => $sesi->token,
            'user_id' => $korban->id_user,
        ])->assertOk();

        $this->assertSame($pelaku->id_user, (int) AttendanceRecord::firstOrFail()->user_id);
    }

    public function test_status_terlambat_mengikuti_batas_keterlambatan(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-11-25 08:00:00'));

        $tepat = $this->sesi(['starts_at' => now()->subMinutes(10), 'expires_at' => now()->addHour(), 'late_after_minutes' => 15]);
        $telat = $this->sesi(['starts_at' => now()->subMinutes(30), 'expires_at' => now()->addHour(), 'late_after_minutes' => 15]);
        $tanpaBatas = $this->sesi(['starts_at' => now()->subMinutes(50), 'expires_at' => now()->addHour(), 'late_after_minutes' => null]);

        $this->checkIn($this->guru('Guru A'), $tepat->token)->assertJsonPath('status', 'hadir');
        $this->checkIn($this->guru('Guru B'), $telat->token)->assertJsonPath('status', 'terlambat');
        $this->checkIn($this->guru('Guru C'), $tanpaBatas->token)->assertJsonPath('status', 'hadir');
    }

    public function test_check_in_gagal_jika_token_tidak_valid(): void
    {
        $guru = $this->guru();
        $this->sesi();

        $this->checkIn($guru, Str::random(64))->assertStatus(422)->assertJsonPath('reason', 'token_invalid');
        $this->checkIn($guru, 'pendek')->assertStatus(422)->assertJsonPath('reason', 'token_invalid');
        $this->checkIn($guru, "' OR 1=1 --")->assertStatus(422)->assertJsonPath('reason', 'token_invalid');

        $this->assertSame(0, AttendanceRecord::count());
    }

    public function test_check_in_gagal_jika_sesi_sudah_berakhir_dan_status_ditandai_expired(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi(['starts_at' => now()->subHours(3), 'expires_at' => now()->subHour()]);

        $this->checkIn($guru, $sesi->token)->assertStatus(422)->assertJsonPath('reason', 'session_expired');

        $this->assertSame('expired', $sesi->fresh()->status);
        $this->assertSame(0, AttendanceRecord::count());
    }

    public function test_check_in_gagal_jika_sesi_ditutup(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi(['status' => 'closed']);

        $this->checkIn($guru, $sesi->token)->assertStatus(422)->assertJsonPath('reason', 'session_closed');
        $this->assertSame(0, AttendanceRecord::count());
    }

    public function test_check_in_gagal_jika_sesi_belum_dimulai(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi(['starts_at' => now()->addHour(), 'expires_at' => now()->addHours(2)]);

        $this->checkIn($guru, $sesi->token)->assertStatus(422)->assertJsonPath('reason', 'not_started');
        $this->assertSame(0, AttendanceRecord::count());
    }

    public function test_check_in_gagal_jika_sudah_pernah_check_in(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi();

        $this->checkIn($guru, $sesi->token)->assertOk();
        $this->checkIn($guru, $sesi->token)->assertStatus(409)->assertJsonPath('reason', 'already_checked_in');

        $this->assertSame(1, AttendanceRecord::count());
    }

    public function test_database_menolak_check_in_ganda(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi();
        $data = [
            'attendance_session_id' => $sesi->id,
            'user_id' => $guru->id_user,
            'checked_in_at' => now(),
            'status' => 'hadir',
        ];

        AttendanceRecord::create($data);

        $this->expectException(QueryException::class);
        AttendanceRecord::create($data);
    }

    public function test_percobaan_token_salah_berulang_dibatasi(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi();

        for ($i = 0; $i < 10; $i++) {
            $this->checkIn($guru, Str::random(64))->assertStatus(422);
        }

        // Setelah batas gagal tercapai, bahkan token benar pun ditahan sementara.
        $this->checkIn($guru, $sesi->token)->assertStatus(429)->assertJsonPath('reason', 'too_many_attempts');
        $this->assertSame(0, AttendanceRecord::count());
    }

    // ---------- Halaman mentor & alur login ----------

    public function test_halaman_scan_dan_konfirmasi_tidak_mengubah_data(): void
    {
        $guru = $this->guru();
        $sesi = $this->sesi(['title' => 'Sesi Konfirmasi']);

        $this->actingAs($guru)->get(route('attendance.scan'))->assertOk()->assertSee('HTTPS');

        $this->actingAs($guru)->get(route('attendance.check-in.link', ['token' => $sesi->token]))
            ->assertOk()
            ->assertSee('Sesi Konfirmasi')
            ->assertSee('Check-in sekarang');

        // GET tidak boleh mencatat kehadiran.
        $this->assertSame(0, AttendanceRecord::count());

        $this->actingAs($guru)->get(route('attendance.check-in.link', ['token' => Str::random(64)]))
            ->assertOk()
            ->assertSee('QR tidak dikenali');
    }

    public function test_pengguna_belum_login_dialihkan_ke_login_dan_tujuan_diingat(): void
    {
        $sesi = $this->sesi();
        $url = route('attendance.check-in.link', ['token' => $sesi->token]);

        $this->get($url)
            ->assertRedirect(route('login'))
            ->assertSessionHas('url.intended', $url);
    }

    public function test_setelah_login_ajax_mentor_kembali_ke_halaman_check_in(): void
    {
        $guru = $this->guru('Guru Login');
        $sesi = $this->sesi();
        $url = route('attendance.check-in.link', ['token' => $sesi->token]);

        $this->withSession(['url.intended' => $url])
            ->postJson('/login', ['email' => $guru->email, 'password' => 'password123'])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('redirect', $url);
    }

    public function test_login_ajax_tidak_mengikuti_tujuan_lain_selain_check_in(): void
    {
        $guru = $this->guru('Guru Biasa');

        $this->withSession(['url.intended' => url('/admin/data')])
            ->postJson('/login', ['email' => $guru->email, 'password' => 'password123'])
            ->assertOk()
            ->assertJsonPath('redirect', url('/admin'));
    }

    // ---------- Rekap ----------

    public function test_admin_bisa_melihat_rekap_dan_yang_belum_check_in(): void
    {
        $sesi = $this->sesi(['late_after_minutes' => 0, 'starts_at' => now()->subMinutes(30)]);
        $hadir = $this->guru('Guru Sudah Hadir');
        $this->guru('Guru Belum Hadir');

        $this->checkIn($hadir, $sesi->token)->assertOk();

        $this->actingAs($this->admin())->get(route('admin.attendance.report', $sesi))
            ->assertOk()
            ->assertSee('Guru Sudah Hadir')
            ->assertSee('Terlambat')
            ->assertSee('Guru Belum Hadir')
            ->assertSee('Belum check-in');
    }

    public function test_ekspor_csv_berisi_rekap_dan_menetralkan_formula(): void
    {
        $sesi = $this->sesi();
        $jahat = $this->user(2, '=HYPERLINK("http://x")');
        $this->checkIn($jahat, $sesi->token)->assertOk();

        $response = $this->actingAs($this->admin())->get(route('admin.attendance.export', $sesi));
        $response->assertOk();

        $isi = $response->streamedContent();
        $this->assertStringContainsString('Nama,Email,Status,"Waktu Check-in"', $isi);
        $this->assertStringContainsString("'=HYPERLINK", $isi);
        // Tanpa penetralan, sel akan diawali langsung dengan "= (formula); harus tidak ada.
        $this->assertStringNotContainsString('"=HYPERLINK', $isi);
        $this->assertStringNotContainsString(',=HYPERLINK', $isi);
    }
}

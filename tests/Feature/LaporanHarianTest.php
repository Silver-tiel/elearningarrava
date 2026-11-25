<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\SesiPresensi;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LaporanHarianTest extends TestCase
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
        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });
        Schema::create('kelas', function (Blueprint $table) {
            $table->increments('id_kelas');
            $table->string('nama');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->string('hari')->nullable();
            $table->date('berlaku_dari')->nullable();
            $table->date('berlaku_sampai')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
        Schema::create('kelas_guru', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kelas');
            $table->unsignedInteger('id_guru');
            $table->timestamps();
        });
        Schema::create('sesi_presensi', function (Blueprint $table) {
            $table->increments('id_sesi');
            $table->unsignedInteger('id_kelas');
            $table->unsignedInteger('id_guru');
            $table->string('judul');
            $table->date('tanggal');
            $table->string('status')->default('buka');
            $table->timestamps();
        });
        Schema::create('mapel', function (Blueprint $table) {
            $table->increments('id_mapel');
            $table->string('nama_mapel');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->timestamps();
        });
        Schema::create('presensi', function (Blueprint $table) {
            $table->increments('id_presensi');
            $table->unsignedInteger('id_sesi');
            $table->unsignedInteger('id_siswa');
            $table->unsignedInteger('id_guru_pemindai');
            $table->string('status');
            $table->dateTime('waktu_scan');
            $table->boolean('is_bintang')->default(false);
            $table->timestamps();
        });
        Schema::create('laporan_harian', function (Blueprint $table) {
            $table->increments('id_laporan');
            $table->unsignedInteger('id_sesi')->unique();
            $table->unsignedInteger('id_guru');
            $table->unsignedInteger('id_mapel');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->date('kelas_berlaku_dari')->nullable();
            $table->date('kelas_berlaku_sampai')->nullable();
            $table->timestamps();
        });

        DB::table('jenjang')->insert(['id_jenjang' => 1, 'nama_tipe' => 'SD']);
        DB::table('mapel')->insert(['id_mapel' => 1, 'nama_mapel' => 'Matematika', 'id_jenjang' => 1]);
    }

    private function buatUser(int $role, string $nama): User
    {
        return User::create([
            'nama' => $nama,
            'email' => strtolower(str_replace(' ', '.', $nama)) . '@example.com',
            'password' => 'password123',
            'id_tipeuser' => $role,
            'status_akun' => 'Aktif',
        ]);
    }

    private function buatSesi(User $guru, bool $ditugaskan = true): array
    {
        $siswa = $this->buatUser(3, 'Siswa Aktif');
        $kelas = Kelas::create([
            'nama' => 'Kelas A',
            'id_jenjang' => 1,
            'aktif' => true,
        ]);
        if ($ditugaskan) {
            $kelas->guru()->attach($guru->id_user);
        }

        $sesi = SesiPresensi::create([
            'id_kelas' => $kelas->id_kelas,
            'id_guru' => $guru->id_user,
            'judul' => 'Presensi hari ini',
            'tanggal' => now()->toDateString(),
            'status' => 'tutup',
        ]);
        DB::table('presensi')->insert([
            'id_sesi' => $sesi->id_sesi,
            'id_siswa' => $siswa->id_user,
            'id_guru_pemindai' => $guru->id_user,
            'status' => 'hadir',
            'waktu_scan' => now(),
            'is_bintang' => false,
        ]);

        return [$kelas, $sesi, $siswa];
    }

    public function test_guru_mengirim_laporan_dan_menyimpan_siswa_bintang_yang_hadir(): void
    {
        $guru = $this->buatUser(2, 'Guru Satu');
        [, $sesi, $siswa] = $this->buatSesi($guru);

        $this->actingAs($guru)
            ->put(route('guru.laporan-harian.update', $sesi->id_sesi), [
                'id_mapel' => 1,
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '09:30',
                'id_siswa_bintang' => $siswa->id_user,
            ])
            ->assertRedirect(route('guru.laporan-harian.index'));

        $this->assertDatabaseHas('laporan_harian', [
            'id_sesi' => $sesi->id_sesi,
            'id_guru' => $guru->id_user,
            'id_mapel' => 1,
        ]);
        $this->assertSame('08:00', DB::table('laporan_harian')->value('waktu_mulai'));
        $this->assertSame('09:30', DB::table('laporan_harian')->value('waktu_selesai'));
        $this->assertDatabaseHas('presensi', [
            'id_sesi' => $sesi->id_sesi,
            'id_siswa' => $siswa->id_user,
            'is_bintang' => true,
        ]);
    }

    public function test_guru_tidak_dapat_melaporkan_kelas_yang_tidak_ditugaskan(): void
    {
        $guru = $this->buatUser(2, 'Guru Dua');
        [, $sesi] = $this->buatSesi($guru, false);

        $this->actingAs($guru)
            ->put(route('guru.laporan-harian.update', $sesi->id_sesi), [
                'id_mapel' => 1,
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '09:30',
                'id_siswa_bintang' => 1,
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('laporan_harian', 0);
    }

    public function test_guru_hanya_dapat_memilih_siswa_hadir_sebagai_bintang(): void
    {
        $guru = $this->buatUser(2, 'Guru Tiga');
        [, $sesi] = $this->buatSesi($guru);

        $this->actingAs($guru)
            ->put(route('guru.laporan-harian.update', $sesi->id_sesi), [
                'id_mapel' => 1,
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '09:30',
                'id_siswa_bintang' => 999,
            ])
            ->assertSessionHasErrors('id_siswa_bintang');

        $this->assertDatabaseCount('laporan_harian', 0);
    }

    public function test_admin_dapat_melihat_rekap_laporan_dan_guru_tidak_dapat_mengaksesnya(): void
    {
        $guru = $this->buatUser(2, 'Guru Empat');
        $admin = $this->buatUser(1, 'Admin Satu');
        [, $sesi, $siswa] = $this->buatSesi($guru);

        $this->actingAs($guru)
            ->put(route('guru.laporan-harian.update', $sesi->id_sesi), [
                'id_mapel' => 1,
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '09:30',
                'id_siswa_bintang' => $siswa->id_user,
            ])
            ->assertRedirect();

        $this->actingAs($guru)->get(route('admin.laporan-harian'))->assertForbidden();

        $this->actingAs($admin)
            ->get(route('admin.laporan-harian'))
            ->assertOk()
            ->assertSee('Guru Empat')
            ->assertSee('Kelas A')
            ->assertSee('Matematika')
            ->assertSee('Siswa Aktif');
    }
}

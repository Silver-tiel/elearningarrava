<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiswaProfileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nisn')->unique();
            $table->string('nomor_hp')->nullable();
            $table->string('kelas', 50)->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->unsignedInteger('id_tipeuser')->default(3);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->integer('total_poin')->default(0);
            $table->string('status_akun')->default('Aktif');
            $table->unsignedInteger('id_modul')->nullable();
            $table->string('foto_profil')->nullable();
            $table->timestamps();
        });

        Schema::create('hasilquizmodul', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->unsignedInteger('id_user');
            $table->integer('total_poin')->default(0);
            $table->integer('poin_didapat')->default(0);
        });

        Schema::create('pencapaianuser', function (Blueprint $table) {
            $table->increments('id_pencapaian');
            $table->unsignedInteger('id_user');
            $table->string('nama');
            $table->dateTime('waktu_pencapaian');
        });

        DB::table('jenjang')->insert(['id_jenjang' => 1, 'nama_tipe' => 'SMA']);
    }

    public function test_student_can_update_profile_without_changing_email(): void
    {
        Storage::fake('public');

        $student = User::create([
            'nama' => 'Nama Lama',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password123'),
            'nisn' => '0012345678',
            'nomor_hp' => '08123456789',
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        $this->actingAs($student)
            ->put(route('siswa.profil.update'), [
                'nama' => 'Nama Baru',
                'nisn' => '0098765432',
                'nomor_hp' => '08111111111',
                'kelas' => 'Kelas 10',
                'asal_sekolah' => 'SMA Negeri 1',
                'id_jenjang' => 1,
                'foto_profil' => UploadedFile::fake()->image('profil.jpg'),
                'email' => 'email-baru@example.com',
            ])
            ->assertRedirect(route('siswa.profil'))
            ->assertSessionHas('success');

        $student->refresh();

        $this->assertSame('Nama Baru', $student->nama);
        $this->assertSame('0098765432', $student->nisn);
        $this->assertSame('siswa@example.com', $student->email);
        $this->assertSame('Kelas 10', $student->kelas);
        $this->assertSame('SMA Negeri 1', $student->asal_sekolah);
        $this->assertNotEmpty($student->foto_profil);
        Storage::disk('public')->assertExists($student->foto_profil);

        $this->actingAs($student)
            ->get(route('siswa.profil'))
            ->assertOk()
            ->assertSee('Nama Baru')
            ->assertSee('Email terikat ke akun dan tidak dapat diubah.')
            ->assertSee('Simpan Perubahan')
            ->assertSeeHtml('data-open-on-load="false"');

        User::create([
            'nama' => 'Siswa Lain',
            'email' => 'lain@example.com',
            'password' => bcrypt('password123'),
            'nisn' => '0088888888',
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
        ]);

        $this->actingAs($student)
            ->from(route('siswa.profil'))
            ->put(route('siswa.profil.update'), [
                'nama' => 'Nama Baru',
                'nisn' => '0088888888',
                'id_jenjang' => 1,
            ])
            ->assertRedirect(route('siswa.profil'))
            ->assertSessionHasErrors('nisn');

        $this->get(route('siswa.profil'))
            ->assertOk()
            ->assertSee('0088888888')
            ->assertSeeHtml('data-open-on-load="true"');

        $this->assertSame('0098765432', $student->fresh()->nisn);
    }
}

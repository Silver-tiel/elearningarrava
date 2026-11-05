<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HeaderSoundSettingsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('jenjang', function (Blueprint $table) {
            $table->increments('id_jenjang');
            $table->string('nama_tipe');
        });

        Schema::create('tipeuser', function (Blueprint $table) {
            $table->increments('id_tipeUser');
            $table->string('nama_tipe');
            $table->timestamps();
        });

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nisn')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->unsignedInteger('id_tipeuser')->default(3);
            $table->string('status_akun')->default('Aktif');
            $table->integer('total_poin')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('modul', function (Blueprint $table) {
            $table->increments('id_modul');
            $table->string('judul_modul');
            $table->unsignedInteger('id_jenjang');
            $table->string('status')->default('published');
            $table->timestamps();
        });

        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('judul_quiz');
            $table->unsignedInteger('id_jenjang');
            $table->string('status')->default('published');
            $table->timestamps();
        });

        DB::table('jenjang')->insert(['nama_tipe' => 'SMA']);
        DB::table('tipeuser')->insert([
            ['id_tipeUser' => 1, 'nama_tipe' => 'admin'],
            ['id_tipeUser' => 2, 'nama_tipe' => 'guru'],
            ['id_tipeUser' => 3, 'nama_tipe' => 'siswa'],
            ['id_tipeUser' => 4, 'nama_tipe' => 'orangtua'],
        ]);
    }

    public function test_header_siswa_memiliki_komponen_pengaturan_suara(): void
    {
        $siswa = User::create([
            'nama' => 'Siswa Test',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password123'),
            'id_jenjang' => 1,
            'id_tipeuser' => 3,
        ]);

        $response = $this->actingAs($siswa)->get('/siswa/dashboard');

        $response->assertStatus(200);
        $response->assertSee('id="soundSettingsContainer"', false);
        $response->assertSee('id="soundSettingsTrigger"', false);
        $response->assertSee('Pengaturan Suara');
        $response->assertSee('id="soundVolumeRange"', false);
        $response->assertSee('Uji Efek Suara');
    }

    public function test_view_sound_settings_component_dapat_dirender_langsung(): void
    {
        $rendered = view('components.sound-settings')->render();

        $this->assertStringContainsString('soundSettingsContainer', $rendered);
        $this->assertStringContainsString('soundVolumeRange', $rendered);
        $this->assertStringContainsString('soundToggleCheckbox', $rendered);
        $this->assertStringContainsString('Uji Efek Suara', $rendered);
    }
}


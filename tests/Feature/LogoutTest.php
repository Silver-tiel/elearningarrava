<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LogoutTest extends TestCase
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

        DB::table('jenjang')->insert(['nama_tipe' => 'SMA']);
        DB::table('tipeuser')->insert(['nama_tipe' => 'siswa']);
    }

    public function test_logout_via_post_berhasil_dan_redirect_ke_login(): void
    {
        $user = User::create([
            'nama' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'id_jenjang' => 1,
            'id_tipeuser' => 3,
        ]);

        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertFalse(Auth::check());
    }

    public function test_logout_via_get_berhasil_dan_redirect_ke_login(): void
    {
        $user = User::create([
            'nama' => 'Test User 2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password123'),
            'id_jenjang' => 1,
            'id_tipeuser' => 3,
        ]);

        $this->actingAs($user);
        $this->assertTrue(Auth::check());

        $response = $this->get('/logout');

        $response->assertRedirect('/login');
        $this->assertFalse(Auth::check());
    }

    public function test_logout_saat_tidak_login_tetap_redirect_ke_login(): void
    {
        $response = $this->post('/logout');
        $response->assertRedirect('/login');

        $responseGet = $this->get('/logout');
        $responseGet->assertRedirect('/login');
    }
}


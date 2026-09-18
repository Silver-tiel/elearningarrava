<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PendaftaranDuplicateTest extends TestCase
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
            $table->string('nama')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_jenjang');
            $table->unsignedInteger('id_tipeuser');
            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang');
        });

        DB::table('jenjang')->insert([
            'nama_tipe' => 'SMA',
        ]);
    }

    public function test_duplicate_name_and_email_are_rejected(): void
    {
        User::create([
            'nama' => 'User Lama',
            'email' => 'lama@example.com',
            'password' => bcrypt('password123'),
            'id_jenjang' => 1,
            'id_tipeuser' => 3,
        ]);

        $response = $this->from('/pendaftaran')->post('/pendaftaran', [
            'nama' => 'User Lama',
            'email' => 'lama@example.com',
            'password' => 'password123',
            'id_jenjang' => 1,
        ]);

        $response->assertSessionHasErrors(['nama', 'email']);
    }
}

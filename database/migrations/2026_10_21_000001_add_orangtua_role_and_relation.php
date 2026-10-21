<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah tipe user orangtua (id=4) jika belum ada
        DB::table('tipeuser')->insertOrIgnore([
            ['id_tipeUser' => 4, 'nama_tipe' => 'orangtua', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Buat tabel relasi orangtua-siswa
        Schema::create('orangtua_siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_orangtua');
            $table->unsignedInteger('id_siswa');
            $table->timestamps();

            $table->unique(['id_orangtua', 'id_siswa']);
            $table->foreign('id_orangtua')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orangtua_siswa');
        DB::table('tipeuser')->where('id_tipeUser', 4)->delete();
    }
};

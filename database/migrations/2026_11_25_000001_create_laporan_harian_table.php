<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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

            $table->foreign('id_sesi')->references('id_sesi')->on('sesi_presensi')->cascadeOnDelete();
            $table->foreign('id_guru')->references('id_user')->on('user')->cascadeOnDelete();
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_harian');
    }
};

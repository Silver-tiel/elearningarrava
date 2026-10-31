<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_presensi', function (Blueprint $table) {
            $table->increments('id_sesi');
            $table->unsignedInteger('id_kelas');
            $table->unsignedInteger('id_guru');
            $table->string('judul', 150);
            $table->unsignedSmallInteger('pertemuan_ke')->nullable();
            $table->date('tanggal');
            $table->dateTime('batas_tepat_waktu')->nullable();
            $table->string('status', 10)->default('buka'); // buka | tutup
            $table->timestamps();

            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->cascadeOnDelete();
            $table->foreign('id_guru')->references('id_user')->on('user')->cascadeOnDelete();
        });

        Schema::create('presensi', function (Blueprint $table) {
            $table->increments('id_presensi');
            $table->unsignedInteger('id_sesi');
            $table->unsignedInteger('id_siswa');
            $table->unsignedInteger('id_guru_pemindai');
            $table->string('status', 10); // hadir | terlambat
            $table->dateTime('waktu_scan');
            $table->timestamps();

            // Pagar utama anti-duplikasi (aman terhadap scan bersamaan).
            $table->unique(['id_sesi', 'id_siswa']);
            $table->foreign('id_sesi')->references('id_sesi')->on('sesi_presensi')->cascadeOnDelete();
            $table->foreign('id_siswa')->references('id_user')->on('user')->cascadeOnDelete();
            $table->foreign('id_guru_pemindai')->references('id_user')->on('user')->cascadeOnDelete();
        });

        Schema::create('log_pemindaian', function (Blueprint $table) {
            $table->increments('id_log');
            $table->unsignedInteger('id_sesi')->nullable();
            $table->unsignedInteger('id_guru');
            $table->unsignedInteger('id_siswa')->nullable();
            $table->char('token_hash', 64)->nullable(); // sha256, BUKAN token mentah
            $table->string('hasil', 20); // hadir|terlambat|duplikat|tidak_valid|bukan_anggota|tidak_aktif|sesi_ditutup
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['id_sesi', 'created_at']);
            $table->foreign('id_sesi')->references('id_sesi')->on('sesi_presensi')->nullOnDelete();
            $table->foreign('id_guru')->references('id_user')->on('user')->cascadeOnDelete();
            $table->foreign('id_siswa')->references('id_user')->on('user')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_pemindaian');
        Schema::dropIfExists('presensi');
        Schema::dropIfExists('sesi_presensi');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->increments('id_kelas');
            $table->string('nama', 150);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->string('tahun_ajaran', 20)->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang')->nullOnDelete();
        });

        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kelas');
            $table->unsignedInteger('id_siswa');
            $table->timestamps();

            $table->unique(['id_kelas', 'id_siswa']);
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->cascadeOnDelete();
            $table->foreign('id_siswa')->references('id_user')->on('user')->cascadeOnDelete();
        });

        Schema::create('kelas_guru', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kelas');
            $table->unsignedInteger('id_guru');
            $table->timestamps();

            $table->unique(['id_kelas', 'id_guru']);
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->cascadeOnDelete();
            $table->foreign('id_guru')->references('id_user')->on('user')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas_guru');
        Schema::dropIfExists('kelas_siswa');
        Schema::dropIfExists('kelas');
    }
};

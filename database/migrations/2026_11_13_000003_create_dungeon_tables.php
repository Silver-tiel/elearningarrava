<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tabel dungeon_sesi
        Schema::create('dungeon_sesi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_jenjang');
            $table->unsignedInteger('id_mapel');
            $table->integer('ronde_ke')->default(1);
            $table->timestamp('mulai');
            $table->timestamp('selesai')->nullable();
            $table->string('alasan_selesai')->nullable(); // nyawa_habis, keluar, timeout, tuntas
            $table->integer('jumlah_benar')->default(0);
            $table->integer('jumlah_salah')->default(0);
            $table->integer('nyawa')->default(3);
            $table->integer('lantai_tertinggi')->default(1);
            $table->integer('skor_dungeon')->default(0);
            $table->decimal('multiplier_akhir', 4, 2)->default(1.00);
            $table->integer('poin_profil_didapat')->default(0);
            $table->boolean('poin_sudah_diberikan')->default(false);
            $table->unsignedInteger('kunci_aktif')->nullable();
            $table->boolean('is_uji_coba')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel');

            $table->unique('kunci_aktif');
            $table->index(['id_user', 'id_mapel']);
            $table->index(['id_mapel', 'id_jenjang', 'skor_dungeon']);
        });

        // 2. Tabel dungeon_sesi_soal
        Schema::create('dungeon_sesi_soal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_sesi');
            $table->unsignedInteger('id_soal');
            $table->integer('urutan')->default(1);
            $table->json('urutan_pilihan')->nullable();
            $table->timestamp('waktu_tampil');
            $table->timestamp('batas_waktu');
            $table->text('jawaban_user')->nullable();
            $table->boolean('is_benar')->nullable();
            $table->integer('poin_didapat')->default(0);
            $table->timestamps();

            $table->foreign('id_sesi')->references('id')->on('dungeon_sesi')->onDelete('cascade');
            $table->foreign('id_soal')->references('id_soal')->on('soal')->onDelete('cascade');

            $table->unique(['id_sesi', 'id_soal']);
            $table->index('id_sesi');
        });

        // 3. Tabel dungeon_riwayat_soal
        Schema::create('dungeon_riwayat_soal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_soal');
            $table->integer('ronde_terakhir')->default(1);
            $table->integer('times_seen')->default(0);
            $table->integer('times_correct')->default(0);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_soal')->references('id_soal')->on('soal')->onDelete('cascade');

            $table->unique(['id_user', 'id_soal']);
        });

        // 4. Tabel dungeon_pengaturan
        Schema::create('dungeon_pengaturan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kunci')->unique();
            $table->json('nilai');
            $table->timestamps();
        });

        // 5. Tabel dungeon_laporan_soal
        Schema::create('dungeon_laporan_soal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_soal');
            $table->unsignedInteger('id_user');
            $table->text('alasan');
            $table->string('status')->default('menunggu'); // menunggu, ditinjau, disetujui, ditolak
            $table->timestamps();

            $table->foreign('id_soal')->references('id_soal')->on('soal')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');

            $table->unique(['id_soal', 'id_user']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dungeon_laporan_soal');
        Schema::dropIfExists('dungeon_pengaturan');
        Schema::dropIfExists('dungeon_riwayat_soal');
        Schema::dropIfExists('dungeon_sesi_soal');
        Schema::dropIfExists('dungeon_sesi');
    }
};

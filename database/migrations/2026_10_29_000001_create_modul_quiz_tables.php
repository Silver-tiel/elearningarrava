<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom KKM dan Poin Modul pada tabel modul
        Schema::table('modul', function (Blueprint $table) {
            if (!Schema::hasColumn('modul', 'kkm_quiz')) {
                $table->integer('kkm_quiz')->default(70)->after('progressModul');
            }
            if (!Schema::hasColumn('modul', 'poin_modul')) {
                $table->integer('poin_modul')->default(50)->after('kkm_quiz');
            }
        });

        // 2. Tabel Soal Kuis Modul
        if (!Schema::hasTable('modul_soal')) {
            Schema::create('modul_soal', function (Blueprint $table) {
                $table->increments('id_soal');
                $table->unsignedInteger('id_modul');
                $table->text('pertanyaan');
                $table->integer('poin')->default(10);
                $table->integer('urutan')->default(1);
                $table->timestamps();

                $table->foreign('id_modul')->references('id_modul')->on('modul')->onDelete('cascade');
            });
        }

        // 3. Tabel Pilihan Jawaban Soal Kuis Modul
        if (!Schema::hasTable('modul_soal_pilihan')) {
            Schema::create('modul_soal_pilihan', function (Blueprint $table) {
                $table->increments('id_pilihan');
                $table->unsignedInteger('id_soal');
                $table->string('label', 10)->nullable();
                $table->text('teks_pilihan');
                $table->boolean('is_benar')->default(false);
                $table->timestamps();

                $table->foreign('id_soal')->references('id_soal')->on('modul_soal')->onDelete('cascade');
            });
        }

        // 4. Tabel Pelacak Progres Modul & Kuis Siswa
        if (!Schema::hasTable('progres_modul_siswa')) {
            Schema::create('progres_modul_siswa', function (Blueprint $table) {
                $table->increments('id_progres');
                $table->unsignedInteger('id_user');
                $table->unsignedInteger('id_modul');
                $table->boolean('materi_selesai')->default(false);
                $table->boolean('quiz_selesai')->default(false);
                $table->boolean('quiz_lulus')->default(false);
                $table->integer('nilai_quiz')->default(0);
                $table->boolean('is_tuntas')->default(false);
                $table->integer('poin_didapat')->default(0);
                $table->dateTime('waktu_materi_selesai')->nullable();
                $table->dateTime('waktu_quiz_selesai')->nullable();
                $table->dateTime('waktu_tuntas')->nullable();
                $table->timestamps();

                $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
                $table->foreign('id_modul')->references('id_modul')->on('modul')->onDelete('cascade');
                $table->unique(['id_user', 'id_modul']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('progres_modul_siswa');
        Schema::dropIfExists('modul_soal_pilihan');
        Schema::dropIfExists('modul_soal');

        Schema::table('modul', function (Blueprint $table) {
            if (Schema::hasColumn('modul', 'poin_modul')) {
                $table->dropColumn('poin_modul');
            }
            if (Schema::hasColumn('modul', 'kkm_quiz')) {
                $table->dropColumn('kkm_quiz');
            }
        });
    }
};


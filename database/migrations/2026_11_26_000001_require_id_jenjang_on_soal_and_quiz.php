<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Wajibkan id_jenjang di tabel soal dan quiz.
 * Langkah: isi NULL dengan jenjang kuis atau default SMP (id=2), lalu ubah kolom NOT NULL.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. Isi quiz yang id_jenjang NULL → default SMP (2)
        DB::statement('
            UPDATE quiz
            SET id_jenjang = 2
            WHERE id_jenjang IS NULL
        ');

        // 2. Isi soal yang id_jenjang NULL → ikuti id_jenjang kuisnya, atau default SMP (2) jika dari Bank Soal
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('
                UPDATE soal
                SET id_jenjang = COALESCE(
                    (SELECT q.id_jenjang FROM quiz q WHERE q.id_quiz = soal.id_quiz),
                    2
                )
                WHERE id_jenjang IS NULL
            ');
        } else {
            DB::statement('
                UPDATE soal s
                LEFT JOIN quiz q ON s.id_quiz = q.id_quiz
                SET s.id_jenjang = COALESCE(q.id_jenjang, 2)
                WHERE s.id_jenjang IS NULL
            ');
        }

        // 3. Ubah kolom soal.id_jenjang → NOT NULL
        Schema::table('soal', function (Blueprint $table) {
            $table->unsignedInteger('id_jenjang')->nullable(false)->change();
        });

        // 4. Ubah kolom quiz.id_jenjang → NOT NULL
        Schema::table('quiz', function (Blueprint $table) {
            $table->unsignedInteger('id_jenjang')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->unsignedInteger('id_jenjang')->nullable()->change();
        });

        Schema::table('quiz', function (Blueprint $table) {
            $table->unsignedInteger('id_jenjang')->nullable()->change();
        });
    }
};

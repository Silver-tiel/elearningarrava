<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->unsignedInteger('id_quiz')->nullable()->change();

            if (!Schema::hasColumn('soal', 'id_mapel')) {
                $table->unsignedInteger('id_mapel')->nullable()->after('id_quiz');
            }

            if (!Schema::hasColumn('soal', 'parent_soal_id')) {
                $table->unsignedInteger('parent_soal_id')->nullable()->after('id_penulis');
            }
        });

        // Add foreign keys
        Schema::table('soal', function (Blueprint $table) {
            if (Schema::hasTable('mapel')) {
                $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->nullOnDelete();
            }
            $table->foreign('parent_soal_id')->references('id_soal')->on('soal')->nullOnDelete();
        });

        // Backfill id_mapel for existing questions that belong to a quiz
        if (Schema::hasTable('quiz')) {
            if (DB::getDriverName() === 'sqlite') {
                DB::statement("UPDATE soal SET id_mapel = (SELECT q.id_mapel FROM quiz q WHERE q.id_quiz = soal.id_quiz) WHERE id_mapel IS NULL AND id_quiz IS NOT NULL");
            } else {
                DB::statement("UPDATE soal s INNER JOIN quiz q ON s.id_quiz = q.id_quiz SET s.id_mapel = q.id_mapel WHERE s.id_mapel IS NULL");
            }
        }
    }

    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            if (Schema::hasColumn('soal', 'id_mapel')) {
                $table->dropForeign(['id_mapel']);
            }
            if (Schema::hasColumn('soal', 'parent_soal_id')) {
                $table->dropForeign(['parent_soal_id']);
            }
            $table->dropColumn(['id_mapel', 'parent_soal_id']);
        });
    }
};

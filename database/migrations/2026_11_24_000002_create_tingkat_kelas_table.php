<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tingkat_kelas')) {
            Schema::create('tingkat_kelas', function (Blueprint $table) {
                $table->increments('id_tingkat');
                $table->unsignedInteger('id_jenjang');
                $table->string('nama', 50);
                $table->unsignedTinyInteger('urutan')->default(1);
                $table->boolean('aktif')->default(true);
                $table->timestamps();

                $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('user') && !Schema::hasColumn('user', 'id_tingkat_kelas')) {
            Schema::table('user', function (Blueprint $table) {
                $table->unsignedInteger('id_tingkat_kelas')->nullable()->after('id_jenjang');
                $table->foreign('id_tingkat_kelas')->references('id_tingkat')->on('tingkat_kelas')->nullOnDelete();
            });
        }

        if (Schema::hasTable('quiz') && !Schema::hasColumn('quiz', 'id_tingkat_kelas')) {
            Schema::table('quiz', function (Blueprint $table) {
                $table->unsignedInteger('id_tingkat_kelas')->nullable()->after('id_jenjang');
                $table->foreign('id_tingkat_kelas')->references('id_tingkat')->on('tingkat_kelas')->nullOnDelete();
            });
        }

        if (Schema::hasTable('modul') && !Schema::hasColumn('modul', 'id_tingkat_kelas')) {
            Schema::table('modul', function (Blueprint $table) {
                $table->unsignedInteger('id_tingkat_kelas')->nullable()->after('id_jenjang');
                $table->foreign('id_tingkat_kelas')->references('id_tingkat')->on('tingkat_kelas')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('modul') && Schema::hasColumn('modul', 'id_tingkat_kelas')) {
            Schema::table('modul', function (Blueprint $table) {
                $table->dropForeign(['id_tingkat_kelas']);
                $table->dropColumn('id_tingkat_kelas');
            });
        }

        if (Schema::hasTable('quiz') && Schema::hasColumn('quiz', 'id_tingkat_kelas')) {
            Schema::table('quiz', function (Blueprint $table) {
                $table->dropForeign(['id_tingkat_kelas']);
                $table->dropColumn('id_tingkat_kelas');
            });
        }

        if (Schema::hasTable('user') && Schema::hasColumn('user', 'id_tingkat_kelas')) {
            Schema::table('user', function (Blueprint $table) {
                $table->dropForeign(['id_tingkat_kelas']);
                $table->dropColumn('id_tingkat_kelas');
            });
        }

        Schema::dropIfExists('tingkat_kelas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('quiz')) {
            Schema::table('quiz', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz', 'waktu_mulai')) {
                    $table->dateTime('waktu_mulai')->nullable()->after('waktu_kadaluarsa');
                }
                if (!Schema::hasColumn('quiz', 'acak_soal')) {
                    $table->boolean('acak_soal')->default(false)->after('opsi_preview');
                }
                if (!Schema::hasColumn('quiz', 'batas_percobaan')) {
                    $table->unsignedSmallInteger('batas_percobaan')->nullable()->after('acak_soal');
                }
                if (!Schema::hasColumn('quiz', 'tampilkan_hasil_ujian')) {
                    $table->boolean('tampilkan_hasil_ujian')->default(true)->after('batas_percobaan');
                }
            });
        }

        if (Schema::hasTable('soal')) {
            Schema::table('soal', function (Blueprint $table) {
                if (!Schema::hasColumn('soal', 'kategori_bank')) {
                    $table->string('kategori_bank', 20)->default('umum')->after('tingkat_soal');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('quiz')) {
            Schema::table('quiz', function (Blueprint $table) {
                $cols = array_filter(['waktu_mulai', 'acak_soal', 'batas_percobaan', 'tampilkan_hasil_ujian'], fn($c) => Schema::hasColumn('quiz', $c));
                if (!empty($cols)) {
                    $table->dropColumn($cols);
                }
            });
        }

        if (Schema::hasTable('soal')) {
            Schema::table('soal', function (Blueprint $table) {
                if (Schema::hasColumn('soal', 'kategori_bank')) {
                    $table->dropColumn('kategori_bank');
                }
            });
        }
    }
};

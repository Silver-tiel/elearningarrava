<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Batas tepat waktu harian (HH:MM). Scan setelah jam ini dicatat "terlambat".
            $table->time('jam_batas')->nullable()->after('berlaku_sampai');
        });

        Schema::table('sesi_presensi', function (Blueprint $table) {
            // "<id_kelas>:<tanggal>" untuk sesi yang dibuat otomatis. Unique = tidak mungkin ganda
            // walau dua orang membuka halaman Presensi bersamaan. Sesi lama/manual = null.
            $table->string('kunci_otomatis', 40)->nullable()->unique()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('sesi_presensi', function (Blueprint $table) {
            $table->dropUnique(['kunci_otomatis']);
            $table->dropColumn('kunci_otomatis');
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('jam_batas');
        });
    }
};

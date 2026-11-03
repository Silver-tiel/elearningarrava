<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Hari aktif, CSV angka ISO (1=Senin ... 7=Minggu). Null = setiap hari.
            $table->string('hari', 20)->nullable()->after('tahun_ajaran');
            // Masa berlaku kelas. Null = tanpa batas.
            $table->date('berlaku_dari')->nullable()->after('hari');
            $table->date('berlaku_sampai')->nullable()->after('berlaku_dari');
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn(['hari', 'berlaku_dari', 'berlaku_sampai']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('presensi') || Schema::hasColumn('presensi', 'nilai')) {
            return;
        }

        Schema::table('presensi', function (Blueprint $table) {
            $table->decimal('nilai', 5, 2)->nullable()->after('waktu_scan');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('presensi') || !Schema::hasColumn('presensi', 'nilai')) {
            return;
        }

        Schema::table('presensi', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });
    }
};

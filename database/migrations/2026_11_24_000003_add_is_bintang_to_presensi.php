<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('presensi') || Schema::hasColumn('presensi', 'is_bintang')) {
            return;
        }

        Schema::table('presensi', function (Blueprint $table) {
            $table->boolean('is_bintang')->default(false)->after('nilai');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('presensi') || !Schema::hasColumn('presensi', 'is_bintang')) {
            return;
        }

        Schema::table('presensi', function (Blueprint $table) {
            $table->dropColumn('is_bintang');
        });
    }
};

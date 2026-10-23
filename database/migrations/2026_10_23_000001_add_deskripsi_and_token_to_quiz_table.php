<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('judul');
            }
            if (!Schema::hasColumn('quiz', 'token')) {
                $table->string('token', 50)->nullable()->after('durasi_total_menit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quiz', function (Blueprint $table) {
            $colsToDrop = [];
            if (Schema::hasColumn('quiz', 'deskripsi')) {
                $colsToDrop[] = 'deskripsi';
            }
            if (Schema::hasColumn('quiz', 'token')) {
                $colsToDrop[] = 'token';
            }
            if (!empty($colsToDrop)) {
                $table->dropColumn($colsToDrop);
            }
        });
    }
};

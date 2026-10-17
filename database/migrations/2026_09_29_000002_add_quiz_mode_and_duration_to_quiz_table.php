<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz', 'mode_pengerjaan')) {
                $table->string('mode_pengerjaan')->default('wayground');
            }
            if (!Schema::hasColumn('quiz', 'durasi_total_menit')) {
                $table->unsignedSmallInteger('durasi_total_menit')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('quiz', function (Blueprint $table) {
            $colsToDrop = [];
            if (Schema::hasColumn('quiz', 'mode_pengerjaan')) {
                $colsToDrop[] = 'mode_pengerjaan';
            }
            if (Schema::hasColumn('quiz', 'durasi_total_menit')) {
                $colsToDrop[] = 'durasi_total_menit';
            }
            if (!empty($colsToDrop)) {
                $table->dropColumn($colsToDrop);
            }
        });
    }
};
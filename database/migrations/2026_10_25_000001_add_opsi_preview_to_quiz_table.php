<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz', 'opsi_preview')) {
                $table->string('opsi_preview', 20)->default('lengkap')->after('mode_pengerjaan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quiz', function (Blueprint $table) {
            if (Schema::hasColumn('quiz', 'opsi_preview')) {
                $table->dropColumn('opsi_preview');
            }
        });
    }
};

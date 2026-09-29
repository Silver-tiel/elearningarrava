<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            if (!Schema::hasColumn('soal', 'foto_soal')) {
                $table->string('foto_soal')->nullable()->after('jawaban_benar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            if (Schema::hasColumn('soal', 'foto_soal')) {
                $table->dropColumn('foto_soal');
            }
        });
    }
};

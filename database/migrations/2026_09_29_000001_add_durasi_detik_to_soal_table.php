<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->unsignedSmallInteger('durasi_detik')->default(20);
        });
    }

    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            $table->dropColumn('durasi_detik');
        });
    }
};
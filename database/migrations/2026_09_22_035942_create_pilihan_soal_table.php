<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pilihan_soal', function (Blueprint $table) {
            $table->increments('id_pilihan');
            $table->unsignedInteger('id_soal');
            $table->string('label', 1);        // A, B, C, D
            $table->text('teks_pilihan');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->index('id_soal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pilihan_soal');
    }
};

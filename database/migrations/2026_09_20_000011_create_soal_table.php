<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('soal', function (Blueprint $table) {
            $table->increments('id_soal');
            $table->unsignedInteger('id_quiz');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->unsignedInteger('id_jenis_soal')->nullable();
            $table->text('pertanyaan');
            $table->text('jawaban_benar');
            $table->timestamps();

            $table->foreign('id_quiz')->references('id_quiz')->on('quiz')->onDelete('cascade');
            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang');
            $table->foreign('id_jenis_soal')->references('id_jenis_soal')->on('jenis_soal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};

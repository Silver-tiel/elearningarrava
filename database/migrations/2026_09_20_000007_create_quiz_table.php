<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id_quiz');
            $table->string('judul');
            $table->unsignedInteger('id_tipequiz');
            $table->unsignedInteger('id_tingkatquiz');
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->dateTime('waktu_kadaluarsa')->nullable();
            $table->string('hasil_quiz')->nullable();
            $table->string('proggressQuiz')->nullable();
            $table->string('foto_quiz')->nullable();
            $table->timestamps();

            $table->foreign('id_tipequiz')->references('id_tipequiz')->on('tipequiz');
            $table->foreign('id_tingkatquiz')->references('id_tingkatquiz')->on('tingkatquiz');
            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};

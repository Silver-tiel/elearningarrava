<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasilquizmodul', function (Blueprint $table) {
            $table->increments('id_hasil');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_quiz');
            $table->integer('total_poin')->default(0);
            $table->integer('poin_didapat')->default(0);
            $table->dateTime('waktu_dapat');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_quiz')->references('id_quiz')->on('quiz')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasilquizmodul');
    }
};

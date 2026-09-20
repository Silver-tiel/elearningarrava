<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pencapaianuser', function (Blueprint $table) {
            $table->increments('id_pencapaian');
            $table->unsignedInteger('id_user');
            $table->string('nama');
            $table->dateTime('waktu_pencapaian');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pencapaianuser');
    }
};

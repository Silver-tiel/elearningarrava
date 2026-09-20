<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('id_tipeuser');
            $table->unsignedInteger('id_jenjang');
            $table->integer('total_poin')->default(0);
            $table->string('status_akun', 50)->nullable();
            $table->unsignedInteger('id_modul')->nullable();
            $table->string('foto_profil')->nullable();
            $table->timestamps();

            $table->foreign('id_tipeuser')->references('id_tipeUser')->on('tipeuser');
            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang');
            $table->foreign('id_modul')->references('id_modul')->on('modul')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};

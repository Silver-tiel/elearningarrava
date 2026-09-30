<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_modul', function (Blueprint $table) {
            $table->increments('id_catatan');
            $table->unsignedInteger('id_modul');
            $table->string('judul');
            $table->text('isi');
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();

            $table->foreign('id_modul')->references('id_modul')->on('modul')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_modul');
    }
};

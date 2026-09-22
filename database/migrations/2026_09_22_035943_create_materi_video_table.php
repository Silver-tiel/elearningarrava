<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materi_video', function (Blueprint $table) {
            $table->increments('id_materi');
            $table->unsignedInteger('id_modul');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_video')->nullable();
            $table->string('durasi', 20)->nullable();
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->enum('status', ['aktif', 'draft'])->default('aktif');
            $table->timestamps();

            $table->index('id_modul');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi_video');
    }
};

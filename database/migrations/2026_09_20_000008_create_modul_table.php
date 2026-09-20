<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modul', function (Blueprint $table) {
            $table->increments('id_modul');
            $table->string('judul_modul');
            $table->string('file_materi')->nullable();
            $table->string('tipe_file', 50)->nullable();
            $table->unsignedInteger('id_tipemodul');
            $table->unsignedInteger('id_jenjang');
            $table->unsignedInteger('id_quiz')->nullable();
            $table->string('progressModul')->nullable();
            $table->string('foto_modul')->nullable();
            $table->timestamps();

            $table->foreign('id_tipemodul')->references('id_tipemodul')->on('tipemodul');
            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang');
            $table->foreign('id_quiz')->references('id_quiz')->on('quiz')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modul');
    }
};

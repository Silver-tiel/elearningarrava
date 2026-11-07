<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mapel', function (Blueprint $table) {
            $table->increments('id_mapel');
            $table->string('nama_mapel', 100);
            $table->unsignedInteger('id_jenjang')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('icon', 100)->nullable();
            $table->timestamps();

            $table->foreign('id_jenjang')->references('id_jenjang')->on('jenjang')->nullOnDelete();
        });

        Schema::table('quiz', function (Blueprint $table) {
            $table->unsignedInteger('id_mapel')->nullable()->after('id_jenjang');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->nullOnDelete();
        });

        Schema::table('modul', function (Blueprint $table) {
            $table->unsignedInteger('id_mapel')->nullable()->after('id_jenjang');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('modul', function (Blueprint $table) {
            $table->dropForeign(['id_mapel']);
            $table->dropColumn('id_mapel');
        });

        Schema::table('quiz', function (Blueprint $table) {
            $table->dropForeign(['id_mapel']);
            $table->dropColumn('id_mapel');
        });

        Schema::dropIfExists('mapel');
    }
};


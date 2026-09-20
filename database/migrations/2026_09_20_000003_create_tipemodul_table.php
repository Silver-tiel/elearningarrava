<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipemodul', function (Blueprint $table) {
            $table->increments('id_tipemodul');
            $table->string('nama_tipe');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipemodul');
    }
};

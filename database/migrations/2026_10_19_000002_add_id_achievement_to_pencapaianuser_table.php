<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pencapaianuser', function (Blueprint $table) {
            $table->unsignedInteger('id_achievement')->nullable()->after('id_user');
            $table->foreign('id_achievement')
                ->references('id_achievement')
                ->on('achievements')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pencapaianuser', function (Blueprint $table) {
            $table->dropForeign(['id_achievement']);
            $table->dropColumn('id_achievement');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('user', 'hero_theme')) {
            Schema::table('user', function (Blueprint $table) {
                $table->string('hero_theme', 30)->default('samudra')->after('foto_profil');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('user', 'hero_theme')) {
            Schema::table('user', function (Blueprint $table) {
                $table->dropColumn('hero_theme');
            });
        }
    }
};


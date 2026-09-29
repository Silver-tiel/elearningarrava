<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasilquizmodul', function (Blueprint $table) {
            if (!Schema::hasColumn('hasilquizmodul', 'is_lulus')) {
                $table->boolean('is_lulus')->default(false)->after('poin_didapat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('hasilquizmodul', function (Blueprint $table) {
            if (Schema::hasColumn('hasilquizmodul', 'is_lulus')) {
                $table->dropColumn('is_lulus');
            }
        });
    }
};

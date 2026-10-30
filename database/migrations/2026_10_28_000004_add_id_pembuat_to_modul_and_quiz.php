<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['modul', 'quiz'] as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                // Null = konten lama tanpa pemilik (hanya admin yang boleh mengubah).
                $table->unsignedInteger('id_pembuat')->nullable();
                $table->foreign('id_pembuat')->references('id_user')->on('user')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        foreach (['modul', 'quiz'] as $tabel) {
            Schema::table($tabel, function (Blueprint $table) {
                $table->dropForeign(['id_pembuat']);
                $table->dropColumn('id_pembuat');
            });
        }
    }
};

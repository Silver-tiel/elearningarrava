<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            // Token acak UUID v4. Bukan data pribadi; dipetakan ke siswa lewat tabel ini.
            $table->char('qr_token', 36)->nullable()->unique()->after('foto_profil');
            $table->timestamp('qr_dibuat_pada')->nullable()->after('qr_token');
        });

        // Backfill: setiap siswa (id_tipeuser = 3) yang sudah ada mendapat satu token.
        DB::table('user')
            ->where('id_tipeuser', 3)
            ->whereNull('qr_token')
            ->orderBy('id_user')
            ->each(function ($row) {
                DB::table('user')->where('id_user', $row->id_user)->update([
                    'qr_token'       => (string) Str::uuid(),
                    'qr_dibuat_pada' => now(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropUnique(['qr_token']);
            $table->dropColumn(['qr_token', 'qr_dibuat_pada']);
        });
    }
};

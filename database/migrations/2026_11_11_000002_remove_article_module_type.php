<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('modul') && DB::table('modul')->where('id_tipemodul', 3)->exists()) {
            throw new RuntimeException('Cannot remove module type 3 while modules still reference it.');
        }

        DB::table('tipemodul')->where('id_tipemodul', 3)->delete();
    }

    public function down(): void
    {
        if (! DB::table('tipemodul')->where('id_tipemodul', 3)->exists()) {
            $now = now();

            DB::table('tipemodul')->insert([
                'id_tipemodul' => 3,
                'nama_tipe' => 'Artikel',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $activeMapelIds = [1, 2, 3, 4, 5, 11, 12, 13];

        if (!Schema::hasTable('mapel')) {
            return;
        }

        $unusedMapelIds = DB::table('mapel')
            ->whereNotIn('id_mapel', $activeMapelIds)
            ->pluck('id_mapel')
            ->toArray();

        if (empty($unusedMapelIds)) {
            return;
        }

        // 1. Bersihkan dungeon_sesi yang menggunakan mapel tidak aktif
        if (Schema::hasTable('dungeon_sesi')) {
            $sesiIds = DB::table('dungeon_sesi')
                ->whereIn('id_mapel', $unusedMapelIds)
                ->pluck('id')
                ->toArray();

            if (!empty($sesiIds)) {
                if (Schema::hasTable('dungeon_sesi_soal')) {
                    DB::table('dungeon_sesi_soal')->whereIn('id_sesi', $sesiIds)->delete();
                }
                DB::table('dungeon_sesi')->whereIn('id', $sesiIds)->delete();
            }
        }

        // 2. Set id_mapel = null pada quiz, modul, dan soal yang mereferensikan mapel tidak aktif
        if (Schema::hasTable('quiz') && Schema::hasColumn('quiz', 'id_mapel')) {
            DB::table('quiz')->whereIn('id_mapel', $unusedMapelIds)->update(['id_mapel' => null]);
        }

        if (Schema::hasTable('modul') && Schema::hasColumn('modul', 'id_mapel')) {
            DB::table('modul')->whereIn('id_mapel', $unusedMapelIds)->update(['id_mapel' => null]);
        }

        if (Schema::hasTable('soal') && Schema::hasColumn('soal', 'id_mapel')) {
            DB::table('soal')->whereIn('id_mapel', $unusedMapelIds)->update(['id_mapel' => null]);
        }

        // 3. Hapus data mapel tidak aktif
        DB::table('mapel')->whereIn('id_mapel', $unusedMapelIds)->delete();
    }

    public function down(): void
    {
        // Mapel yang dihapus tidak di-restore otomatis
    }
};

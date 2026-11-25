<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $activeMapelIds = [1, 2, 3, 4, 5, 11, 12, 13];

        DB::transaction(function () use ($activeMapelIds) {
            // 1. Bersihkan dungeon_sesi & dungeon_sesi_soal untuk mapel tidak aktif atau IPA/IPS di SMA (jenjang 3)
            if (Schema::hasTable('dungeon_sesi')) {
                $unusedSesiIds = DB::table('dungeon_sesi')
                    ->where(function ($q) use ($activeMapelIds) {
                        $q->whereNotIn('id_mapel', $activeMapelIds)
                            ->orWhere(function ($sma) {
                                $sma->where('id_jenjang', 3)
                                    ->whereIn('id_mapel', [4, 5]);
                            });
                    })
                    ->pluck('id')
                    ->toArray();

                if (!empty($unusedSesiIds)) {
                    if (Schema::hasTable('dungeon_sesi_soal')) {
                        DB::table('dungeon_sesi_soal')->whereIn('id_sesi', $unusedSesiIds)->delete();
                    }
                    DB::table('dungeon_sesi')->whereIn('id', $unusedSesiIds)->delete();
                }
            }

            // 2. Kumpulkan seluruh quiz (Dungeon & Reguler) yang mapelnya sudah dihapus (NULL / non-aktif)
            //    serta quiz IPA/IPS untuk jenjang SMA (3) karena SMA menggunakan Fisika, Kimia, Biologi.
            $unusedQuizIds = [];
            if (Schema::hasTable('quiz')) {
                $unusedQuizIds = DB::table('quiz')
                    ->where(function ($q) use ($activeMapelIds) {
                        $q->whereNull('id_mapel')
                            ->orWhereNotIn('id_mapel', $activeMapelIds)
                            ->orWhere('judul', 'like', '%Pendidikan Agama%')
                            ->orWhere('judul', 'like', '%Pendidikan Pancasila%')
                            ->orWhere('judul', 'like', '%PJOK%')
                            ->orWhere('judul', 'like', '%Sejarah Indonesia%')
                            ->orWhere(function ($sma) {
                                $sma->where('id_jenjang', 3)
                                    ->whereIn('id_mapel', [4, 5]);
                            });
                    })
                    ->pluck('id_quiz')
                    ->toArray();
            }

            // 3. Kumpulkan seluruh soal milik quiz yang dihapus + soal Bank Soal yatim (id_mapel NULL / tidak aktif / IPA-IPS SMA)
            $unusedSoalIds = [];
            if (Schema::hasTable('soal')) {
                $unusedSoalIds = DB::table('soal')
                    ->where(function ($q) use ($unusedQuizIds, $activeMapelIds) {
                        if (!empty($unusedQuizIds)) {
                            $q->whereIn('id_quiz', $unusedQuizIds);
                        }
                        $q->orWhere(function ($bank) use ($activeMapelIds) {
                            $bank->whereNull('id_quiz')
                                ->where(function ($sub) use ($activeMapelIds) {
                                    $sub->whereNull('id_mapel')
                                        ->orWhereNotIn('id_mapel', $activeMapelIds)
                                        ->orWhere(function ($sma) {
                                            $sma->where('id_jenjang', 3)
                                                ->whereIn('id_mapel', [4, 5]);
                                        });
                                });
                        });
                    })
                    ->pluck('id_soal')
                    ->toArray();
            }

            // 4. Hapus seluruh relasi anak dari soal tersebut secara eksplisit sebelum menghapus soal
            if (!empty($unusedSoalIds)) {
                foreach (['dungeon_sesi_soal', 'dungeon_riwayat_soal', 'dungeon_laporan_soal', 'pilihan_soal'] as $childTable) {
                    if (Schema::hasTable($childTable)) {
                        foreach (array_chunk($unusedSoalIds, 500) as $chunk) {
                            DB::table($childTable)->whereIn('id_soal', $chunk)->delete();
                        }
                    }
                }

                if (Schema::hasColumn('soal', 'parent_soal_id')) {
                    foreach (array_chunk($unusedSoalIds, 500) as $chunk) {
                        DB::table('soal')->whereIn('parent_soal_id', $chunk)->update(['parent_soal_id' => null]);
                    }
                }

                foreach (array_chunk($unusedSoalIds, 500) as $chunk) {
                    DB::table('soal')->whereIn('id_soal', $chunk)->delete();
                }
            }

            // 5. Hapus riwayat hasil quiz, putuskan referensi modul jika ada, lalu hapus quiz-nya
            if (!empty($unusedQuizIds)) {
                if (Schema::hasTable('hasilquizmodul')) {
                    foreach (array_chunk($unusedQuizIds, 500) as $chunk) {
                        DB::table('hasilquizmodul')->whereIn('id_quiz', $chunk)->delete();
                    }
                }

                if (Schema::hasTable('modul') && Schema::hasColumn('modul', 'id_quiz')) {
                    foreach (array_chunk($unusedQuizIds, 500) as $chunk) {
                        DB::table('modul')->whereIn('id_quiz', $chunk)->update(['id_quiz' => null]);
                    }
                }

                foreach (array_chunk($unusedQuizIds, 500) as $chunk) {
                    DB::table('quiz')->whereIn('id_quiz', $chunk)->delete();
                }
            }
        });
    }

    public function down(): void
    {
        // Data quiz, dungeon, dan soal yang dihapus tidak di-restore otomatis.
    }
};

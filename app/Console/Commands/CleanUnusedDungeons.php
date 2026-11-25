<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CleanUnusedDungeons extends Command
{
    protected $signature = 'app:clean-unused-dungeons';
    protected $description = 'Bersihkan Dungeon, Quiz, dan Mapel yang tidak digunakan (Agama, PPKn, PJOK, Sejarah, serta IPA/IPS di SMA)';

    public function handle(): int
    {
        $this->info('Memulai pembersihan data dungeon dan kuis tidak terpakai...');

        $activeMapelIds = [1, 2, 3, 4, 5, 11, 12, 13];
        $keywords = [
            '%Pendidikan Agama%',
            '%Pendidikan Pancasila%',
            '%PJOK%',
            '%Sejarah Indonesia%',
        ];

        DB::transaction(function () use ($activeMapelIds, $keywords) {
            // 1. Cari Quiz / Dungeon yang tidak aktif
            $quizQuery = DB::table('quiz')->where(function ($q) use ($activeMapelIds, $keywords) {
                $q->whereNull('id_mapel')
                    ->orWhereNotIn('id_mapel', $activeMapelIds)
                    ->orWhere(function ($sma) {
                        $sma->where('id_jenjang', 3)
                            ->whereIn('id_mapel', [4, 5]);
                    });

                foreach ($keywords as $kw) {
                    $q->orWhere('judul', 'like', $kw);
                }
            });

            $unusedQuizzes = $quizQuery->select('id_quiz', 'judul')->get();
            $unusedQuizIds = $unusedQuizzes->pluck('id_quiz')->toArray();

            $this->line("Ditemukan <comment>" . count($unusedQuizIds) . "</comment> kuis/dungeon tidak terpakai.");
            foreach ($unusedQuizzes as $uq) {
                $this->line(" - [ID {$uq->id_quiz}] {$uq->judul}");
            }

            // 2. Kumpulkan Soal terkait kuis tersebut atau bank soal dari mapel tidak aktif
            $soalQuery = DB::table('soal')->where(function ($q) use ($unusedQuizIds, $activeMapelIds, $keywords) {
                if (!empty($unusedQuizIds)) {
                    $q->whereIn('id_quiz', $unusedQuizIds);
                }
                $q->orWhere(function ($bank) use ($activeMapelIds, $keywords) {
                    $bank->whereNull('id_quiz')
                        ->where(function ($sub) use ($activeMapelIds, $keywords) {
                            $sub->whereNull('id_mapel')
                                ->orWhereNotIn('id_mapel', $activeMapelIds)
                                ->orWhere(function ($sma) {
                                    $sma->where('id_jenjang', 3)
                                        ->whereIn('id_mapel', [4, 5]);
                                });
                        });
                });
            });

            $unusedSoalIds = $soalQuery->pluck('id_soal')->toArray();
            $this->line("Ditemukan <comment>" . count($unusedSoalIds) . "</comment> butir soal terkait.");

            // 3. Bersihkan tabel anak soal
            if (!empty($unusedSoalIds)) {
                foreach (['dungeon_sesi_soal', 'dungeon_riwayat_soal', 'dungeon_laporan_soal', 'pilihan_soal'] as $table) {
                    if (Schema::hasTable($table)) {
                        foreach (array_chunk($unusedSoalIds, 500) as $chunk) {
                            DB::table($table)->whereIn('id_soal', $chunk)->delete();
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

            // 4. Bersihkan dungeon_sesi
            if (Schema::hasTable('dungeon_sesi')) {
                $sesiQuery = DB::table('dungeon_sesi')->where(function ($q) use ($activeMapelIds) {
                    $q->whereNotIn('id_mapel', $activeMapelIds)
                        ->orWhere(function ($sma) {
                            $sma->where('id_jenjang', 3)
                                ->whereIn('id_mapel', [4, 5]);
                        });
                });
                $sesiIds = $sesiQuery->pluck('id')->toArray();
                if (!empty($sesiIds)) {
                    if (Schema::hasTable('dungeon_sesi_soal')) {
                        DB::table('dungeon_sesi_soal')->whereIn('id_sesi', $sesiIds)->delete();
                    }
                    DB::table('dungeon_sesi')->whereIn('id', $sesiIds)->delete();
                }
            }

            // 5. Bersihkan hasilquizmodul dan referensi modul
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

            // 6. Bersihkan baris mapel jika masih ada di tabel mapel
            if (Schema::hasTable('mapel')) {
                $deletedMapel = DB::table('mapel')->whereNotIn('id_mapel', $activeMapelIds)->delete();
                if ($deletedMapel > 0) {
                    $this->line("Dihapus <comment>{$deletedMapel}</comment> mapel lama dari tabel mapel.");
                }
            }

            $this->info("Pembersihan selesai! Semua dungeon dan soal terkait telah dihapus.");
        });

        return Command::SUCCESS;
    }
}

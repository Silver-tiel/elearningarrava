<?php

namespace App\Console\Commands;

use App\Models\DungeonLaporanSoal;
use App\Models\DungeonSesi;
use App\Models\Mapel;
use App\Models\Soal;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class DungeonWeeklyReport extends Command
{
    protected $signature = 'dungeon:weekly-report';
    protected $description = 'Menghasilkan dan menampilkan laporan mingguan aktivitas Dungeon Soal.';

    public function handle(): int
    {
        $startOfWeek = Carbon::now()->subDays(7);

        $this->info('==================================================');
        $this->info('       LAPORAN MINGGUAN DUNGEON SOAL (7 HARI)     ');
        $this->info('==================================================');

        $totalSesi = DungeonSesi::where('mulai', '>=', $startOfWeek)->count();
        $totalSesiSelesai = DungeonSesi::where('mulai', '>=', $startOfWeek)->whereNotNull('selesai')->count();
        $totalPoin = DungeonSesi::where('mulai', '>=', $startOfWeek)->sum('poin_profil_didapat');
        $avgSkor = DungeonSesi::where('mulai', '>=', $startOfWeek)->avg('skor_dungeon') ?? 0;

        $this->line("Total Sesi Dimulai : {$totalSesi}");
        $this->line("Total Sesi Selesai : {$totalSesiSelesai}");
        $this->line("Rata-rata Skor     : " . number_format($avgSkor, 1));
        $this->line("Total Poin Profil  : " . number_format($totalPoin));
        $this->newLine();

        // Rekap per Mapel
        $this->info('--- Aktivitas Berdasarkan Mata Pelajaran ---');
        $mapelStats = DungeonSesi::join('mapel', 'dungeon_sesi.id_mapel', '=', 'mapel.id_mapel')
            ->where('dungeon_sesi.mulai', '>=', $startOfWeek)
            ->selectRaw('mapel.nama_mapel, COUNT(dungeon_sesi.id) as total_sesi, AVG(dungeon_sesi.skor_dungeon) as avg_skor, MAX(dungeon_sesi.lantai_tertinggi) as max_lantai')
            ->groupBy('mapel.id_mapel', 'mapel.nama_mapel')
            ->orderByDesc('total_sesi')
            ->get();

        $headersMapel = ['Mata Pelajaran', 'Total Sesi', 'Rata-rata Skor', 'Lantai Max'];
        $dataMapel = $mapelStats->map(fn($row) => [
            $row->nama_mapel,
            $row->total_sesi,
            number_format($row->avg_skor, 1),
            'Lt. ' . $row->max_lantai,
        ])->toArray();
        $this->table($headersMapel, $dataMapel);

        // Laporan Soal
        $this->newLine();
        $this->info('--- Soal Paling Sering Dilaporkan ---');
        $laporanStats = DungeonLaporanSoal::join('soal', 'dungeon_laporan_soal.id_soal', '=', 'soal.id_soal')
            ->where('dungeon_laporan_soal.created_at', '>=', $startOfWeek)
            ->selectRaw('soal.id_soal, soal.pertanyaan, soal.aktif, COUNT(dungeon_laporan_soal.id) as total_laporan')
            ->groupBy('soal.id_soal', 'soal.pertanyaan', 'soal.aktif')
            ->orderByDesc('total_laporan')
            ->take(5)
            ->get();

        $headersLapor = ['ID Soal', 'Pertanyaan', 'Status Aktif', 'Jumlah Laporan'];
        $dataLapor = $laporanStats->map(fn($row) => [
            $row->id_soal,
            \Illuminate\Support\Str::limit($row->pertanyaan, 40),
            $row->aktif ? 'Aktif' : 'Nonaktif',
            $row->total_laporan,
        ])->toArray();
        $this->table($headersLapor, $dataLapor);

        $this->info('==================================================');
        return SymfonyCommand::SUCCESS;
    }
}

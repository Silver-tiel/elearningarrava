<?php

namespace Tests\Feature;

use App\Models\DungeonPengaturan;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeQuiz;
use App\Services\DungeonService;
use Database\Seeders\DungeonSeeder;
use Database\Seeders\MapelSeeder;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DungeonSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_dungeon_seeder_generates_quizzes_settings_and_initial_bank(): void
    {
        $this->seed(MasterDataSeeder::class);
        $this->seed(MapelSeeder::class);
        $this->seed(DungeonSeeder::class);

        // 1. Verifikasi pengaturan terisi
        $this->assertEquals(3, (int) DungeonPengaturan::getNilai('nyawa_awal'));
        $this->assertEquals(2, (int) DungeonPengaturan::getNilai('toleransi_jaringan'));
        $this->assertEquals(30, (int) DungeonPengaturan::getNilai('syarat_total_soal_aktif'));
        $this->assertEquals(8, (int) DungeonPengaturan::getNilai('syarat_soal_per_tingkat'));

        // 2. Verifikasi 39 Kuis Dungeon terbuat (11 mapel umum x 3 jenjang = 33, + 6 SMA peminatan = 39)
        $dungeonQuizzes = Quiz::whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))->get();
        $this->assertCount(39, $dungeonQuizzes);

        // 3. Verifikasi Bank Soal Awal Matematika SD & IPA SD langsung terbuka (masing-masing 60 soal: 20 mudah, 20 sedang, 20 sulit)
        $service = app(DungeonService::class);
        $statusMatematikaSd = $service->cekStatusDungeon(1, 1);
        $this->assertTrue($statusMatematikaSd['terbuka']);
        $this->assertEquals(60, $statusMatematikaSd['total_soal']);
        $this->assertEquals(20, $statusMatematikaSd['mudah']);
        $this->assertEquals(20, $statusMatematikaSd['sedang']);
        $this->assertEquals(20, $statusMatematikaSd['sulit']);

        $statusIpaSd = $service->cekStatusDungeon(4, 1);
        $this->assertTrue($statusIpaSd['terbuka']);
        $this->assertEquals(60, $statusIpaSd['total_soal']);
        $this->assertEquals(20, $statusIpaSd['mudah']);
        $this->assertEquals(20, $statusIpaSd['sedang']);
        $this->assertEquals(20, $statusIpaSd['sulit']);

        // 4. Verifikasi SELURUH 39 Dungeon di semua jenjang (SD, SMP, SMA) kini TERBUKA dan siap dimainkan
        foreach ($dungeonQuizzes as $dq) {
            $status = $service->cekStatusDungeon((int) $dq->id_mapel, (int) $dq->id_jenjang);
            $this->assertTrue($status['terbuka'], "Dungeon mapel {$dq->id_mapel} jenjang {$dq->id_jenjang} harusnya terbuka.");
            $this->assertGreaterThanOrEqual(30, $status['total_soal']);
            $this->assertGreaterThanOrEqual(8, $status['mudah']);
            $this->assertGreaterThanOrEqual(8, $status['sedang']);
            $this->assertGreaterThanOrEqual(8, $status['sulit']);
        }

        // 5. Seeder idempoten jika dijalankan ulang
        $this->seed(DungeonSeeder::class);
        $dungeonQuizzesUlang = Quiz::whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))->get();
        $this->assertCount(39, $dungeonQuizzesUlang);
    }
}

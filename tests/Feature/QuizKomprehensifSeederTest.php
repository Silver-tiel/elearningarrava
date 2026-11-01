<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\PilihanSoal;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\QuizSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizKomprehensifSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_quiz_seeder_membuat_data_soal_dan_kuis_secara_lengkap_dan_beragam(): void
    {
        // Jalankan master data dan quiz seeder
        $this->seed(MasterDataSeeder::class);
        $this->seed(QuizSeeder::class);

        // 1. Verifikasi jumlah Quiz dibuat (9 Kuis total)
        $this->assertGreaterThanOrEqual(9, Quiz::count());

        // 2. Verifikasi cakupan Jenjang: SD (1), SMP (2), SMA (3)
        $this->assertTrue(Quiz::where('id_jenjang', 1)->exists(), 'Kuis untuk SD harus tersedia');
        $this->assertTrue(Quiz::where('id_jenjang', 2)->exists(), 'Kuis untuk SMP harus tersedia');
        $this->assertTrue(Quiz::where('id_jenjang', 3)->exists(), 'Kuis untuk SMA harus tersedia');

        // 3. Verifikasi cakupan Mode Pengerjaan: 'biasa' dan 'wayground'
        $quizBiasa = Quiz::where('mode_pengerjaan', 'biasa')->get();
        $quizWayground = Quiz::where('mode_pengerjaan', 'wayground')->get();

        $this->assertTrue($quizBiasa->isNotEmpty(), 'Harus ada kuis dengan mode biasa');
        $this->assertTrue($quizWayground->isNotEmpty(), 'Harus ada kuis dengan mode wayground');

        // Kuis mode biasa harus memiliki durasi_total_menit
        foreach ($quizBiasa as $qb) {
            $this->assertNotNull($qb->durasi_total_menit, "Kuis mode biasa '{$qb->judul}' harus memiliki durasi_total_menit");
            $this->assertGreaterThan(0, $qb->durasi_total_menit);
        }

        // 4. Verifikasi cakupan Tipe Kuis & Token
        $this->assertTrue(Quiz::where('id_tipequiz', 1)->exists(), 'Harus ada tipe quiz harian');
        $this->assertTrue(Quiz::where('id_tipequiz', 2)->exists(), 'Harus ada tipe quiz ulangan');
        $this->assertTrue(Quiz::whereNotNull('token')->exists(), 'Harus ada quiz dengan token akses');

        // 5. Verifikasi Bentuk Soal: Pilihan Ganda (1), Isian Singkat (2), Benar/Salah (3)
        $soalPG = Soal::where('id_jenis_soal', 1)->get();
        $soalIsian = Soal::where('id_jenis_soal', 2)->get();
        $soalBS = Soal::where('id_jenis_soal', 3)->get();

        $this->assertTrue($soalPG->isNotEmpty(), 'Harus ada soal jenis Pilihan Ganda');
        $this->assertTrue($soalIsian->isNotEmpty(), 'Harus ada soal jenis Isian Singkat');
        $this->assertTrue($soalBS->isNotEmpty(), 'Harus ada soal jenis Benar/Salah');

        // Verifikasi Pilihan Ganda: memiliki 4 pilihan, tepat 1 jawaban benar
        foreach ($soalPG as $spg) {
            $pilihan = $spg->pilihanSoal;
            $this->assertCount(4, $pilihan, "Soal PG ID {$spg->id_soal} harus punya 4 pilihan jawaban");
            $this->assertSame(1, $pilihan->where('is_correct', true)->count(), "Soal PG ID {$spg->id_soal} harus punya tepat 1 pilihan benar");
            $this->assertNotEmpty($spg->jawaban_benar, "Soal PG ID {$spg->id_soal} harus mencantumkan label jawaban benar");
        }

        // Verifikasi Benar / Salah: memiliki 2 pilihan (Benar & Salah), tepat 1 jawaban benar
        foreach ($soalBS as $sbs) {
            $pilihan = $sbs->pilihanSoal;
            $this->assertCount(2, $pilihan, "Soal Benar/Salah ID {$sbs->id_soal} harus punya 2 pilihan jawaban");
            $this->assertSame(1, $pilihan->where('is_correct', true)->count(), "Soal Benar/Salah ID {$sbs->id_soal} harus punya tepat 1 pilihan benar");
            $this->assertContains($sbs->jawaban_benar, ['A', 'B'], "Kunci Benar/Salah harus A atau B");
        }

        // Verifikasi Isian Singkat: TIDAK memiliki pilihan_soal, kunci ada di jawaban_benar
        foreach ($soalIsian as $sis) {
            $this->assertCount(0, $sis->pilihanSoal, "Soal Isian Singkat ID {$sis->id_soal} tidak boleh memiliki record di pilihan_soal");
            $this->assertNotEmpty($sis->jawaban_benar, "Soal Isian Singkat ID {$sis->id_soal} harus memiliki kunci jawaban teks");
        }

        // 6. Verifikasi Idempotensi: seeding dua kali tidak boleh error / menduplikasi aneh
        $this->seed(QuizSeeder::class);
        $this->assertCount(9, Quiz::all(), 'Jumlah kuis harus tetap 9 (idempotent)');
    }
}


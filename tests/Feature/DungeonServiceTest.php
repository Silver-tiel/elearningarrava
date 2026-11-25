<?php

namespace Tests\Feature;

use App\Models\DungeonLaporanSoal;
use App\Models\DungeonPengaturan;
use App\Models\DungeonRiwayatSoal;
use App\Models\DungeonSesi;
use App\Models\DungeonSesiSoal;
use App\Models\JenisSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeQuiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use App\Services\DungeonService;
use Carbon\Carbon;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DungeonServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DungeonService $service;
    protected User $admin;
    protected User $siswa;
    protected Jenjang $jenjangSd;
    protected Mapel $mapelMatematika;
    protected TipeQuiz $tipeDungeon;
    protected TingkatQuiz $tingkatMudah;
    protected JenisSoal $jenisPG;
    protected JenisSoal $jenisIsian;
    protected JenisSoal $jenisBS;
    protected Quiz $dungeonQuiz;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);

        $this->service = app(DungeonService::class);

        $this->tipeDungeon = TipeQuiz::firstOrCreate(['nama_tipe' => 'Dungeon']);
        $this->tingkatMudah = TingkatQuiz::first();
        $this->jenisPG = JenisSoal::where('id_jenis_soal', 1)->first() ?? JenisSoal::first();
        $this->jenisIsian = JenisSoal::where('id_jenis_soal', 2)->first() ?? JenisSoal::create(['nama_jenis' => 'Isian Singkat']);
        $this->jenisBS = JenisSoal::where('id_jenis_soal', 3)->first() ?? JenisSoal::create(['nama_jenis' => 'Benar / Salah']);

        $this->jenjangSd = Jenjang::where('id_jenjang', 1)->first() ?? Jenjang::create(['nama_tipe' => 'SD']);
        $this->mapelMatematika = Mapel::first() ?? Mapel::create(['nama_mapel' => 'Matematika', 'id_jenjang' => 1]);

        $this->admin = User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin-dungeon@example.com',
            'nisn' => 'ADM999',
            'password' => Hash::make('password'),
            'id_tipeuser' => 1,
            'status_akun' => 'Aktif',
        ]);

        $this->siswa = User::create([
            'nama' => 'Siswa Penguji',
            'email' => 'siswa-dungeon@example.com',
            'nisn' => 'SIS999',
            'password' => Hash::make('password'),
            'id_tipeuser' => 3,
            'id_jenjang' => 1,
            'status_akun' => 'Aktif',
            'total_poin' => 0,
        ]);

        // Buat Kuis Dungeon
        $this->dungeonQuiz = Quiz::create([
            'judul' => 'Dungeon Matematika SD',
            'deskripsi' => 'Dungeon Soal Matematika SD',
            'id_tipequiz' => $this->tipeDungeon->id_tipequiz,
            'id_tingkatquiz' => $this->tingkatMudah->id_tingkatquiz,
            'id_jenjang' => $this->jenjangSd->id_jenjang,
            'id_mapel' => $this->mapelMatematika->id_mapel,
            'id_pembuat' => $this->admin->id_user,
            'durasi_total_menit' => 0,
            'proggressQuiz' => 'Tersedia',
        ]);
    }

    /**
     * Helper membuat banyak soal dungeon
     */
    protected function buatKumpulanSoal(int $mudah = 10, int $sedang = 10, int $sulit = 10): void
    {
        $tingkatList = [
            'mudah' => $mudah,
            'sedang' => $sedang,
            'sulit' => $sulit,
        ];

        foreach ($tingkatList as $tingkat => $jumlah) {
            for ($i = 1; $i <= $jumlah; $i++) {
                $soal = Soal::create([
                    'id_quiz' => $this->dungeonQuiz->id_quiz,
                    'id_jenis_soal' => $this->jenisPG->id_jenis_soal,
                    'pertanyaan' => "Soal {$tingkat} nomor {$i}",
                    'tingkat_soal' => $tingkat,
                    'jawaban_benar' => 'A',
                    'id_penulis' => $this->admin->id_user,
                    'aktif' => true,
                    'poin' => 10,
                ]);

                // Buat 4 pilihan (A benar)
                for ($p = 0; $p < 4; $p++) {
                    PilihanSoal::create([
                        'id_soal' => $soal->id_soal,
                        'label' => chr(65 + $p),
                        'teks_pilihan' => "Pilihan {$tingkat} {$i} - " . chr(65 + $p),
                        'is_correct' => ($p === 0),
                        'tetap_di_bawah' => ($p === 3), // Pilihan D tetap di bawah
                    ]);
                }
            }
        }
    }

    public function test_cek_status_dungeon_returns_false_when_requirements_not_met(): void
    {
        // Hanya buat 5 soal mudah
        $this->buatKumpulanSoal(5, 0, 0);

        $status = $this->service->cekStatusDungeon($this->mapelMatematika->id_mapel, $this->jenjangSd->id_jenjang);

        $this->assertFalse($status['terbuka']);
        $this->assertEquals(5, $status['total_soal']);
        $this->assertEquals(5, $status['mudah']);
        $this->assertEquals(0, $status['sedang']);
        $this->assertEquals(0, $status['sulit']);
        $this->assertNotNull($status['alasan']);
    }

    public function test_cek_status_dungeon_returns_true_when_requirements_met(): void
    {
        // Standar: 10 mudah, 10 sedang, 10 sulit (total 30, min 8 per tingkat)
        $this->buatKumpulanSoal(10, 10, 10);

        $status = $this->service->cekStatusDungeon($this->mapelMatematika->id_mapel, $this->jenjangSd->id_jenjang);

        $this->assertTrue($status['terbuka']);
        $this->assertEquals(30, $status['total_soal']);
        $this->assertNull($status['alasan']);
    }

    public function test_mulai_sesi_throws_validation_exception_if_dungeon_not_open_unless_uji_coba(): void
    {
        $this->buatKumpulanSoal(2, 2, 2); // Kurang dari syarat

        $this->expectException(ValidationException::class);
        $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel, isUjiCoba: false);
    }

    public function test_mulai_sesi_uji_coba_allowed_even_if_dungeon_not_fully_open(): void
    {
        $this->buatKumpulanSoal(2, 2, 2);

        $result = $this->service->mulaiSesi($this->admin, $this->mapelMatematika->id_mapel, isUjiCoba: true, idJenjangOverride: 1);

        $this->assertInstanceOf(DungeonSesi::class, $result['sesi']);
        $this->assertTrue((bool) $result['sesi']->is_uji_coba);
        $this->assertEquals($this->admin->id_user, $result['sesi']->kunci_aktif);
    }

    public function test_mulai_sesi_creates_new_session_with_kunci_aktif_and_correct_ronde(): void
    {
        $this->buatKumpulanSoal(10, 10, 10);

        $res1 = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);
        $sesi1 = $res1['sesi'];

        $this->assertEquals(1, $sesi1->ronde_ke);
        $this->assertEquals(3, $sesi1->nyawa);
        $this->assertEquals(1, $sesi1->lantai_tertinggi);
        $this->assertEquals($this->siswa->id_user, $sesi1->kunci_aktif);
        $this->assertNotNull($res1['soal']);

        // Tutup sesi 1
        $this->service->tutupSesi($sesi1, 'nyawa_habis');

        // Buka sesi 2
        $res2 = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);
        $sesi2 = $res2['sesi'];

        $this->assertEquals(2, $sesi2->ronde_ke);
        $this->assertEquals($this->siswa->id_user, $sesi2->kunci_aktif);
    }

    public function test_mulai_sesi_resumes_active_session_if_same_mapel_and_has_active_question(): void
    {
        $this->buatKumpulanSoal(10, 10, 10);

        $res1 = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);
        $sesi1 = $res1['sesi'];

        // Panggil mulaiSesi lagi untuk pemain yang sama & mapel sama
        $res2 = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);

        $this->assertTrue($res2['is_resume']);
        $this->assertEquals($sesi1->id, $res2['sesi']->id);
        $this->assertEquals($res1['soal']['id_soal'], $res2['soal']['id_soal']);
    }

    public function test_siapkan_soal_hides_correct_answers_and_preserves_tetap_di_bawah(): void
    {
        $this->buatKumpulanSoal(10, 10, 10);

        $res = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);
        $soalPayload = $res['soal'];

        $this->assertArrayNotHasKey('is_correct', $soalPayload);
        $this->assertArrayNotHasKey('jawaban_benar', $soalPayload);

        $pilihan = $soalPayload['pilihan'];
        $this->assertCount(4, $pilihan);

        // Pilihan terakhir harus pilihan yang tetap_di_bawah = true
        $pilihanTerakhir = end($pilihan);
        $this->assertTrue($pilihanTerakhir['tetap_di_bawah']);

        // Tiap pilihan tidak boleh ada is_correct
        foreach ($pilihan as $p) {
            $this->assertArrayNotHasKey('is_correct', $p);
        }

        // Dungeon riwayat soal harus di-upsert dengan times_seen = 1
        $riwayat = DungeonRiwayatSoal::where('id_user', $this->siswa->id_user)
            ->where('id_soal', $soalPayload['id_soal'])
            ->first();
        $this->assertNotNull($riwayat);
        $this->assertEquals(1, $riwayat->times_seen);
        $this->assertEquals(1, $riwayat->ronde_terakhir);
    }

    public function test_siapkan_soal_maintains_true_false_choice_order(): void
    {
        $soalBS = Soal::create([
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenis_soal' => $this->jenisBS->id_jenis_soal,
            'pertanyaan' => 'Matahari terbit dari timur.',
            'tingkat_soal' => 'mudah',
            'jawaban_benar' => 'Benar',
            'aktif' => true,
        ]);

        $pA = PilihanSoal::create([
            'id_soal' => $soalBS->id_soal,
            'label' => 'A',
            'teks_pilihan' => 'Benar',
            'is_correct' => true,
        ]);

        $pB = PilihanSoal::create([
            'id_soal' => $soalBS->id_soal,
            'label' => 'B',
            'teks_pilihan' => 'Salah',
            'is_correct' => false,
        ]);

        $sesi = DungeonSesi::create([
            'id_user' => $this->siswa->id_user,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapelMatematika->id_mapel,
            'ronde_ke' => 1,
            'mulai' => now(),
            'nyawa' => 3,
            'lantai_tertinggi' => 1,
        ]);

        $payload = $this->service->siapkanSoalUntukPemain($sesi, $soalBS);

        $this->assertEquals('Benar', $payload['pilihan'][0]['teks_pilihan']);
        $this->assertEquals('Salah', $payload['pilihan'][1]['teks_pilihan']);
    }

    public function test_jawab_soal_correct_answer_updates_score_and_multiplier(): void
    {
        $this->buatKumpulanSoal(10, 10, 10);

        $res = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);
        $sesi = $res['sesi'];
        $soal = $res['soal'];

        // Cari pilihan yang is_correct = true
        $pilihanBenar = PilihanSoal::where('id_soal', $soal['id_soal'])->where('is_correct', true)->first();

        $hasil = $this->service->jawabSoal($sesi, $soal['id_soal'], $pilihanBenar->id_pilihan);

        $this->assertTrue($hasil['is_benar']);
        $this->assertFalse($hasil['is_timeout']);
        $this->assertGreaterThan(0, $hasil['poin_didapat']);
        $this->assertEquals(3, $hasil['status_sesi']['nyawa']);
        $this->assertEquals(1, $hasil['status_sesi']['jumlah_benar']);

        // Riwayat times_correct harus bertambah 1
        $riwayat = DungeonRiwayatSoal::where('id_user', $this->siswa->id_user)
            ->where('id_soal', $soal['id_soal'])
            ->first();
        $this->assertEquals(1, $riwayat->times_correct);
    }

    public function test_jawab_soal_short_answer_with_normalization(): void
    {
        $soalIsian = Soal::create([
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenis_soal' => $this->jenisIsian->id_jenis_soal,
            'pertanyaan' => 'Ibu kota Indonesia?',
            'jawaban_benar' => 'Nusantara',
            'tingkat_soal' => 'sedang',
            'aktif' => true,
        ]);

        $sesi = DungeonSesi::create([
            'id_user' => $this->siswa->id_user,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapelMatematika->id_mapel,
            'ronde_ke' => 1,
            'mulai' => now(),
            'nyawa' => 3,
            'lantai_tertinggi' => 1,
        ]);

        $this->service->siapkanSoalUntukPemain($sesi, $soalIsian);

        // Jawaban user dengan huruf besar, spasi berlebih, dan tanda seru: "   NuSanTaRa!  "
        $hasil = $this->service->jawabSoal($sesi, $soalIsian->id_soal, '   NuSanTaRa!  ');

        $this->assertTrue($hasil['is_benar']);
        $this->assertEquals(20, $hasil['poin_didapat']); // Poin dasar sedang = 20 (multiplier 1.0)
    }

    public function test_jawab_soal_deducts_heart_on_incorrect_answer(): void
    {
        $this->buatKumpulanSoal(10, 10, 10);

        $res = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);
        $sesi = $res['sesi'];
        $soal = $res['soal'];

        // Cari pilihan yang salah
        $pilihanSalah = PilihanSoal::where('id_soal', $soal['id_soal'])->where('is_correct', false)->first();

        $hasil = $this->service->jawabSoal($sesi, $soal['id_soal'], $pilihanSalah->id_pilihan);

        $this->assertFalse($hasil['is_benar']);
        $this->assertEquals(0, $hasil['poin_didapat']);
        $this->assertEquals(2, $hasil['status_sesi']['nyawa']); // Nyawa berkurang dari 3 -> 2
        $this->assertEquals(1, $hasil['status_sesi']['jumlah_salah']);
    }

    public function test_jawab_soal_timeout_treated_as_wrong(): void
    {
        $this->buatKumpulanSoal(10, 10, 10);

        $res = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);
        $sesi = $res['sesi'];
        $soal = $res['soal'];

        // Manipulasi batas waktu menjadi 10 detik yang lalu (melebihi toleransi 2 detik)
        DungeonSesiSoal::where('id_sesi', $sesi->id)
            ->where('id_soal', $soal['id_soal'])
            ->update([
                'batas_waktu' => now()->subSeconds(10),
            ]);

        $pilihanBenar = PilihanSoal::where('id_soal', $soal['id_soal'])->where('is_correct', true)->first();

        $hasil = $this->service->jawabSoal($sesi, $soal['id_soal'], $pilihanBenar->id_pilihan);

        $this->assertFalse($hasil['is_benar']);
        $this->assertTrue($hasil['is_timeout']);
        $this->assertEquals(2, $hasil['status_sesi']['nyawa']);
    }

    public function test_jawab_soal_ends_session_when_hearts_reach_zero(): void
    {
        $this->buatKumpulanSoal(10, 10, 10);

        $res = $this->service->mulaiSesi($this->siswa, $this->mapelMatematika->id_mapel);
        $sesi = $res['sesi'];

        // Set nyawa tinggal 1
        $sesi->nyawa = 1;
        $sesi->save();

        $soal = $res['soal'];
        $pilihanSalah = PilihanSoal::where('id_soal', $soal['id_soal'])->where('is_correct', false)->first();

        $hasil = $this->service->jawabSoal($sesi, $soal['id_soal'], $pilihanSalah->id_pilihan);

        $this->assertFalse($hasil['is_benar']);
        $this->assertEquals(0, $hasil['status_sesi']['nyawa']);
        $this->assertTrue($hasil['status_sesi']['selesai']);
        $this->assertEquals('nyawa_habis', $hasil['status_sesi']['alasan_selesai']);

        // Pastikan kunci_aktif sesi sekarang null
        $sesiRefreshed = DungeonSesi::find($sesi->id);
        $this->assertNull($sesiRefreshed->kunci_aktif);
        $this->assertNotNull($sesiRefreshed->selesai);
    }

    public function test_multiplier_and_floor_progression(): void
    {
        // 0-4 benar = 1.0 (Lantai 1)
        $this->assertEquals(1.0, $this->service->hitungMultiplier(0));
        $this->assertEquals(1.0, $this->service->hitungMultiplier(4));

        // 5-9 benar = 1.25 (Lantai 2)
        $this->assertEquals(1.25, $this->service->hitungMultiplier(5));
        $this->assertEquals(1.25, $this->service->hitungMultiplier(9));

        // 10-14 benar = 1.50 (Lantai 3)
        $this->assertEquals(1.50, $this->service->hitungMultiplier(10));

        // 40 benar = capped at 3.0
        $this->assertEquals(3.0, $this->service->hitungMultiplier(40));
    }

    public function test_tutup_sesi_is_idempotent_and_awards_profile_points(): void
    {
        $sesi = DungeonSesi::create([
            'id_user' => $this->siswa->id_user,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapelMatematika->id_mapel,
            'ronde_ke' => 1,
            'mulai' => now(),
            'nyawa' => 1,
            'lantai_tertinggi' => 2,
            'skor_dungeon' => 300,
            'jumlah_benar' => 5,
            'jumlah_salah' => 1,
            'kunci_aktif' => $this->siswa->id_user,
        ]);

        $this->assertEquals(0, $this->siswa->total_poin);

        // Tutup sesi pertama kali
        $sesiClosed = $this->service->tutupSesi($sesi, 'keluar');

        $this->assertNotNull($sesiClosed->selesai);
        $this->assertNull($sesiClosed->kunci_aktif);
        $this->assertTrue((bool) $sesiClosed->poin_sudah_diberikan);

        // Skor 300 * 0.05 = 15. Rekor baru di mapel ini: +10. Total: 25 poin.
        $this->assertEquals(25, $sesiClosed->poin_profil_didapat);

        $this->siswa->refresh();
        $this->assertEquals(25, $this->siswa->total_poin);

        // Panggilan kedua (idempoten) tidak boleh menambah poin lagi
        $this->service->tutupSesi($sesiClosed, 'keluar');
        $this->siswa->refresh();
        $this->assertEquals(25, $this->siswa->total_poin);
    }

    public function test_tutup_sesi_with_tuntas_awards_completion_bonus(): void
    {
        $sesi = DungeonSesi::create([
            'id_user' => $this->siswa->id_user,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapelMatematika->id_mapel,
            'ronde_ke' => 1,
            'mulai' => now(),
            'nyawa' => 3,
            'lantai_tertinggi' => 5,
            'skor_dungeon' => 500,
            'jumlah_benar' => 20,
            'jumlah_salah' => 0,
            'kunci_aktif' => $this->siswa->id_user,
        ]);

        // Skor 500 * 0.05 = 25 dasar.
        // Tuntas bonus +20% dari dasar = +5 -> dasar jadi 30.
        // Rekor baru di mapel ini: +10 -> total 40 poin.
        $sesiClosed = $this->service->tutupSesi($sesi, 'tuntas');

        $this->assertEquals(40, $sesiClosed->poin_profil_didapat);
        $this->siswa->refresh();
        $this->assertEquals(40, $this->siswa->total_poin);
    }

    public function test_tutup_sesi_no_points_if_under_five_questions(): void
    {
        $sesi = DungeonSesi::create([
            'id_user' => $this->siswa->id_user,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapelMatematika->id_mapel,
            'ronde_ke' => 1,
            'mulai' => now(),
            'nyawa' => 1,
            'lantai_tertinggi' => 1,
            'skor_dungeon' => 30,
            'jumlah_benar' => 3,
            'jumlah_salah' => 0, // Total baru 3 soal (< 5)
            'kunci_aktif' => $this->siswa->id_user,
        ]);

        $sesiClosed = $this->service->tutupSesi($sesi, 'keluar');

        $this->assertEquals(0, $sesiClosed->poin_profil_didapat);
        $this->siswa->refresh();
        $this->assertEquals(0, $this->siswa->total_poin);
    }

    public function test_laporkan_soal_auto_deactivates_when_threshold_reached(): void
    {
        $soal = Soal::create([
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenis_soal' => $this->jenisPG->id_jenis_soal,
            'pertanyaan' => 'Soal dengan kesalahan cetak',
            'tingkat_soal' => 'mudah',
            'jawaban_benar' => 'A',
            'aktif' => true,
        ]);

        $u1 = User::create(['nama' => 'User 1', 'email' => 'u1@test.com', 'nisn' => 'U01', 'password' => Hash::make('password'), 'id_tipeuser' => 3, 'id_jenjang' => 1]);
        $u2 = User::create(['nama' => 'User 2', 'email' => 'u2@test.com', 'nisn' => 'U02', 'password' => Hash::make('password'), 'id_tipeuser' => 3, 'id_jenjang' => 1]);
        $u3 = User::create(['nama' => 'User 3', 'email' => 'u3@test.com', 'nisn' => 'U03', 'password' => Hash::make('password'), 'id_tipeuser' => 3, 'id_jenjang' => 1]);

        $r1 = $this->service->laporkanSoal($soal->id_soal, $u1, 'Kunci jawaban salah');
        $this->assertFalse($r1['dinonaktifkan']);
        $this->assertTrue((bool) $soal->fresh()->aktif);

        $r2 = $this->service->laporkanSoal($soal->id_soal, $u2, 'Typo fatal');
        $this->assertFalse($r2['dinonaktifkan']);
        $this->assertTrue((bool) $soal->fresh()->aktif);

        // Laporan ke-3 dari user berbeda mencapai ambang batas 3
        $r3 = $this->service->laporkanSoal($soal->id_soal, $u3, 'Pilihan ganda ambigu');
        $this->assertTrue($r3['dinonaktifkan']);
        $this->assertFalse((bool) $soal->fresh()->aktif);
        $this->assertNotNull($soal->fresh()->nonaktif_alasan);
    }

    public function test_auto_close_all_stale_sessions(): void
    {
        // Buat sesi basi: soal aktif dengan batas waktu 5 menit lalu
        $soal = Soal::create([
            'id_quiz' => $this->dungeonQuiz->id_quiz,
            'id_jenis_soal' => $this->jenisPG->id_jenis_soal,
            'pertanyaan' => 'Soal untuk sesi basi',
            'tingkat_soal' => 'mudah',
            'jawaban_benar' => 'A',
            'aktif' => true,
        ]);

        $sesiBasi = DungeonSesi::create([
            'id_user' => $this->siswa->id_user,
            'id_jenjang' => 1,
            'id_mapel' => $this->mapelMatematika->id_mapel,
            'ronde_ke' => 1,
            'mulai' => now()->subMinutes(10),
            'nyawa' => 3,
            'kunci_aktif' => $this->siswa->id_user,
        ]);

        DungeonSesiSoal::create([
            'id_sesi' => $sesiBasi->id,
            'id_soal' => $soal->id_soal,
            'urutan' => 1,
            'waktu_tampil' => now()->subMinutes(5),
            'batas_waktu' => now()->subMinutes(4), // Melebihi toleransi + 30s
        ]);

        $closedCount = $this->service->autoCloseAllStaleSessions();

        $this->assertEquals(1, $closedCount);
        $sesiBasi->refresh();
        $this->assertNotNull($sesiBasi->selesai);
        $this->assertEquals('timeout', $sesiBasi->alasan_selesai);
        $this->assertNull($sesiBasi->kunci_aktif);
    }
}

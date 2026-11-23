<?php

namespace Database\Seeders;

use App\Models\DungeonPengaturan;
use App\Models\JenisSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeQuiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DungeonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Pengaturan Bawaan Dungeon
        $pengaturanAwal = [
            'nyawa_awal' => 3,
            'toleransi_jaringan' => 2,
            'rasio_poin_profil' => 0.05,
            'min_soal_poin_profil' => 5,
            'poin_minimal_ronde' => 5,
            'maks_poin_profil_ronde' => 100,
            'bonus_rekor_pribadi' => 10,
            'bonus_dungeon_tuntas_persen' => 0.20,
            'syarat_total_soal_aktif' => 30,
            'syarat_soal_per_tingkat' => 8,
            'ambang_soal_dinonaktifkan' => 3,
            'poin_dasar_mudah' => 10,
            'poin_dasar_sedang' => 20,
            'poin_dasar_sulit' => 30,
            'waktu_mudah' => 20,
            'waktu_sedang' => 30,
            'waktu_sulit' => 60,
        ];

        foreach ($pengaturanAwal as $kunci => $nilai) {
            DungeonPengaturan::setNilai($kunci, $nilai);
        }

        // 2. Pastikan TipeQuiz "Dungeon" ada
        $tipeDungeon = TipeQuiz::firstOrCreate(['nama_tipe' => 'Dungeon']);
        $tingkatUmum = TingkatQuiz::first() ?? TingkatQuiz::create(['nama_tingkat' => 'Semua Tingkat']);

        // 3. Cari / Buat Akun Sistem/Admin sebagai pemilik
        $admin = User::where('id_tipeuser', 1)->first();
        if (!$admin) {
            $admin = User::create([
                'nama' => 'Sistem Dungeon',
                'email' => 'dungeon-system@arrava.id',
                'nisn' => 'SYS999999',
                'password' => Hash::make('secret_dungeon_system'),
                'id_tipeuser' => 1,
                'status_akun' => 'Aktif',
            ]);
        }

        // 4. Pastikan jenjang ada (SD=1, SMP=2, SMA=3)
        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        if ($jenjangList->isEmpty()) {
            $jenjangList = collect([
                Jenjang::create(['id_jenjang' => 1, 'nama_tipe' => 'SD']),
                Jenjang::create(['id_jenjang' => 2, 'nama_tipe' => 'SMP']),
                Jenjang::create(['id_jenjang' => 3, 'nama_tipe' => 'SMA']),
            ]);
        }

        $allMapels = Mapel::orderBy('id_mapel')->get();

        $dungeonQuizzesCreated = 0;

        foreach ($allMapels as $mapel) {
            // Tentukan target jenjang:
            // Jika id_jenjang = null -> berlaku untuk SD(1), SMP(2), SMA(3)
            // Jika id_jenjang diisi -> hanya untuk jenjang tersebut (misal peminatan SMA = 3)
            $targetJenjangIds = $mapel->id_jenjang
                ? [(int) $mapel->id_jenjang]
                : $jenjangList->pluck('id_jenjang')->toArray();

            foreach ($targetJenjangIds as $jId) {
                $jenjangObj = $jenjangList->firstWhere('id_jenjang', $jId);
                $namaJenjang = $jenjangObj ? ($jenjangObj->nama_tipe ?? $jenjangObj->nama_jenjang ?? "Jenjang {$jId}") : "Jenjang {$jId}";

                $quiz = Quiz::firstOrCreate(
                    [
                        'id_mapel' => $mapel->id_mapel,
                        'id_jenjang' => $jId,
                        'id_tipequiz' => $tipeDungeon->id_tipequiz,
                    ],
                    [
                        'judul' => "Dungeon {$mapel->nama_mapel} ({$namaJenjang})",
                        'deskripsi' => "Dungeon Soal tanpa batas untuk mata pelajaran {$mapel->nama_mapel} jenjang {$namaJenjang}.",
                        'id_tingkatquiz' => $tingkatUmum->id_tingkatquiz,
                        'id_pembuat' => $admin->id_user,
                        'durasi_total_menit' => 0,
                        'proggressQuiz' => 'Tersedia',
                    ]
                );

                $dungeonQuizzesCreated++;
            }
        }

        // 5. Inisialisasi Bank Soal Awal 2X lebih banyak (60 soal per mapel: 20 mudah, 20 sedang, 20 sulit)
        // Disediakan untuk Matematika SD (id_mapel=1) dan IPA SD (id_mapel=4) agar langsung terbuka & siap dicoba.
        $this->seedSampleQuestions($admin->id_user);

        // 6. Inisialisasi Bank Soal untuk SEMUA Mapel & Jenjang Lainnya (SD, SMP, SMA)
        // Memastikan seluruh 39 dungeon memiliki minimal 30 soal aktif (10 Mudah, 10 Sedang, 10 Sulit)
        // sehingga seluruh dungeon di semua jenjang langsung terbuka dan siap digunakan.
        $this->seedAllDungeonQuestions($admin->id_user);

        // 7. Sinkronisasi soal dari kuis biasa jika ada di database
        $this->importFromRegularQuizzes($admin->id_user);
    }

    /**
     * Seed bank soal untuk seluruh jenjang (SD, SMP, SMA) sehingga seluruh 39 dungeon
     * memenuhi syarat minimal (>= 30 soal aktif, >= 8 mudah, >= 8 sedang, >= 8 sulit).
     */
    protected function seedAllDungeonQuestions(int $idAdmin): void
    {
        require_once __DIR__ . '/dungeon/DungeonQuestionDatasetSd.php';
        require_once __DIR__ . '/dungeon/DungeonQuestionDatasetSmp.php';
        require_once __DIR__ . '/dungeon/DungeonQuestionDatasetSma.php';

        $jenisPG = JenisSoal::where('id_jenis_soal', 1)->first() ?? JenisSoal::first();
        $jenisBS = JenisSoal::where('id_jenis_soal', 3)->first();

        // 1. SD (Mapel selain Matematika dan IPA yang sudah di-seed di atas)
        $soalSd = \Database\Seeders\Dungeon\DungeonQuestionDatasetSd::getQuestionsByMapel();
        foreach ($soalSd as $idMapel => $listSoal) {
            $quiz = Quiz::where('id_mapel', $idMapel)
                ->where('id_jenjang', 1)
                ->whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
                ->first();
            if ($quiz) {
                $this->seedSoalList($quiz->id_quiz, 1, $idAdmin, $listSoal, $jenisPG, $jenisBS);
            }
        }

        // 2. SMP (11 Mapel)
        $soalSmp = \Database\Seeders\Dungeon\DungeonQuestionDatasetSmp::getQuestionsByMapel();
        foreach ($soalSmp as $idMapel => $listSoal) {
            $quiz = Quiz::where('id_mapel', $idMapel)
                ->where('id_jenjang', 2)
                ->whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
                ->first();
            if ($quiz) {
                $this->seedSoalList($quiz->id_quiz, 2, $idAdmin, $listSoal, $jenisPG, $jenisBS);
            }
        }

        // 3. SMA (17 Mapel: 11 Umum + 6 Peminatan)
        $soalSma = \Database\Seeders\Dungeon\DungeonQuestionDatasetSma::getQuestionsByMapel();
        foreach ($soalSma as $idMapel => $listSoal) {
            $quiz = Quiz::where('id_mapel', $idMapel)
                ->where('id_jenjang', 3)
                ->whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
                ->first();
            if ($quiz) {
                $this->seedSoalList($quiz->id_quiz, 3, $idAdmin, $listSoal, $jenisPG, $jenisBS);
            }
        }
    }

    /**
     * Sinkronisasi soal dari kuis biasa jika tersedia di database.
     */
    protected function importFromRegularQuizzes(int $idAdmin): void
    {
        $regularQuizzes = Quiz::bukanDungeon()
            ->with(['soal.pilihanSoal', 'tingkatQuiz'])
            ->whereNotNull('id_mapel')
            ->get();

        foreach ($regularQuizzes as $regQuiz) {
            $targetJenjang = $regQuiz->id_jenjang ? [(int) $regQuiz->id_jenjang] : [1, 2, 3];
            foreach ($targetJenjang as $jId) {
                $dungeonQuiz = Quiz::where('id_mapel', $regQuiz->id_mapel)
                    ->where('id_jenjang', $jId)
                    ->whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
                    ->first();

                if (!$dungeonQuiz) {
                    continue;
                }

                foreach ($regQuiz->soal as $soalAsal) {
                    $pertanyaan = trim((string) $soalAsal->pertanyaan);
                    if ($pertanyaan === '') {
                        continue;
                    }

                    if (Soal::where('id_quiz', $dungeonQuiz->id_quiz)->where('pertanyaan', $pertanyaan)->exists()) {
                        continue;
                    }

                    $tingkat = match ((int) ($regQuiz->id_tingkatquiz ?? 1)) {
                        1 => 'mudah',
                        3 => 'sulit',
                        default => 'sedang',
                    };
                    if ((int) $soalAsal->id_jenis_soal === 3) {
                        $tingkat = 'mudah';
                    }

                    $newSoal = Soal::create([
                        'id_quiz' => $dungeonQuiz->id_quiz,
                        'id_jenjang' => $jId,
                        'id_jenis_soal' => $soalAsal->id_jenis_soal,
                        'pertanyaan' => $pertanyaan,
                        'tingkat_soal' => $tingkat,
                        'jawaban_benar' => $soalAsal->jawaban_benar,
                        'id_penulis' => $idAdmin,
                        'aktif' => true,
                        'poin' => 10,
                        'durasi_detik' => $soalAsal->durasi_detik ?: 20,
                    ]);

                    foreach ($soalAsal->pilihanSoal as $pil) {
                        PilihanSoal::create([
                            'id_soal' => $newSoal->id_soal,
                            'label' => $pil->label,
                            'teks_pilihan' => $pil->teks_pilihan,
                            'is_correct' => (bool) $pil->is_correct,
                            'tetap_di_bawah' => (bool) ($pil->tetap_di_bawah ?? false),
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Seed soal awal berkualitas 2X lebih banyak (60 soal per mapel: 20 mudah, 20 sedang, 20 sulit)
     * sehingga langsung bisa dimainkan dan diuji tanpa cepat kehabisan bank soal.
     */
    protected function seedSampleQuestions(int $idAdmin): void
    {
        $jenisPG = JenisSoal::where('id_jenis_soal', 1)->first() ?? JenisSoal::first();
        $jenisBS = JenisSoal::where('id_jenis_soal', 3)->first();

        // --- 1. MATEMATIKA SD (id_mapel=1, id_jenjang=1) ---
        $dungeonMatematika = Quiz::where('id_mapel', 1)
            ->where('id_jenjang', 1)
            ->whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
            ->first();

        if ($dungeonMatematika) {
            $this->seedSoalList($dungeonMatematika->id_quiz, 1, $idAdmin, $this->getSoalMatematikaSd(), $jenisPG, $jenisBS);
        }

        // --- 2. IPA SD (id_mapel=4, id_jenjang=1) ---
        $dungeonIpa = Quiz::where('id_mapel', 4)
            ->where('id_jenjang', 1)
            ->whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
            ->first();

        if ($dungeonIpa) {
            $this->seedSoalList($dungeonIpa->id_quiz, 1, $idAdmin, $this->getSoalIpaSd(), $jenisPG, $jenisBS);
        }
    }

    /**
     * Masukkan daftar soal ke kuis dungeon secara idempoten (firstOrCreate).
     */
    protected function seedSoalList(int $idQuiz, int $idJenjang, int $idAdmin, array $soalList, $jenisPG, $jenisBS): void
    {
        foreach ($soalList as $s) {
            $isBs = !empty($s['bs']) && $jenisBS;
            $jId = $isBs ? $jenisBS->id_jenis_soal : $jenisPG->id_jenis_soal;

            $soal = Soal::firstOrCreate(
                [
                    'id_quiz' => $idQuiz,
                    'pertanyaan' => $s['q'],
                ],
                [
                    'id_jenjang' => $idJenjang,
                    'id_jenis_soal' => $jId,
                    'tingkat_soal' => $s['t'],
                    'jawaban_benar' => $s['ans'],
                    'id_penulis' => $idAdmin,
                    'aktif' => true,
                    'poin' => 10,
                    'durasi_detik' => match ($s['t']) {
                        'sulit' => 60,
                        'sedang' => 30,
                        default => 20,
                    },
                ]
            );

            // Buat pilihan soal jika belum ada
            if ($soal->wasRecentlyCreated || PilihanSoal::where('id_soal', $soal->id_soal)->count() === 0) {
                foreach ($s['opts'] as $idx => $optText) {
                    PilihanSoal::firstOrCreate(
                        [
                            'id_soal' => $soal->id_soal,
                            'label' => chr(65 + $idx),
                        ],
                        [
                            'teks_pilihan' => $optText,
                            'is_correct' => ($optText === $s['ans']),
                            'tetap_di_bawah' => false,
                        ]
                    );
                }
            }
        }
    }

    /**
     * Bank Soal Matematika SD: 60 Soal (20 Mudah, 20 Sedang, 20 Sulit)
     */
    protected function getSoalMatematikaSd(): array
    {
        return [
            // 20 MUDAH
            ['t' => 'mudah', 'q' => 'Hasil dari 15 + 27 adalah...', 'ans' => '42', 'opts' => ['38', '40', '42', '45']],
            ['t' => 'mudah', 'q' => 'Hasil dari 50 - 18 adalah...', 'ans' => '32', 'opts' => ['32', '34', '36', '38']],
            ['t' => 'mudah', 'q' => 'Berapakah 7 x 6?', 'ans' => '42', 'opts' => ['40', '42', '44', '48']],
            ['t' => 'mudah', 'q' => 'Berapakah 64 : 8?', 'ans' => '8', 'opts' => ['6', '7', '8', '9']],
            ['t' => 'mudah', 'q' => 'Bangun datar yang memiliki 4 sisi sama panjang dan 4 sudut siku-siku adalah...', 'ans' => 'Persegi', 'opts' => ['Persegi', 'Persegi Panjang', 'Segitiga', 'Trapesium']],
            ['t' => 'mudah', 'q' => 'Bilangan ganjil antara 10 dan 14 adalah...', 'ans' => '11 dan 13', 'opts' => ['11 dan 12', '11 dan 13', '12 dan 13', '13 dan 15']],
            ['t' => 'mudah', 'q' => 'Nilai tempat angka 5 pada bilangan 3.520 adalah...', 'ans' => 'Ratusan', 'opts' => ['Satuan', 'Puluhan', 'Ratusan', 'Ribuan']],
            ['t' => 'mudah', 'q' => 'Berapa jumlah sudut pada bangun segitiga?', 'ans' => '3', 'opts' => ['2', '3', '4', '5']],
            ['t' => 'mudah', 'q' => 'Hasil dari 100 : 4 adalah...', 'ans' => '25', 'opts' => ['20', '25', '30', '35']],
            ['t' => 'mudah', 'q' => 'Bangun lingkaran tidak memiliki sudut.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ['t' => 'mudah', 'q' => 'Hasil dari 8 x 9 adalah...', 'ans' => '72', 'opts' => ['63', '72', '81', '84']],
            ['t' => 'mudah', 'q' => 'Hasil pengurangan 95 - 47 adalah...', 'ans' => '48', 'opts' => ['46', '48', '52', '58']],
            ['t' => 'mudah', 'q' => 'Berapakah 12 x 5?', 'ans' => '60', 'opts' => ['50', '55', '60', '65']],
            ['t' => 'mudah', 'q' => 'Hasil dari 81 : 9 adalah...', 'ans' => '9', 'opts' => ['7', '8', '9', '10']],
            ['t' => 'mudah', 'q' => 'Bangun datar yang memiliki 3 sisi dan 3 sudut adalah...', 'ans' => 'Segitiga', 'opts' => ['Segitiga', 'Persegi', 'Lingkaran', 'Jajar Genjang']],
            ['t' => 'mudah', 'q' => 'Bilangan genap yang terletak di antara 17 dan 21 adalah...', 'ans' => '18 dan 20', 'opts' => ['18 dan 19', '18 dan 20', '19 dan 20', '20 dan 22']],
            ['t' => 'mudah', 'q' => 'Nilai tempat angka 7 pada bilangan 7.425 adalah...', 'ans' => 'Ribuan', 'opts' => ['Satuan', 'Puluhan', 'Ratusan', 'Ribuan']],
            ['t' => 'mudah', 'q' => 'Angka 0 merupakan bilangan bulat positif.', 'ans' => 'Salah', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ['t' => 'mudah', 'q' => 'Hasil dari 150 + 250 adalah...', 'ans' => '400', 'opts' => ['350', '380', '400', '450']],
            ['t' => 'mudah', 'q' => 'Jumlah sisi pada sebuah bangun layang-layang adalah...', 'ans' => '4', 'opts' => ['3', '4', '5', '6']],

            // 20 SEDANG
            ['t' => 'sedang', 'q' => 'FPB dari bilangan 12 dan 18 adalah...', 'ans' => '6', 'opts' => ['2', '3', '6', '9']],
            ['t' => 'sedang', 'q' => 'KPK dari bilangan 4 dan 6 adalah...', 'ans' => '12', 'opts' => ['10', '12', '18', '24']],
            ['t' => 'sedang', 'q' => 'Sebuah persegi memiliki sisi 12 cm. Berapa kelilingnya?', 'ans' => '48 cm', 'opts' => ['24 cm', '36 cm', '48 cm', '144 cm']],
            ['t' => 'sedang', 'q' => 'Luas persegi panjang dengan panjang 15 cm dan lebar 8 cm adalah...', 'ans' => '120 cm²', 'opts' => ['46 cm²', '90 cm²', '115 cm²', '120 cm²']],
            ['t' => 'sedang', 'q' => 'Pecahan senilai dari 2/3 adalah...', 'ans' => '4/6', 'opts' => ['3/4', '4/6', '5/8', '6/10']],
            ['t' => 'sedang', 'q' => 'Hasil dari 3/4 + 1/2 adalah...', 'ans' => '5/4', 'opts' => ['4/6', '1', '5/4', '3/2']],
            ['t' => 'sedang', 'q' => 'Sebuah segitiga memiliki alas 10 cm dan tinggi 8 cm. Berapa luasnya?', 'ans' => '40 cm²', 'opts' => ['20 cm²', '40 cm²', '80 cm²', '100 cm²']],
            ['t' => 'sedang', 'q' => 'Berapa hasil dari 25 x 16?', 'ans' => '400', 'opts' => ['350', '380', '400', '420']],
            ['t' => 'sedang', 'q' => 'Bentuk desimal dari 3/5 adalah...', 'ans' => '0,6', 'opts' => ['0,3', '0,5', '0,6', '0,75']],
            ['t' => 'sedang', 'q' => 'Sudut siku-siku memiliki besar tepat 90 derajat.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah']],
            ['t' => 'sedang', 'q' => 'FPB dari bilangan 24 dan 36 adalah...', 'ans' => '12', 'opts' => ['4', '6', '8', '12']],
            ['t' => 'sedang', 'q' => 'KPK dari bilangan 8 dan 12 adalah...', 'ans' => '24', 'opts' => ['16', '24', '32', '48']],
            ['t' => 'sedang', 'q' => 'Keliling persegi panjang dengan panjang 14 cm dan lebar 9 cm adalah...', 'ans' => '46 cm', 'opts' => ['42 cm', '46 cm', '54 cm', '126 cm']],
            ['t' => 'sedang', 'q' => 'Luas persegi dengan keliling 36 cm adalah...', 'ans' => '81 cm²', 'opts' => ['36 cm²', '72 cm²', '81 cm²', '144 cm²']],
            ['t' => 'sedang', 'q' => 'Hasil dari 5/6 - 1/3 adalah...', 'ans' => '1/2', 'opts' => ['1/3', '1/2', '2/3', '4/6']],
            ['t' => 'sedang', 'q' => 'Hasil perkalian pecahan 2/5 x 15/4 adalah...', 'ans' => '3/2', 'opts' => ['1', '3/2', '5/4', '2']],
            ['t' => 'sedang', 'q' => 'Bentuk persen dari pecahan 3/4 adalah...', 'ans' => '75%', 'opts' => ['25%', '50%', '75%', '80%']],
            ['t' => 'sedang', 'q' => 'Hasil dari 1.250 - 450 + 200 adalah...', 'ans' => '1.000', 'opts' => ['950', '1.000', '1.050', '1.100']],
            ['t' => 'sedang', 'q' => 'Sebuah jajar genjang memiliki alas 12 cm dan tinggi 7 cm. Berapa luasnya?', 'ans' => '84 cm²', 'opts' => ['42 cm²', '74 cm²', '84 cm²', '96 cm²']],
            ['t' => 'sedang', 'q' => 'Berapa hasil dari (-8) + 15?', 'ans' => '7', 'opts' => ['-23', '-7', '7', '23']],

            // 20 SULIT
            ['t' => 'sulit', 'q' => 'Volume kubus dengan panjang rusuk 9 cm adalah...', 'ans' => '729 cm³', 'opts' => ['81 cm³', '243 cm³', '512 cm³', '729 cm³']],
            ['t' => 'sulit', 'q' => 'Sebuah bak mandi berbentuk balok dengan panjang 1 m, lebar 80 cm, dan tinggi 60 cm. Berapa liter volume air jika terisi penuh?', 'ans' => '480 liter', 'opts' => ['240 liter', '480 liter', '540 liter', '600 liter']],
            ['t' => 'sulit', 'q' => 'Sebuah lingkaran memiliki jari-jari 14 cm. Berapakah luasnya? (π = 22/7)', 'ans' => '616 cm²', 'opts' => ['88 cm²', '308 cm²', '616 cm²', '1232 cm²']],
            ['t' => 'sulit', 'q' => 'Kecepatan rata-rata sebuah mobil adalah 60 km/jam. Jarak yang ditempuh mobil selama 2,5 jam adalah...', 'ans' => '150 km', 'opts' => ['120 km', '140 km', '150 km', '160 km']],
            ['t' => 'sulit', 'q' => 'Rata-rata nilai ulangan matematika dari 8 siswa adalah 75. Jika ditambah nilai Anton, rata-ratanya menjadi 77. Berapakah nilai Anton?', 'ans' => '93', 'opts' => ['83', '87', '91', '93']],
            ['t' => 'sulit', 'q' => 'Sebuah toko memberikan diskon 20% untuk tas seharga Rp150.000. Berapa uang yang harus dibayar pembeli?', 'ans' => 'Rp120.000', 'opts' => ['Rp110.000', 'Rp120.000', 'Rp130.000', 'Rp135.000']],
            ['t' => 'sulit', 'q' => 'Hasil dari (-15) + 8 x (-4) adalah...', 'ans' => '-47', 'opts' => ['-47', '-37', '17', '92']],
            ['t' => 'sulit', 'q' => 'Perbandingan umur Ayah dan Budi adalah 5 : 2. Jika selisih umur mereka 30 tahun, berapa umur Ayah?', 'ans' => '50 tahun', 'opts' => ['40 tahun', '45 tahun', '50 tahun', '55 tahun']],
            ['t' => 'sulit', 'q' => 'Skala pada peta adalah 1 : 250.000. Jika jarak dua kota pada peta 6 cm, berapa jarak sebenarnya?', 'ans' => '15 km', 'opts' => ['12 km', '15 km', '18 km', '25 km']],
            ['t' => 'sulit', 'q' => 'Berapa luas permukaan balok dengan ukuran panjang 10 cm, lebar 6 cm, dan tinggi 4 cm?', 'ans' => '248 cm²', 'opts' => ['124 cm²', '240 cm²', '248 cm²', '260 cm²']],
            ['t' => 'sulit', 'q' => 'Volume tabung dengan jari-jari alas 7 cm dan tinggi 10 cm adalah... (π = 22/7)', 'ans' => '1.540 cm³', 'opts' => ['440 cm³', '770 cm³', '1.540 cm³', '3.080 cm³']],
            ['t' => 'sulit', 'q' => 'Sebuah bak penampungan air berisi 1.200 liter. Air mengalir melalui pipa dengan debit 40 liter/menit hingga kosong. Waktu yang diperlukan adalah...', 'ans' => '30 menit', 'opts' => ['20 menit', '25 menit', '30 menit', '45 menit']],
            ['t' => 'sulit', 'q' => 'Keliling sebuah lingkaran adalah 88 cm. Berapakah jari-jari lingkaran tersebut? (π = 22/7)', 'ans' => '14 cm', 'opts' => ['7 cm', '14 cm', '21 cm', '28 cm']],
            ['t' => 'sulit', 'q' => 'Sebuah kolam renang panjangnya 20 m, lebar 10 m, dan kedalaman rata-rata 1,5 m. Berapa meter kubik air yang dapat ditampung kolam tersebut?', 'ans' => '300 m³', 'opts' => ['150 m²', '250 m³', '300 m³', '450 m³']],
            ['t' => 'sulit', 'q' => 'Rata-rata berat badan 5 orang anak adalah 36 kg. Jika seorang anak dengan berat badan 42 kg bergabung, berapakah rata-rata berat badan mereka sekarang?', 'ans' => '37 kg', 'opts' => ['36,5 kg', '37 kg', '37,5 kg', '38 kg']],
            ['t' => 'sulit', 'q' => 'Harga 5 buku tulis dan 2 pulpen adalah Rp23.000. Jika harga 1 pulpen adalah Rp4.000, berapakah harga 1 buku tulis?', 'ans' => 'Rp3.000', 'opts' => ['Rp2.500', 'Rp3.000', 'Rp3.500', 'Rp4.000']],
            ['t' => 'sulit', 'q' => 'Hasil dari (24 + 16) : (-5) x 3 adalah...', 'ans' => '-24', 'opts' => ['-24', '-18', '18', '24']],
            ['t' => 'sulit', 'q' => 'Ibu memiliki 3 1/2 kg tepung terigu. Digunakan untuk membuat kue 2 1/4 kg, lalu membeli lagi 1 1/2 kg. Berapa kg sisa tepung terigu Ibu sekarang?', 'ans' => '2 3/4 kg', 'opts' => ['2 1/4 kg', '2 1/2 kg', '2 3/4 kg', '3 kg']],
            ['t' => 'sulit', 'q' => 'Sebuah peta memiliki skala 1 : 1.500.000. Jarak kota A ke kota B sebenarnya adalah 45 km. Berapa jarak kedua kota tersebut pada peta?', 'ans' => '3 cm', 'opts' => ['2 cm', '3 cm', '4 cm', '5 cm']],
            ['t' => 'sulit', 'q' => 'Luas permukaan kubus adalah 216 cm². Berapakah volume kubus tersebut?', 'ans' => '216 cm³', 'opts' => ['144 cm³', '196 cm³', '216 cm³', '256 cm³']],
        ];
    }

    /**
     * Bank Soal IPA SD: 60 Soal (20 Mudah, 20 Sedang, 20 Sulit)
     */
    protected function getSoalIpaSd(): array
    {
        return [
            // 20 MUDAH
            ['t' => 'mudah', 'q' => 'Hewan yang memakan tumbuhan disebut...', 'ans' => 'Herbivora', 'opts' => ['Karnivora', 'Herbivora', 'Omnivora', 'Insektivora']],
            ['t' => 'mudah', 'q' => 'Bagian tumbuhan yang berfungsi menyerap air dan zat hara dari dalam tanah adalah...', 'ans' => 'Akar', 'opts' => ['Akar', 'Batang', 'Daun', 'Bunga']],
            ['t' => 'mudah', 'q' => 'Benda yang tidak dapat tembus cahaya disebut benda...', 'ans' => 'Gelap', 'opts' => ['Bening', 'Gelap', 'Transparan', 'Cermin']],
            ['t' => 'mudah', 'q' => 'Proses pembuatan makanan pada tumbuhan hijau dengan bantuan cahaya matahari disebut...', 'ans' => 'Fotosintesis', 'opts' => ['Fotosintesis', 'Respirasi', 'Metamorfosis', 'Penyerbukan']],
            ['t' => 'mudah', 'q' => 'Zat hijau pada daun yang berfungsi dalam fotosintesis adalah...', 'ans' => 'Klorofil', 'opts' => ['Klorofil', 'Stomata', 'Floem', 'Xilem']],
            ['t' => 'mudah', 'q' => 'Perubahan wujud benda dari cair menjadi gas disebut...', 'ans' => 'Menguap', 'opts' => ['Membeku', 'Mencair', 'Menguap', 'Mengembun']],
            ['t' => 'mudah', 'q' => 'Alat pernapasan utama pada ikan adalah...', 'ans' => 'Insang', 'opts' => ['Paru-paru', 'Insang', 'Kulit', 'Trakea']],
            ['t' => 'mudah', 'q' => 'Matahari terbit dari arah...', 'ans' => 'Timur', 'opts' => ['Barat', 'Timur', 'Utara', 'Selatan']],
            ['t' => 'mudah', 'q' => 'Bulan memancarkan cahayanya sendiri.', 'ans' => 'Salah', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ['t' => 'mudah', 'q' => 'Tumbuhan putri malu akan mengatupkan daunnya jika disentuh.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ['t' => 'mudah', 'q' => 'Hewan yang berkembang biak dengan cara bertelur disebut...', 'ans' => 'Ovipar', 'opts' => ['Ovipar', 'Vivipar', 'Ovovivipar', 'Mamalia']],
            ['t' => 'mudah', 'q' => 'Contoh hewan yang mengalami metamorfosis sempurna adalah...', 'ans' => 'Kupu-kupu', 'opts' => ['Kupu-kupu', 'Belalang', 'Kecoa', 'Jangkrik']],
            ['t' => 'mudah', 'q' => 'Batu termasuk dalam jenis benda...', 'ans' => 'Padat', 'opts' => ['Padat', 'Cair', 'Gas', 'Plasma']],
            ['t' => 'mudah', 'q' => 'Alat indra pada manusia yang berfungsi untuk mengecap rasa adalah...', 'ans' => 'Lidah', 'opts' => ['Hidung', 'Kulit', 'Lidah', 'Telinga']],
            ['t' => 'mudah', 'q' => 'Kucing berkembang biak dengan cara melahirkan (vivipar).', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ['t' => 'mudah', 'q' => 'Perubahan wujud benda dari padat menjadi cair disebut...', 'ans' => 'Mencair', 'opts' => ['Membeku', 'Mencair', 'Menguap', 'Menyublim']],
            ['t' => 'mudah', 'q' => 'Planet yang paling dekat dengan matahari adalah...', 'ans' => 'Merkurius', 'opts' => ['Merkurius', 'Bumi', 'Venus', 'Mars']],
            ['t' => 'mudah', 'q' => 'Bunyi tidak dapat merambat di ruang hampa udara.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ['t' => 'mudah', 'q' => 'Hewan pemakan daging disebut karnivora.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah'], 'bs' => true],
            ['t' => 'mudah', 'q' => 'Organ tubuh manusia yang berfungsi memompa darah ke seluruh tubuh adalah...', 'ans' => 'Jantung', 'opts' => ['Paru-paru', 'Jantung', 'Hati', 'Ginjal']],

            // 20 SEDANG
            ['t' => 'sedang', 'q' => 'Hubungan saling menguntungkan antara dua makhluk hidup disebut simbiosis...', 'ans' => 'Mutualisme', 'opts' => ['Komensalisme', 'Parasitisme', 'Mutualisme', 'Amensalisme']],
            ['t' => 'sedang', 'q' => 'Gaya yang timbul saat dua permukaan benda saling bersentuhan dan menghambat gerak adalah...', 'ans' => 'Gaya gesek', 'opts' => ['Gaya gravitasi', 'Gaya magnet', 'Gaya pegas', 'Gaya gesek']],
            ['t' => 'sedang', 'q' => 'Contoh peristiwa perpindahan panas secara konduksi adalah...', 'ans' => 'Ujung sendok logam terasa panas saat mengaduk teh hangat', 'opts' => ['Ujung sendok logam terasa panas saat mengaduk teh hangat', 'Panas matahari sampai ke bumi', 'Terjadinya angin darat dan laut', 'Air mendidih saat direbus']],
            ['t' => 'sedang', 'q' => 'Sendi yang memungkinkan gerakan ke segala arah pada tubuh manusia adalah sendi...', 'ans' => 'Peluru', 'opts' => ['Engsel', 'Peluru', 'Putar', 'Pelana']],
            ['t' => 'sedang', 'q' => 'Urutan metamorfosis katak yang benar adalah...', 'ans' => 'Telur - kecebong - katak berekor - katak muda - katak dewasa', 'opts' => ['Telur - kecebong - katak berekor - katak muda - katak dewasa', 'Telur - larva - pupa - imago', 'Telur - nimfa - katak dewasa', 'Telur - katak berekor - kecebong - katak dewasa']],
            ['t' => 'sedang', 'q' => 'Lapisan atmosfer bumi yang berfungsi melindungi bumi dari radiasi sinar ultraviolet adalah...', 'ans' => 'Lapisan ozon', 'opts' => ['Troposfer', 'Lapisan ozon', 'Mesosfer', 'Eksosfer']],
            ['t' => 'sedang', 'q' => 'Organ pencernaan manusia tempat penyerapan sari-sari makanan terjadi di...', 'ans' => 'Usus halus', 'opts' => ['Lambung', 'Usus halus', 'Usus besar', 'Kerongkongan']],
            ['t' => 'sedang', 'q' => 'Magnet memiliki dua kutub, yaitu kutub utara dan kutub selatan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah']],
            ['t' => 'sedang', 'q' => 'Benda yang dapat ditarik kuat oleh magnet disebut benda...', 'ans' => 'Feromagnetik', 'opts' => ['Feromagnetik', 'Paramagnetik', 'Diamagnetik', 'Nonmagnetik']],
            ['t' => 'sedang', 'q' => 'Peristiwa pembelokan cahaya saat merambat melalui dua medium berbeda kerapatannya disebut...', 'ans' => 'Pembiasan', 'opts' => ['Pemantulan', 'Pembiasan', 'Perambatan', 'Penguraian']],
            ['t' => 'sedang', 'q' => 'Tumbuhan kantung semar menangkap serangga untuk memenuhi kebutuhan zat...', 'ans' => 'Nitrogen', 'opts' => ['Oksigen', 'Karbon', 'Nitrogen', 'Hidrogen']],
            ['t' => 'sedang', 'q' => 'Contoh simbiosis komensalisme adalah hubungan antara...', 'ans' => 'Ikan remora dan ikan hiu', 'opts' => ['Kutu dan anjing', 'Benalu dan pohon inang', 'Bunga dan lebah', 'Ikan remora dan ikan hiu']],
            ['t' => 'sedang', 'q' => 'Cacing tanah bernapas menggunakan...', 'ans' => 'Permukaan kulit', 'opts' => ['Insang', 'Paru-paru', 'Trakea', 'Permukaan kulit']],
            ['t' => 'sedang', 'q' => 'Alat untuk mengukur besar gaya adalah...', 'ans' => 'Dinamometer', 'opts' => ['Termometer', 'Barometer', 'Dinamometer', 'Anemometer']],
            ['t' => 'sedang', 'q' => 'Pelangi terbentuk karena peristiwa pembiasan dan penguraian cahaya matahari oleh tetes air hujan.', 'ans' => 'Benar', 'opts' => ['Benar', 'Salah']],
            ['t' => 'sedang', 'q' => 'Bunyi pantul yang terdengar hampir bersamaan dengan bunyi asli disebut...', 'ans' => 'Gaung', 'opts' => ['Gema', 'Gaung', 'Resonansi', 'Desah']],
            ['t' => 'sedang', 'q' => 'Peristiwa perpindahan panas yang disertai dengan perpindahan partikel zatnya disebut...', 'ans' => 'Konveksi', 'opts' => ['Konduksi', 'Konveksi', 'Radiasi', 'Evaporasi']],
            ['t' => 'sedang', 'q' => 'Bagian mata yang berfungsi mengatur jumlah cahaya yang masuk ke dalam mata adalah...', 'ans' => 'Pupil', 'opts' => ['Kornea', 'Iris', 'Pupil', 'Retina']],
            ['t' => 'sedang', 'q' => 'Hewan mamalia yang dapat terbang adalah...', 'ans' => 'Kelelawar', 'opts' => ['Burung hantu', 'Kelelawar', 'Ayam', 'Tupai terbang']],
            ['t' => 'sedang', 'q' => 'Fungsi utama sel darah merah (eritrosit) adalah mengangkut...', 'ans' => 'Oksigen', 'opts' => ['Oksigen', 'Karbon dioksida', 'Sari makanan', 'Hormon']],

            // 20 SULIT
            ['t' => 'sulit', 'q' => 'Peredaran darah besar pada manusia mengalirkan darah dari...', 'ans' => 'Bilik kiri ke seluruh tubuh lalu kembali ke serambi kanan', 'opts' => ['Bilik kanan ke paru-paru lalu ke serambi kiri', 'Bilik kiri ke seluruh tubuh lalu kembali ke serambi kanan', 'Serambi kanan ke bilik kanan', 'Seluruh tubuh ke paru-paru']],
            ['t' => 'sulit', 'q' => 'Energi potensial suatu benda dipengaruhi oleh...', 'ans' => 'Massa benda, gravitasi, dan ketinggian', 'opts' => ['Massa benda, kecepatan, dan waktu', 'Massa benda, gravitasi, dan ketinggian', 'Luas permukaan dan gaya gesek', 'Kecepatan dan arah gerak']],
            ['t' => 'sulit', 'q' => 'Gerak tumbuhan menuju arah datangnya rangsangan cahaya disebut...', 'ans' => 'Fototropisme', 'opts' => ['Geotropisme', 'Hidrotropisme', 'Fototropisme', 'Tigmotropisme']],
            ['t' => 'sulit', 'q' => 'Pada rangkaian listrik seri, jika salah satu lampu padam, maka lampu yang lain akan...', 'ans' => 'Padam', 'opts' => ['Tetap menyala', 'Padam', 'Menyala lebih terang', 'Berkedip']],
            ['t' => 'sulit', 'q' => 'Penyakit tulang rapuh yang disebabkan oleh kekurangan kalsium pada orang dewasa disebut...', 'ans' => 'Osteoporosis', 'opts' => ['Rakitis', 'Osteoporosis', 'Polio', 'Lordosis']],
            ['t' => 'sulit', 'q' => 'Peristiwa gerhana matahari total terjadi ketika posisi...', 'ans' => 'Bulan berada di antara matahari dan bumi dalam satu garis lurus', 'opts' => ['Bumi berada di antara matahari dan bulan', 'Bulan berada di antara matahari dan bumi dalam satu garis lurus', 'Matahari berada di antara bumi dan bulan', 'Bayangan bumi menutupi bulan']],
            ['t' => 'sulit', 'q' => 'Waktu yang dibutuhkan bumi untuk satu kali berevolusi mengelilingi matahari adalah...', 'ans' => '365 1/4 hari', 'opts' => ['24 jam', '30 hari', '365 1/4 hari', '366 hari']],
            ['t' => 'sulit', 'q' => 'Ketinggian air laut pasang maksimum (pasang purnama) terjadi saat...', 'ans' => 'Bulan baru dan bulan purnama', 'opts' => ['Bulan baru dan bulan purnama', 'Bulan sabit', 'Bulan kuartir pertama', 'Gerhana matahari saja']],
            ['t' => 'sulit', 'q' => 'Alveolus pada paru-paru berfungsi sebagai tempat pertukaran gas antara...', 'ans' => 'Oksigen dan karbon dioksida', 'opts' => ['Oksigen dan karbon monoksida', 'Oksigen dan karbon dioksida', 'Karbon dioksida dan nitrogen', 'Uap air dan udara panas']],
            ['t' => 'sulit', 'q' => 'Hukum kekekalan energi menyatakan bahwa energi...', 'ans' => 'Tidak dapat diciptakan dan tidak dapat dimusnahkan', 'opts' => ['Dapat diciptakan tetapi tidak dapat dimusnahkan', 'Dapat dimusnahkan dengan panas tinggi', 'Tidak dapat diciptakan dan tidak dapat dimusnahkan', 'Selalu berkurang seiring waktu']],
            ['t' => 'sulit', 'q' => 'Zat aditif makanan yang berfungsi sebagai pemanis buatan tanpa kalori adalah...', 'ans' => 'Aspartam', 'opts' => ['Tartrazin', 'Monosodium glutamat', 'Aspartam', 'Asam sitrat']],
            ['t' => 'sulit', 'q' => 'Tumbuhan kaktus memiliki daun yang berbentuk duri dengan tujuan utama untuk...', 'ans' => 'Mengurangi penguapan air', 'opts' => ['Menarik serangga', 'Mengurangi penguapan air', 'Menyimpan cadangan makanan', 'Melakukan fotosintesis maksimal']],
            ['t' => 'sulit', 'q' => 'Pada katrol tetap, keuntungan mekanis yang diperoleh adalah...', 'ans' => '1', 'opts' => ['1', '2', '3', '4']],
            ['t' => 'sulit', 'q' => 'Alat optik yang digunakan untuk melihat benda-benda renik atau mikroorganisme adalah...', 'ans' => 'Mikroskop', 'opts' => ['Periskop', 'Teleskop', 'Lup', 'Mikroskop']],
            ['t' => 'sulit', 'q' => 'Seseorang yang menderita rabun jauh (miopi) dapat ditolong dengan kacamata berlensa...', 'ans' => 'Cekung (negatif)', 'opts' => ['Cembung (positif)', 'Cekung (negatif)', 'Silindris', 'Bifokal']],
            ['t' => 'sulit', 'q' => 'Gigi manusia yang berfungsi untuk merobek dan mengoyak makanan adalah...', 'ans' => 'Gigi taring', 'opts' => ['Gigi seri', 'Gigi taring', 'Gigi geraham depan', 'Gigi geraham belakang']],
            ['t' => 'sulit', 'q' => 'Bagian jantung yang berdinding paling tebal dan berotot kuat adalah...', 'ans' => 'Bilik kiri', 'opts' => ['Serambi kanan', 'Serambi kiri', 'Bilik kanan', 'Bilik kiri']],
            ['t' => 'sulit', 'q' => 'Adaptasi fisiologis pada hewan unta yang membantunya bertahan hidup di padang pasir adalah...', 'ans' => 'Memiliki urin yang sangat pekat dan tahan dehidrasi', 'opts' => ['Memiliki punuk berisi air', 'Memiliki urin yang sangat pekat dan tahan dehidrasi', 'Berbulu sangat tipis tanpa kelenjar keringat', 'Bernapas lambat']],
            ['t' => 'sulit', 'q' => 'Planet dalam tata surya yang memiliki sistem cincin paling jelas dan indah adalah...', 'ans' => 'Saturnus', 'opts' => ['Jupiter', 'Saturnus', 'Uranus', 'Neptunus']],
            ['t' => 'sulit', 'q' => 'Zat yang berfungsi mempercepat laju reaksi kimia dalam tubuh tanpa ikut bereaksi disebut...', 'ans' => 'Enzim', 'opts' => ['Hormon', 'Enzim', 'Vitamin', 'Antibodi']],
        ];
    }
}

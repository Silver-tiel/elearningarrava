<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\DungeonLaporanSoal;
use App\Models\DungeonPengaturan;
use App\Models\DungeonRiwayatSoal;
use App\Models\DungeonSesi;
use App\Models\DungeonSesiSoal;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\PilihanSoal;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TipeQuiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DungeonService
{
    /**
     * Normalisasi jawaban isian singkat (trim, huruf kecil, hapus tanda baca, dan spasi ganda).
     */
    public static function normalisasiIsian(?string $teks): string
    {
        if ($teks === null) {
            return '';
        }

        $str = mb_strtolower(trim($teks));
        // Hapus tanda baca umum
        $str = preg_replace('/[[:punct:]]/u', ' ', $str);
        // Hapus spasi ganda berlebih
        $str = preg_replace('/\s+/', ' ', $str);

        return trim($str);
    }

    /**
     * Pastikan kuis bertipe Dungeon untuk kombinasi mapel & jenjang tersedia (idempotent).
     */
    public function ensureDungeonQuiz(int $idMapel, int $idJenjang): ?Quiz
    {
        $tipeDungeon = TipeQuiz::firstOrCreate(['nama_tipe' => 'Dungeon']);
        $tingkatUmum = TingkatQuiz::first() ?? TingkatQuiz::create(['nama_tingkat' => 'Semua Tingkat']);
        $admin = User::where('id_tipeuser', 1)->first();
        $mapel = Mapel::find($idMapel);
        $jenjang = Jenjang::find($idJenjang);
        $namaJenjang = $jenjang ? ($jenjang->nama_tipe ?? $jenjang->nama_jenjang ?? "Jenjang {$idJenjang}") : "Jenjang {$idJenjang}";
        $namaMapel = $mapel ? $mapel->nama_mapel : "Mapel {$idMapel}";

        return Quiz::firstOrCreate(
            [
                'id_mapel' => $idMapel,
                'id_jenjang' => $idJenjang,
                'id_tipequiz' => $tipeDungeon->id_tipequiz,
            ],
            [
                'judul' => "Dungeon {$namaMapel} ({$namaJenjang})",
                'deskripsi' => "Dungeon Soal tanpa batas untuk mata pelajaran {$namaMapel} jenjang {$namaJenjang}.",
                'id_tingkatquiz' => $tingkatUmum->id_tingkatquiz,
                'id_pembuat' => $admin ? $admin->id_user : null,
                'durasi_total_menit' => 0,
                'token' => null,
                'proggressQuiz' => 'Tersedia',
            ]
        );
    }

    /**
     * Memeriksa apakah dungeon untuk mapel dan jenjang tertentu memenuhi syarat terbuka.
     * Syarat default: minimal 30 soal aktif dan minimal 8 per tingkat (mudah, sedang, sulit).
     */
    public function cekStatusDungeon(int $idMapel, int $idJenjang): array
    {
        $dungeonQuiz = Quiz::where('id_mapel', $idMapel)
            ->where('id_jenjang', $idJenjang)
            ->whereHas('tipeQuiz', fn ($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
            ->first();

        if (!$dungeonQuiz) {
            return [
                'quiz' => null,
                'terbuka' => false,
                'alasan' => 'Dungeon untuk mata pelajaran dan jenjang ini belum tersedia.',
                'total_soal' => 0,
                'mudah' => 0,
                'sedang' => 0,
                'sulit' => 0,
            ];
        }

        $soalAktif = Soal::where('id_quiz', $dungeonQuiz->id_quiz)
            ->where('aktif', true)
            ->get(['id_soal', 'tingkat_soal']);

        $total = $soalAktif->count();
        $mudah = $soalAktif->where('tingkat_soal', 'mudah')->count();
        $sedang = $soalAktif->where('tingkat_soal', 'sedang')->count();
        $sulit = $soalAktif->where('tingkat_soal', 'sulit')->count();

        $minTotal = (int) DungeonPengaturan::getNilai('syarat_total_soal_aktif', 30);
        $minPerTingkat = (int) DungeonPengaturan::getNilai('syarat_soal_per_tingkat', 8);

        $terbuka = ($total >= $minTotal && $mudah >= $minPerTingkat && $sedang >= $minPerTingkat && $sulit >= $minPerTingkat);

        return [
            'quiz' => $dungeonQuiz,
            'terbuka' => $terbuka,
            'alasan' => $terbuka ? null : "Dungeon belum terbuka (membutuhkan minimal {$minTotal} soal aktif dan minimal {$minPerTingkat} soal per tingkat).",
            'total_soal' => $total,
            'mudah' => $mudah,
            'sedang' => $sedang,
            'sulit' => $sulit,
            'syarat' => [
                'min_total' => $minTotal,
                'min_per_tingkat' => $minPerTingkat,
            ],
        ];
    }

    /**
     * Memulai sesi permainan Dungeon baru.
     */
    public function mulaiSesi(User $user, int $idMapel, bool $isUjiCoba = false, ?int $idJenjangOverride = null): array
    {
        $idJenjang = $idJenjangOverride ?? $user->id_jenjang ?? 1;

        // Validasi dungeon terbuka
        $statusDungeon = $this->cekStatusDungeon($idMapel, $idJenjang);
        if (!$statusDungeon['terbuka'] && !$isUjiCoba) {
            throw ValidationException::withMessages([
                'dungeon' => $statusDungeon['alasan'] ?? 'Dungeon belum memenuhi syarat untuk dimainkan.',
            ]);
        }

        return DB::transaction(function () use ($user, $idMapel, $idJenjang, $isUjiCoba, $statusDungeon) {
            // Tutup sesi basi / menggantung pemain jika ada
            $this->tutupSesiBasi($user);

            // Periksa jika pemain masih punya sesi aktif yang valid
            $sesiAktif = DungeonSesi::where('kunci_aktif', $user->id_user)->first();
            if ($sesiAktif) {
                // Jika mapelnya sama, kembalikan sesi berjalan
                if ((int) $sesiAktif->id_mapel === (int) $idMapel) {
                    $soalBerjalan = $this->ambilSoalAktif($sesiAktif);
                    if ($soalBerjalan) {
                        return [
                            'sesi' => $sesiAktif,
                            'soal' => $soalBerjalan,
                            'is_resume' => true,
                        ];
                    }
                }
                // Jika mapel berbeda atau tidak ada soal aktif, tutup dulu
                $this->tutupSesi($sesiAktif, 'keluar');
            }

            // Hitung nomor ronde pemain
            $rondeKe = 1;
            if (!$isUjiCoba) {
                $rondeKe = DungeonSesi::where('id_user', $user->id_user)
                    ->where('id_mapel', $idMapel)
                    ->where('is_uji_coba', false)
                    ->count() + 1;
            }

            $nyawaAwal = (int) DungeonPengaturan::getNilai('nyawa_awal', 3);

            $sesi = DungeonSesi::create([
                'id_user' => $user->id_user,
                'id_jenjang' => $idJenjang,
                'id_mapel' => $idMapel,
                'ronde_ke' => $rondeKe,
                'mulai' => now(),
                'jumlah_benar' => 0,
                'jumlah_salah' => 0,
                'nyawa' => $nyawaAwal,
                'lantai_tertinggi' => 1,
                'skor_dungeon' => 0,
                'multiplier_akhir' => 1.0,
                'poin_profil_didapat' => 0,
                'poin_sudah_diberikan' => false,
                'kunci_aktif' => $user->id_user,
                'is_uji_coba' => $isUjiCoba,
            ]);

            // Pilih soal pertama
            $soalPertama = $this->pilihSoalBerikutnya($sesi);
            if (!$soalPertama) {
                $this->tutupSesi($sesi, 'tuntas');
                return [
                    'sesi' => $sesi,
                    'soal' => null,
                    'is_resume' => false,
                ];
            }

            $soalPayload = $this->siapkanSoalUntukPemain($sesi, $soalPertama);

            return [
                'sesi' => $sesi,
                'soal' => $soalPayload,
                'is_resume' => false,
            ];
        });
    }

    /**
     * Memilih soal berikutnya berdasarkan undian tingkat dan bobot kemunculan repetisi ronde.
     */
    public function pilihSoalBerikutnya(DungeonSesi $sesi): ?Soal
    {
        $dungeonQuiz = Quiz::where('id_mapel', $sesi->id_mapel)
            ->where('id_jenjang', $sesi->id_jenjang)
            ->whereHas('tipeQuiz', fn ($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
            ->first();

        if (!$dungeonQuiz) {
            return null;
        }

        // Ambil ID soal yang sudah pernah tampil di sesi ini
        $soalSudahTampil = DungeonSesiSoal::where('id_sesi', $sesi->id)->pluck('id_soal')->toArray();

        // 1. Tentukan target tingkat berdasarkan jumlah jawaban benar
        $targetTingkat = $this->tentukanTingkatTarget($sesi->jumlah_benar);

        // 2. Kumpulkan kandidat soal
        $urutanTingkat = match ($targetTingkat) {
            'sulit' => ['sulit', 'sedang', 'mudah'],
            'sedang' => ['sedang', 'mudah', 'sulit'],
            default => ['mudah', 'sedang', 'sulit'],
        };

        $kandidatList = collect();
        foreach ($urutanTingkat as $tingkat) {
            $query = Soal::where('id_quiz', $dungeonQuiz->id_quiz)
                ->where('aktif', true)
                ->where('tingkat_soal', $tingkat);

            if (!empty($soalSudahTampil)) {
                $query->whereNotIn('id_soal', $soalSudahTampil);
            }

            $list = $query->get();
            if ($list->isNotEmpty()) {
                $kandidatList = $list;
                break;
            }
        }

        // Jika semua tingkat kosong (habis), berarti dungeon tuntas
        if ($kandidatList->isEmpty()) {
            return null;
        }

        // 3. Hitung bobot repetisi ronde per soal
        $riwayatUser = DungeonRiwayatSoal::where('id_user', $sesi->id_user)
            ->whereIn('id_soal', $kandidatList->pluck('id_soal'))
            ->get()
            ->keyBy('id_soal');

        $rondeSekarang = (int) $sesi->ronde_ke;
        $weightedCandidates = [];
        $totalBobot = 0.0;

        foreach ($kandidatList as $soal) {
            $riwayat = $riwayatUser->get($soal->id_soal);
            if (!$riwayat) {
                // Belum pernah dilihat sama sekali
                $bobot = 1.0;
            } else {
                $selisih = $rondeSekarang - (int) $riwayat->ronde_terakhir;
                if ($selisih <= 1) {
                    $bobot = 0.1;
                } elseif ($selisih === 2) {
                    $bobot = 0.3;
                } elseif ($selisih === 3) {
                    $bobot = 0.6;
                } else {
                    $bobot = 1.0;
                }
            }

            $weightedCandidates[] = [
                'soal' => $soal,
                'bobot' => $bobot,
            ];
            $totalBobot += $bobot;
        }

        // Undian berbobot (weighted random selection)
        $rand = (float) (mt_rand(1, 10000) / 10000.0) * $totalBobot;
        $runningSum = 0.0;
        foreach ($weightedCandidates as $item) {
            $runningSum += $item['bobot'];
            if ($rand <= $runningSum) {
                return $item['soal'];
            }
        }

        return $weightedCandidates[array_key_last($weightedCandidates)]['soal'] ?? null;
    }

    /**
     * Tentukan tingkat target berdasarkan persentase jumlah jawaban benar.
     */
    protected function tentukanTingkatTarget(int $jumlahBenar): string
    {
        $roll = mt_rand(1, 100);

        if ($jumlahBenar < 10) {
            // 0–9 benar: 70% Mudah, 30% Sedang, 0% Sulit
            return $roll <= 70 ? 'mudah' : 'sedang';
        } elseif ($jumlahBenar < 20) {
            // 10–19 benar: 30% Mudah, 50% Sedang, 20% Sulit
            if ($roll <= 30) return 'mudah';
            if ($roll <= 80) return 'sedang';
            return 'sulit';
        } elseif ($jumlahBenar < 30) {
            // 20–29 benar: 10% Mudah, 50% Sedang, 40% Sulit
            if ($roll <= 10) return 'mudah';
            if ($roll <= 60) return 'sedang';
            return 'sulit';
        } else {
            // 30+ benar: 0% Mudah, 40% Sedang, 60% Sulit
            return $roll <= 40 ? 'sedang' : 'sulit';
        }
    }

    /**
     * Menyiapkan soal untuk dikirim ke pemain:
     * - Mengacak urutan pilihan di server (menjaga Benar/Salah dan pilihan tetap_di_bawah).
     * - Menyimpan batas waktu & riwayat tampil.
     * - Tidak memuat kunci jawaban.
     */
    public function siapkanSoalUntukPemain(DungeonSesi $sesi, Soal $soal): array
    {
        $soal->loadMissing(['pilihanSoal', 'jenisSoal']);

        $durasi = $soal->durasi_detik;
        if (!$durasi || $durasi <= 0) {
            $durasi = match ($soal->tingkat_soal) {
                'sulit' => (int) DungeonPengaturan::getNilai('waktu_sulit', 60),
                'sedang' => (int) DungeonPengaturan::getNilai('waktu_sedang', 30),
                default => (int) DungeonPengaturan::getNilai('waktu_mudah', 20),
            };
        }

        $waktuTampil = now();
        $batasWaktu = $waktuTampil->copy()->addSeconds($durasi);

        // Pengacakan pilihan
        $isBenarSalah = (int) $soal->id_jenis_soal === 3;
        $pilihanOriginal = $soal->pilihanSoal;
        $urutanPilihanIds = [];

        if ($isBenarSalah) {
            // Urutan Benar/Salah tetap: A Benar, B Salah
            $sorted = $pilihanOriginal->sortBy('label')->values();
            $urutanPilihanIds = $sorted->pluck('id_pilihan')->toArray();
        } else {
            $acak = $pilihanOriginal->where('tetap_di_bawah', false)->shuffle()->values();
            $tetapBawah = $pilihanOriginal->where('tetap_di_bawah', true)->sortBy('id_pilihan')->values();
            $merged = $acak->concat($tetapBawah);
            $urutanPilihanIds = $merged->pluck('id_pilihan')->toArray();
        }

        $urutanKe = DungeonSesiSoal::where('id_sesi', $sesi->id)->count() + 1;

        // Simpan sesi soal
        $sesiSoal = DungeonSesiSoal::create([
            'id_sesi' => $sesi->id,
            'id_soal' => $soal->id_soal,
            'urutan' => $urutanKe,
            'urutan_pilihan' => $urutanPilihanIds,
            'waktu_tampil' => $waktuTampil,
            'batas_waktu' => $batasWaktu,
        ]);

        // Upsert dungeon_riwayat_soal (times_seen + 1, ronde_terakhir) saat soal ditampilkan
        DungeonRiwayatSoal::updateOrCreate(
            ['id_user' => $sesi->id_user, 'id_soal' => $soal->id_soal],
            ['ronde_terakhir' => $sesi->ronde_ke]
        )->increment('times_seen');

        // Format pilihan tanpa kunci
        $pilihanMap = $pilihanOriginal->keyBy('id_pilihan');
        $pilihanPayload = [];
        $huruf = ['A', 'B', 'C', 'D', 'E'];
        foreach ($urutanPilihanIds as $pos => $pId) {
            $pModel = $pilihanMap->get($pId);
            if ($pModel) {
                $pilihanPayload[] = [
                    'id_pilihan' => $pModel->id_pilihan,
                    'label' => $huruf[$pos] ?? chr(65 + $pos),
                    'teks_pilihan' => $pModel->teks_pilihan,
                    'tetap_di_bawah' => (bool) $pModel->tetap_di_bawah,
                ];
            }
        }

        $multiplierSekarang = $this->hitungMultiplier((int) ($sesi->jumlah_benar ?? 0));

        return [
            'id_sesi' => $sesi->id,
            'id_soal' => $soal->id_soal,
            'urutan' => $urutanKe,
            'pertanyaan' => $soal->pertanyaan,
            'foto_soal' => $soal->foto_soal ? asset('storage/' . $soal->foto_soal) : null,
            'id_jenis_soal' => (int) $soal->id_jenis_soal,
            'tingkat_soal' => $soal->tingkat_soal ?? 'mudah',
            'durasi_detik' => $durasi,
            'batas_waktu' => $batasWaktu->toIso8601String(),
            'pilihan' => $pilihanPayload,
            'multiplier' => $multiplierSekarang,
            'nyawa' => $sesi->nyawa,
            'lantai' => $sesi->lantai_tertinggi,
            'skor_dungeon' => $sesi->skor_dungeon,
        ];
    }

    /**
     * Mengambil soal aktif yang sedang dihadapi pemain jika ada.
     */
    public function ambilSoalAktif(DungeonSesi $sesi): ?array
    {
        $sesiSoal = DungeonSesiSoal::where('id_sesi', $sesi->id)
            ->whereNull('jawaban_user')
            ->latest('id')
            ->first();

        if (!$sesiSoal) {
            return null;
        }

        $soal = Soal::with(['pilihanSoal', 'jenisSoal'])->find($sesiSoal->id_soal);
        if (!$soal) {
            return null;
        }

        $urutanPilihanIds = $sesiSoal->urutan_pilihan ?? [];
        $pilihanOriginal = $soal->pilihanSoal->keyBy('id_pilihan');
        $pilihanPayload = [];
        $huruf = ['A', 'B', 'C', 'D', 'E'];

        foreach ($urutanPilihanIds as $pos => $pId) {
            $pModel = $pilihanOriginal->get($pId);
            if ($pModel) {
                $pilihanPayload[] = [
                    'id_pilihan' => $pModel->id_pilihan,
                    'label' => $huruf[$pos] ?? chr(65 + $pos),
                    'teks_pilihan' => $pModel->teks_pilihan,
                    'tetap_di_bawah' => (bool) $pModel->tetap_di_bawah,
                ];
            }
        }

        $sisaWaktu = max(0, Carbon::now()->diffInSeconds(Carbon::parse($sesiSoal->batas_waktu), false));

        return [
            'id_sesi' => $sesi->id,
            'id_soal' => $soal->id_soal,
            'urutan' => $sesiSoal->urutan,
            'pertanyaan' => $soal->pertanyaan,
            'foto_soal' => $soal->foto_soal ? asset('storage/' . $soal->foto_soal) : null,
            'id_jenis_soal' => (int) $soal->id_jenis_soal,
            'tingkat_soal' => $soal->tingkat_soal ?? 'mudah',
            'durasi_detik' => (int) $sisaWaktu,
            'batas_waktu' => Carbon::parse($sesiSoal->batas_waktu)->toIso8601String(),
            'pilihan' => $pilihanPayload,
            'multiplier' => $this->hitungMultiplier($sesi->jumlah_benar),
            'nyawa' => $sesi->nyawa,
            'lantai' => $sesi->lantai_tertinggi,
            'skor_dungeon' => $sesi->skor_dungeon,
        ];
    }

    /**
     * Menerima dan mengevaluasi jawaban pemain untuk soal tertentu.
     */
    public function jawabSoal(DungeonSesi $sesi, int $idSoal, mixed $jawabanInput): array
    {
        return DB::transaction(function () use ($sesi, $idSoal, $jawabanInput) {
            $sesi = DungeonSesi::where('id', $sesi->id)->lockForUpdate()->firstOrFail();

            if ($sesi->selesai !== null) {
                return [
                    'status' => 'selesai',
                    'pesan' => 'Petualangan sudah berakhir.',
                    'sesi' => $sesi,
                    'soal_berikutnya' => null,
                ];
            }

            $sesiSoal = DungeonSesiSoal::where('id_sesi', $sesi->id)
                ->where('id_soal', $idSoal)
                ->whereNull('jawaban_user')
                ->firstOrFail();

            $soal = Soal::with(['pilihanSoal', 'jenisSoal'])->findOrFail($idSoal);

            $toleransi = (int) DungeonPengaturan::getNilai('toleransi_jaringan', 2);
            $batasDenganToleransi = Carbon::parse($sesiSoal->batas_waktu)->addSeconds($toleransi);
            $isTimeout = now()->greaterThan($batasDenganToleransi);

            $isBenar = false;
            $kunciJawabanTeks = '';

            if ($isTimeout) {
                // Waktu habis -> salah
                $isBenar = false;
                $sesiSoal->jawaban_user = '[waktu_habis]';
            } else {
                $sesiSoal->jawaban_user = is_scalar($jawabanInput) ? (string) $jawabanInput : json_encode($jawabanInput);

                if ((int) $soal->id_jenis_soal === 2) {
                    // Isian Singkat
                    $cleanUser = self::normalisasiIsian((string) $jawabanInput);
                    $cleanKunci = self::normalisasiIsian((string) $soal->jawaban_benar);
                    $isBenar = ($cleanUser !== '' && $cleanUser === $cleanKunci);
                    $kunciJawabanTeks = (string) $soal->jawaban_benar;
                } else {
                    // Pilihan Ganda / Benar Salah: klien mengirim ID pilihan
                    $pilihanTerpilih = PilihanSoal::where('id_soal', $idSoal)
                        ->where('id_pilihan', (int) $jawabanInput)
                        ->first();

                    $pilihanBenar = PilihanSoal::where('id_soal', $idSoal)
                        ->where('is_correct', true)
                        ->first();

                    $isBenar = $pilihanTerpilih ? (bool) $pilihanTerpilih->is_correct : false;
                    $kunciJawabanTeks = $pilihanBenar ? $pilihanBenar->teks_pilihan : '';
                }
            }

            $poinDidapat = 0;
            $multiplierSaatIni = $this->hitungMultiplier($sesi->jumlah_benar);

            if ($isBenar) {
                $poinDasar = match ($soal->tingkat_soal) {
                    'sulit' => (int) DungeonPengaturan::getNilai('poin_dasar_sulit', 30),
                    'sedang' => (int) DungeonPengaturan::getNilai('poin_dasar_sedang', 20),
                    default => (int) DungeonPengaturan::getNilai('poin_dasar_mudah', 10),
                };

                $poinDidapat = (int) round($poinDasar * $multiplierSaatIni);
                $sesi->skor_dungeon += $poinDidapat;
                $sesi->jumlah_benar += 1;

                $lantaiBaru = (int) floor($sesi->jumlah_benar / 5) + 1;
                $sesi->lantai_tertinggi = max($sesi->lantai_tertinggi, $lantaiBaru);

                // Update riwayat times_correct
                DungeonRiwayatSoal::where('id_user', $sesi->id_user)
                    ->where('id_soal', $idSoal)
                    ->increment('times_correct');
            } else {
                $sesi->jumlah_salah += 1;
                $sesi->nyawa = max(0, $sesi->nyawa - 1);
            }

            $sesiSoal->is_benar = $isBenar;
            $sesiSoal->poin_didapat = $poinDidapat;
            $sesiSoal->save();

            $sesi->save();

            // Cek kondisi game over
            $petualanganBerakhir = false;
            $alasanSelesai = null;

            if ($sesi->nyawa <= 0) {
                $petualanganBerakhir = true;
                $alasanSelesai = 'nyawa_habis';
            }

            $soalBerikutnyaPayload = null;
            if (!$petualanganBerakhir) {
                $soalBerikutnya = $this->pilihSoalBerikutnya($sesi);
                if ($soalBerikutnya) {
                    $soalBerikutnyaPayload = $this->siapkanSoalUntukPemain($sesi, $soalBerikutnya);
                } else {
                    // Tidak ada soal lagi -> Dungeon Tuntas!
                    $petualanganBerakhir = true;
                    $alasanSelesai = 'tuntas';
                }
            }

            if ($petualanganBerakhir) {
                $sesi = $this->tutupSesi($sesi, $alasanSelesai);
            } else {
                $sesi->multiplier_akhir = $this->hitungMultiplier($sesi->jumlah_benar);
                $sesi->save();
            }

            return [
                'is_benar' => $isBenar,
                'is_timeout' => $isTimeout,
                'kunci_jawaban' => $kunciJawabanTeks,
                'poin_didapat' => $poinDidapat,
                'status_sesi' => [
                    'nyawa' => $sesi->nyawa,
                    'lantai' => $sesi->lantai_tertinggi,
                    'skor_dungeon' => $sesi->skor_dungeon,
                    'multiplier' => $this->hitungMultiplier($sesi->jumlah_benar),
                    'jumlah_benar' => $sesi->jumlah_benar,
                    'jumlah_salah' => $sesi->jumlah_salah,
                    'selesai' => (bool) $sesi->selesai,
                    'alasan_selesai' => $sesi->alasan_selesai,
                    'poin_profil_didapat' => (int) ($sesi->poin_profil_didapat ?? 0),
                ],
                'soal_berikutnya' => $soalBerikutnyaPayload,
            ];
        });
    }

    /**
     * Menutup sesi dungeon secara idempoten dan membagikan poin profil.
     */
    public function tutupSesi(DungeonSesi $sesi, string $alasan = 'keluar'): DungeonSesi
    {
        return DB::transaction(function () use ($sesi, $alasan) {
            $sesi = DungeonSesi::where('id', $sesi->id)->lockForUpdate()->firstOrFail();

            if ($sesi->selesai !== null) {
                return $sesi;
            }

            // Jika ada soal yang sedang tampil dan belum dijawab, tandai tidak dijawab (poin 0)
            $soalAktif = DungeonSesiSoal::where('id_sesi', $sesi->id)
                ->whereNull('jawaban_user')
                ->first();

            if ($soalAktif) {
                $soalAktif->update([
                    'jawaban_user' => '[dibatalkan]',
                    'is_benar' => false,
                    'poin_didapat' => 0,
                ]);
            }

            $multiplierAkhir = $this->hitungMultiplier($sesi->jumlah_benar);

            $sesi->selesai = now();
            $sesi->alasan_selesai = $alasan;
            $sesi->multiplier_akhir = $multiplierAkhir;
            $sesi->kunci_aktif = null;

            // Hitung dan berikan poin profil
            $totalTerjawab = $sesi->jumlah_benar + $sesi->jumlah_salah;
            $minSoalPoin = (int) DungeonPengaturan::getNilai('min_soal_poin_profil', 5);
            $poinProfil = 0;

            if (!$sesi->is_uji_coba && !$sesi->poin_sudah_diberikan && $totalTerjawab >= $minSoalPoin) {
                $rasioPoin = (float) DungeonPengaturan::getNilai('rasio_poin_profil', 0.05);
                $poinMinRonde = (int) DungeonPengaturan::getNilai('poin_minimal_ronde', 5);
                $maksPoinRonde = (int) DungeonPengaturan::getNilai('maks_poin_profil_ronde', 100);

                $dasar = max($poinMinRonde, (int) floor($sesi->skor_dungeon * $rasioPoin));

                if ($alasan === 'tuntas') {
                    $bonusTuntasPersen = (float) DungeonPengaturan::getNilai('bonus_dungeon_tuntas_persen', 0.20);
                    $dasar += (int) floor($dasar * $bonusTuntasPersen);
                }

                // Cek rekor pribadi di mapel ini
                $rekorLama = DungeonSesi::where('id_user', $sesi->id_user)
                    ->where('id_mapel', $sesi->id_mapel)
                    ->where('id', '!=', $sesi->id)
                    ->where('is_uji_coba', false)
                    ->whereNotNull('selesai')
                    ->max('skor_dungeon') ?? 0;

                if ($sesi->skor_dungeon > $rekorLama) {
                    $bonusRekor = (int) DungeonPengaturan::getNilai('bonus_rekor_pribadi', 10);
                    $dasar += $bonusRekor;
                }

                $poinProfil = min($maksPoinRonde, $dasar);

                // Batas harian jika disetel
                $batasHarian = DungeonPengaturan::getNilai('batas_harian', null);
                if ($batasHarian !== null && is_numeric($batasHarian)) {
                    $poinHariIni = DungeonSesi::where('id_user', $sesi->id_user)
                        ->where('id', '!=', $sesi->id)
                        ->where('is_uji_coba', false)
                        ->whereDate('selesai', today())
                        ->sum('poin_profil_didapat');

                    $sisaJatah = max(0, (int) $batasHarian - (int) $poinHariIni);
                    $poinProfil = min($poinProfil, $sisaJatah);
                }

                if ($poinProfil > 0) {
                    $user = User::where('id_user', $sesi->id_user)->lockForUpdate()->first();
                    if ($user) {
                        $user->increment('total_poin', $poinProfil);
                        if (class_exists(Achievement::class)) {
                            Achievement::syncForUser($user);
                        }
                        $user->refreshRankTier();
                    }
                }

                $sesi->poin_profil_didapat = $poinProfil;
                $sesi->poin_sudah_diberikan = true;
            }

            $sesi->save();
            return $sesi;
        });
    }

    /**
     * Hitung multiplier: min(3.0, 1 + 0.25 * floor(jumlah_benar / 5)).
     */
    public function hitungMultiplier(?int $jumlahBenar = 0): float
    {
        $benar = (int) ($jumlahBenar ?? 0);
        return (float) min(3.0, 1.0 + (0.25 * floor($benar / 5)));
    }

    /**
     * Menutup sesi basi untuk pemain tertentu secara lazy.
     */
    public function tutupSesiBasi(User $user): void
    {
        $sesiAktif = DungeonSesi::where('kunci_aktif', $user->id_user)->first();
        if (!$sesiAktif) {
            return;
        }

        $soalAktif = DungeonSesiSoal::where('id_sesi', $sesiAktif->id)
            ->whereNull('jawaban_user')
            ->latest('id')
            ->first();

        $toleransi = (int) DungeonPengaturan::getNilai('toleransi_jaringan', 2);
        $waktuSekarang = now();

        $isBasi = false;
        if ($soalAktif) {
            // Jika batas waktu soal + toleransi + 30 detik sudah terlewati
            $expiredAt = Carbon::parse($soalAktif->batas_waktu)->addSeconds($toleransi + 30);
            if ($waktuSekarang->greaterThan($expiredAt)) {
                $isBasi = true;
            }
        } else {
            // Jika sesi sudah dibuat lebih dari 1 jam lalu tanpa ada soal aktif
            if ($waktuSekarang->diffInHours(Carbon::parse($sesiAktif->mulai)) >= 1) {
                $isBasi = true;
            }
        }

        if ($isBasi) {
            $this->tutupSesi($sesiAktif, 'timeout');
        }
    }

    /**
     * Menutup seluruh sesi yang sudah basi secara massal (dipanggil via scheduler/cron).
     */
    public function autoCloseAllStaleSessions(): int
    {
        $sesiBasiList = DungeonSesi::whereNotNull('kunci_aktif')
            ->whereNull('selesai')
            ->get();

        $closedCount = 0;
        foreach ($sesiBasiList as $sesi) {
            $soalAktif = DungeonSesiSoal::where('id_sesi', $sesi->id)
                ->whereNull('jawaban_user')
                ->latest('id')
                ->first();

            $toleransi = (int) DungeonPengaturan::getNilai('toleransi_jaringan', 2);
            $waktuSekarang = now();
            $isBasi = false;

            if ($soalAktif) {
                $expiredAt = Carbon::parse($soalAktif->batas_waktu)->addSeconds($toleransi + 30);
                if ($waktuSekarang->greaterThan($expiredAt)) {
                    $isBasi = true;
                }
            } else {
                if ($waktuSekarang->diffInHours(Carbon::parse($sesi->mulai)) >= 1) {
                    $isBasi = true;
                }
            }

            if ($isBasi) {
                $this->tutupSesi($sesi, 'timeout');
                $closedCount++;
            }
        }

        return $closedCount;
    }

    /**
     * Melaporkan soal dan menonaktifkan soal secara otomatis jika mencapai ambang batas laporan.
     */
    public function laporkanSoal(int $idSoal, User $user, string $alasan): array
    {
        $laporan = DungeonLaporanSoal::updateOrCreate(
            ['id_soal' => $idSoal, 'id_user' => $user->id_user],
            ['alasan' => $alasan, 'status' => 'menunggu']
        );

        $ambang = (int) DungeonPengaturan::getNilai('ambang_soal_dinonaktifkan', 3);
        $totalLaporan = DungeonLaporanSoal::where('id_soal', $idSoal)->distinct('id_user')->count('id_user');

        $dinonaktifkan = false;
        if ($totalLaporan >= $ambang) {
            Soal::where('id_soal', $idSoal)->update([
                'aktif' => false,
                'nonaktif_alasan' => "Dinonaktifkan otomatis: menerima {$totalLaporan} laporan dari pemain berbeda.",
            ]);
            $dinonaktifkan = true;
        }

        return [
            'laporan' => $laporan,
            'total_laporan' => $totalLaporan,
            'dinonaktifkan' => $dinonaktifkan,
        ];
    }
}

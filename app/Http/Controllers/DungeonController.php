<?php

namespace App\Http\Controllers;

use App\Models\DungeonLaporanSoal;
use App\Models\DungeonSesi;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Models\Quiz;
use App\Models\Soal;
use App\Services\DungeonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DungeonController extends Controller
{
    public function __construct(protected DungeonService $dungeonService)
    {
    }

    /**
     * Helper resolve Mapel model dari id atau nama.
     */
    protected function resolveMapel(mixed $mapelId): Mapel
    {
        if (is_numeric($mapelId)) {
            return Mapel::findOrFail((int) $mapelId);
        }
        return Mapel::where('nama_mapel', $mapelId)->firstOrFail();
    }

    /**
     * Katalog Dungeon per mata pelajaran.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isStaff = $user->isAdmin() || $user->isGuru();

        $selectedJenjangId = $request->query('jenjang', $user->id_jenjang ?? 1);
        if (!$isStaff && $user->id_jenjang) {
            $selectedJenjangId = $user->id_jenjang;
        }

        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        $selectedJenjang = Jenjang::find($selectedJenjangId) ?? $jenjangList->first();

        // Ambil mapel yang berlaku untuk jenjang ini (lintas jenjang / null, atau mapel jenjang spesifik)
        $mapelList = Mapel::where(function ($q) use ($selectedJenjang) {
                $q->whereNull('id_jenjang')
                  ->orWhere('id_jenjang', $selectedJenjang->id_jenjang ?? 1);
            })
            ->orderBy('nama_mapel')
            ->get();

        $dungeonData = [];
        foreach ($mapelList as $mapel) {
            if ($isStaff) {
                // Pastikan kuis dungeon mapel ini sudah ada di sistem agar siap menerima soal
                $this->dungeonService->ensureDungeonQuiz($mapel->id_mapel, $selectedJenjang->id_jenjang ?? 1);
            }

            $status = $this->dungeonService->cekStatusDungeon($mapel->id_mapel, $selectedJenjang->id_jenjang ?? 1);

            // Rekor tertinggi pemain di mapel ini
            $rekorPemain = DungeonSesi::where('id_user', $user->id_user)
                ->where('id_mapel', $mapel->id_mapel)
                ->where('is_uji_coba', false)
                ->whereNotNull('selesai')
                ->max('skor_dungeon') ?? 0;

            $lantaiTertinggi = DungeonSesi::where('id_user', $user->id_user)
                ->where('id_mapel', $mapel->id_mapel)
                ->where('is_uji_coba', false)
                ->whereNotNull('selesai')
                ->max('lantai_tertinggi') ?? 1;

            // Sesi aktif jika ada
            $sesiAktif = DungeonSesi::where('kunci_aktif', $user->id_user)
                ->where('id_mapel', $mapel->id_mapel)
                ->first();

            $dungeonData[] = [
                'mapel' => $mapel,
                'quiz' => $status['quiz'] ?? null,
                'quiz_id' => $status['quiz']?->id_quiz ?? null,
                'status' => $status,
                'rekor_skor' => $rekorPemain,
                'lantai_tertinggi' => $lantaiTertinggi,
                'sesi_aktif' => $sesiAktif,
                'bisa_main' => $status['terbuka'] || $isStaff,
            ];
        }

        $pendingReportsCount = $isStaff
            ? DungeonLaporanSoal::where('status', 'menunggu')->count()
            : 0;

        $regularQuizzesByMapel = [];
        if ($isStaff) {
            $quizzes = Quiz::bukanDungeon()
                ->where('proggressQuiz', '!=', 'Draft')
                ->where(function ($q) use ($selectedJenjang) {
                    $q->whereNull('id_jenjang')
                      ->orWhere('id_jenjang', $selectedJenjang->id_jenjang ?? 1);
                })
                ->withCount('soal')
                ->with('tingkatQuiz')
                ->orderBy('judul')
                ->get();

            foreach ($quizzes as $qz) {
                if ($qz->id_mapel && $qz->soal_count > 0) {
                    $regularQuizzesByMapel[$qz->id_mapel][] = [
                        'id_quiz' => $qz->id_quiz,
                        'judul' => $qz->judul,
                        'total_soal' => $qz->soal_count,
                        'tingkat' => $qz->tingkatQuiz->nama_tingkat ?? 'Umum',
                    ];
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'jenjang_terpilih' => $selectedJenjang,
                'dungeon_list' => $dungeonData,
            ]);
        }

        return view('dungeon.index', [
            'jenjangList' => $jenjangList,
            'selectedJenjang' => $selectedJenjang,
            'dungeonData' => $dungeonData,
            'isStaff' => $isStaff,
            'pendingReportsCount' => $pendingReportsCount,
            'regularQuizzesByMapel' => $regularQuizzesByMapel,
        ]);
    }

    /**
     * Arena / Game Hub Dungeon per mapel.
     */
    public function show(Request $request, mixed $mapelId)
    {
        $user = Auth::user();
        $isStaff = $user->isAdmin() || $user->isGuru();
        $mapel = $this->resolveMapel($mapelId);

        $idJenjang = ($isStaff && $request->filled('jenjang'))
            ? (int) $request->input('jenjang')
            : ($user->id_jenjang ?? $mapel->id_jenjang ?? 1);

        $statusDungeon = $this->dungeonService->cekStatusDungeon($mapel->id_mapel, $idJenjang);

        $sesiAktif = DungeonSesi::where('kunci_aktif', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->first();

        $soalAktif = $sesiAktif ? $this->dungeonService->ambilSoalAktif($sesiAktif) : null;

        $rekorPribadi = DungeonSesi::where('id_user', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->where('is_uji_coba', false)
            ->whereNotNull('selesai')
            ->max('skor_dungeon') ?? 0;

        $lantaiTertinggi = DungeonSesi::where('id_user', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->where('is_uji_coba', false)
            ->whereNotNull('selesai')
            ->max('lantai_tertinggi') ?? 1;

        if ($request->wantsJson()) {
            return response()->json([
                'mapel' => $mapel,
                'status_dungeon' => $statusDungeon,
                'sesi_aktif' => $sesiAktif,
                'soal_aktif' => $soalAktif,
                'rekor_pribadi' => $rekorPribadi,
                'lantai_tertinggi' => $lantaiTertinggi,
            ]);
        }

        return view('dungeon.arena', [
            'mapel' => $mapel,
            'idJenjang' => $idJenjang,
            'statusDungeon' => $statusDungeon,
            'sesiAktif' => $sesiAktif,
            'soalAktif' => $soalAktif,
            'rekorPribadi' => $rekorPribadi,
            'lantaiTertinggi' => $lantaiTertinggi,
            'isStaff' => $isStaff,
        ]);
    }

    /**
     * Memulai sesi permainan Dungeon baru atau melanjutkan sesi aktif.
     */
    public function mulai(Request $request, mixed $mapelId): JsonResponse
    {
        $user = Auth::user();
        $isStaff = $user->isAdmin() || $user->isGuru();
        $mapel = $this->resolveMapel($mapelId);

        $isUjiCoba = $isStaff && $request->boolean('uji_coba', false);
        $idJenjangOverride = ($isStaff && $request->filled('id_jenjang'))
            ? (int) $request->input('id_jenjang')
            : ($user->id_jenjang ?? $mapel->id_jenjang ?? 1);

        try {
            $hasil = $this->dungeonService->mulaiSesi(
                user: $user,
                idMapel: $mapel->id_mapel,
                isUjiCoba: $isUjiCoba,
                idJenjangOverride: $idJenjangOverride
            );

            return response()->json([
                'success' => true,
                'sesi' => $hasil['sesi'],
                'soal' => $hasil['soal'],
                'is_resume' => $hasil['is_resume'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memulai petualangan Dungeon: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mengambil soal yang sedang aktif pada sesi pemain.
     */
    public function ambilSoalAktif(Request $request, mixed $mapelId): JsonResponse
    {
        $user = Auth::user();
        $mapel = $this->resolveMapel($mapelId);

        $sesi = DungeonSesi::where('kunci_aktif', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada petualangan Dungeon yang sedang aktif.',
            ], 404);
        }

        $soal = $this->dungeonService->ambilSoalAktif($sesi);
        if (!$soal) {
            // Jika tidak ada soal aktif, mungkin sudah tuntas atau perlu dipilihkan soal baru
            $soalBaru = $this->dungeonService->pilihSoalBerikutnya($sesi);
            if ($soalBaru) {
                $soal = $this->dungeonService->siapkanSoalUntukPemain($sesi, $soalBaru);
            } else {
                $sesi = $this->dungeonService->tutupSesi($sesi, 'tuntas');
                return response()->json([
                    'success' => true,
                    'sesi' => $sesi,
                    'soal' => null,
                    'selesai' => true,
                    'alasan' => 'tuntas',
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'sesi' => $sesi,
            'soal' => $soal,
        ]);
    }

    /**
     * Mengirimkan jawaban untuk soal aktif.
     */
    public function jawab(Request $request, mixed $mapelId): JsonResponse
    {
        $request->validate([
            'id_soal' => 'required|integer',
            'jawaban' => 'required',
        ]);

        $user = Auth::user();
        $mapel = $this->resolveMapel($mapelId);

        $sesi = DungeonSesi::where('kunci_aktif', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada petualangan yang aktif atau petualangan sudah berakhir.',
            ], 400);
        }

        $idSoal = (int) $request->input('id_soal');
        $jawaban = $request->input('jawaban');

        try {
            $hasil = $this->dungeonService->jawabSoal($sesi, $idSoal, $jawaban);

            return response()->json([
                'success' => true,
                'hasil' => $hasil,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses jawaban: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Menyerah / Mengakhiri petualangan dungeon.
     */
    public function selesai(Request $request, mixed $mapelId): JsonResponse
    {
        $user = Auth::user();
        $mapel = $this->resolveMapel($mapelId);

        $sesi = DungeonSesi::where('kunci_aktif', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada sesi Dungeon aktif yang ditemukan.',
            ], 404);
        }

        $sesiTertutup = $this->dungeonService->tutupSesi($sesi, 'keluar');

        return response()->json([
            'success' => true,
            'message' => 'Petualangan berhasil diakhiri.',
            'sesi' => $sesiTertutup,
        ]);
    }

    /**
     * Melaporkan soal yang memiliki kesalahan atau masalah.
     */
    public function lapor(Request $request, mixed $mapelId): JsonResponse
    {
        $request->validate([
            'id_soal' => 'required|integer|exists:soal,id_soal',
            'alasan' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $idSoal = (int) $request->input('id_soal');
        $alasan = trim($request->input('alasan'));

        $hasil = $this->dungeonService->laporkanSoal($idSoal, $user, $alasan);

        return response()->json([
            'success' => true,
            'message' => 'Laporan soal berhasil dikirim. Terima kasih atas bantuan Anda menjaga kualitas soal!',
            'data' => $hasil,
        ]);
    }

    /**
     * Riwayat Petualangan Dungeon Pemain.
     */
    public function riwayat(Request $request)
    {
        $user = Auth::user();

        $riwayat = DungeonSesi::with(['mapel', 'user'])
            ->where('id_user', $user->id_user)
            ->whereNotNull('selesai')
            ->orderByDesc('selesai')
            ->paginate(15);

        if ($request->wantsJson()) {
            return response()->json($riwayat);
        }

        return view('dungeon.riwayat', [
            'riwayat' => $riwayat,
        ]);
    }

    /**
     * Dashboard Bank Soal Dungeon untuk Admin & Guru.
     */
    public function adminBank(Request $request)
    {
        $user = Auth::user();
        $selectedJenjangId = (int) $request->query('jenjang', 1);

        $jenjangList = Jenjang::orderBy('id_jenjang')->get();
        $selectedJenjang = Jenjang::find($selectedJenjangId) ?? $jenjangList->first();

        $dungeonQuizzes = Quiz::where('id_jenjang', $selectedJenjang->id_jenjang ?? 1)
            ->whereHas('tipeQuiz', fn($q) => $q->whereRaw("LOWER(COALESCE(nama_tipe, '')) = 'dungeon'"))
            ->with(['mapel', 'soal' => fn($q) => $q->with('penulis')])
            ->get();

        $bankData = $dungeonQuizzes->map(function ($q) {
            $soals = $q->soal;
            $status = $this->dungeonService->cekStatusDungeon($q->id_mapel, $q->id_jenjang);

            return [
                'quiz' => $q,
                'mapel' => $q->mapel,
                'total_soal' => $soals->count(),
                'total_aktif' => $soals->where('aktif', true)->count(),
                'total_nonaktif' => $soals->where('aktif', false)->count(),
                'mudah' => $soals->where('aktif', true)->where('tingkat_soal', 'mudah')->count(),
                'sedang' => $soals->where('aktif', true)->where('tingkat_soal', 'sedang')->count(),
                'sulit' => $soals->where('aktif', true)->where('tingkat_soal', 'sulit')->count(),
                'status_dungeon' => $status,
                'soal_list' => $soals,
            ];
        });

        if ($request->wantsJson()) {
            return response()->json([
                'jenjang' => $selectedJenjang,
                'bank_data' => $bankData,
            ]);
        }

        return view('admin.dungeon.bank', [
            'jenjangList' => $jenjangList,
            'selectedJenjang' => $selectedJenjang,
            'bankData' => $bankData,
        ]);
    }

    /**
     * Antrean moderasi laporan soal Dungeon.
     */
    public function adminLaporan(Request $request)
    {
        $statusFilter = $request->query('status', 'menunggu');

        $query = DungeonLaporanSoal::with(['soal.quiz.mapel', 'soal.quiz.jenjang', 'user'])
            ->orderByDesc('id');

        if ($statusFilter !== 'semua') {
            $query->where('status', $statusFilter);
        }

        $laporanList = $query->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($laporanList);
        }

        return view('admin.dungeon.laporan', [
            'laporanList' => $laporanList,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Memutuskan status laporan soal (nonaktifkan, pulihkan, tolak).
     */
    public function adminPutuskanLaporan(Request $request, $idLaporan): JsonResponse
    {
        $request->validate([
            'tindakan' => 'required|in:nonaktifkan,pulihkan,tolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $laporan = DungeonLaporanSoal::with('soal')->findOrFail($idLaporan);
        $tindakan = $request->input('tindakan');
        $catatan = $request->input('catatan');

        if ($tindakan === 'nonaktifkan') {
            $laporan->status = 'diterima';
            $laporan->soal->update([
                'aktif' => false,
                'nonaktif_alasan' => $catatan ?? 'Dinonaktifkan oleh guru/admin via moderasi laporan.',
            ]);
        } elseif ($tindakan === 'pulihkan') {
            $laporan->status = 'dipulihkan';
            $laporan->soal->update([
                'aktif' => true,
                'nonaktif_alasan' => null,
            ]);
        } else {
            // Tolak laporan
            $laporan->status = 'ditolak';
        }

        $laporan->save();

        return response()->json([
            'success' => true,
            'message' => 'Keputusan laporan soal berhasil disimpan.',
            'laporan' => $laporan,
        ]);
    }

    /**
     * Toggle status aktif / nonaktif soal.
     */
    public function adminToggleSoal(Request $request, $idSoal): JsonResponse
    {
        $soal = Soal::findOrFail($idSoal);
        $baruAktif = !$soal->aktif;

        $soal->aktif = $baruAktif;
        if (!$baruAktif) {
            $soal->nonaktif_alasan = $request->input('alasan', 'Dinonaktifkan secara manual oleh admin/guru.');
        } else {
            $soal->nonaktif_alasan = null;
        }
        $soal->save();

        return response()->json([
            'success' => true,
            'aktif' => $soal->aktif,
            'message' => $soal->aktif ? 'Soal berhasil diaktifkan kembali.' : 'Soal berhasil dinonaktifkan.',
        ]);
    }

    /**
     * Impor / salin soal dari kuis biasa ke kuis Dungeon mapel terkait.
     */
    public function imporSoal(Request $request, mixed $mapelId)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isGuru())) {
            abort(403, 'Hanya Admin dan Guru yang dapat mengimpor soal ke Dungeon.');
        }

        $mapel = $this->resolveMapel($mapelId);
        $validated = $request->validate([
            'id_jenjang' => 'required|integer|exists:jenjang,id_jenjang',
            'id_quiz_asal' => 'required|integer|exists:quiz,id_quiz',
            'tingkat_soal' => 'required|in:mudah,sedang,sulit,otomatis',
        ]);

        $quizAsal = Quiz::with('soal.pilihanSoal')->findOrFail($validated['id_quiz_asal']);
        $dungeonQuiz = $this->dungeonService->ensureDungeonQuiz($mapel->id_mapel, (int) $validated['id_jenjang']);

        if (!$dungeonQuiz) {
            return back()->with('error', 'Kuis Dungeon untuk mapel ini belum tersedia.');
        }

        $tingkatPilihan = $validated['tingkat_soal'];
        $importedCount = 0;
        $skippedCount = 0;

        foreach ($quizAsal->soal as $soalAsal) {
            $pertanyaanTrim = trim((string) $soalAsal->pertanyaan);
            if ($pertanyaanTrim === '') {
                continue;
            }

            // Cek apakah soal dengan pertanyaan sama sudah ada di kuis dungeon ini
            $alreadyExists = Soal::where('id_quiz', $dungeonQuiz->id_quiz)
                ->where('pertanyaan', $pertanyaanTrim)
                ->exists();

            if ($alreadyExists) {
                $skippedCount++;
                continue;
            }

            // Tentukan tingkat soal
            $tingkat = $tingkatPilihan;
            if ($tingkat === 'otomatis') {
                $tingkat = match ((int) $quizAsal->id_tingkatquiz) {
                    1 => 'mudah',
                    3 => 'sulit',
                    default => 'sedang',
                };
            }

            // Aturan Dungeon: Soal Benar/Salah (id_jenis_soal = 3) wajib tingkat Mudah
            if ((int) $soalAsal->id_jenis_soal === 3) {
                $tingkat = 'mudah';
            }

            $durasiDetik = match ($tingkat) {
                'sulit' => 60,
                'sedang' => 30,
                default => 20,
            };

            $newSoal = Soal::create([
                'id_quiz' => $dungeonQuiz->id_quiz,
                'id_jenjang' => (int) $validated['id_jenjang'],
                'id_jenis_soal' => $soalAsal->id_jenis_soal,
                'pertanyaan' => $pertanyaanTrim,
                'tingkat_soal' => $tingkat,
                'jawaban_benar' => $soalAsal->jawaban_benar,
                'id_penulis' => $user->id_user,
                'aktif' => true,
                'poin' => 10,
                'durasi_detik' => $soalAsal->durasi_detik ?: $durasiDetik,
                'foto_soal' => $soalAsal->foto_soal,
            ]);

            foreach ($soalAsal->pilihanSoal as $pilihan) {
                \App\Models\PilihanSoal::create([
                    'id_soal' => $newSoal->id_soal,
                    'label' => $pilihan->label,
                    'teks_pilihan' => $pilihan->teks_pilihan,
                    'is_correct' => (bool) $pilihan->is_correct,
                    'tetap_di_bawah' => (bool) ($pilihan->tetap_di_bawah ?? false),
                ]);
            }

            $importedCount++;
        }

        $pesan = "Berhasil menyalin {$importedCount} soal dari \"{$quizAsal->judul}\" ke Dungeon {$mapel->nama_mapel}!";
        if ($skippedCount > 0) {
            $pesan .= " ({$skippedCount} soal dilewati karena sudah ada di dungeon).";
        }

        return redirect()->route('dungeon.index', ['jenjang' => $validated['id_jenjang']])
            ->with('success', $pesan);
    }
}

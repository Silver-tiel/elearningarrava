<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DungeonSesi;
use App\Models\Jenjang;
use App\Models\Mapel;
use App\Services\DungeonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DungeonApiController extends Controller
{
    public function __construct(protected DungeonService $dungeonService)
    {
    }

    protected function resolveMapel(mixed $mapelId): Mapel
    {
        if (is_numeric($mapelId)) {
            return Mapel::findOrFail((int) $mapelId);
        }
        return Mapel::where('nama_mapel', $mapelId)->firstOrFail();
    }

    /**
     * List mata pelajaran dan status dungeon untuk jenjang pemain.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $idJenjang = $user->id_jenjang ?? 1;

        $mapelList = Mapel::forJenjang($idJenjang)
            ->orderBy('nama_mapel')
            ->get();

        $dungeons = [];
        foreach ($mapelList as $mapel) {
            $status = $this->dungeonService->cekStatusDungeon($mapel->id_mapel, $idJenjang);

            $rekor = DungeonSesi::where('id_user', $user->id_user)
                ->where('id_mapel', $mapel->id_mapel)
                ->where('is_uji_coba', false)
                ->whereNotNull('selesai')
                ->max('skor_dungeon') ?? 0;

            $lantai = DungeonSesi::where('id_user', $user->id_user)
                ->where('id_mapel', $mapel->id_mapel)
                ->where('is_uji_coba', false)
                ->whereNotNull('selesai')
                ->max('lantai_tertinggi') ?? 1;

            $sesiAktif = DungeonSesi::where('kunci_aktif', $user->id_user)
                ->where('id_mapel', $mapel->id_mapel)
                ->first();

            $dungeons[] = [
                'id_mapel' => $mapel->id_mapel,
                'nama_mapel' => $mapel->nama_mapel,
                'terbuka' => $status['terbuka'],
                'alasan_terkunci' => $status['alasan'],
                'total_soal' => $status['total_soal'],
                'rekor_skor' => $rekor,
                'lantai_tertinggi' => $lantai,
                'ada_sesi_aktif' => $sesiAktif !== null,
            ];
        }

        return response()->json([
            'success' => true,
            'id_jenjang' => $idJenjang,
            'dungeons' => $dungeons,
        ]);
    }

    /**
     * Detail status dungeon untuk mapel tertentu.
     */
    public function status(Request $request, mixed $mapelId): JsonResponse
    {
        $user = $request->user();
        $mapel = $this->resolveMapel($mapelId);
        $idJenjang = $user->id_jenjang ?? $mapel->id_jenjang ?? 1;

        $status = $this->dungeonService->cekStatusDungeon($mapel->id_mapel, $idJenjang);

        $sesiAktif = DungeonSesi::where('kunci_aktif', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->first();

        $soalAktif = $sesiAktif ? $this->dungeonService->ambilSoalAktif($sesiAktif) : null;

        $rekor = DungeonSesi::where('id_user', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->where('is_uji_coba', false)
            ->whereNotNull('selesai')
            ->max('skor_dungeon') ?? 0;

        return response()->json([
            'success' => true,
            'mapel' => [
                'id_mapel' => $mapel->id_mapel,
                'nama_mapel' => $mapel->nama_mapel,
            ],
            'status_dungeon' => $status,
            'rekor_pribadi' => $rekor,
            'sesi_aktif' => $sesiAktif,
            'soal_aktif' => $soalAktif,
        ]);
    }

    /**
     * Mulai sesi dungeon baru atau resume sesi aktif.
     */
    public function mulai(Request $request, mixed $mapelId): JsonResponse
    {
        $user = $request->user();
        $mapel = $this->resolveMapel($mapelId);

        $isStaff = $user->isAdmin() || $user->isGuru();
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
     * Ambil soal yang sedang aktif pada sesi pemain.
     */
    public function ambilSoalAktif(Request $request, mixed $mapelId): JsonResponse
    {
        $user = $request->user();
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
     * Mengirimkan jawaban untuk soal dungeon.
     */
    public function jawab(Request $request, mixed $mapelId): JsonResponse
    {
        $request->validate([
            'id_soal' => 'required|integer',
            'jawaban' => 'required',
        ]);

        $user = $request->user();
        $mapel = $this->resolveMapel($mapelId);

        $sesi = DungeonSesi::where('kunci_aktif', $user->id_user)
            ->where('id_mapel', $mapel->id_mapel)
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada sesi Dungeon aktif yang sedang berjalan.',
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
     * Mengakhiri / Menyerah dari sesi petualangan.
     */
    public function selesai(Request $request, mixed $mapelId): JsonResponse
    {
        $user = $request->user();
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
            'message' => 'Petualangan selesai.',
            'sesi' => $sesiTertutup,
        ]);
    }

    /**
     * Melaporkan soal.
     */
    public function lapor(Request $request, mixed $mapelId): JsonResponse
    {
        $request->validate([
            'id_soal' => 'required|integer|exists:soal,id_soal',
            'alasan' => 'required|string|max:500',
        ]);

        $user = $request->user();
        $idSoal = (int) $request->input('id_soal');
        $alasan = trim($request->input('alasan'));

        $hasil = $this->dungeonService->laporkanSoal($idSoal, $user, $alasan);

        return response()->json([
            'success' => true,
            'message' => 'Laporan soal berhasil dikirim.',
            'data' => $hasil,
        ]);
    }

    /**
     * Riwayat Dungeon pemain.
     */
    public function riwayat(Request $request): JsonResponse
    {
        $user = $request->user();

        $riwayat = DungeonSesi::with('mapel:id_mapel,nama_mapel')
            ->where('id_user', $user->id_user)
            ->whereNotNull('selesai')
            ->orderByDesc('selesai')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'riwayat' => $riwayat,
        ]);
    }
}

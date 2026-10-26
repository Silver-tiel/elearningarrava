<?php

namespace App\Http\Controllers;

use App\Models\HasilQuizModul;
use App\Models\Modul;
use App\Models\OrangtuaSiswa;
use App\Models\TipeModul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriPembelajaranController extends Controller
{
    public function index(Request $request)
    {
        $orangtuaId = Auth::id();

        /* --- Ambil daftar siswa milik orang tua --- */
        $siswaIds = OrangtuaSiswa::where('id_orangtua', $orangtuaId)->pluck('id_siswa');

        $siswaList = User::whereIn('id_user', $siswaIds)
            ->where('id_tipeuser', 3)
            ->with('jenjang')
            ->get();

        if ($siswaList->isEmpty()) {
            return view('orangtua.materi_pembelajaran', [
                'siswaList'    => $siswaList,
                'siswa'        => null,
                'moduls'       => collect(),
                'stats'        => null,
                'tipeList'     => collect(),
                'tipeAktif'    => null,
                'statusAktif'  => null,
                'searchQuery'  => null,
                'perPage'      => 8,
            ]);
        }

        /* --- Siswa aktif --- */
        $siswaId = $request->input('siswa_id', $siswaList->first()->id_user);
        $siswa   = $siswaList->firstWhere('id_user', $siswaId) ?? $siswaList->first();

        /* --- Filter --- */
        $tipeAktif   = $request->input('tipe');      // id_tipemodul
        $statusAktif = $request->input('status');    // 'selesai' | 'sedang' | 'belum'
        $searchQuery = $request->input('q');

        /* --- Query modul sesuai jenjang siswa --- */
        $modulQuery = Modul::with(['tipeModul', 'jenjang', 'quiz'])
            ->where('id_jenjang', $siswa->id_jenjang);

        if ($tipeAktif) {
            $modulQuery->where('id_tipemodul', $tipeAktif);
        }

        if ($searchQuery) {
            $modulQuery->where('judul_modul', 'like', '%' . $searchQuery . '%');
        }

        $allModuls = $modulQuery->orderBy('created_at')->get();

        /* --- ID quiz yang pernah lulus siswa --- */
        $lulusQuizIds = HasilQuizModul::where('id_user', $siswa->id_user)
            ->where('is_lulus', true)
            ->pluck('id_quiz')
            ->toArray();

        /* --- ID quiz yang pernah dikerjakan (tapi mungkin belum lulus) --- */
        $dikerjakanQuizIds = HasilQuizModul::where('id_user', $siswa->id_user)
            ->pluck('id_quiz')
            ->toArray();

        /* --- Map status progres per modul --- */
        $moduls = $allModuls->map(function ($modul) use ($lulusQuizIds, $dikerjakanQuizIds) {
            // Hitung progres (nilai terakhir jika ada quiz)
            $progres = 0;
            $statusLabel = 'Belum Dimulai';

            if ($modul->id_quiz) {
                if (in_array($modul->id_quiz, $lulusQuizIds)) {
                    $progres     = 100;
                    $statusLabel = 'Selesai';
                } elseif (in_array($modul->id_quiz, $dikerjakanQuizIds)) {
                    // Ambil nilai terakhir
                    $hasil = HasilQuizModul::where('id_user', request()->user()->id_user ?? 0)
                        ->where('id_quiz', $modul->id_quiz)
                        ->latest('waktu_dapat')
                        ->first();
                    $progres     = $hasil && $hasil->total_poin > 0
                        ? round(($hasil->poin_didapat / $hasil->total_poin) * 100)
                        : 0;
                    $statusLabel = 'Sedang Dipelajari';
                }
            } else {
                // Modul tanpa quiz — cek berdasarkan materi video aktif (hanya bisa dilihat/tidak)
                $statusLabel = 'Belum Dimulai';
                $progres     = 0;
            }

            $modul->progres      = $progres;
            $modul->status_label = $statusLabel;

            return $modul;
        });

        /* --- Filter status setelah map --- */
        if ($statusAktif === 'selesai') {
            $moduls = $moduls->filter(fn($m) => $m->status_label === 'Selesai');
        } elseif ($statusAktif === 'sedang') {
            $moduls = $moduls->filter(fn($m) => $m->status_label === 'Sedang Dipelajari');
        } elseif ($statusAktif === 'belum') {
            $moduls = $moduls->filter(fn($m) => $m->status_label === 'Belum Dimulai');
        }

        $moduls = $moduls->values();

        /* --- Statistik summary --- */
        $totalModul   = $allModuls->count();
        $selesai      = $allModuls->filter(fn($m) => in_array($m->id_quiz, $lulusQuizIds) && $m->id_quiz)->count();
        $sedang       = $allModuls->filter(fn($m) => !in_array($m->id_quiz, $lulusQuizIds) && in_array($m->id_quiz, $dikerjakanQuizIds) && $m->id_quiz)->count();
        $belum        = $totalModul - $selesai - $sedang;
        $targetPersen = $totalModul > 0 ? round(($selesai / $totalModul) * 100) : 0;

        // Jumlah mata pelajaran unik (dari nama jenjang atau tipe modul)
        $tipeUnik = $allModuls->groupBy('id_tipemodul')->count();

        $stats = [
            'total_modul'    => $totalModul,
            'selesai'        => $selesai,
            'sedang'         => $sedang,
            'belum'          => $belum,
            'target_persen'  => $targetPersen,
            'tipe_unik'      => $tipeUnik,
        ];

        /* --- Daftar tipe modul untuk filter --- */
        $tipeList = TipeModul::all();

        /* --- Pagination manual (8 per halaman) --- */
        $perPage     = 8;
        $currentPage = $request->input('page', 1);
        $paginated   = new \Illuminate\Pagination\LengthAwarePaginator(
            $moduls->forPage($currentPage, $perPage),
            $moduls->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('orangtua.materi_pembelajaran', [
            'siswaList'   => $siswaList,
            'siswa'       => $siswa,
            'moduls'      => $paginated,
            'stats'       => $stats,
            'tipeList'    => $tipeList,
            'tipeAktif'   => $tipeAktif,
            'statusAktif' => $statusAktif,
            'searchQuery' => $searchQuery,
            'perPage'     => $perPage,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\HasilQuizModul;
use App\Models\OrangtuaSiswa;
use App\Models\PencapaianUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PencapaianController extends Controller
{
    public function index(Request $request)
    {
        $orangtuaId = Auth::id();

        /* --- Daftar siswa milik orang tua --- */
        $siswaIds = OrangtuaSiswa::where('id_orangtua', $orangtuaId)->pluck('id_siswa');

        $siswaList = User::whereIn('id_user', $siswaIds)
            ->where('id_tipeuser', 3)
            ->with('jenjang')
            ->get();

        if ($siswaList->isEmpty()) {
            return view('orangtua.pencapaian', [
                'siswaList'         => $siswaList,
                'siswa'             => null,
                'diraih'            => collect(),
                'belumDiraih'       => collect(),
                'stats'             => null,
                'filterTab'         => 'semua',
                'filterKategori'    => null,
                'searchQuery'       => null,
            ]);
        }

        /* --- Siswa aktif --- */
        $siswaId = $request->input('siswa_id', $siswaList->first()->id_user);
        $siswa   = $siswaList->firstWhere('id_user', $siswaId) ?? $siswaList->first();

        /* --- Sync achievement berdasarkan poin terkini --- */
        Achievement::syncForUser($siswa);

        /* --- Semua achievement yang aktif --- */
        $allAchievements = Achievement::where('is_active', true)
            ->orderBy('minimal_poin_achivement')
            ->get();

        /* --- Pencapaian yang sudah diraih siswa --- */
        $pencapaianDiraih = PencapaianUser::where('id_user', $siswa->id_user)
            ->with('achievement')
            ->orderByDesc('waktu_pencapaian')
            ->get();

        $diraihAchievementIds = $pencapaianDiraih->pluck('id_achievement')->toArray();

        /* --- Filter tab --- */
        $filterTab     = $request->input('tab', 'semua');
        $filterKategori = $request->input('kategori');
        $searchQuery   = $request->input('q');

        /* --- Map: achievement diraih dengan data pencapaian --- */
        $diraih = $pencapaianDiraih->map(function ($p) {
            return [
                'id'              => $p->id_pencapaian,
                'id_achievement'  => $p->id_achievement,
                'nama'            => $p->nama,
                'deskripsi'       => $p->achievement?->deskripsi ?? '-',
                'poin'            => $p->achievement?->minimal_poin_achivement ?? 0,
                'gambar_url'      => $p->achievement?->gambar_url ?? null,
                'waktu'           => $p->waktu_pencapaian,
                'status'          => 'tercapai',
            ];
        });

        /* --- Achievement belum diraih --- */
        $belumDiraih = $allAchievements
            ->whereNotIn('id_achievement', $diraihAchievementIds)
            ->map(function ($a) use ($siswa) {
                $poinSiswa = (int) ($siswa->total_poin ?? 0);
                $poinTarget = (int) $a->minimal_poin_achivement;
                $progres = $poinTarget > 0 ? min(100, round($poinSiswa / $poinTarget * 100)) : 0;

                return [
                    'id'             => $a->id_achievement,
                    'id_achievement' => $a->id_achievement,
                    'nama'           => $a->nama_achivement,
                    'deskripsi'      => $a->deskripsi ?? '-',
                    'poin'           => $poinTarget,
                    'gambar_url'     => $a->gambar_url ?? null,
                    'waktu'          => null,
                    'status'         => $progres >= 100 ? 'sedang' : 'terkunci',
                    'progres'        => $progres,
                ];
            })->values();

        /* --- Gabungkan untuk filter "Semua" --- */
        $semuaItems = collect([
            ...$diraih->map(fn($d) => array_merge($d, ['_tipe' => 'diraih'])),
            ...$belumDiraih->map(fn($b) => array_merge($b, ['_tipe' => 'belum'])),
        ]);

        /* --- Terapkan search --- */
        if ($searchQuery) {
            $semuaItems = $semuaItems->filter(fn($item) =>
                str_contains(strtolower($item['nama']), strtolower($searchQuery)) ||
                str_contains(strtolower($item['deskripsi'] ?? ''), strtolower($searchQuery))
            );
            $diraih     = $diraih->filter(fn($item) =>
                str_contains(strtolower($item['nama']), strtolower($searchQuery))
            );
            $belumDiraih = $belumDiraih->filter(fn($item) =>
                str_contains(strtolower($item['nama']), strtolower($searchQuery))
            );
        }

        /* --- Statistik --- */
        $totalPoin   = (int) ($siswa->total_poin ?? 0);
        $totalLencana = $pencapaianDiraih->count();
        $totalAll    = $allAchievements->count();

        // Peringkat kelas: berapa siswa jenjang sama yang poinnya lebih tinggi
        $rankKelas = User::where('id_tipeuser', 3)
            ->where('id_jenjang', $siswa->id_jenjang)
            ->where('total_poin', '>', $totalPoin)
            ->count() + 1;

        // Total kuis dikerjakan untuk streak estimasi
        $totalKuisDikerjakan = HasilQuizModul::where('id_user', $siswa->id_user)->count();
        $kuisLulus           = HasilQuizModul::where('id_user', $siswa->id_user)->where('is_lulus', true)->count();

        // Level tier berdasarkan poin
        $level = match(true) {
            $totalPoin >= 5000 => ['level' => 10, 'nama' => 'Grandmaster', 'warna' => 'text-purple-600', 'bg' => 'bg-purple-50'],
            $totalPoin >= 3000 => ['level' => 8,  'nama' => 'Master',      'warna' => 'text-indigo-600', 'bg' => 'bg-indigo-50'],
            $totalPoin >= 1800 => ['level' => 6,  'nama' => 'Madya',       'warna' => 'text-blue-600',   'bg' => 'bg-blue-50'],
            $totalPoin >= 1000 => ['level' => 5,  'nama' => 'Mahir',       'warna' => 'text-sky-600',    'bg' => 'bg-sky-50'],
            $totalPoin >= 500  => ['level' => 4,  'nama' => 'Pemula',      'warna' => 'text-teal-600',   'bg' => 'bg-teal-50'],
            $totalPoin >= 200  => ['level' => 3,  'nama' => 'Dasar',       'warna' => 'text-emerald-600','bg' => 'bg-emerald-50'],
            $totalPoin >= 50   => ['level' => 2,  'nama' => 'Rintisan',    'warna' => 'text-green-600',  'bg' => 'bg-green-50'],
            default            => ['level' => 1,  'nama' => 'Starter',     'warna' => 'text-slate-600',  'bg' => 'bg-slate-100'],
        };

        $poinNextLevel = match($level['level']) {
            1 => 50, 2 => 200, 3 => 500, 4 => 1000, 5 => 1800,
            6 => 3000, 8 => 5000, default => null
        };

        $stats = [
            'total_poin'         => $totalPoin,
            'total_lencana'      => $totalLencana,
            'total_achievement'  => $totalAll,
            'rank_kelas'         => $rankKelas,
            'kuis_lulus'         => $kuisLulus,
            'total_kuis'         => $totalKuisDikerjakan,
            'level'              => $level,
            'poin_next_level'    => $poinNextLevel,
            'belum_diraih'       => $belumDiraih->count(),
        ];

        return view('orangtua.pencapaian', [
            'siswaList'       => $siswaList,
            'siswa'           => $siswa,
            'diraih'          => $diraih,
            'belumDiraih'     => $belumDiraih,
            'semuaItems'      => $semuaItems->values(),
            'stats'           => $stats,
            'filterTab'       => $filterTab,
            'filterKategori'  => $filterKategori,
            'searchQuery'     => $searchQuery,
        ]);
    }
}

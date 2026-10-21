<?php

namespace App\Http\Controllers;

use App\Models\HasilQuizModul;
use App\Models\OrangtuaSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PerkembanganNilaiController extends Controller
{
    public function index(Request $request)
    {
        $orangtuaId = Auth::id();

        // Ambil daftar siswa milik orang tua yang login
        $siswaIds = OrangtuaSiswa::where('id_orangtua', $orangtuaId)->pluck('id_siswa');

        $siswaList = User::whereIn('id_user', $siswaIds)
            ->where('id_tipeuser', 3)
            ->with('jenjang')
            ->get();

        if ($siswaList->isEmpty()) {
            return view('orangtua.perkembangan_nilai', [
                'siswaList'  => $siswaList,
                'siswa'      => null,
                'stats'      => null,
                'chartData'  => [],
                'hasilList'  => collect(),
                'mataPelajaranList' => collect(),
            ]);
        }

        // Pilih siswa aktif
        $siswaId = $request->input('siswa_id', $siswaList->first()->id_user);
        $siswa   = $siswaList->firstWhere('id_user', $siswaId) ?? $siswaList->first();

        // Filter rentang waktu
        $rentang = $request->input('rentang', 'semua');
        $hasilQuery = HasilQuizModul::where('id_user', $siswa->id_user)
            ->with('quiz.tipeQuiz')
            ->orderBy('waktu_dapat');

        if ($rentang === '7')  $hasilQuery->where('waktu_dapat', '>=', now()->subDays(7));
        if ($rentang === '30') $hasilQuery->where('waktu_dapat', '>=', now()->subDays(30));
        if ($rentang === '90') $hasilQuery->where('waktu_dapat', '>=', now()->subDays(90));

        // Filter mata pelajaran (berdasarkan judul quiz)
        $mapel = $request->input('mapel');

        $hasilAll = $hasilQuery->get();

        // Filter status (lulus / remedial)
        $statusFilter = $request->input('status');
        $hasilFiltered = $hasilAll;
        if ($statusFilter === 'lulus')    $hasilFiltered = $hasilAll->where('is_lulus', true);
        if ($statusFilter === 'remedial') $hasilFiltered = $hasilAll->where('is_lulus', false);

        // Daftar mata pelajaran unik (dari judul quiz)
        $mataPelajaranList = $hasilAll->map(fn($h) => $h->quiz?->judul)->filter()->unique()->values();

        if ($mapel) {
            $hasilFiltered = $hasilFiltered->filter(fn($h) => $h->quiz?->judul === $mapel);
        }

        // Hitung nilai (persen) per hasil
        $hasilFiltered = $hasilFiltered->map(function ($h) {
            $h->nilai = $h->total_poin > 0
                ? round(($h->poin_didapat / $h->total_poin) * 100, 1)
                : 0;
            return $h;
        });

        // Statistik
        $nilaiList  = $hasilFiltered->pluck('nilai');
        $avgNilai   = $nilaiList->isNotEmpty() ? round($nilaiList->avg(), 1) : 0;
        $maxNilai   = $nilaiList->isNotEmpty() ? $nilaiList->max() : 0;
        $hasilTerbaru = $hasilFiltered->sortByDesc('waktu_dapat')->first();
        $nilaiTerbaru = $hasilTerbaru ? $hasilTerbaru->nilai : 0;

        $totalKuis     = $hasilFiltered->count();
        $kuisLulus     = $hasilFiltered->where('is_lulus', true)->count();
        $ketuntasan    = $totalKuis > 0 ? round(($kuisLulus / $totalKuis) * 100, 1) : 0;

        $kkm = 75;

        // Nilai tertinggi quiz-nya
        $hasilTertinggi = $hasilFiltered->sortByDesc('nilai')->first();

        // Rata-rata kelas (semua siswa aktif jenjang yang sama)
        $avgKelas = 0;
        if ($siswa->id_jenjang) {
            $semuaSiswaJenjang = User::where('id_tipeuser', 3)
                ->where('id_jenjang', $siswa->id_jenjang)
                ->pluck('id_user');

            $nilaiKelas = HasilQuizModul::whereIn('id_user', $semuaSiswaJenjang)->get()
                ->map(fn($h) => $h->total_poin > 0 ? ($h->poin_didapat / $h->total_poin) * 100 : 0);

            $avgKelas = $nilaiKelas->isNotEmpty() ? round($nilaiKelas->avg(), 1) : 0;
        }

        // Data chart (tren nilai)
        $chartData = $hasilFiltered
            ->sortBy('waktu_dapat')
            ->map(fn($h) => [
                'label' => Carbon::parse($h->waktu_dapat)->translatedFormat('d M'),
                'nilai' => $h->nilai,
                'judul' => $h->quiz?->judul ?? '-',
            ])
            ->values()
            ->toArray();

        $stats = [
            'avg_nilai'     => $avgNilai,
            'max_nilai'     => $maxNilai,
            'nilai_terbaru' => $nilaiTerbaru,
            'judul_terbaru' => $hasilTerbaru?->quiz?->judul ?? '-',
            'waktu_terbaru' => $hasilTerbaru ? Carbon::parse($hasilTerbaru->waktu_dapat)->translatedFormat('d M Y') : '-',
            'ketuntasan'    => $ketuntasan,
            'total_kuis'    => $totalKuis,
            'kuis_lulus'    => $kuisLulus,
            'kkm'           => $kkm,
            'avg_kelas'     => $avgKelas,
            'selisih_kkm'   => round($avgNilai - $kkm, 1),
            'di_atas_kkm'   => $avgNilai >= $kkm,
            'judul_tertinggi' => $hasilTertinggi?->quiz?->judul ?? '-',
        ];

        return view('orangtua.perkembangan_nilai', [
            'orangtua'          => Auth::user(),
            'siswaList'         => $siswaList,
            'siswa'             => $siswa,
            'stats'             => $stats,
            'chartData'         => $chartData,
            'hasilList'         => $hasilFiltered->sortByDesc('waktu_dapat')->values(),
            'mataPelajaranList' => $mataPelajaranList,
            'rentangAktif'      => $rentang,
            'mapelAktif'        => $mapel,
            'statusAktif'       => $statusFilter,
        ]);
    }
}

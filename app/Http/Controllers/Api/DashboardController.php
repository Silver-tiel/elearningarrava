<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Guru;
use App\Models\HasilQuizModul;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard data khusus Siswa (Mobile)
     */
    public function studentDashboard(Request $request)
    {
        $user = $request->user();
        if ($user) {
            Achievement::syncForUser($user);
            $user->refresh()->load('jenjang');
        }

        $idJenjang = $user->id_jenjang ?? null;

        $modulQuery = Modul::published();
        $quizQuery = Quiz::published()->belumKadaluarsa();

        if ($idJenjang) {
            $modulQuery->where('id_jenjang', $idJenjang);
            $quizQuery->where('id_jenjang', $idJenjang);
        }

        $totalModul = $modulQuery->count();
        $totalQuiz = $quizQuery->count();

        // Kuis yang sudah lulus
        $kuisLulus = HasilQuizModul::where('id_user', $user->id_user)
            ->where('is_lulus', true)
            ->distinct('id_quiz')
            ->count('id_quiz');

        $progressPercent = $totalQuiz > 0 ? round(($kuisLulus / $totalQuiz) * 100) : 0;

        // Modul terbaru untuk jenjang siswa
        $latestModuls = $modulQuery->with(['tipeModul', 'jenjang'])
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($m) {
                return [
                    'id_modul' => $m->id_modul,
                    'judul_modul' => $m->judul_modul,
                    'deskripsi' => $m->deskripsi,
                    'tipe' => $m->tipeModul->nama_tipe ?? 'Umum',
                    'jenjang' => $m->jenjang->nama_jenjang ?? 'Semua',
                    'cover_url' => $m->cover_url ?? null,
                ];
            });

        // Riwayat pengerjaan kuis terbaru siswa
        $riwayatKuis = HasilQuizModul::where('id_user', $user->id_user)
            ->with('quiz:id_quiz,judul')
            ->orderByDesc('id_hasil')
            ->take(5)
            ->get()
            ->map(function ($h) {
                $nilai = $h->total_poin > 0 ? round(($h->poin_didapat / $h->total_poin) * 100) : 0;
                return [
                    'id_hasil' => $h->id_hasil,
                    'id_quiz' => $h->id_quiz,
                    'judul' => $h->quiz->judul ?? 'Kuis Pembelajaran',
                    'skor' => $nilai,
                    'poin_didapat' => (int) $h->poin_didapat,
                    'total_poin' => (int) $h->total_poin,
                    'is_lulus' => (bool) $h->is_lulus,
                    'tanggal' => $h->waktu_dapat ? $h->waktu_dapat->diffForHumans() : $h->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id_user' => $user->id_user,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'nisn' => $user->nisn,
                    'jenjang' => $user->jenjang->nama_jenjang ?? 'Umum',
                    'total_xp' => (int) ($user->total_poin ?? 0),
                    'foto_profil' => $user->foto_profil ? asset('storage/' . $user->foto_profil) : null,
                ],
                'stats' => [
                    'kursus_aktif' => $totalModul,
                    'total_quiz' => $totalQuiz,
                    'kuis_lulus' => $kuisLulus,
                    'progress_percent' => $progressPercent,
                    'total_xp' => (int) ($user->total_poin ?? 0),
                ],
                'materi_terbaru' => $latestModuls,
                'riwayat_belajar' => $riwayatKuis,
            ],
        ]);
    }

    /**
     * Dashboard data khusus Admin (Mobile)
     */
    public function adminDashboard()
    {
        $totalSiswa = User::where('id_tipeuser', 3)->count();
        $totalGuru = Guru::count();
        $totalModul = Modul::count();
        $totalQuiz = Quiz::count();

        $recentModules = Modul::with(['tipeModul', 'jenjang'])
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($m) {
                return [
                    'id_modul' => $m->id_modul,
                    'judul_modul' => $m->judul_modul,
                    'deskripsi' => $m->deskripsi,
                    'status' => $m->proggressModul ?? 'Tersedia',
                    'tipe' => $m->tipeModul->nama_tipe ?? 'Umum',
                    'jenjang' => $m->jenjang->nama_jenjang ?? 'Semua',
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => [
                    'total_siswa' => $totalSiswa,
                    'total_guru' => $totalGuru,
                    'total_modul' => $totalModul,
                    'total_quiz' => $totalQuiz,
                ],
                'recent_modules' => $recentModules,
            ],
        ]);
    }

    /**
     * Data guru dari database
     */
    public function teachers()
    {
        $teachers = Guru::latest('id_guru')->get()->map(function ($g) {
            return [
                'id_guru' => $g->id_guru,
                'nama' => $g->nama,
                'nik' => $g->nik,
                'no_telepon' => $g->no_telepon,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $teachers,
        ]);
    }

    /**
     * Data siswa dari database
     */
    public function students(Request $request)
    {
        $query = User::where('id_tipeuser', 3)->with('jenjang');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $students = $query->latest('id_user')->get()->map(function ($s) {
            return [
                'id_user' => $s->id_user,
                'nama' => $s->nama,
                'nisn' => $s->nisn,
                'email' => $s->email,
                'kelas' => $s->kelas,
                'jenjang' => $s->jenjang->nama_jenjang ?? 'Umum',
                'status' => $s->status_akun ?? 'Aktif',
                'total_poin' => (int) ($s->total_poin ?? 0),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $students,
        ]);
    }
}


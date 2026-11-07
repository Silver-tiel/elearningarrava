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

    /**
     * Profil lengkap Siswa (Mobile)
     */
    public function studentProfile(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        Achievement::syncForUser($user);
        $user->refresh()->load('jenjang');

        // Return only the parents linked to the authenticated student's account.
        $orangTua = $user->orangtuaList()
            ->whereHas('orangtua', fn ($query) => $query->where('id_tipeuser', 4))
            ->with('orangtua:id_user,nama,nomor_hp,email')
            ->orderBy('id')
            ->get()
            ->map(fn ($relasi) => [
                'nama' => $relasi->orangtua->nama,
                'nomor_hp' => $relasi->orangtua->nomor_hp,
                'email' => $relasi->orangtua->email,
            ])
            ->values();

        $rankTier = $user->rank_tier;
        $qrPayload = method_exists($user, 'qrPayload') ? $user->qrPayload() : null;

        $hasIsLulus = \Illuminate\Support\Facades\Schema::hasColumn('hasilquizmodul', 'is_lulus');
        $kuisLulusExpr = $hasIsLulus
            ? 'COUNT(DISTINCT CASE WHEN is_lulus = 1 THEN id_quiz END) as kuis_lulus'
            : 'COUNT(DISTINCT id_quiz) as kuis_lulus';

        $scoreSummary = HasilQuizModul::where('id_user', $user->id_user)
            ->selectRaw("COUNT(*) as total_percobaan, {$kuisLulusExpr}, COUNT(DISTINCT id_quiz) as jumlah_kuis, COALESCE(SUM(total_poin), 0) as total_poin_maks, COALESCE(SUM(poin_didapat), 0) as total_poin_didapat")
            ->first();

        $quizResults = HasilQuizModul::where('id_user', $user->id_user)
            ->with('quiz:id_quiz,judul')
            ->latest('id_hasil')
            ->take(10)
            ->get()
            ->map(function ($hasil) {
                $nilai = (int) $hasil->total_poin > 0
                    ? round($hasil->poin_didapat / $hasil->total_poin * 100, 1)
                    : null;
                return [
                    'id_hasil' => (int) $hasil->id_hasil,
                    'id_quiz' => (int) $hasil->id_quiz,
                    'judul_quiz' => $hasil->quiz->judul ?? 'Kuis',
                    'total_poin' => (int) $hasil->total_poin,
                    'poin_didapat' => (int) $hasil->poin_didapat,
                    'nilai' => $nilai,
                    'is_lulus' => (bool) $hasil->is_lulus,
                    'tanggal' => $hasil->waktu_dapat ? $hasil->waktu_dapat->format('d M Y, H:i') : ($hasil->created_at ? $hasil->created_at->format('d M Y, H:i') : '-'),
                ];
            });

        $achievements = \App\Models\PencapaianUser::with('achievement')
            ->where('id_user', $user->id_user)
            ->orderByDesc('waktu_pencapaian')
            ->take(10)
            ->get()
            ->map(function ($p) {
                $ach = $p->achievement;
                $gambar = $ach?->gambar_url ? (filter_var($ach->gambar_url, FILTER_VALIDATE_URL) ? $ach->gambar_url : asset($ach->gambar_url)) : null;
                return [
                    'id_pencapaian' => (int) $p->id_pencapaian,
                    'nama' => $p->nama ?? $ach?->nama_achivement ?? 'Penghargaan',
                    'deskripsi' => $ach?->deskripsi ?? 'Capaian prestasi belajar',
                    'gambar_url' => $gambar,
                    'tanggal' => $p->waktu_pencapaian ? $p->waktu_pencapaian->format('d M Y') : ($p->created_at ? $p->created_at->format('d M Y') : '-'),
                ];
            });

        $fotoUrl = $user->foto_profil ? asset('storage/' . ltrim($user->foto_profil, '/')) : null;

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id_user' => (int) $user->id_user,
                    'nama' => $user->nama,
                    'username' => $user->username ?? $user->nama,
                    'email' => $user->email,
                    'nisn' => $user->nisn ?? '-',
                    'nomor_hp' => $user->nomor_hp ?? '-',
                    'asal_sekolah' => $user->asal_sekolah ?? '-',
                    'kelas' => $user->kelas ?? '-',
                    'id_jenjang' => $user->id_jenjang ? (int) $user->id_jenjang : null,
                    'nama_jenjang' => $user->jenjang->nama_tipe ?? $user->jenjang->nama_jenjang ?? '-',
                    'total_poin' => (int) ($user->total_poin ?? 0),
                    'foto_profil' => $fotoUrl,
                    'qr_payload' => $qrPayload,
                ],
                'orang_tua' => $orangTua,
                'rank' => [
                    'current_rank' => $rankTier['current_rank'] ?? 'Pemula',
                    'current_badge_url' => $rankTier['current_badge_url'] ?? null,
                    'next_rank' => $rankTier['next_rank'] ?? 'Lanjutan',
                    'current_points' => (int) ($rankTier['current_points'] ?? ($user->total_poin ?? 0)),
                    'next_points' => (int) ($rankTier['next_points'] ?? 100),
                    'points_needed' => (int) ($rankTier['points_needed'] ?? 0),
                    'percent' => (int) ($rankTier['percent'] ?? 0),
                    'is_max' => (bool) ($rankTier['is_max'] ?? false),
                ],
                'stats' => [
                    'total_percobaan' => (int) ($scoreSummary->total_percobaan ?? 0),
                    'kuis_lulus' => (int) ($scoreSummary->kuis_lulus ?? 0),
                    'jumlah_kuis' => (int) ($scoreSummary->jumlah_kuis ?? 0),
                    'total_poin_didapat' => (int) ($scoreSummary->total_poin_didapat ?? 0),
                ],
                'achievements' => $achievements,
                'riwayat_kuis' => $quizResults,
            ],
        ], 200);
    }

    /**
     * Update profil Siswa (Mobile)
     */
    public function updateStudentProfile(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'username' => ['nullable', 'string', 'max:50'],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'asal_sekolah' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (!empty($validated['username'])) {
            $user->username = $validated['username'];
        }
        if (array_key_exists('nomor_hp', $validated)) {
            $user->nomor_hp = $validated['nomor_hp'];
        }
        if (array_key_exists('asal_sekolah', $validated)) {
            $user->asal_sekolah = $validated['asal_sekolah'];
        }
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'user' => [
                'nama' => $user->nama,
                'username' => $user->username,
                'email' => $user->email,
                'nomor_hp' => $user->nomor_hp,
                'asal_sekolah' => $user->asal_sekolah,
            ],
        ]);
    }
}


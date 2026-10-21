<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\HasilQuizModul;
use App\Models\Modul;
use App\Models\OrangtuaSiswa;
use App\Models\PencapaianUser;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OrangtuaController extends Controller
{
    /* -----------------------------------------------------------------
     |  Ambil daftar siswa yang berhak diakses orang tua yang login.
     | Gunakan fungsi ini di setiap metode agar kontrol akses konsisten.
     * --------------------------------------------------------------- */
    private function getSiswaIds(): array
    {
        return OrangtuaSiswa::where('id_orangtua', Auth::id())
            ->pluck('id_siswa')
            ->toArray();
    }

    private function getSiswaOrFail(int $idSiswa): User
    {
        $siswaIds = $this->getSiswaIds();

        abort_if(!in_array($idSiswa, $siswaIds), 403, 'Anda tidak memiliki akses ke data siswa ini.');

        return User::with(['jenjang', 'tipeUser'])->findOrFail($idSiswa);
    }

    /* -----------------------------------------------------------------
     |  Dashboard utama – menampilkan ringkasan belajar siswa terpilih.
     * --------------------------------------------------------------- */
    public function dashboard(Request $request)
    {
        $orangtua  = Auth::user();
        $siswaIds  = $this->getSiswaIds();

        // Jika belum ada siswa yang dihubungkan tampilkan empty state.
        if (empty($siswaIds)) {
            return view('orangtua.dashboard', [
                'orangtua'       => $orangtua,
                'siswa'          => null,
                'siswaList'      => collect(),
                'stats'          => null,
                'quizTrend'      => collect(),
                'modulProgress'  => collect(),
                'aktivitas'      => collect(),
                'pencapaian'     => collect(),
                'totalJamBelajar'=> 0,
            ]);
        }

        // Pilih siswa aktif: dari query string atau default siswa pertama.
        $activeSiswaId = (int) $request->get('siswa_id', $siswaIds[0]);
        if (!in_array($activeSiswaId, $siswaIds)) {
            $activeSiswaId = $siswaIds[0];
        }

        $siswa = User::with(['jenjang'])->findOrFail($activeSiswaId);

        // Daftar semua siswa yang bisa dipilih di dropdown.
        $siswaList = User::whereIn('id_user', $siswaIds)
            ->select('id_user', 'nama', 'id_jenjang')
            ->with('jenjang')
            ->get();

        /* ---- Statistik ---- */
        // Rata-rata nilai kuis (poin_didapat / total_poin * 100)
        $hasilList = HasilQuizModul::where('id_user', $activeSiswaId)
            ->with(['quiz.tipeQuiz'])
            ->orderByDesc('waktu_dapat')
            ->get();

        $totalQuizDikerjakan = $hasilList->count();
        $totalQuizTersedia   = Quiz::count();

        // Nilai rata-rata (persentase benar)
        $avgNilai = 0;
        if ($hasilList->isNotEmpty()) {
            $avgNilai = $hasilList->avg(function ($h) {
                return $h->total_poin > 0
                    ? round(($h->poin_didapat / $h->total_poin) * 100, 1)
                    : 0;
            });
        }

        // Modul selesai: hitung dari hasilquizmodul yang lulus & modul punya quiz
        $modulSelesai = HasilQuizModul::where('id_user', $activeSiswaId)
            ->where('is_lulus', true)
            ->distinct('id_quiz')
            ->count('id_quiz');

        $totalModul = Modul::count();

        // Total poin siswa
        $totalPoin = (int) ($siswa->total_poin ?? 0);

        // Peringkat kelas berdasarkan total_poin di antara jenjang yang sama
        $rankKelas = DB::table('user')
            ->where('id_tipeuser', 3)
            ->where('id_jenjang', $siswa->id_jenjang)
            ->where('total_poin', '>', $totalPoin)
            ->count() + 1;

        // Evaluasi status lulus: rata-rata nilai vs KKM 75
        $kkm       = 75;
        $statusEval = $avgNilai >= $kkm ? 'Tuntas Mandiri' : 'Perlu Bimbingan';

        // Partisipasi quiz (persen)
        $partisipasiPersen = $totalQuizTersedia > 0
            ? round(($totalQuizDikerjakan / $totalQuizTersedia) * 100, 1)
            : 0;

        // Target kurikulum (persen modul selesai)
        $targetKurikulumPersen = $totalModul > 0
            ? round(($modulSelesai / $totalModul) * 100, 1)
            : 0;

        $stats = [
            'avg_nilai'               => round($avgNilai, 1),
            'kkm'                     => $kkm,
            'status_eval'             => $statusEval,
            'total_quiz_dikerjakan'   => $totalQuizDikerjakan,
            'total_quiz_tersedia'     => $totalQuizTersedia,
            'partisipasi_persen'      => $partisipasiPersen,
            'modul_selesai'           => $modulSelesai,
            'total_modul'             => $totalModul,
            'target_kurikulum_persen' => $targetKurikulumPersen,
            'total_poin'              => $totalPoin,
            'rank_kelas'              => $rankKelas,
        ];

        /* ---- Tren Nilai Quiz (7 quiz terakhir per mata pelajaran / per quiz) ---- */
        // Ambil 10 hasil quiz terakhir untuk grafik
        $quizTrend = HasilQuizModul::where('id_user', $activeSiswaId)
            ->with('quiz')
            ->orderByDesc('waktu_dapat')
            ->take(10)
            ->get()
            ->reverse()
            ->values()
            ->map(function ($h) {
                $nilai = $h->total_poin > 0
                    ? round(($h->poin_didapat / $h->total_poin) * 100, 1)
                    : 0;
                return [
                    'label' => \Illuminate\Support\Str::limit($h->quiz->judul ?? 'Quiz', 15),
                    'nilai' => $nilai,
                    'tanggal' => $h->waktu_dapat,
                ];
            });

        /* ---- Progres Mata Pelajaran (per tipe modul / per jenjang) ---- */
        // Kelompokkan modul berdasarkan tipe/jenjang dan hitung berapa yang sudah lulus quiz-nya
        $allModuls = Modul::with(['jenjang', 'tipeModul', 'quiz'])
            ->where('id_jenjang', $siswa->id_jenjang)
            ->get();

        $lulusQuizIds = HasilQuizModul::where('id_user', $activeSiswaId)
            ->where('is_lulus', true)
            ->pluck('id_quiz')
            ->toArray();

        // Kelompokkan modul berdasarkan tipe modul (Video, PDF, Artikel)
        $modulGrouped = $allModuls->groupBy(fn($m) => $m->tipeModul->nama_tipe ?? 'Lainnya');

        $modulProgress = $modulGrouped->map(function ($group, $tipeName) use ($lulusQuizIds) {
            $total   = $group->count();
            $selesai = $group->filter(fn($m) => $m->id_quiz && in_array($m->id_quiz, $lulusQuizIds))->count();

            // Rata-rata nilai untuk modul yang punya quiz di grup ini
            $avgNilaiGroup = 0;
            $quizModulIds  = $group->filter(fn($m) => $m->id_quiz)->pluck('id_quiz')->toArray();
            if (!empty($quizModulIds)) {
                $hasilGroup = HasilQuizModul::whereIn('id_quiz', $quizModulIds)
                    ->where('is_lulus', true)
                    ->get();
                if ($hasilGroup->isNotEmpty()) {
                    $avgNilaiGroup = $hasilGroup->avg(fn($h) => $h->total_poin > 0
                        ? round(($h->poin_didapat / $h->total_poin) * 100, 1) : 0);
                }
            }

            $persen = $total > 0 ? round(($selesai / $total) * 100, 1) : 0;

            return [
                'nama'      => $tipeName,
                'selesai'   => $selesai,
                'total'     => $total,
                'persen'    => $persen,
                'avg_nilai' => round($avgNilaiGroup, 1),
            ];
        })->values();

        /* ---- Aktivitas Belajar Terbaru ---- */
        $aktivitas = HasilQuizModul::where('id_user', $activeSiswaId)
            ->with(['quiz.tipeQuiz'])
            ->orderByDesc('waktu_dapat')
            ->take(8)
            ->get()
            ->map(function ($h) {
                $nilai   = $h->total_poin > 0
                    ? round(($h->poin_didapat / $h->total_poin) * 100, 1)
                    : 0;
                $status  = $h->is_lulus ? 'Tuntas' : ($nilai < 50 ? 'Remedial' : 'Selesai');
                $tipe    = $h->quiz?->tipeQuiz?->nama_tipe ?? 'Quiz';

                return [
                    'waktu'        => $h->waktu_dapat,
                    'judul_quiz'   => $h->quiz?->judul ?? 'Quiz',
                    'tipe'         => $tipe,
                    'nilai'        => $nilai,
                    'poin_didapat' => $h->poin_didapat,
                    'total_poin'   => $h->total_poin,
                    'status'       => $status,
                    'is_lulus'     => (bool) $h->is_lulus,
                ];
            });

        /* ---- Pencapaian & Lencana Terbaru ---- */
        $pencapaian = PencapaianUser::where('id_user', $activeSiswaId)
            ->with('achievement')
            ->orderByDesc('waktu_pencapaian')
            ->take(3)
            ->get();

        /* ---- Total Jam Belajar (estimasi dari jumlah kuis dikerjakan × rata-rata durasi) ---- */
        // Karena tidak ada kolom durasi di hasilquizmodul, estimasi 15 menit per kuis
        $totalJamBelajar = $totalQuizDikerjakan * 15; // menit

        return view('orangtua.dashboard', compact(
            'orangtua',
            'siswa',
            'siswaList',
            'stats',
            'quizTrend',
            'modulProgress',
            'aktivitas',
            'pencapaian',
            'totalJamBelajar'
        ));
    }

    /* -----------------------------------------------------------------
     |  Halaman Pengaturan Akun – menampilkan & menyimpan data profil.
     * --------------------------------------------------------------- */
    public function pengaturan()
    {
        $user = Auth::user();
        return view('orangtua.pengaturan', compact('user'));
    }

    public function updatePengaturan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'       => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', Rule::unique('user', 'email')->ignore($user->id_user, 'id_user')],
            'nomor_hp'   => ['nullable', 'string', 'max:20'],
            'foto_profil'=> ['nullable', 'image', 'max:2048'],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'nama'     => $request->nama,
            'email'    => $request->email,
            'nomor_hp' => $request->nomor_hp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $data['foto_profil'] = $path;
        }

        DB::table('user')->where('id_user', $user->id_user)->update($data);

        return redirect()->route('orangtua.pengaturan')
            ->with('success', 'Perubahan berhasil disimpan.');
    }
}

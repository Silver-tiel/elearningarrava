<?php

namespace App\Http\Controllers;

use App\Models\HasilQuizModul;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class SiswaController extends Controller
{
    // Syarat lulus: minimal 70% soal dijawab benar.
    private const RASIO_LULUS = 0.70;

    // Durasi bawaan per soal (detik) bila kolom durasi_detik kosong.
    private const DURASI_SOAL_DEFAULT = 20;

    // Wayground: toleransi keterlambatan submit jawaban (latensi jaringan).
    private const WAYGROUND_GRACE_DETIK = 10;

    // Wayground: toleransi submit yang datang sedikit lebih awal dari batas
    // (pembulatan detik antara JS dan server), supaya jawaban tidak ditolak.
    private const WAYGROUND_TOLERANSI_AWAL_DETIK = 2;

    // Mode biasa: toleransi keterlambatan auto-submit saat waktu habis.
    private const BIASA_GRACE_DETIK = 15;

    /* ---------------------------------------------------------------------
     |  DASHBOARD & MATERI
     * ------------------------------------------------------------------- */

    public function dashboard(Request $request)
    {
        $modulCount = Modul::count();
        $quizCount = Quiz::count();
        $moduls = Modul::with(['tipeModul', 'jenjang'])->latest()->take(4)->get();

        return view('siswa.dashboard', [
            'user' => $request->user(),
            'modulCount' => $modulCount,
            'quizCount' => $quizCount,
            'moduls' => $moduls,
        ]);
    }

    public function belajar()
    {
        // Menampilkan daftar modul untuk belajar.
        $moduls = Modul::with(['tipeModul', 'jenjang'])->latest()->get();

        return view('siswa.modul', compact('moduls'));
    }

    public function materiVideo()
    {
        // Menampilkan daftar modul yang ada videonya.
        $moduls = Modul::with(['tipeModul', 'jenjang'])->latest()->get();

        return view('siswa.materi-video-list', compact('moduls'));
    }

    public function materiVideoDetail(Request $request, $id_modul)
    {
        $modul = Modul::with([
            'tipeModul',
            'jenjang',
            'materiVideo' => fn($q) => $q->orderBy('urutan', 'asc'),
            'catatan',
        ])->findOrFail($id_modul);

        $selectedVideoId = $request->get('v');
        $selectedVideo = $selectedVideoId
            ? $modul->materiVideo->firstWhere('id_materi', $selectedVideoId)
            : $modul->materiVideo->first();

        return view('siswa.materi-video', compact('modul', 'selectedVideo'));
    }

    /* ---------------------------------------------------------------------
     |  DAFTAR LATIHAN SOAL & QUIZ
     * ------------------------------------------------------------------- */

    public function latihanSoalModul($id_modul)
    {
        $modul = Modul::with(['tipeModul', 'jenjang'])->findOrFail($id_modul);
        $user = Auth::user();

        // Tanpa kuis terkait dan tanpa jenjang, tidak ada yang bisa ditampilkan.
        // (Grup where kosong akan diabaikan Eloquent dan menampilkan SEMUA kuis.)
        if (!$modul->id_quiz && !$modul->id_jenjang) {
            $quizzes = collect();

            return view('siswa.latihan-soal-modul', compact('modul', 'quizzes'));
        }

        $quizzes = Quiz::belumKadaluarsa()
            ->where(function ($q) use ($modul) {
                $q->when($modul->id_quiz, fn($qq) => $qq->where('id_quiz', $modul->id_quiz))
                    ->when($modul->id_jenjang, fn($qq) => $qq->orWhere('id_jenjang', $modul->id_jenjang));
            })
            // Siswa hanya melihat kuis untuk jenjangnya sendiri.
            ->when($user && $user->id_jenjang, fn($q) => $q->where('id_jenjang', $user->id_jenjang))
            ->with(['tipeQuiz', 'tingkatQuiz'])
            ->withCount('soal')
            ->latest()
            ->get();

        return view('siswa.latihan-soal-modul', compact('modul', 'quizzes'));
    }

    public function latihanSoal(Request $request)
    {
        $user = Auth::user();

        $query = Quiz::belumKadaluarsa()->with(['tipeQuiz', 'tingkatQuiz']);

        if ($user && $user->id_jenjang) {
            $query->where('id_jenjang', $user->id_jenjang);
        }

        $quizzes = $query->latest()->get();

        return view('siswa.latihan-soal', compact('quizzes'));
    }

    public function quiz(Request $request)
    {
        $filters = $request->validate([
            'tingkat' => ['nullable', 'integer', 'exists:tingkatquiz,id_tingkatquiz'],
            'sort' => ['nullable', 'in:terbaru,terlama'],
        ]);

        $query = Quiz::belumKadaluarsa()->with(['tipeQuiz', 'tingkatQuiz', 'jenjang']);

        $user = Auth::user();
        if ($user && $user->id_jenjang) {
            $query->where('id_jenjang', $user->id_jenjang);
        }

        if (!empty($filters['tingkat'])) {
            $query->where('id_tingkatquiz', $filters['tingkat']);
        }

        if (($filters['sort'] ?? null) === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $quizzes = $query->get();
        $tingkatQuizList = TingkatQuiz::orderBy('id_tingkatquiz')->get();

        return view('siswa.quiz', compact('quizzes', 'tingkatQuizList'));
    }

    /* ---------------------------------------------------------------------
     |  PENGERJAAN QUIZ
     * ------------------------------------------------------------------- */

    public function kerjakanLatihan($id_quiz)
    {
        return $this->tampilkanQuiz($this->muatQuiz($id_quiz), 'siswa.latihan-soal');
    }

    public function kerjakanQuiz($id_quiz)
    {
        return $this->tampilkanQuiz($this->muatQuiz($id_quiz), 'siswa.quiz');
    }

    public function previewQuiz($id_quiz)
    {
        // Preview untuk admin/guru: tanpa timer server dan tanpa penyimpanan hasil.
        return view('siswa.mengerjakan-quiz', [
            'quiz' => $this->muatQuiz($id_quiz),
            'remainingSeconds' => null,
            'activeQuestionIndex' => 0,
            'questionRemainingSeconds' => null,
            'isPreview' => true,
        ]);
    }

    private function tampilkanQuiz(Quiz $quiz, string $routeDaftar)
    {
        if ($tolak = $this->tolakJikaBukanJenjangnya($quiz, $routeDaftar)) {
            return $tolak;
        }

        // Kadaluarsa = batas untuk MEMULAI. Percobaan yang sudah berjalan
        // sebelum kadaluarsa boleh dilanjutkan sampai selesai.
        if ($quiz->sudahKadaluarsa() && !$this->punyaAttemptAktif($quiz)) {
            return redirect()->route($routeDaftar)->withErrors([
                'quiz' => 'Waktu kuis sudah berakhir.',
            ]);
        }

        if ($quiz->soal->isEmpty()) {
            return redirect()->route($routeDaftar)->withErrors([
                'quiz' => 'Kuis ini belum memiliki soal.',
            ]);
        }

        $remainingSeconds = null;
        $activeQuestionIndex = 0;
        $questionRemainingSeconds = null;

        if ($quiz->mode_pengerjaan === 'wayground') {
            $attemptKey = $this->waygroundAttemptSessionKey($quiz);
            $attempt = session($attemptKey);

            if (!$attempt) {
                $attempt = [
                    'active_question_index' => 0,
                    'question_started_at' => now()->timestamp,
                    'answers' => [],
                ];
                session([$attemptKey => $attempt]);
            }

            $activeQuestionIndex = (int) ($attempt['active_question_index'] ?? 0);
            $activeQuestion = $quiz->soal->values()->get($activeQuestionIndex);

            if (!$activeQuestion) {
                session()->forget($attemptKey);

                return redirect()->route($routeDaftar)->withErrors([
                    'quiz' => 'Sesi pengerjaan kuis tidak valid. Silakan mulai kembali.',
                ]);
            }

            $questionRemainingSeconds = max(
                0,
                $this->durasiSoal($activeQuestion)
                - (now()->timestamp - (int) $attempt['question_started_at'])
            );
        }

        if ($quiz->mode_pengerjaan === 'biasa' && $quiz->durasi_total_menit) {
            $attemptKey = $this->attemptSessionKey($quiz);
            $startedAt = session($attemptKey);

            if (!$startedAt) {
                $startedAt = now()->timestamp;
                session([$attemptKey => $startedAt]);
            }

            $remainingSeconds = max(
                0,
                ($quiz->durasi_total_menit * 60) - (now()->timestamp - (int) $startedAt)
            );

            if ($remainingSeconds === 0) {
                session()->forget($attemptKey);

                return redirect()->route($routeDaftar)->withErrors([
                    'quiz' => 'Waktu pengerjaan kuis sudah habis.',
                ]);
            }
        }

        return view('siswa.mengerjakan-quiz', compact(
            'quiz',
            'remainingSeconds',
            'activeQuestionIndex',
            'questionRemainingSeconds'
        ));
    }

    public function submitQuiz(Request $request, $id_quiz)
    {
        $request->validate([
            'jawaban' => ['nullable', 'array'],
            'jawaban.*' => ['nullable', 'string', 'max:500'],
        ]);

        $quiz = $this->muatQuiz($id_quiz);
        $user = Auth::user();
        $jawabanSiswa = $request->input('jawaban', []);

        if ($tolak = $this->tolakJikaBukanJenjangnya($quiz, 'siswa.quiz')) {
            return $tolak;
        }

        if ($quiz->sudahKadaluarsa() && !$this->punyaAttemptAktif($quiz)) {
            return redirect()->route('siswa.quiz')->withErrors([
                'quiz' => 'Waktu kuis sudah berakhir.',
            ]);
        }

        if ($quiz->soal->isEmpty()) {
            return redirect()->route('siswa.quiz')->withErrors([
                'quiz' => 'Kuis ini belum memiliki soal.',
            ]);
        }

        // Kunci session yang harus dibersihkan setelah kuis selesai.
        $kunciAttempt = $this->attemptSessionKey($quiz);

        if ($quiz->mode_pengerjaan === 'wayground') {
            $kunciAttempt = $this->waygroundAttemptSessionKey($quiz);
            $attempt = session($kunciAttempt);

            if (!$attempt) {
                return redirect()->route('siswa.quiz')->withErrors([
                    'quiz' => 'Silakan mulai kuis terlebih dahulu.',
                ]);
            }

            $activeQuestionIndex = (int) ($attempt['active_question_index'] ?? 0);
            $activeQuestion = $quiz->soal->values()->get($activeQuestionIndex);

            if (!$activeQuestion) {
                session()->forget($kunciAttempt);

                return redirect()->route('siswa.quiz')->withErrors([
                    'quiz' => 'Sesi pengerjaan kuis tidak valid. Silakan mulai kembali.',
                ]);
            }

            $durasi = $this->durasiSoal($activeQuestion);
            $elapsedSeconds = now()->timestamp - (int) $attempt['question_started_at'];

            // Jawaban yang datang terlambat dianggap tidak menjawab.
            $attempt['answers'][$activeQuestion->id_soal] =
                $elapsedSeconds <= $durasi + self::WAYGROUND_GRACE_DETIK
                ? ($jawabanSiswa[$activeQuestion->id_soal] ?? null)
                : null;

            $nextQuestionIndex = $activeQuestionIndex + 1;

            if ($nextQuestionIndex < $quiz->soal->count()) {
                $attempt['active_question_index'] = $nextQuestionIndex;
                $attempt['question_started_at'] = now()->timestamp;
                session([$kunciAttempt => $attempt]);

                return redirect()->route('siswa.quiz.kerjakan', $quiz->id_quiz);
            }

            // Soal terakhir sudah dijawab: nilai semua jawaban yang terkumpul.
            $jawabanSiswa = $attempt['answers'];
        }

        if ($quiz->mode_pengerjaan === 'biasa' && $quiz->durasi_total_menit) {
            $startedAt = session($kunciAttempt);

            if (!$startedAt) {
                return redirect()->route('siswa.quiz')->withErrors([
                    'quiz' => 'Silakan mulai kuis terlebih dahulu.',
                ]);
            }

            $elapsedSeconds = now()->timestamp - (int) $startedAt;

            // Ada toleransi supaya auto-submit saat waktu habis tidak ditolak
            // hanya karena latensi jaringan.
            if ($elapsedSeconds > ($quiz->durasi_total_menit * 60) + self::BIASA_GRACE_DETIK) {
                session()->forget($kunciAttempt);

                return redirect()->route('siswa.quiz')->withErrors([
                    'quiz' => 'Waktu pengerjaan kuis sudah habis.',
                ]);
            }
        }

        // ---- Penilaian ----
        [$benar, $totalPoinQuiz, $poinDidapat] = $this->hitungSkor($quiz, $jawabanSiswa);

        $totalSoal = $quiz->soal->count();
        $isLulus = $totalSoal > 0 && ($benar / $totalSoal) >= self::RASIO_LULUS;

        // ---- Simpan hasil + beri poin secara atomik ----
        // Baris user dikunci supaya dua submit bersamaan tidak memberi poin ganda.
        [$hasil, $poinDiberikan] = DB::transaction(function () use ($user, $quiz, $totalPoinQuiz, $poinDidapat, $isLulus) {
            User::whereKey($user->id_user)->lockForUpdate()->firstOrFail();

            // Poin hanya diberikan SEKALI: pada kelulusan pertama.
            // Percobaan gagal sebelumnya tidak menghalangi.
            $sudahLulusSebelumnya = HasilQuizModul::where('id_user', $user->id_user)
                ->where('id_quiz', $quiz->id_quiz)
                ->where('is_lulus', true)
                ->exists();

            $poinDiberikan = ($isLulus && !$sudahLulusSebelumnya) ? $poinDidapat : 0;

            $hasil = HasilQuizModul::create([
                'id_user' => $user->id_user,
                'id_quiz' => $quiz->id_quiz,
                'total_poin' => $totalPoinQuiz,
                'poin_didapat' => $poinDidapat,
                'is_lulus' => $isLulus,
                'waktu_dapat' => now(),
            ]);

            if ($poinDiberikan > 0) {
                User::whereKey($user->id_user)->increment('total_poin', $poinDiberikan);
            }

            return [$hasil, $poinDiberikan];
        });

        // Percobaan selesai: bersihkan kedua jenis attempt.
        session()->forget([
            $this->attemptSessionKey($quiz),
            $this->waygroundAttemptSessionKey($quiz),
        ]);

        return redirect()->route('siswa.quiz')->with('quiz_result', [
            'id_hasil' => $hasil->id_hasil,
            'id_quiz' => $quiz->id_quiz,
            'poin_didapat' => $poinDidapat,     // skor percobaan ini
            'poin_diberikan' => $poinDiberikan, // poin yang benar-benar masuk ke akun
            'benar' => $benar,
            'total_soal' => $totalSoal,
            'is_lulus' => $isLulus,
        ]);
    }

    public function hasilQuiz($id_quiz, $id_hasil)
    {
        $quiz = Quiz::findOrFail($id_quiz);

        $hasil = HasilQuizModul::where('id_hasil', $id_hasil)
            ->where('id_quiz', $quiz->id_quiz)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        if (!view()->exists('siswa.quiz-result')) {
            return redirect()->route('siswa.quiz')->withErrors([
                'quiz' => 'Halaman hasil belum tersedia.',
            ]);
        }

        return view('siswa.quiz-result', compact('quiz', 'hasil'));
    }

    /* ---------------------------------------------------------------------
     |  HELPER QUIZ
     * ------------------------------------------------------------------- */

    // Memuat quiz dengan urutan soal dan pilihan yang deterministik.
    // Wayground bergantung pada indeks soal, jadi urutannya tidak boleh berubah.
    private function muatQuiz($id_quiz): Quiz
    {
        return Quiz::with([
            'soal' => fn($q) => $q->orderBy('id_soal'),
            'soal.pilihanSoal' => fn($q) => $q->orderBy('label'),
        ])->findOrFail($id_quiz);
    }

    // Hanya siswa dengan jenjang yang sama yang boleh mengerjakan kuis.
    // Kuis tanpa jenjang (null) terbuka untuk semua.
    private function tolakJikaBukanJenjangnya(Quiz $quiz, string $routeDaftar)
    {
        $user = Auth::user();

        if (
            $user && $user->id_jenjang && $quiz->id_jenjang
            && (int) $user->id_jenjang !== (int) $quiz->id_jenjang
        ) {
            return redirect()->route($routeDaftar)->withErrors([
                'quiz' => 'Kuis ini bukan untuk jenjang Anda.',
            ]);
        }

        return null;
    }

    private function durasiSoal($soal): int
    {
        return max(1, (int) ($soal->durasi_detik ?: self::DURASI_SOAL_DEFAULT));
    }

    private function punyaAttemptAktif(Quiz $quiz): bool
    {
        $kunci = $quiz->mode_pengerjaan === 'wayground'
            ? $this->waygroundAttemptSessionKey($quiz)
            : $this->attemptSessionKey($quiz);

        return session()->has($kunci);
    }

    /**
     * Menilai jawaban. Satu sumber kebenaran per jenis soal:
     *  - punya pilihan (pilihan ganda / benar-salah) -> hanya is_correct
     *  - tanpa pilihan (isian singkat)               -> hanya jawaban_benar
     *
     * @return array{0:int,1:int,2:int} [jumlah benar, total poin kuis, poin didapat]
     */
    private function hitungSkor(Quiz $quiz, array $jawabanSiswa): array
    {
        $benar = 0;
        $totalPoinQuiz = 0;
        $poinDidapat = 0;

        foreach ($quiz->soal as $soal) {
            $poinSoal = (int) ($soal->poin ?? 10);
            $totalPoinQuiz += $poinSoal;

            if (!isset($jawabanSiswa[$soal->id_soal])) {
                continue;
            }

            $jawab = $jawabanSiswa[$soal->id_soal];
            $jawab = is_scalar($jawab) ? mb_strtolower(trim((string) $jawab)) : '';

            if ($jawab === '') {
                continue;
            }

            if ($soal->pilihanSoal->isNotEmpty()) {
                // Soal bermasalah (0 atau >1 kunci) tidak bisa dijawab benar,
                // daripada memberi dua jawaban benar sekaligus.
                $kunciBenar = $soal->pilihanSoal->where('is_correct', true);

                $isCorrect = $kunciBenar->count() === 1
                    && mb_strtolower(trim($kunciBenar->first()->label)) === $jawab;
            } else {
                $kunci = mb_strtolower(trim((string) $soal->jawaban_benar));

                // Kunci kosong tidak boleh dianggap cocok dengan jawaban apa pun.
                $isCorrect = $kunci !== '' && $kunci === $jawab;
            }

            if ($isCorrect) {
                $benar++;
                $poinDidapat += $poinSoal;
            }
        }

        return [$benar, $totalPoinQuiz, $poinDidapat];
    }

    private function attemptSessionKey(Quiz $quiz): string
    {
        return 'quiz_attempt.' . Auth::id() . '.' . $quiz->id_quiz;
    }

    private function waygroundAttemptSessionKey(Quiz $quiz): string
    {
        return 'wayground_attempt.' . Auth::id() . '.' . $quiz->id_quiz;
    }

    /* ---------------------------------------------------------------------
     |  ADMIN: DATA SISWA
     * ------------------------------------------------------------------- */

    public function dataSiswa(Request $request)
    {
        // Query dasar: hanya siswa (id_tipeuser = 3).
        $query = User::with(['jenjang', 'tipeUser'])->where('id_tipeuser', 3);

        // Pencarian berdasarkan nama atau email.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter kelas/jenjang (SD, SMP, SMA).
        if ($request->filled('kelas')) {
            $query->whereHas('jenjang', function ($q) use ($request) {
                $q->where('nama_tipe', $request->kelas);
            });
        }

        // Filter status. Akun yang status_akun-nya masih null dianggap Aktif.
        if ($request->filled('status')) {
            $status = $request->status;

            $query->where(function ($q) use ($status) {
                $q->where('status_akun', $status);

                if ($status === 'Aktif') {
                    $q->orWhereNull('status_akun');
                }
            });
        }

        $siswas = $query->latest()->paginate(10)->withQueryString();

        // Statistik memakai data asli (tidak lagi ditimpa angka default).
        $totalSiswa = User::where('id_tipeuser', 3)->count();

        $totalAktif = User::where('id_tipeuser', 3)
            ->where(function ($q) {
                $q->where('status_akun', 'Aktif')->orWhereNull('status_akun');
            })
            ->count();

        $totalNonaktif = User::where('id_tipeuser', 3)
            ->where('status_akun', 'Nonaktif')
            ->count();

        // Status di luar Aktif/Nonaktif (bukan null) dianggap perlu ditinjau.
        $totalPerluDitinjau = User::where('id_tipeuser', 3)
            ->whereNotNull('status_akun')
            ->whereNotIn('status_akun', ['Aktif', 'Nonaktif'])
            ->count();

        // Opsi dropdown filter kelas.
        $listKelas = ['SD', 'SMP', 'SMA'];

        return view('admin.daftar_siswa.data_siswa', compact(
            'siswas',
            'totalSiswa',
            'totalAktif',
            'totalNonaktif',
            'totalPerluDitinjau',
            'listKelas'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'status' => ['required', 'in:Aktif,Nonaktif'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        }

        // Hanya akun siswa yang boleh diubah lewat endpoint ini.
        $siswa = User::where('id_tipeuser', 3)->find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.',
            ], 404);
        }

        try {
            $siswa->status_akun = $data['status'];
            $siswa->save();
        } catch (Throwable $e) {
            // Detail error dicatat di log, tidak dikirim ke browser.
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan status. Silakan coba lagi.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status ' . $siswa->nama . ' berhasil diubah menjadi ' . $siswa->status_akun,
        ]);
    }
}
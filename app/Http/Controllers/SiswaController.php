<?php

namespace App\Http\Controllers;

use App\Models\HasilQuizModul;
use App\Models\Jenjang;
use App\Models\Modul;
use App\Models\ModulSoal;
use App\Models\ProgresModulSiswa;
use App\Models\OrangtuaSiswa;
use App\Models\PencapaianUser;
use App\Models\Achievement;
use App\Models\Quiz;
use App\Models\TingkatQuiz;
use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
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
        $user = $request->user();
        if ($user) {
            Achievement::syncForUser($user);
        }

        $modulQuery = Modul::published();
        $quizQuery = Quiz::published()->belumKadaluarsa();

        if ($user && $user->id_jenjang) {
            $modulQuery->where('id_jenjang', $user->id_jenjang);
            $quizQuery->where('id_jenjang', $user->id_jenjang);
        }

        $modulCount = $modulQuery->count();
        $quizCount = $quizQuery->count();
        $moduls = $modulQuery->with(['tipeModul', 'jenjang'])->latest()->take(4)->get();

        return view('siswa.dashboard', [
            'user' => $user,
            'modulCount' => $modulCount,
            'quizCount' => $quizCount,
            'moduls' => $moduls,
        ]);
    }

    public function belajar()
    {
        $user = Auth::user();

        // Menampilkan daftar modul untuk belajar sesuai jenjang siswa (hanya yang sudah dipublikasikan)
        $query = Modul::published()->with(['tipeModul', 'jenjang']);

        if ($user && $user->id_jenjang) {
            $query->where('id_jenjang', $user->id_jenjang);
        }

        $moduls = $query->latest()->get();

        return view('siswa.modul', compact('moduls', 'user'));
    }

    public function materiVideo()
    {
        $user = Auth::user();

        // Menampilkan daftar modul yang ada videonya (hanya yang sudah dipublikasikan dan sesuai jenjang)
        $query = Modul::published()->with(['tipeModul', 'jenjang']);

        if ($user && $user->id_jenjang) {
            $query->where('id_jenjang', $user->id_jenjang);
        }

        $moduls = $query->latest()->get();

        return view('siswa.materi-video-list', compact('moduls', 'user'));
    }

    public function materiVideoDetail(Request $request, $id_modul)
    {
        $modul = Modul::with([
            'tipeModul',
            'jenjang',
            'catatan',
            'quiz',
            'soalModul.pilihan',
        ])->findOrFail($id_modul);

        if ($modul->isDraft()) {
            return redirect()->route('siswa.modul')->withErrors([
                'modul' => 'Materi modul ini masih dalam bentuk draf dan belum tersedia.',
            ]);
        }

        $user = Auth::user();
        if ($user && $user->id_jenjang && $modul->id_jenjang && $modul->id_jenjang != $user->id_jenjang) {
            return redirect()->route('siswa.modul')->withErrors([
                'modul' => 'Materi modul ini tidak tersedia untuk jenjang Anda.',
            ]);
        }

        // Ambil atau inisialisasi progres belajar siswa pada modul ini
        $progres = null;
        if ($user) {
            $progres = ProgresModulSiswa::firstOrCreate(
                ['id_user' => $user->id_user, 'id_modul' => $modul->id_modul],
                [
                    'materi_selesai' => false,
                    'quiz_selesai' => false,
                    'quiz_lulus' => false,
                    'nilai_quiz' => 0,
                    'is_tuntas' => false,
                    'poin_didapat' => 0,
                ]
            );
        }

        // Ambil modul lain untuk navigasi daftar materi sejenjang (hanya yang dipublikasikan)
        $modulLain = Modul::published()->with(['tipeModul', 'jenjang'])
            ->where('id_jenjang', $modul->id_jenjang)
            ->where('id_modul', '!=', $modul->id_modul)
            ->latest()
            ->take(8)
            ->get();

        $selectedVideo = $modul;

        return view('siswa.materi-video', compact('modul', 'selectedVideo', 'modulLain', 'progres'));
    }

    /**
     * Tandai bahwa siswa sudah selesai mempelajari materi (menonton video / membaca PDF)
     */
    public function tandaiMateriSelesai(Request $request, $id_modul)
    {
        $user = Auth::user();
        $modul = Modul::with('soalModul')->findOrFail($id_modul);

        $progres = ProgresModulSiswa::firstOrCreate(
            ['id_user' => $user->id_user, 'id_modul' => $modul->id_modul]
        );

        $progres->materi_selesai = true;
        $progres->waktu_materi_selesai = $progres->waktu_materi_selesai ?? now();

        $hasQuiz = $modul->hasQuizModul();
        $wasTuntas = (bool) $progres->is_tuntas;

        // Modul tuntas jika tidak punya kuis, ATAU jika punya kuis dan kuisnya sudah lulus
        if (!$hasQuiz || ($hasQuiz && $progres->quiz_lulus)) {
            $progres->is_tuntas = true;
            $progres->waktu_tuntas = $progres->waktu_tuntas ?? now();

            if (!$wasTuntas) {
                $poin = (int) ($modul->poin_modul ?: 50);
                $progres->poin_didapat = $poin;
                $user->increment('total_poin', $poin);
            }
        }

        $progres->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_tuntas' => $progres->is_tuntas,
                'poin_diberikan' => (!$wasTuntas && $progres->is_tuntas) ? $progres->poin_didapat : 0,
                'message' => 'Materi berhasil ditandai selesai dipelajari! 🎉',
            ]);
        }

        return back()->with('success', 'Materi berhasil ditandai selesai dipelajari! 🎉');
    }

    /**
     * Menilai pengerjaan kuis modul oleh siswa
     */
    public function submitKuisModul(Request $request, $id_modul)
    {
        $user = Auth::user();
        $modul = Modul::with('soalModul.pilihan')->findOrFail($id_modul);

        $soalList = $modul->soalModul;
        $totalSoal = $soalList->count();

        if ($totalSoal === 0) {
            return back()->with('error', 'Modul ini tidak memiliki kuis.');
        }

        $jawaban = $request->input('jawaban', []);
        $benarCount = 0;
        $totalBobot = 0;
        $bobotBenar = 0;

        foreach ($soalList as $soal) {
            $bobot = (int) ($soal->poin ?: 10);
            $totalBobot += $bobot;

            $chosenId = $jawaban[$soal->id_soal] ?? null;
            if ($chosenId) {
                $pilihan = $soal->pilihan->firstWhere('id_pilihan', (int) $chosenId);
                if ($pilihan && $pilihan->is_benar) {
                    $benarCount++;
                    $bobotBenar += $bobot;
                }
            }
        }

        $skorPersen = $totalBobot > 0 ? (int) round(($bobotBenar / $totalBobot) * 100) : 0;
        $kkm = (int) ($modul->kkm_quiz ?: 70);
        $isLulus = $skorPersen >= $kkm;

        $progres = ProgresModulSiswa::firstOrCreate(
            ['id_user' => $user->id_user, 'id_modul' => $modul->id_modul]
        );

        $progres->quiz_selesai = true;
        $progres->quiz_lulus = $isLulus;
        $progres->nilai_quiz = max((int) $progres->nilai_quiz, $skorPersen);
        $progres->waktu_quiz_selesai = now();

        $wasTuntas = (bool) $progres->is_tuntas;

        // Modul tuntas HANYA JIKA materi sudah selesai dipelajari DAN kuis lulus KKM!
        if ($progres->materi_selesai && $isLulus) {
            $progres->is_tuntas = true;
            $progres->waktu_tuntas = $progres->waktu_tuntas ?? now();

            if (!$wasTuntas) {
                $poin = (int) ($modul->poin_modul ?: 50);
                $progres->poin_didapat = $poin;
                $user->increment('total_poin', $poin);
            }
        }

        $progres->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'benar' => $benarCount,
                'total_soal' => $totalSoal,
                'skor' => $skorPersen,
                'kkm' => $kkm,
                'is_lulus' => $isLulus,
                'is_tuntas' => $progres->is_tuntas,
                'materi_selesai' => $progres->materi_selesai,
                'poin_diberikan' => (!$wasTuntas && $progres->is_tuntas) ? $progres->poin_didapat : 0,
            ]);
        }

        if ($progres->is_tuntas && !$wasTuntas) {
            $pesan = "Selamat! Nilai kuis kamu {$skorPersen} (Lulus KKM). Modul tuntas sempurna dan kamu mendapatkan +{$modul->poin_modul} EXP! 🎓🎉";
        } elseif ($isLulus) {
            $pesan = "Hebat! Kamu lulus kuis modul dengan nilai {$skorPersen} (KKM: {$kkm}). Pastikan materi juga sudah ditandai selesai agar modul tuntas.";
        } else {
            $pesan = "Nilai kuis kamu: {$skorPersen} (KKM: {$kkm}). Belum mencapai KKM, silakan pelajari kembali materi dan coba lagi ya!";
        }

        return back()->with($isLulus ? 'success' : 'error', $pesan);
    }

    /* ---------------------------------------------------------------------
     |  DAFTAR LATIHAN SOAL & QUIZ
     * ------------------------------------------------------------------- */

    public function latihanSoalModul($id_modul)
    {
        $modul = Modul::with(['tipeModul', 'jenjang'])->findOrFail($id_modul);

        if ($modul->isDraft()) {
            return redirect()->route('siswa.modul')->withErrors([
                'modul' => 'Latihan soal untuk modul ini belum tersedia karena modul masih dalam bentuk draf.',
            ]);
        }

        $user = Auth::user();

        if ($user && $user->id_jenjang && $modul->id_jenjang && $modul->id_jenjang != $user->id_jenjang) {
            return redirect()->route('siswa.modul')->withErrors([
                'modul' => 'Latihan soal modul ini tidak tersedia untuk jenjang Anda.',
            ]);
        }

        // Tanpa kuis terkait dan tanpa jenjang, tidak ada yang bisa ditampilkan.
        // (Grup where kosong akan diabaikan Eloquent dan menampilkan SEMUA kuis.)
        if (!$modul->id_quiz && !$modul->id_jenjang) {
            $quizzes = collect();

            return view('siswa.latihan-soal-modul', compact('modul', 'quizzes'));
        }

        $quizzes = Quiz::published()
            ->belumKadaluarsa()
            ->where(function ($q) use ($modul) {
                $q->when($modul->id_quiz, fn($qq) => $qq->where('id_quiz', $modul->id_quiz))
                    ->when($modul->id_jenjang, fn($qq) => $qq->orWhere('id_jenjang', $modul->id_jenjang));
            })
            // Siswa hanya melihat kuis untuk jenjangnya sendiri.
            ->when($user && $user->id_jenjang, fn($q) => $q->where('id_jenjang', $user->id_jenjang))
            ->with([
                'tipeQuiz',
                'tingkatQuiz',
                'hasil' => fn($q) => $user ? $q->where('id_user', $user->id_user) : $q,
            ])
            ->withCount('soal')
            ->latest()
            ->get();

        return view('siswa.latihan-soal-modul', compact('modul', 'quizzes'));
    }

    public function latihanSoal(Request $request)
    {
        $user = Auth::user();

        $query = Quiz::published()->belumKadaluarsa()->with(['tipeQuiz', 'tingkatQuiz']);

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

        $user = Auth::user();

        $query = Quiz::published()->belumKadaluarsa()->with([
            'tipeQuiz',
            'tingkatQuiz',
            'jenjang',
            'soal.jenisSoal',
            'hasil' => fn($q) => $user ? $q->where('id_user', $user->id_user) : $q,
        ]);

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

    public function detailQuiz($id_quiz)
    {
        $quiz = $this->muatQuiz($id_quiz);

        if ($tolak = $this->tolakJikaBukanJenjangnya($quiz, 'siswa.quiz')) {
            return $tolak;
        }

        $user = Auth::user();
        $hasilSiswa = $user ? HasilQuizModul::where('id_user', $user->id_user)
            ->where('id_quiz', $quiz->id_quiz)
            ->where('is_lulus', true)
            ->where('poin_didapat', '>', 0)
            ->orderByDesc('poin_didapat')
            ->first() : null;

        $totalPoin = $quiz->soal->sum('poin');
        $totalSoal = $quiz->soal->count();

        return view('siswa.quiz-detail', compact('quiz', 'totalPoin', 'totalSoal', 'hasilSiswa'));
    }

    public function mulaiQuiz(Request $request, $id_quiz)
    {
        $quiz = $this->muatQuiz($id_quiz);

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

        // Jika kuis memerlukan token
        if ($quiz->perluToken()) {
            $tokenInput = trim((string) $request->input('token', ''));

            if ($tokenInput === '') {
                return redirect()->back()->withInput()->withErrors([
                    'token' => 'Token kuis wajib diisi untuk memulai.',
                    'id_quiz' => $quiz->id_quiz,
                ]);
            }

            if (strcasecmp($tokenInput, $quiz->token) !== 0) {
                return redirect()->back()->withInput()->withErrors([
                    'token' => 'Token kuis salah. Silakan tanyakan token kepada guru Anda.',
                    'id_quiz' => $quiz->id_quiz,
                ]);
            }

            session(["quiz_token_verified_{$quiz->id_quiz}" => true]);
        }

        return redirect()->route('siswa.quiz.kerjakan', $quiz->id_quiz);
    }

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

        // Jika kuis memerlukan token dan siswa belum verifikasi token serta belum ada attempt berjalan
        if ($quiz->perluToken() && !$this->punyaAttemptAktif($quiz)) {
            if (!session("quiz_token_verified_{$quiz->id_quiz}")) {
                return redirect()->route('siswa.quiz.detail', $quiz->id_quiz)->withErrors([
                    'token' => 'Kuis ini memerlukan token. Silakan masukkan token kuis.',
                ]);
            }
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

        // Pada mode biasa (tipe normal), jika bukan auto-submit karena waktu habis,
        // seluruh soal wajib dijawab sebelum dapat mengumpulkan kuis.
        if ($quiz->mode_pengerjaan === 'biasa' && !$request->boolean('is_timeout')) {
            $nomorBelumDijawab = [];
            foreach ($quiz->soal->values() as $idx => $s) {
                $jawab = $jawabanSiswa[$s->id_soal] ?? null;
                if ($jawab === null || (is_string($jawab) && trim($jawab) === '')) {
                    $nomorBelumDijawab[] = $idx + 1;
                }
            }

            if (!empty($nomorBelumDijawab)) {
                $pesanNomor = count($nomorBelumDijawab) === 1
                    ? "nomor {$nomorBelumDijawab[0]}"
                    : "nomor " . implode(', ', array_slice($nomorBelumDijawab, 0, -1)) . " dan " . end($nomorBelumDijawab);

                return redirect()->back()
                    ->withInput()
                    ->withErrors(['quiz' => "Jawaban belum lengkap! Soal {$pesanNomor} belum dijawab. Harap jawab semua soal sebelum mengumpulkan kuis."]);
            }
        }

        // ---- Penilaian ----
        [$benar, $totalPoinQuiz, $poinDidapat] = $this->hitungSkor($quiz, $jawabanSiswa);

        $totalSoal = $quiz->soal->count();
        $isLulus = $totalSoal > 0 && ($benar / $totalSoal) >= self::RASIO_LULUS;

        // Simpan rank lama sebelum poin masuk untuk deteksi level-up
        $oldRankInfo = $user->rank_tier;
        $oldRankName = $oldRankInfo['current_rank'] ?? 'Pemula';

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

        if ($poinDiberikan > 0) {
            $freshUser = $user->fresh();
            Achievement::syncForUser($freshUser);

            $newRankInfo = $freshUser->refreshRankTier();
            $newRankName = $newRankInfo['current_rank'] ?? 'Pemula';

            // Jika naik pangkat baru, simpan ke flash session agar modal animasi muncul
            if ($newRankName !== $oldRankName && $newRankName !== 'Pemula') {
                session()->flash('rank_up', [
                    'old_rank' => $oldRankName,
                    'new_rank' => $newRankName,
                    'badge_url' => $newRankInfo['current_badge_url'],
                    'poin' => (int) ($freshUser->total_poin ?? 0),
                    'poin_diberikan' => $poinDiberikan,
                ]);
            }
        }

        // Percobaan selesai: bersihkan kedua jenis attempt dan status token.
        session()->forget([
            $this->attemptSessionKey($quiz),
            $this->waygroundAttemptSessionKey($quiz),
            "quiz_token_verified_{$quiz->id_quiz}",
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
        $quiz = Quiz::where('id_quiz', $id_quiz)->orWhere('kode_quiz', $id_quiz)->firstOrFail();

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
    private function muatQuiz($identifier): Quiz
    {
        return Quiz::with([
            'soal' => fn($q) => $q->orderBy('id_soal'),
            'soal.jenisSoal',
            'soal.pilihanSoal' => fn($q) => $q->orderBy('label'),
        ])->where(function ($q) use ($identifier) {
            if (is_numeric($identifier)) {
                $q->where('id_quiz', $identifier)->orWhere('kode_quiz', $identifier);
            } else {
                $q->where('kode_quiz', $identifier);
            }
        })->firstOrFail();
    }

    // Hanya siswa dengan jenjang yang sama yang boleh mengerjakan kuis.
    // Kuis tanpa jenjang (null) terbuka untuk semua. Kuis draf ditolak.
    private function tolakJikaBukanJenjangnya(Quiz $quiz, string $routeDaftar)
    {
        if ($quiz->isDraft()) {
            return redirect()->route($routeDaftar)->withErrors([
                'quiz' => 'Kuis masih dalam bentuk draf dan belum dipublikasikan.',
            ]);
        }

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
        $query = $this->filteredStudentsQuery($request)
            ->with(['jenjang', 'tipeUser']);

        $siswas = $query->latest()->paginate(10)->withQueryString();
        $filteredStudentCount = (clone $query)->count();

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
        $jenjangs = Jenjang::orderBy('nama_tipe')->get();

        return view('admin.daftar_siswa.data_siswa', compact(
            'siswas',
            'totalSiswa',
            'totalAktif',
            'totalNonaktif',
            'totalPerluDitinjau',
            'listKelas',
            'jenjangs',
            'filteredStudentCount'
        ));
    }

    private function filteredStudentsQuery(Request $request)
    {
        $query = User::where('id_tipeuser', 3);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kelas')) {
            $kelas = $request->input('kelas');
            $query->whereHas('jenjang', function ($q) use ($kelas) {
                $q->where('nama_tipe', $kelas);
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');

            $query->where(function ($q) use ($status) {
                $q->where('status_akun', $status);

                if ($status === 'Aktif') {
                    $q->orWhereNull('status_akun');
                }
            });
        }

        return $query;
    }

    public function updateStudentJenjangMassal(Request $request)
    {
        $data = $request->validate([
            'id_jenjang' => ['required', 'integer', 'exists:jenjang,id_jenjang'],
            'all_filtered' => ['required', 'boolean'],
            'student_ids' => ['nullable', 'array', 'max:5000'],
            'student_ids.*' => ['integer', 'distinct', 'exists:user,id_user'],
            'search' => ['nullable', 'string', 'max:255'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'in:Aktif,Nonaktif'],
        ]);

        if (!$data['all_filtered'] && empty($data['student_ids'])) {
            return back()
                ->withInput()
                ->withErrors(['student_ids' => 'Pilih setidaknya satu siswa atau terapkan ke semua hasil filter.']);
        }

        $query = $data['all_filtered']
            ? $this->filteredStudentsQuery($request)
            : User::where('id_tipeuser', 3)->whereIn('id_user', $data['student_ids']);

        $updatedCount = DB::transaction(function () use ($query, $data) {
            return $query
                ->where(function ($q) use ($data) {
                    $q->whereNull('id_jenjang')
                        ->orWhere('id_jenjang', '!=', $data['id_jenjang']);
                })
                ->update(['id_jenjang' => $data['id_jenjang']]);
        });

        $jenjang = Jenjang::findOrFail($data['id_jenjang']);

        return redirect()
            ->route('admin.daftar_siswa', $request->only(['search', 'kelas', 'status', 'page']))
            ->with('success', "Jenjang {$jenjang->nama_tipe} berhasil diterapkan pada {$updatedCount} siswa.");
    }

    public function adminLihatProfilSiswa($id)
    {
        $siswa = User::where('id_tipeuser', 3)
            ->with(['jenjang', 'tipeUser'])
            ->findOrFail($id);

        // Sinkronkan capaian penghargaan siswa sesuai poin yang diperoleh
        if (class_exists(Achievement::class)) {
            Achievement::syncForUser($siswa);
        }

        // Leaderboard rank pada jenjang yang sama
        $peringkat = User::where('id_tipeuser', 3)
            ->when($siswa->id_jenjang, fn($q) => $q->where('id_jenjang', $siswa->id_jenjang))
            ->where('total_poin', '>', (int) $siswa->total_poin)
            ->count() + 1;

        $totalSiswaJenjang = User::where('id_tipeuser', 3)
            ->when($siswa->id_jenjang, fn($q) => $q->where('id_jenjang', $siswa->id_jenjang))
            ->count();

        // Modul statistics
        $totalModulJenjang = Modul::published()
            ->when($siswa->id_jenjang, fn($q) => $q->where('id_jenjang', $siswa->id_jenjang))
            ->count();

        // Riwayat pengerjaan kuis siswa
        $quizResults = HasilQuizModul::where('id_user', $siswa->id_user)
            ->with('quiz')
            ->orderByDesc('waktu_dapat')
            ->get();

        $totalPercobaan = $quizResults->count();
        $kuisLulus = $quizResults->where('is_lulus', true)->count();
        $kuisGagal = $totalPercobaan - $kuisLulus;
        $uniqueQuizLulus = $quizResults->where('is_lulus', true)->pluck('id_quiz')->unique()->count();

        $nilaiList = $quizResults->map(function ($hasil) {
            return (float) $hasil->total_poin > 0
                ? round(($hasil->poin_didapat / $hasil->total_poin) * 100, 1)
                : 0;
        });

        $rataRataNilai = $nilaiList->isNotEmpty() ? round($nilaiList->avg(), 1) : 0;
        $nilaiTertinggi = $nilaiList->isNotEmpty() ? $nilaiList->max() : 0;

        // Modul selesai berdasarkan kuis modul yang lulus
        $quizLulusIds = $quizResults->where('is_lulus', true)->pluck('id_quiz')->unique();
        $modulSelesai = $quizLulusIds->isNotEmpty()
            ? Modul::whereIn('id_quiz', $quizLulusIds)->distinct()->count('id_modul')
            : 0;

        $progresModulPersen = $totalModulJenjang > 0
            ? min(100, (int) round(($modulSelesai / $totalModulJenjang) * 100))
            : 0;

        // Data untuk Grafik Tren Nilai (Urut dari waktu terlama ke terbaru)
        $chartDataTrend = $quizResults->sortBy('waktu_dapat')->values()->map(function ($hasil) {
            $nilai = (float) $hasil->total_poin > 0
                ? round(($hasil->poin_didapat / $hasil->total_poin) * 100, 1)
                : 0;
            return [
                'judul' => $hasil->quiz?->judul ?? ('Kuis #' . $hasil->id_quiz),
                'tanggal' => $hasil->waktu_dapat ? Carbon::parse($hasil->waktu_dapat)->format('d M H:i') : '-',
                'nilai' => $nilai,
                'poin' => (int) $hasil->poin_didapat,
                'total_poin' => (int) $hasil->total_poin,
                'is_lulus' => (bool) $hasil->is_lulus,
            ];
        });

        // Data untuk Grafik Aktivitas Harian
        $chartAktivitas = $quizResults->groupBy(function ($hasil) {
            return $hasil->waktu_dapat ? Carbon::parse($hasil->waktu_dapat)->toDateString() : 'Lainnya';
        })->map(function ($group, $date) {
            return [
                'tanggal' => $date !== 'Lainnya' ? Carbon::parse($date)->translatedFormat('d M') : 'Lainnya',
                'jumlah' => $group->count(),
            ];
        })->values()->take(10);

        // Pencapaian / Achievements
        $achievementsUnlocked = PencapaianUser::with('achievement')
            ->where('id_user', $siswa->id_user)
            ->orderByDesc('waktu_pencapaian')
            ->get();

        $allAchievements = Achievement::where('is_active', true)
            ->orderBy('minimal_poin_achivement')
            ->get();

        // Orang tua terhubung
        $orangtuaList = OrangtuaSiswa::with('orangtua')
            ->where('id_siswa', $siswa->id_user)
            ->get();

        // Semua jenjang
        $jenjangs = Jenjang::orderBy('nama_tipe')->get();

        return view('admin.daftar_siswa.profil_siswa', compact(
            'siswa',
            'peringkat',
            'totalSiswaJenjang',
            'totalModulJenjang',
            'totalPercobaan',
            'kuisLulus',
            'kuisGagal',
            'uniqueQuizLulus',
            'rataRataNilai',
            'nilaiTertinggi',
            'modulSelesai',
            'progresModulPersen',
            'quizResults',
            'chartDataTrend',
            'chartAktivitas',
            'achievementsUnlocked',
            'allAchievements',
            'orangtuaList',
            'jenjangs'
        ));
    }

    public function updateStudentData(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'id_jenjang' => ['nullable', 'integer', 'exists:jenjang,id_jenjang'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        }

        $siswa = User::where('id_tipeuser', 3)->find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.',
            ], 404);
        }

        try {
            $siswa->nama = $data['nama'];
            $siswa->id_jenjang = $data['id_jenjang'] ?? null;
            $siswa->save();
            $siswa->load('jenjang');
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data siswa. Silakan coba lagi.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diperbarui.',
            'siswa' => [
                'nama' => $siswa->nama,
                'id_jenjang' => $siswa->id_jenjang,
                'jenjang' => $siswa->jenjang->nama_tipe ?? $siswa->kelas ?? '-',
            ],
        ]);
    }

    public function updateStudentJenjang(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'id_jenjang' => ['nullable', 'integer', 'exists:jenjang,id_jenjang'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ], 422);
        }

        $siswa = User::where('id_tipeuser', 3)->find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.',
            ], 404);
        }

        try {
            $siswa->id_jenjang = $data['id_jenjang'] ?? null;
            $siswa->save();
            $siswa->load('jenjang');
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah jenjang siswa. Silakan coba lagi.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jenjang siswa berhasil diperbarui.',
            'jenjang' => $siswa->jenjang->nama_tipe ?? $siswa->kelas ?? '-',
        ]);
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

    public function index()
    {
        return view('dashboard');
    }

    public function profile()
    {
        $user = auth()->user()->fresh()->load('jenjang');

        // Sinkronkan capaian penghargaan siswa sesuai poin yang diperoleh
        Achievement::syncForUser($user);

        $jenjangs = Jenjang::orderBy('nama_tipe')->get();
        $hasIsLulus = \Illuminate\Support\Facades\Schema::hasColumn('hasilquizmodul', 'is_lulus');
        $kuisLulusExpr = $hasIsLulus
            ? 'COUNT(DISTINCT CASE WHEN is_lulus = 1 THEN id_quiz END) as kuis_lulus'
            : 'COUNT(DISTINCT id_quiz) as kuis_lulus';

        $scoreSummary = HasilQuizModul::query()
            ->where('id_user', $user->id_user)
            ->selectRaw("COUNT(*) as total_percobaan, {$kuisLulusExpr}, COUNT(*) as jumlah_kuis, COALESCE(SUM(total_poin), 0) as total_poin_maks, COALESCE(SUM(poin_didapat), 0) as poin_didapat")
            ->first();

        $quizResults = HasilQuizModul::query()
            ->where('id_user', $user->id_user)
            ->with('quiz:id_quiz,judul')
            ->orderBy('waktu_dapat')
            ->orderBy('id_hasil')
            ->get(['id_hasil', 'id_quiz', 'waktu_dapat', 'total_poin', 'poin_didapat'])
            ->map(function ($hasil) {
                $hasil->nilai = (int) $hasil->total_poin > 0
                    ? round($hasil->poin_didapat / $hasil->total_poin * 100, 1)
                    : null;

                return $hasil;
            });
        $scoreTrend = $quizResults->groupBy(function ($hasil) {
            return \Illuminate\Support\Carbon::parse($hasil->waktu_dapat)->toDateString();
        })->map(function ($dailyResults, $date) {
            $tanggal = \Illuminate\Support\Carbon::parse($date);

            return [
                'tanggal' => $tanggal->translatedFormat('d M'),
                'detail' => $tanggal->translatedFormat('d M Y'),
                'jumlah_pengerjaan' => $dailyResults->count(),
            ];
        })->values();
        $achievements = PencapaianUser::with('achievement')
            ->where('id_user', $user->id_user)
            ->orderByDesc('waktu_pencapaian')
            ->take(6)
            ->get();

        $qrSvg = null;
        $kelasList = collect();
        if (\Illuminate\Support\Facades\Schema::hasColumn('user', 'qr_token')) {
            $renderer = new ImageRenderer(new RendererStyle(280, 1), new SvgImageBackEnd());
            $qrSvg = (new Writer($renderer))->writeString($user->qrPayload());
            $qrSvg = preg_replace('/^<\?xml.*?\?>\s*/s', '', $qrSvg);
            if (\Illuminate\Support\Facades\Schema::hasTable('kelas_siswa')) {
                $kelasList = $user->kelasDiikuti()->orderBy('nama')->pluck('nama');
            }
        }

        return view('siswa.profil_siswa', compact(
            'user',
            'jenjangs',
            'scoreSummary',
            'scoreTrend',
            'quizResults',
            'achievements',
            'qrSvg',
            'kelasList'
        ));
    }

    public function updateProfile(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'username' => [
            'required',
            'string',
            'max:50',
            Rule::unique('user', 'username')->ignore($user->id_user, 'id_user'),
        ],
        'nomor_hp'     => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
        'kelas'        => ['nullable', 'string', 'max:50'],
        'asal_sekolah' => ['nullable', 'string', 'max:255'],
        'foto_profil'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        // 'nama', 'nisn', dan 'id_jenjang' sengaja dihapus dari validasi 
        // karena bersifat readonly di view siswa dan tidak dikirim via form.
    ]);

    $oldPhoto = $user->foto_profil;

    // Isi atribut selain foto_profil
    $user->fill(collect($validated)->except('foto_profil')->all());

    // Handle upload foto profil jika ada berkas baru
    if ($request->hasFile('foto_profil')) {
        $user->foto_profil = $request->file('foto_profil')->store('profil-siswa', 'public');
    }

    $user->save();

    // Hapus foto profil lama jika ada foto baru yang berhasil diunggah
    if ($oldPhoto && $request->hasFile('foto_profil')) {
        Storage::disk('public')->delete($oldPhoto);
    }

    return redirect()->route('siswa.profil')->with('success', 'Profil berhasil diperbarui.');
}
}
<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Jenjang;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\TingkatQuiz;
use App\Models\HasilQuizModul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    private const WAYGROUND_SUBMISSION_GRACE_SECONDS = 10;

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
        // Menampilkan daftar modul untuk belajar
        $moduls = Modul::with(['tipeModul', 'jenjang'])->latest()->get();
        return view('siswa.modul', compact('moduls'));
    }

    public function materiVideo()
    {
        // Menampilkan daftar modul yang ada videonya
        $moduls = Modul::with(['tipeModul', 'jenjang'])->latest()->get();

        return view('siswa.materi-video-list', compact('moduls'));
    }

    public function materiVideoDetail($id_modul)
    {
        $modul = Modul::with(['materiVideo' => function($q) {
            $q->orderBy('urutan', 'asc');
        }])->findOrFail($id_modul);

        return view('siswa.materi-video', compact('modul'));
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

    public function kerjakanLatihan($id_quiz)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->findOrFail($id_quiz);
        return $this->tampilkanQuiz($quiz, 'siswa.latihan-soal');
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

        if (isset($filters['sort']) && $filters['sort'] === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $quizzes = $query->get();
        $tingkatQuizList = TingkatQuiz::orderBy('id_tingkatquiz')->get();

        return view('siswa.quiz', compact('quizzes', 'tingkatQuizList'));
    }

    public function kerjakanQuiz($id_quiz)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->findOrFail($id_quiz);
        return $this->tampilkanQuiz($quiz, 'siswa.quiz');
    }

    public function previewQuiz($id_quiz)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->findOrFail($id_quiz);

        return view('siswa.mengerjakan-quiz', [
            'quiz' => $quiz,
            'remainingSeconds' => null,
            'isPreview' => true,
        ]);
    }

    private function tampilkanQuiz(Quiz $quiz, string $routeDaftar)
    {
        if ($quiz->sudahKadaluarsa()) {
            return redirect()->route($routeDaftar)->withErrors([
                'quiz' => 'Waktu kuis sudah berakhir.',
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

            $activeQuestionIndex = (int) $attempt['active_question_index'];
            $activeQuestion = $quiz->soal->values()->get($activeQuestionIndex);

            if (!$activeQuestion) {
                session()->forget($attemptKey);
                return redirect()->route($routeDaftar)->withErrors([
                    'quiz' => 'Sesi pengerjaan kuis tidak valid. Silakan mulai kembali.',
                ]);
            }

            $questionRemainingSeconds = max(
                0,
                (int) ($activeQuestion->durasi_detik ?? 20)
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
        $quiz = Quiz::with('soal.pilihanSoal')->findOrFail($id_quiz);
        $user = Auth::user();
        $jawabanSiswa = $request->input('jawaban', []);
        $jawabanSiswa = is_array($jawabanSiswa) ? $jawabanSiswa : [];

        if ($quiz->sudahKadaluarsa()) {
            return redirect()->route('siswa.quiz')->withErrors([
                'quiz' => 'Waktu kuis sudah berakhir.',
            ]);
        }

        $attemptKey = $this->attemptSessionKey($quiz);
        if ($quiz->mode_pengerjaan === 'wayground') {
            $attemptKey = $this->waygroundAttemptSessionKey($quiz);
            $attempt = session($attemptKey);

            if (!$attempt) {
                return redirect()->route('siswa.quiz')->withErrors([
                    'quiz' => 'Silakan mulai kuis terlebih dahulu.',
                ]);
            }

            $activeQuestionIndex = (int) $attempt['active_question_index'];
            $activeQuestion = $quiz->soal->values()->get($activeQuestionIndex);

            if (!$activeQuestion) {
                session()->forget($attemptKey);
                return redirect()->route('siswa.quiz')->withErrors([
                    'quiz' => 'Sesi pengerjaan kuis tidak valid. Silakan mulai kembali.',
                ]);
            }

            $questionDuration = max(1, (int) ($activeQuestion->durasi_detik ?? 20));
            $elapsedSeconds = now()->timestamp - (int) $attempt['question_started_at'];

            if ($elapsedSeconds < $questionDuration) {
                return redirect()->route('siswa.quiz.kerjakan', $quiz->id_quiz)->withErrors([
                    'quiz' => 'Waktu untuk soal ini belum habis.',
                ]);
            }

            $attempt['answers'][$activeQuestion->id_soal] = $elapsedSeconds <= $questionDuration + self::WAYGROUND_SUBMISSION_GRACE_SECONDS
                ? ($jawabanSiswa[$activeQuestion->id_soal] ?? null)
                : null;
            $nextQuestionIndex = $activeQuestionIndex + 1;

            if ($nextQuestionIndex < $quiz->soal->count()) {
                $attempt['active_question_index'] = $nextQuestionIndex;
                $attempt['question_started_at'] = now()->timestamp;
                session([$attemptKey => $attempt]);

                return redirect()->route('siswa.quiz.kerjakan', $quiz->id_quiz);
            }

            $jawabanSiswa = $attempt['answers'];
            session()->forget($attemptKey);
        }

        if ($quiz->mode_pengerjaan === 'biasa' && $quiz->durasi_total_menit) {
            $startedAt = session($attemptKey);
            if (!$startedAt) {
                return redirect()->route('siswa.quiz')->withErrors([
                    'quiz' => 'Silakan mulai kuis terlebih dahulu.',
                ]);
            }

            $elapsedSeconds = now()->timestamp - (int) $startedAt;
            if ($elapsedSeconds > $quiz->durasi_total_menit * 60) {
                session()->forget($attemptKey);
                return redirect()->route('siswa.quiz')->withErrors([
                    'quiz' => 'Waktu pengerjaan kuis sudah habis.',
                ]);
            }
        }

        $totalSoal = $quiz->soal->count();

        $benar = 0;
        
        $totalPoinQuiz = 0;
        $poinDidapat = 0;

        foreach ($quiz->soal as $soal) {
            $poinSoal = $soal->poin ?? 10;
            $totalPoinQuiz += $poinSoal;

            if (isset($jawabanSiswa[$soal->id_soal])) {
                $jawab = $jawabanSiswa[$soal->id_soal];
                $jawab = is_scalar($jawab) ? strtolower(trim((string) $jawab)) : '';

                if ($soal->pilihanSoal->isNotEmpty()) {
                    $correctChoices = $soal->pilihanSoal->where('is_correct', true);
                    $isCorrect = $correctChoices->count() === 1
                        && strtolower(trim($correctChoices->first()->label)) === $jawab;
                } else {
                    $isCorrect = strtolower(trim($soal->jawaban_benar)) === $jawab;
                }

                if ($isCorrect) {
                    $benar++;
                    $poinDidapat += $poinSoal;
                }
            }
        }

        // Syarat lulus minimal 70% benar
        $isLulus = $totalSoal > 0 && ($benar / $totalSoal) >= 0.70;

        $sudahMendapatPoinUntukQuizIni = HasilQuizModul::where('id_user', $user->id_user)
            ->where('id_quiz', $quiz->id_quiz)
            ->where('is_lulus', true)
            ->exists();

        if ($isLulus && $poinDidapat > 0 && !$sudahMendapatPoinUntukQuizIni) {
            $user->total_poin += $poinDidapat;
            $user->save();
        }

        $hasil = HasilQuizModul::create([
            'id_user' => $user->id_user,
            'id_quiz' => $quiz->id_quiz,
            'total_poin' => $totalPoinQuiz,
            'poin_didapat' => $poinDidapat,
            'is_lulus' => $isLulus,
            'waktu_dapat' => now(),
        ]);

        session()->forget($attemptKey);

        return redirect()->route('siswa.quiz')->with('quiz_result', [
            'poin_didapat' => $poinDidapat,
            'benar' => $benar,
            'total_soal' => $totalSoal,
            'is_lulus' => $isLulus
        ]);
    }

    private function attemptSessionKey(Quiz $quiz): string
    {
        return 'quiz_attempt.' . Auth::id() . '.' . $quiz->id_quiz;
    }

    private function waygroundAttemptSessionKey(Quiz $quiz): string
    {
        return 'wayground_attempt.' . Auth::id() . '.' . $quiz->id_quiz;
    }

    public function hasilQuiz($id_quiz, $id_hasil)
    {
        $quiz = Quiz::findOrFail($id_quiz);
        $hasil = HasilQuizModul::where('id_hasil', $id_hasil)->where('id_user', Auth::id())->firstOrFail();

        return view('siswa.quiz-result', compact('quiz', 'hasil'));
    }

    public function dataSiswa(Request $request) 
{
    // Query dasar mengambil data siswa (id_tipeuser = 3)
    $query = User::with(['jenjang', 'tipeUser'])->where('id_tipeuser', 3);

    // Filter pencarian berdasarkan nama atau email
    if ($request->has('search') && $request->search != '') {
        $query->where(function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('kelas')) {
    $query->whereHas('jenjang', function ($q) use ($request) {
        $q->where('nama_tipe', $request->kelas);
    });
    }

    if ($request->filled('status')) {
        $query->where('status_akun', $request->status);
    }

    // Ambil data siswa berpagination
    $siswas = $query->latest()->paginate(10);

    // Total Siswa Keseluruhan
    $totalSiswa = User::where('id_tipeuser', 3)->count();
    
    // Set angka default agar tidak crash karena kolom 'status' belum ada di tabel user
    $totalAktif = $totalSiswa; 
    $totalNonaktif = 0;
    $totalPerluDitinjau = 0;

    // Data opsi kelas untuk dropdown filter
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
}

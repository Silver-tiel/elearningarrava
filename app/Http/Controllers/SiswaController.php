<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\HasilQuizModul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
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

    public function latihanSoal()
    {
        // Menampilkan daftar latihan soal (biasanya quiz dengan tipe latihan)
        $quizzes = Quiz::with(['tipeQuiz', 'tingkatQuiz'])->latest()->get();
        return view('siswa.latihan-soal', compact('quizzes'));
    }

    public function kerjakanLatihan($id_quiz)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->findOrFail($id_quiz);
        return view('siswa.mengerjakan-quiz', compact('quiz'));
    }

    public function quiz()
    {
        $quizzes = Quiz::with(['tipeQuiz', 'tingkatQuiz'])->latest()->get();
        return view('siswa.quiz', compact('quizzes'));
    }

    public function kerjakanQuiz($id_quiz)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->findOrFail($id_quiz);
        return view('siswa.mengerjakan-quiz', compact('quiz'));
    }

    public function submitQuiz(Request $request, $id_quiz)
    {
        $quiz = Quiz::with('soal.pilihanSoal')->findOrFail($id_quiz);
        $user = Auth::user();
        $jawabanSiswa = $request->input('jawaban', []); // format: ['id_soal' => 'A']

        $benar = 0;
        $totalSoal = $quiz->soal->count();

        foreach ($quiz->soal as $soal) {
            if (isset($jawabanSiswa[$soal->id_soal])) {
                $jawab = $jawabanSiswa[$soal->id_soal];
                // Cek apakah jawaban teks cocok atau id pilihan cocok
                $pilihanBenar = $soal->pilihanSoal->where('is_correct', true)->first();
                if ($pilihanBenar && $pilihanBenar->label === $jawab) {
                    $benar++;
                } elseif ($soal->jawaban_benar === $jawab) {
                    $benar++;
                }
            }
        }

        $poinDidapat = $totalSoal > 0 ? round(($benar / $totalSoal) * 100) : 0;

        $hasil = HasilQuizModul::create([
            'id_user' => $user->id_user,
            'id_quiz' => $quiz->id_quiz,
            'total_poin' => 100,
            'poin_didapat' => $poinDidapat,
            'waktu_dapat' => now(),
        ]);

        return redirect()->route('siswa.quiz.result', ['quiz' => $quiz->id_quiz, 'hasil' => $hasil->id_hasil]);
    }

    public function hasilQuiz($id_quiz, $id_hasil)
    {
        $quiz = Quiz::findOrFail($id_quiz);
        $hasil = HasilQuizModul::where('id_hasil', $id_hasil)->where('id_user', Auth::id())->firstOrFail();

        return view('siswa.quiz-result', compact('quiz', 'hasil'));
    }
}

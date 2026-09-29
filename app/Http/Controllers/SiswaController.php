<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Quiz;
use App\Models\Soal;
use App\Models\HasilQuizModul;
use App\Models\User;
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
        $jawabanSiswa = $request->input('jawaban', []);

        if ($quiz->waktu_kadaluarsa && now()->gt($quiz->waktu_kadaluarsa)) {
            return redirect()->back()->withErrors([
                'quiz' => 'Waktu kuis sudah berakhir.',
            ]);
        }

        $totalSoal = $quiz->soal->count();

        if ($totalSoal > 0 && count($jawabanSiswa) !== $totalSoal) {
            return redirect()->back()->withErrors([
                'jawaban' => 'Harap isi semua soal sebelum submit kuis.',
            ]);
        }

        $benar = 0;
        
        $totalPoinQuiz = 0;
        $poinDidapat = 0;

        foreach ($quiz->soal as $soal) {
            $poinSoal = $soal->poin ?? 10;
            $totalPoinQuiz += $poinSoal;

            if (isset($jawabanSiswa[$soal->id_soal])) {
                $jawab = $jawabanSiswa[$soal->id_soal];
                $pilihanBenar = $soal->pilihanSoal->where('is_correct', true)->first();
                
                $isCorrect = false;
                if ($pilihanBenar && strtolower(trim($pilihanBenar->label)) === strtolower(trim($jawab))) {
                    $isCorrect = true;
                } elseif (strtolower(trim($soal->jawaban_benar)) === strtolower(trim($jawab))) {
                    $isCorrect = true;
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
            ->where('poin_didapat', '>', 0)
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
            'waktu_dapat' => now(),
        ]);

        return redirect()->back()->with('quiz_result', [
            'poin_didapat' => $poinDidapat,
            'benar' => $benar,
            'total_soal' => $totalSoal,
            'is_lulus' => $isLulus
        ]);
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
        $query->where('kelas', $request->kelas);
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
    $listKelas = ['Kelas 10 - IPA 1', 'Kelas 10 - IPS 1', 'Kelas 11 - IPA 4', 'Kelas 11 - IPS 3', 'Kelas 12 - IPA 2', 'Kelas 12 - IPS 2'];

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

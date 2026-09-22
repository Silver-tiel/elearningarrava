<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
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
        $moduls = Modul::with(['tipeModul', 'jenjang'])->whereHas('tipeModul', function($q) {
            $q->where('nama_tipe', 'like', '%video%');
        })->orWhereHas('materiVideo')->latest()->get();
        
        return view('siswa.materi-video-index', compact('moduls'));
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
        return view('siswa.mengerjakan-latihan', compact('quiz'));
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
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Digunakan untuk query jika belum ada Model khusus

class SiswaController extends Controller
{
    public function index()
    {
        // 1. Ambil data siswa yang sedang login
        $user = Auth::user();

        // 2. Ambil data statistik dari database
        // (Contoh query real dari DB - sesuaikan nama tabel/kolom dengan database Anda)
        $totalXp = DB::table('xp_log')->where('id_user', $user->id_user)->sum('point') ?? 0;
        $hariStreak = DB::table('streaks')->where('id_user', $user->id_user)->value('total_days') ?? 0;
        
        // 3. Ambil daftar Modul Pelajaran
        $modulPelajaran = DB::table('modul')
                            ->join('guru', 'modul.id_guru', '=', 'guru.id_guru')
                            ->select('modul.*', 'guru.nama as nama_guru')
                            ->limit(3)
                            ->get();

        // 4. Ambil daftar Tugas / Latihan Soal Aktif
        $latihanSoal = DB::table('tugas')
                        ->where('id_user', $user->id_user)
                        ->where('status', 'belum_selesai')
                        ->orderBy('deadline', 'asc')
                        ->limit(3)
                        ->get();

        // 5. Ambil data Progress Kelas/Materi Aktif
        $materiAktif = DB::table('progress_belajar')
                        ->where('id_user', $user->id_user)
                        ->latest('updated_at')
                        ->first();

        // Kirim data ke view dashboard_siswa
        return view('dashboard_siswa', compact(
            'user', 
            'totalXp', 
            'hariStreak', 
            'modulPelajaran', 
            'latihanSoal', 
            'materiAktif'
        ));
    }
}
>>>>>>> 7877a60552d5db3a2a46dbebeaebfa6e882ae319

<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Soal;
use App\Models\PilihanSoal;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Controller khusus untuk mengelola data kuis pembelajaran.
class QuizController extends Controller
{
    // Menampilkan daftar kuis untuk halaman admin atau siswa.
    public function index()
    {
        $quizzes = Quiz::with(['tipeQuiz', 'tingkatQuiz', 'jenjang'])->withCount('soal')->latest()->get();

        return view('admin.quiz.index', ['quizzes' => $quizzes]);
    }

    // Menampilkan form untuk menambah kuis baru (bergaya Kahoot).
    public function create()
    {
        $jenjangList = Jenjang::all();
        $tingkatQuizList = \App\Models\TingkatQuiz::all();
        return view('admin.quiz.create', compact('jenjangList', 'tingkatQuizList'));
    }

    // Menyimpan kuis baru beserta soal dan pilihan jawaban ke database.
    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'id_jenjang'       => 'required|integer',
            'id_tipequiz'      => 'nullable|integer',
            'id_tingkatquiz'   => 'nullable|integer',
            'waktu_kadaluarsa' => 'nullable|date',
            'soal'             => 'required|array|min:1',
            'soal.*.pertanyaan' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan quiz
            $quiz = Quiz::create([
                'judul'            => $request->judul,
                'id_jenjang'       => $request->id_jenjang,
                'id_tipequiz'      => $request->id_tipequiz ?? 1,
                'id_tingkatquiz'   => $request->id_tingkatquiz ?? 1,
                'waktu_kadaluarsa' => $request->waktu_kadaluarsa ?: null,
                'proggressQuiz'    => 'Tersedia',
            ]);

            // 2. Simpan setiap soal
            foreach ($request->soal as $soalData) {
                $jenisSoal = $soalData['jenis_soal'] ?? 'kuis';
                $jawabanBenar = 'A';

                if ($jenisSoal === 'isian_singkat') {
                    $jawabanBenar = $soalData['jawaban_singkat'] ?? '';
                } elseif (isset($soalData['pilihan']) && is_array($soalData['pilihan'])) {
                    $correctChoice = collect($soalData['pilihan'])->where('is_correct', '1')->first();
                    $jawabanBenar = $correctChoice['label'] ?? 'A';
                }

                $soal = Soal::create([
                    'id_quiz'       => $quiz->id_quiz,
                    'id_jenjang'    => $request->id_jenjang,
                    'pertanyaan'    => $soalData['pertanyaan'],
                    'jawaban_benar' => $jawabanBenar,
                    'poin'          => $soalData['poin'] ?? 10,
                ]);

                // 3. Simpan pilihan jawaban (jika bukan isian singkat)
                if ($jenisSoal !== 'isian_singkat' && isset($soalData['pilihan']) && is_array($soalData['pilihan'])) {
                    foreach ($soalData['pilihan'] as $pilihanData) {
                        if (trim($pilihanData['teks_pilihan'] ?? '') === '') continue;

                        PilihanSoal::create([
                            'id_soal'      => $soal->id_soal,
                            'label'        => $pilihanData['label'],
                            'teks_pilihan' => $pilihanData['teks_pilihan'],
                            'is_correct'   => ($pilihanData['is_correct'] ?? '0') == '1',
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.quiz')->with('success', 'Quiz berhasil dibuat! 🎉');
    }
}

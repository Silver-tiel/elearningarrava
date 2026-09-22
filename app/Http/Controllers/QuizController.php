<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

// Controller khusus untuk mengelola data kuis pembelajaran.
class QuizController extends Controller
{
    // Menampilkan daftar kuis untuk halaman admin atau siswa.
    public function index()
    {
        $quizzes = Quiz::all();

        return view('admin.quiz.index', ['quizzes' => $quizzes]);
    }

    // Menampilkan form untuk menambah kuis baru.
    public function create()
    {
        return view('admin.quiz.create');
    }

    // Menyimpan kuis baru ke database.
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'id_tipequiz' => 'required|integer',
            'id_tingkatquiz' => 'required|integer',
        ]);

        Quiz::create([
            'judul' => $request->judul,
            'id_tipequiz' => $request->id_tipequiz,
            'id_tingkatquiz' => $request->id_tingkatquiz,
            'hasil_quiz' => $request->hasil_quiz,
            'proggressQuiz' => $request->proggressQuiz,
            'foto_quiz' => $request->foto_quiz,
        ]);

        return redirect()->route('admin.quiz')->with('success', 'Quiz berhasil ditambahkan.');
    }
}

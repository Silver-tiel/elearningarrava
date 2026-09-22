<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match ((int) $user->id_tipeuser) {
            1 => redirect()->route('admin.dashboard'),
            2 => redirect()->route('guru.dashboard'),
            3 => redirect()->route('siswa.dashboard'),
            default => abort(403, 'Tipe pengguna tidak dikenali.'),
        };
    }

    public function admin()
    {
        return view('admin.dashboard');
    }

    public function guru(Request $request)
    {
        $modulCount = class_exists(\App\Models\Modul::class)
            ? \App\Models\Modul::count()
            : 0;

        $quizCount = class_exists(\App\Models\Quiz::class)
            ? \App\Models\Quiz::count()
            : 0;

        return view('guru', [
            'user' => $request->user(),
            'modulCount' => $modulCount,
            'quizCount' => $quizCount,
        ]);
    }

    public function siswa(Request $request)
    {
        $modulCount = class_exists(\App\Models\Modul::class)
            ? \App\Models\Modul::count()
            : 0;

        $quizCount = class_exists(\App\Models\Quiz::class)
            ? \App\Models\Quiz::count()
            : 0;

        return view('siswa.dashboard', [
            'user' => $request->user(),
            'modulCount' => $modulCount,
            'quizCount' => $quizCount,
        ]);
    }

    public function siswaModul(Request $request)
    {
        $moduls = \App\Models\Modul::with(['tipeModul', 'jenjang'])
            ->latest()
            ->get();

        return view('siswa.modul', [
            'user' => $request->user(),
            'moduls' => $moduls,
        ]);
    }

    public function siswaQuiz(Request $request)
    {
        $quizzes = \App\Models\Quiz::latest()->get();

        return view('siswa.quiz', [
            'user' => $request->user(),
            'quizzes' => $quizzes,
        ]);
    }
}

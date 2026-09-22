<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\SiswaController;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman pendaftaran.
Route::get('/pendaftaran', function () {
    $jenjang = App\Models\jenjang::all();
    return view('pendaftaran', ['jenjang' => $jenjang]);
})->name('pendaftaran');

// Beranda diarahkan ke pendaftaran seperti project awal.
Route::get('/', function () {
    $jenjang = App\Models\jenjang::all();
    return view('pendaftaran', ['jenjang' => $jenjang]);
});

// Login.
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Lupa password - UI dan endpoint awal. Pengiriman email reset dapat disambungkan
// ke Laravel Password Broker ketika konfigurasi mail sudah tersedia.
Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    return back()->with('status', 'Jika email terdaftar, tautan pengaturan ulang akan diproses.');
})->name('password.email');

// Proses pendaftaran.
Route::post('/pendaftaran', [PendaftaranController::class, 'UserBaru'])->name('pendaftaranBaru');

// Dashboard.
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user && ($user->id_tipeuser == 1 || $user->id_tipeuser == 2)) {
        return redirect()->route('admin');
    }
    return redirect()->route('siswa.dashboard');
})->middleware('auth');

// Admin dashboard.
Route::get('/admin', function () {
    $user = Auth::user();
    // Siswa tidak boleh akses halaman admin
    if ($user && $user->id_tipeuser == 3) {
        return redirect()->route('siswa.dashboard');
    }

    return view('admin.admin', [
        'siswaCount'   => User::where('id_tipeuser', 3)->count(),
        'guruCount'    => User::where('id_tipeuser', 2)->count(),
        'modulCount'   => Modul::count(),
        'quizCount'    => Quiz::count(),
        'siswaTerbaru' => User::where('id_tipeuser', 3)->latest()->take(5)->get(),
        'modulTerbaru' => Modul::with(['jenjang'])->latest()->take(5)->get(),
    ]);
})->middleware('auth')->name('admin');

// Siswa.
Route::prefix('siswa')->name('siswa.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');

    Route::get('/belajar', [SiswaController::class, 'belajar'])->name('modul');

    Route::get('/materi-video', [SiswaController::class, 'materiVideo'])->name('materi-video');
    Route::get('/materi-video/{id_modul}', [SiswaController::class, 'materiVideoDetail'])->name('materi-video.detail');

    Route::get('/latihan-soal', [SiswaController::class, 'latihanSoal'])->name('latihan-soal');
    Route::get('/latihan-soal/{quiz}', [SiswaController::class, 'kerjakanLatihan'])->name('latihan-soal.kerjakan');

    Route::get('/quiz', [SiswaController::class, 'quiz'])->name('quiz');
    Route::get('/quiz/{quiz}', [SiswaController::class, 'kerjakanQuiz'])->name('quiz.kerjakan');
    Route::post('/quiz/{quiz}/submit', [SiswaController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/quiz/{quiz}/result/{hasil}', [SiswaController::class, 'hasilQuiz'])->name('quiz.result');
});

// Admin resource routes (dikelompokkan dengan prefix & middleware)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/modul',        [ModulController::class, 'index'])->name('admin.modul');
    Route::get('/modul/create', [ModulController::class, 'create'])->name('modul.create');
    Route::post('/modul/store', [ModulController::class, 'store'])->name('modul.store');

    Route::get('/quiz',         [QuizController::class, 'index'])->name('admin.quiz');
    Route::get('/quiz/create',  [QuizController::class, 'create'])->name('quiz.create');
    Route::get('/quiz/create',  [QuizController::class, 'create'])->name('admin.quiz.create');
    Route::post('/quiz/store',  [QuizController::class, 'store'])->name('quiz.store');
    Route::post('/quiz/store',  [QuizController::class, 'store'])->name('admin.quiz.store');

    Route::get('/soal',         [SoalController::class, 'index'])->name('admin.soal');
    Route::get('/soal/create',  [SoalController::class, 'create'])->name('soal.create');
    Route::post('/soal/store',  [SoalController::class, 'store'])->name('soal.store');
    Route::get('/soal/{id}/edit', [SoalController::class, 'edit'])->name('soal.edit');
    Route::put('/soal/{id}',    [SoalController::class, 'update'])->name('soal.update');
    Route::delete('/soal/{id}', [SoalController::class, 'destroy'])->name('soal.destroy');
});

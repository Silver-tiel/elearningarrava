<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SoalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Landing / auth.
Route::get('/', function () {
    $jenjang = App\Models\Jenjang::all();
    return view('pendaftaran', compact('jenjang'));
});

Route::get('/pendaftaran', function () {
    $jenjang = App\Models\Jenjang::all();
    return view('pendaftaran', compact('jenjang'));
})->name('pendaftaran');

Route::post('/pendaftaran', [PendaftaranController::class, 'UserBaru'])
    ->name('pendaftaranBaru');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => ['required', 'email']]);
    return back()->with('status', 'Jika email terdaftar, tautan pengaturan ulang akan diproses.');
})->name('password.email');

// Setelah login, arahkan berdasarkan id_tipeuser.
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin.
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('root');
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/modul', [ModulController::class, 'index'])->name('modul');
        Route::get('/modul/create', [ModulController::class, 'create'])->name('modul.create');
        Route::post('/modul/store', [ModulController::class, 'store'])->name('modul.store');
        Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');
        Route::get('/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
        Route::post('/quiz/store', [QuizController::class, 'store'])->name('quiz.store');
        Route::get('/soal', [SoalController::class, 'index'])->name('soal');
        Route::get('/soal/create', [SoalController::class, 'create'])->name('soal.create');
        Route::post('/soal/store', [SoalController::class, 'store'])->name('soal.store');
    });

    // Guru.
    Route::prefix('guru')->name('guru.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
        Route::get('/modul', [ModulController::class, 'index'])->name('modul');
        Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');
    });

    // Siswa.
    Route::prefix('siswa')->name('siswa.')->middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\SiswaController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/belajar', [\App\Http\Controllers\SiswaController::class, 'belajar'])->name('modul');
        
        Route::get('/materi-video', [\App\Http\Controllers\SiswaController::class, 'materiVideo'])->name('materi-video');
        Route::get('/materi-video/{modul}', [\App\Http\Controllers\SiswaController::class, 'materiVideoDetail'])->name('materi-video.detail');
        
        Route::get('/latihan-soal', [\App\Http\Controllers\SiswaController::class, 'latihanSoal'])->name('latihan-soal');
        Route::get('/latihan-soal/{quiz}', [\App\Http\Controllers\SiswaController::class, 'kerjakanLatihan'])->name('latihan-soal.kerjakan');
        
        Route::get('/quiz', [\App\Http\Controllers\SiswaController::class, 'quiz'])->name('quiz');
        Route::get('/quiz/{quiz}', [\App\Http\Controllers\SiswaController::class, 'kerjakanQuiz'])->name('quiz.kerjakan');
        Route::post('/quiz/{quiz}/submit', [\App\Http\Controllers\SiswaController::class, 'submitQuiz'])->name('quiz.submit');
        Route::get('/quiz/{quiz}/result/{hasil}', [\App\Http\Controllers\SiswaController::class, 'hasilQuiz'])->name('quiz.result');
    });
});

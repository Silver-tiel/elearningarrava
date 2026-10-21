<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\OrangtuaController;
use App\Models\Modul;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnakSayaController;
use App\Http\Controllers\PerkembanganNilaiController;


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

// // Lupa password - UI dan endpoint awal. Pengiriman email reset dapat disambungkan
// // ke Laravel Password Broker ketika konfigurasi mail sudah tersedia.
// Route::get('/forgot-password', function () {
//     return view('forgot-password');
// })->name('password.request');

// Route::post('/forgot-password', function (Request $request) {
//     $request->validate([
//         'email' => ['required', 'email'],
//     ]);

//     return back()->with('status', 'Jika email terdaftar, tautan pengaturan ulang akan diproses.');
// })->name('password.email');

// Proses pendaftaran.
Route::post('/pendaftaran', [PendaftaranController::class, 'UserBaru'])->name('pendaftaranBaru');

// Dashboard.
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user && ($user->id_tipeuser == 1 || $user->id_tipeuser == 2)) {
        return redirect()->route('admin');
    }
    if ($user && $user->id_tipeuser == 4) {
        return redirect()->route('orangtua.dashboard');
    }
    return redirect()->route('siswa.dashboard');
})->middleware(['auth', 'active.student']);

// Orangtua routes.
Route::prefix('orangtua')
    ->name('orangtua.')
    ->middleware(['auth', 'active.student', 'role:orangtua'])
    ->group(function () {
        Route::get('/dashboard', [OrangtuaController::class, 'dashboard'])->name('dashboard');

        Route::get('/anak-saya', [AnakSayaController::class, 'index'])->name('anak-saya');

        Route::get('/perkembangan-nilai', [PerkembanganNilaiController::class, 'index'])->name('perkembangan-nilai');
    });

// Global Route untuk semua user login
Route::get('/modul/{id}/show', [ModulController::class, 'show'])->name('modul.show')->middleware(['auth', 'active.student']);

// Admin dashboard.
Route::get('/admin', function () {
    $user = Auth::user();
    // Siswa tidak boleh akses halaman admin
    if ($user && $user->id_tipeuser == 3) {
        return redirect()->route('siswa.dashboard');
    }

    return view('admin.admin', [
        'siswaCount'       => User::where('id_tipeuser', 3)->count(),
        'guruCount'        => User::where('id_tipeuser', 2)->count(),
        'modulCount'       => Modul::count(),
        'quizCount'        => Quiz::count(),
        'achievementCount' => Achievement::count(),
        'siswaTerbaru'     => User::where('id_tipeuser', 3)->latest()->take(5)->get(),
        'modulTerbaru'     => Modul::with(['jenjang'])->latest()->take(5)->get(),
    ]);
})->middleware(['auth', 'active.student'])->name('admin');

// Siswa.
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'active.student', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');

    // Halaman Belajar
    Route::get('/belajar', [SiswaController::class, 'belajar'])->name('modul');
    Route::get('/belajar/{id_modul}/materi', [SiswaController::class, 'materiVideoDetail'])->name('modul.materi');
    Route::get('/belajar/{id_modul}/latihan', [SiswaController::class, 'latihanSoalModul'])->name('modul.latihan');

    // Quiz global (tetap ada)
    Route::get('/quiz', [SiswaController::class, 'quiz'])->name('quiz');
    Route::get('/quiz/{quiz}', [SiswaController::class, 'kerjakanQuiz'])->name('quiz.kerjakan');
    Route::post('/quiz/{quiz}/submit', [SiswaController::class, 'submitQuiz'])->name('quiz.submit');

    Route::get('/profil', [SiswaController::class, 'profile'])->name('profil');
    Route::put('/profil/update', [SiswaController::class, 'updateProfile'])->name('profil.update');
});

// Profil guru (hanya untuk guru yang login)
Route::get('/admin/profil', [GuruController::class, 'profil'])
    ->middleware(['auth', 'role:guru'])
    ->name('admin.profil');

// Admin resource routes (dikelompokkan dengan prefix & middleware)
Route::prefix('admin')->middleware(['auth', 'active.student', 'role:admin,guru'])->group(function () {
    Route::get('/modul', [ModulController::class, 'index'])->name('admin.modul');
    Route::get('/modul/create', [ModulController::class, 'create'])->name('admin.modul.create');
    Route::post('/modul/store', [ModulController::class, 'store'])->name('admin.modul.store');
    Route::get('/modul/{id}/edit', [ModulController::class, 'edit'])->name('admin.modul.edit');
    Route::put('/modul/{id}', [ModulController::class, 'update'])->name('admin.modul.update');
    Route::delete('/modul/{id}', [ModulController::class, 'destroy'])->name('admin.modul.destroy');

    Route::get('/quiz',         [QuizController::class, 'index'])->name('admin.quiz');
    Route::get('/quiz/create',  [QuizController::class, 'create'])->name('quiz.create');
    Route::get('/quiz/create',  [QuizController::class, 'create'])->name('admin.quiz.create');
    Route::get('/quiz/{id}/edit', [QuizController::class, 'edit'])->name('admin.quiz.edit');
    Route::put('/quiz/{id}', [QuizController::class, 'update'])->name('admin.quiz.update');
    Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('admin.quiz.destroy');
    Route::get('/quiz/{id}/preview', [SiswaController::class, 'previewQuiz'])->name('admin.quiz.preview');
    Route::post('/quiz/store',  [QuizController::class, 'store'])->name('quiz.store');
    Route::post('/quiz/store',  [QuizController::class, 'store'])->name('admin.quiz.store');

    Route::get('/soal',         [SoalController::class, 'index'])->name('admin.soal');
    Route::get('/soal/create',  [SoalController::class, 'create'])->name('soal.create');
    Route::post('/soal/store',  [SoalController::class, 'store'])->name('soal.store');
    Route::get('/soal/{id}/edit', [SoalController::class, 'edit'])->name('soal.edit');
    Route::put('/soal/{id}',    [SoalController::class, 'update'])->name('soal.update');
    Route::delete('/soal/{id}', [SoalController::class, 'destroy'])->name('soal.destroy');

    // Route untuk Halaman Utama/Tabel Daftar Siswa
    Route::get('/data', [SiswaController::class, 'dataSiswa'])->name('admin.daftar_siswa');
    Route::patch('/data/{id}', [SiswaController::class, 'updateStudentData'])->name('admin.siswa.update');
    Route::patch('/data/{id}/jenjang', [SiswaController::class, 'updateStudentJenjang'])->name('admin.siswa.jenjang');
    Route::patch('/data/{id}/status', [SiswaController::class, 'updateStatus'])->name('admin.siswa.status');

    // Route Guru
    Route::get('/guru', [GuruController::class, 'index'])->name('admin.guru');
    Route::get('/guru/create', [GuruController::class, 'create'])->name('admin.guru.create');
    Route::post('/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::get('/guru/{id}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');

    // Route Achievement / Penghargaan Siswa
    Route::get('/achievement', [AchievementController::class, 'index'])->name('admin.achievement');
    Route::get('/achievement/create', [AchievementController::class, 'create'])->name('admin.achievement.create');
    Route::post('/achievement', [AchievementController::class, 'store'])->name('admin.achievement.store');
    Route::get('/achievement/{id}/edit', [AchievementController::class, 'edit'])->name('admin.achievement.edit');
    Route::put('/achievement/{id}', [AchievementController::class, 'update'])->name('admin.achievement.update');
    Route::delete('/achievement/{id}', [AchievementController::class, 'destroy'])->name('admin.achievement.destroy');
    Route::post('/achievement/{id}/sync', [AchievementController::class, 'sync'])->name('admin.achievement.sync');
});

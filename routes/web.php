<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SoalController;
use Illuminate\Http\Request;
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
    return view('index');
})->middleware('auth');

// Admin.
Route::get('/admin', function () {
    $user = Auth::user();
    if ($user && $user->id_tipeuser == 3) {
        return redirect('/dashboard');
    }
    $users = App\Models\User::all();
    return view('admin', ['users' => $users]);
})->middleware('auth')->name('admin');

Route::get('/admin/modul', [ModulController::class, 'index'])->middleware('auth')->name('admin.modul');
Route::get('/admin/modul/create', [ModulController::class, 'create'])->middleware('auth')->name('modul.create');
Route::post('/admin/modul/store', [ModulController::class, 'store'])->middleware('auth')->name('modul.store');

Route::get('/admin/quiz', [QuizController::class, 'index'])->middleware('auth')->name('admin.quiz');
Route::get('/admin/quiz/create', [QuizController::class, 'create'])->middleware('auth')->name('quiz.create');
Route::post('/admin/quiz/store', [QuizController::class, 'store'])->middleware('auth')->name('quiz.store');

Route::get('/admin/soal', [SoalController::class, 'index'])->middleware('auth')->name('admin.soal');
Route::get('/admin/soal/create', [SoalController::class, 'create'])->middleware('auth')->name('soal.create');
Route::post('/admin/soal/store', [SoalController::class, 'store'])->middleware('auth')->name('soal.store');

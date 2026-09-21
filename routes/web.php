<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SoalController;
use Illuminate\Support\Facades\Route;

// Halaman pendaftaran: menampilkan form pendaftaran dengan daftar jenjang yang tersedia.
Route::get('/pendaftaran', function () {
    $jenjang = App\Models\jenjang::all();
    return view('pendaftaran', ['jenjang' => $jenjang]);
})->name('pendaftaran');

// Halaman login untuk pengguna yang sudah mempunyai akun.
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Halaman utama aplikasi diarahkan ke form pendaftaran agar calon peserta dapat mendaftar.
Route::get('/', function () {
    $jenjang = App\Models\jenjang::all();
    return view('pendaftaran', ['jenjang' => $jenjang]);
});

// Proses submit pendaftaran user baru dan validasi data input yang dikirim.
Route::post('/pendaftaran', [PendaftaranController::class, 'UserBaru'])->name('pendaftaranBaru');

// Login form dan proses login manual menggunakan controller custom.
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Halaman admin yang hanya bisa diakses oleh user yang sudah login.
Route::get('/admin', function () {
    $users = App\Models\User::all();
    return view('admin', ['users' => $users]);
})->middleware('auth')->name('admin');

// Halaman kelola modul di area admin.
Route::get('/admin/modul', [ModulController::class, 'index'])->middleware('auth')->name('admin.modul');
Route::get('/admin/modul/create', [ModulController::class, 'create'])->middleware('auth')->name('modul.create');
Route::post('/admin/modul/store', [ModulController::class, 'store'])->middleware('auth')->name('modul.store');

// Halaman kelola quiz di area admin.
Route::get('/admin/quiz', [QuizController::class, 'index'])->middleware('auth')->name('admin.quiz');
Route::get('/admin/quiz/create', [QuizController::class, 'create'])->middleware('auth')->name('quiz.create');
Route::post('/admin/quiz/store', [QuizController::class, 'store'])->middleware('auth')->name('quiz.store');

// Halaman kelola soal di area admin, dengan penentuan jenjang per soal.
Route::get('/admin/soal', [SoalController::class, 'index'])->middleware('auth')->name('admin.soal');
Route::get('/admin/soal/create', [SoalController::class, 'create'])->middleware('auth')->name('soal.create');
Route::post('/admin/soal/store', [SoalController::class, 'store'])->middleware('auth')->name('soal.store');

// Dashboard setelah login berhasil, menampilkan halaman utama aplikasi.
Route::get('/dashboard', function () {
    return view('index');
})->middleware('auth');

Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
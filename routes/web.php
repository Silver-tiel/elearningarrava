<?php

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\LoginController;
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

// Dashboard setelah login berhasil, menampilkan halaman utama aplikasi.
Route::get('/dashboard', function () {
    return view('index');
})->middleware('auth');


<?php

use App\Http\Controllers\Admin\AttendanceSessionController;
use App\Http\Controllers\AttendanceCheckInController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Absensi Mentor/Guru dengan QR (dibuat Admin)
|--------------------------------------------------------------------------
| Dimuat dari routes/web.php (group `web`: session + CSRF aktif).
| Pengguna yang belum login dialihkan ke /login oleh middleware `auth`, lalu
| kembali ke halaman check-in setelah login (url.intended).
*/

// ADMIN: kelola sesi, QR, rekap.
Route::prefix('admin/attendance')
    ->name('admin.attendance.')
    ->middleware(['auth', 'active.student', 'role:admin'])
    ->group(function () {
        Route::get('/', [AttendanceSessionController::class, 'index'])->name('index');
        Route::get('/create', [AttendanceSessionController::class, 'create'])->name('create');
        Route::post('/', [AttendanceSessionController::class, 'store'])->name('store');
        Route::get('/{attendanceSession}/qr', [AttendanceSessionController::class, 'qr'])->whereNumber('attendanceSession')->name('qr');
        Route::get('/{attendanceSession}/report', [AttendanceSessionController::class, 'report'])->whereNumber('attendanceSession')->name('report');
        Route::get('/{attendanceSession}/export', [AttendanceSessionController::class, 'export'])->whereNumber('attendanceSession')->name('export');
        Route::patch('/{attendanceSession}/close', [AttendanceSessionController::class, 'close'])->whereNumber('attendanceSession')->name('close');
    });

// MENTOR/GURU: scan QR atau input token, check-in untuk diri sendiri.
Route::prefix('attendance')
    ->name('attendance.')
    ->middleware(['auth', 'active.student', 'role:guru'])
    ->group(function () {
        Route::get('/scan', [AttendanceCheckInController::class, 'scan'])->name('scan');
        Route::get('/check-in', [AttendanceCheckInController::class, 'confirm'])->middleware('throttle:30,1')->name('check-in.link');
        Route::post('/check-in', [AttendanceCheckInController::class, 'store'])->middleware('throttle:20,1')->name('check-in');
    });

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PresensiController;

// AUTH
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'active.student'])->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);

    // Dashboard & Leaderboard
    Route::get('/student/dashboard', [DashboardController::class, 'studentDashboard']);
    Route::get('/student/profile', [DashboardController::class, 'studentProfile']);
    Route::match(['put', 'post'], '/student/profile', [DashboardController::class, 'updateStudentProfile']);
    Route::get('/parent/dashboard', [DashboardController::class, 'parentDashboard']);
    Route::get('/leaderboard', [DashboardController::class, 'leaderboard']);
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard']);
    Route::get('/teachers', [DashboardController::class, 'teachers']);
    Route::get('/students', [DashboardController::class, 'students']);

    // Baca: semua pengguna terautentikasi.
    Route::get('/modules', [ModulController::class, 'apiIndex']);
    Route::get('/modules/{id}', [ModulController::class, 'apiShow']);
    Route::post('/modules/{id}/complete', [SiswaController::class, 'tandaiMateriSelesai']);
    Route::post('/modules/{id}/quiz-submit', [SiswaController::class, 'submitKuisModul']);
    Route::get('/quizzes', [QuizController::class, 'apiIndex']);
    Route::get('/quizzes/{id}', [QuizController::class, 'apiShow']);
    Route::get('/mapel', [QuizController::class, 'apiMapelIndex']);
    Route::post('/quizzes/{id}/verify-token', [QuizController::class, 'apiVerifyToken']);
    Route::post('/quizzes/{id}/submit', [QuizController::class, 'apiSubmitQuiz']);

    // Tulis: hanya admin/guru (kepemilikan dicek lagi lewat Policy).
    Route::middleware('role:admin,guru')->group(function () {
        Route::post('/modules', [ModulController::class, 'apiStore']);
        Route::put('/modules/{id}', [ModulController::class, 'apiUpdate']);
        Route::delete('/modules/{id}', [ModulController::class, 'apiDestroy']);

        Route::post('/quizzes', [QuizController::class, 'apiStore']);
        Route::put('/quizzes/{id}', [QuizController::class, 'apiUpdate']);
        Route::delete('/quizzes/{id}', [QuizController::class, 'apiDestroy']);
        Route::get('/quizzes/questions/bank', [QuizController::class, 'apiQuestionBank']);

        Route::get('/sesi-aktif', [PresensiController::class, 'sesiAktif']);
        Route::get('/sesi/{id_sesi}/rekap', [PresensiController::class, 'rekapApi']);
        Route::post('/{id_sesi}/scan', [PresensiController::class, 'prosesScan']);
    });
});
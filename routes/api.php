<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\QuizController;

// AUTH
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'active.student'])->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);

    // Baca: semua pengguna terautentikasi.
    Route::get('/modules', [ModulController::class, 'apiIndex']);
    Route::get('/modules/{id}', [ModulController::class, 'apiShow']);
    Route::get('/quizzes', [QuizController::class, 'apiIndex']);
    Route::get('/quizzes/{id}', [QuizController::class, 'apiShow']);
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
    });
});
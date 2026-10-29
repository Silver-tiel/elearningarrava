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

    Route::get('/modules', [ModulController::class, 'apiIndex']);

    Route::post('/modules', [ModulController::class, 'apiStore']);

    Route::get('/modules/{id}', [ModulController::class, 'apiShow']);

    Route::put('/modules/{id}', [ModulController::class, 'apiUpdate']);

    Route::delete('/modules/{id}', [ModulController::class, 'apiDestroy']);

    // Quiz
    Route::get('/quizzes/questions/bank', [QuizController::class, 'apiQuestionBank']);
    Route::get('/quizzes', [QuizController::class, 'apiIndex']);
    Route::post('/quizzes', [QuizController::class, 'apiStore']);
    Route::get('/quizzes/{id}', [QuizController::class, 'apiShow']);
    Route::put('/quizzes/{id}', [QuizController::class, 'apiUpdate']);
    Route::delete('/quizzes/{id}', [QuizController::class, 'apiDestroy']);
    Route::post('/quizzes/{id}/verify-token', [QuizController::class, 'apiVerifyToken']);
    Route::post('/quizzes/{id}/submit', [QuizController::class, 'apiSubmitQuiz']);
});
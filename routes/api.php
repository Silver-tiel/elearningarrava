<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ModulController;


// ============================================================
// AUTH
// ============================================================

Route::post('/login', [AuthController::class, 'login']);


// ============================================================
// PROTECTED API
// ============================================================

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);


    // ========================================================
    // MODULE
    // ========================================================

    Route::get('/modules', [ModulController::class, 'apiIndex']);

    Route::post('/modules', [ModulController::class, 'apiStore']);

    Route::get('/modules/{id}', [ModulController::class, 'apiShow']);

    Route::put('/modules/{id}', [ModulController::class, 'apiUpdate']);

    Route::delete('/modules/{id}', [ModulController::class, 'apiDestroy']);
});
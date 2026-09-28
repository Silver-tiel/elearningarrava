<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModulController;

Route::get('/modules', [ModulController::class, 'apiIndex']);

Route::post('/modules', [ModulController::class, 'apiStore']);

Route::get('/modules/{id}', [ModulController::class, 'apiShow']);

Route::put('/modules/{id}', [ModulController::class, 'apiUpdate']);

Route::delete('/modules/{id}', [ModulController::class, 'apiDestroy']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutenticadorController;


// Prefix v1
Route::prefix('v1')->group(function () {
    // Login
    Route::post('/login', [AutenticadorController::class, 'login']);
    Route::post('/registrar', [AutenticadorController::class, 'registrar']);
    Route::post('/registrar', [AutenticadorController::class, 'registrar']);

    // Tokens
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/dados', [AutenticadorController::class, 'dados']);
        Route::post('/logout', [AutenticadorController::class, 'logout']);
    });
});

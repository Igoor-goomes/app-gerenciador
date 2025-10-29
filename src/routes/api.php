<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutenticadorController;
use App\Http\Controllers\Api\ProdutoController as ApiProdutoController;


// Prefix v1
Route::prefix('v1')->group(function () {
    // Login
    Route::post('/login', [AutenticadorController::class, 'login']);
    Route::post('/registrar', [AutenticadorController::class, 'registrar']);

    // Tokens
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('recent_token')->group(function () {
            Route::get('/dados', [AutenticadorController::class, 'dados']);
            Route::post('/logout', [AutenticadorController::class, 'logout']);
            Route::post('/token/refresh', [AutenticadorController::class, 'refresh']);
        });

        // Produtos API CRUD
        Route::apiResource('produtos', ApiProdutoController::class);
    });
});

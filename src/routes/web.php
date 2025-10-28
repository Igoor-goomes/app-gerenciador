<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerenciadorController;

Route::get('/', fn() => to_route('signin'));
Route::prefix('gerenciador')->group(function () {
    // Rotas públicas
    Route::middleware('guest')->group(function () {
        Route::get('/signin', [GerenciadorController::class, 'showLogin'])->name('signin');
        Route::post('/signin', [GerenciadorController::class, 'signIn'])->name('signin.form');
    });

    // Rotas privadas
    Route::middleware('auth')->group(function () {
        Route::get('/home', [GerenciadorController::class, 'index'])->name('home');
        Route::post('/logout', [GerenciadorController::class, 'logout'])->name('logout');
    });
});

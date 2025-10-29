<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerenciadorController;
use App\Http\Controllers\ProdutoController;

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
        Route::view('/sobre', 'sobre')->name('sobre');
        Route::view('/contato', 'contato')->name('contato');

        // Endpoint DataTables antes do resource para evitar conflito com {produto}
        Route::get('produtos/datatable', [ProdutoController::class, 'datatable'])->name('produtos.datatable');
        // CRUD de Produtos
        Route::resource('produtos', ProdutoController::class)->names('produtos');
    });
});

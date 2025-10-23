<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JogosController;

Route::prefix('jogos')->group(function(){
    Route::get('/', [JogosController::class, 'index'])->name('jogos.index');
    Route::get('/create', [JogosController::class, 'create'])->name('jogos.create');
    Route::post('/', [JogosController::class, 'store'])->name('jogos.store');
    Route::get('/{id}/edit', [JogosController::class, 'edit'])->where('id', '[0-9]+')->name('jogos.edit');
    Route::put('/{id}', [JogosController::class, 'update'])->where('id', '[0-9]+')->name('jogos.update');
    Route::delete('/{id}', [JogosController::class, 'destroy'])->where('id', '[0-9]+')->name('jogos-destroy');
});

Route::get('/', function () {
    return redirect()->route('jogos.index');
});

Route::fallback(function(){
    return "Erro ao localizar rota!";
});

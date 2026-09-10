<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DusArsipController; 


Route::prefix('dus_arsip')->name('dus_arsip.')->group(function () {

    Route::get('/search', [DusArsipController::class, 'search'])->name('search'); 
    Route::get('/search-dus', [DusArsipController::class, 'search2'])->name('search2'); 

    Route::get('/', [DusArsipController::class, 'index'])->name('index');
    Route::get('/generate_qr/{id}', [DusArsipController::class, 'generate_qr'])->name('gen_qr');
    Route::post('/', [DusArsipController::class, 'store'])->name('store');
    Route::get('/create', [DusArsipController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [DusArsipController::class, 'edit'])->name('edit');
    Route::get('/{id}/show', [DusArsipController::class, 'show'])->name('show');
    Route::post('/{id}', [DusArsipController::class, 'update'])->name('update');
    Route::delete('/{id}', [DusArsipController::class, 'destroy'])->name('destroy');

});

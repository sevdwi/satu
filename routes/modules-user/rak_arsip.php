<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RakArsipController; 


Route::prefix('rak_arsip')->name('rak_arsip.')->group(function () {

    Route::get('/search', [RakArsipController::class, 'search'])->name('search'); 

    Route::get('/', [RakArsipController::class, 'index'])->name('index');
    Route::post('/', [RakArsipController::class, 'store'])->name('store');
    Route::get('/create', [RakArsipController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [RakArsipController::class, 'edit'])->name('edit');
    Route::post('/{id}', [RakArsipController::class, 'update'])->name('update');
    Route::delete('/{id}', [RakArsipController::class, 'destroy'])->name('destroy');

});

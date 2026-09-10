<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemusnahanArsipController; 


Route::prefix('pemusnahan_arsip')->name('pemusnahan_arsip.')->group(function () {

    Route::get('/data-pemusnahan', [PemusnahanArsipController::class, 'index'])->name('home');
    Route::get('/create', [PemusnahanArsipController::class, 'create'])->name('create');
    Route::post('/', [PemusnahanArsipController::class, 'store'])->name('store');
    Route::post('/upload-ba', [PemusnahanArsipController::class, 'uploadBA'])->name('upload_ba');
    Route::get('/{id}', [PemusnahanArsipController::class, 'show'])->name('show');

});

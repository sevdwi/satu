<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DusArsipController; 


Route::prefix('dus_arsip')->name('dus_arsip.')->group(function () {

// Route::get('/dashbord', [DusArsipController::class, 'dashbord'])->name('index');; 
Route::resource('/', DusArsipController::class);
Route::get('/search', [DusArsipController::class, 'search'])->name('search'); 
Route::get('/{id}/edit/', [DusArsipController::class, 'edit']);
Route::post('/{id}', [DusArsipController::class, 'update']);

});
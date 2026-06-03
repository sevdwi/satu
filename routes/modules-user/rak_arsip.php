<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RakArsipController; 


Route::prefix('rak_arsip')->name('rak_arsip.')->group(function () {

Route::get('/dashbord', [RakArsipController::class, 'dashbord'])->name('index');
Route::get('/search', [RakArsipController::class, 'search'])->name('search'); 
Route::get('/{id}/edit/', [RakArsipController::class, 'edit']);
Route::post('/{id}', [RakArsipController::class, 'update']);
Route::resource('/', RakArsipController::class);

});
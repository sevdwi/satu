<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RakArsipController; 


Route::prefix('rak_arsip')->name('rak_arsip.')->group(function () {

Route::get('/dashbord', [RakArsipController::class, 'dashbord'])->name('index');; 
Route::resource('/', RakArsipController::class);

});
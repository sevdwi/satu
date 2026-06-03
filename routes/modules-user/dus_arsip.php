<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DusArsipController; 


Route::prefix('dus_arsip')->name('dus_arsip.')->group(function () {

Route::get('/dashbord', [DusArsipController::class, 'dashbord'])->name('index');; 
Route::resource('/', DusArsipController::class);

});
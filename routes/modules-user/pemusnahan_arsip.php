<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemusnahanArsipController; 


Route::prefix('pemusnahan_arsip')->name('pemusnahan_arsip.')->group(function () {

Route::get('/dashbord', [PemusnahanArsipController::class, 'dashbord'])->name('index');; 
Route::resource('/', PemusnahanArsipController::class);

});
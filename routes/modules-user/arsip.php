<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController; 


Route::prefix('arsip')->name('arsip.')->group(function () {

Route::get('/dashbord', [ArsipController::class, 'dashbord'])->name('index');; 
Route::resource('/', ArsipController::class);

});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController; 


Route::prefix('arsip')->name('arsip.')->group(function () {

Route::get('/dashbord', [ArsipController::class, 'dashbord']); 
Route::resource('/', ArsipController::class);

});
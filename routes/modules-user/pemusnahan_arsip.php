<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemusnahanArsipController; 


Route::prefix('pemusnahan_arsip')->name('pemusnahan_arsip.')->group(function () {
Route::get('/data-pemusnahan', [PemusnahanArsipController::class, 'index'])
    ->name('home');
Route::get('/{id}', [PemusnahanArsipController::class, 'show'])
    ->name('show');
Route::post('/pemusnahan/upload-ba',[PemusnahanArsipController::class, 'uploadBA'])->name('upload_ba');
Route::get('/dashbord', [PemusnahanArsipController::class, 'dashbord'])->name('index');; 
Route::resource('/', PemusnahanArsipController::class);

});
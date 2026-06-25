<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController; 


Route::prefix('arsip')->name('arsip.')->group(function () {
Route::get('/data', [ArsipController::class, 'index'])
    ->name('home');

Route::get('/{id}/edit/', [ArsipController::class, 'edit']);
Route::get('/search', [ArsipController::class, 'search'])->name('search');

Route::post('/', [ArsipController::class, 'store'])->name('store');
Route::post('/uploads',[ArsipController::class, 'uploads_post'])->name('uploads');
    
Route::post('/{id}', [ArsipController::class, 'update']);
Route::get('/dashbord', [ArsipController::class, 'dashbord'])->name('index');; 
Route::resource('/', ArsipController::class);

});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController;

Route::prefix('arsip')->name('arsip.')->group(function () {

    Route::get('/dashbord', [ArsipController::class, 'dashbord'])
        ->name('dashboard');

    Route::get('/data', [ArsipController::class, 'index'])
        ->name('home');

    Route::get('/data', [ArsipController::class, 'index-admin'])
    ->name('home-admin');

    Route::get('/{id}/data/detail', [ArsipController::class, 'index-admin'])
    ->name('data-admin');

        
	Route::get('/{id}/edit/', [ArsipController::class, 'edit']);
        
	Route::post('/{id}', [ArsipController::class, 'update']);

    Route::post('/upload/{id}', [ArsipController::class, 'upload'])
    ->name('upload');

    Route::resource('', ArsipController::class);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController;

Route::prefix('arsip')->name('arsip.')->group(function () {

    Route::get('/dashbord', [ArsipController::class, 'dashbord'])
        ->name('dashboard');

    // Route::get('/data', [ArsipController::class, 'index'])
    //     ->name('home');

    Route::get('/inaktif', [ArsipController::class, 'index_admin'])
    ->name('home-admin');

    Route::get('/data/{opd_induk_id}/', [ArsipController::class, 'detail_admin'])
    ->name('detail-admin');

        
	Route::get('/{id}/edit/', [ArsipController::class, 'edit']);
        
	Route::post('/{id}', [ArsipController::class, 'update']);

    Route::post('/upload/{id}', [ArsipController::class, 'upload'])
    ->name('upload');

    Route::resource('', ArsipController::class);
});
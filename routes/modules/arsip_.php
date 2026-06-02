<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController;

Route::prefix('arsip')->name('arsip.')->group(function () {

    Route::get('/dashbord', [ArsipController::class, 'dashbord'])
        ->name('dashboard');
        
	Route::get('/{id}/edit/', [ArsipController::class, 'edit']);
        
	Route::post('/{id}', [ArsipController::class, 'update']);

    Route::resource('', ArsipController::class);
});
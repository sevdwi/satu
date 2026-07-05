<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdIndukController;

Route::prefix('opd_induk')->name('opd_induk.')->group(function () {

    Route::resource('/', OpdIndukController::class);
    Route::get('/search', [OpdIndukController::class, 'search'])
    ->name('search');


});


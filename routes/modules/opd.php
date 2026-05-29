<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdController;

Route::prefix('opd')->name('opd.')->group(function () {

    Route::resource('/', OpdController::class);


});


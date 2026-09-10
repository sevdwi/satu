<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterKodeController;

Route::prefix('master_kodes')->name('master_kodes.')->group(function () {
    Route::get('/search', [MasterKodeController::class, 'search'])->name('search');
});

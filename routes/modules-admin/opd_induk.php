<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdIndukController;

Route::prefix('opd_induk')->name('opd_induk.')->group(function () {

    Route::get('/', [OpdIndukController::class, 'index'])->name('index');

    Route::get('/create', [OpdIndukController::class, 'create'])->name('create');

    Route::post('/', [OpdIndukController::class, 'store'])->name('store');

    Route::get('/search', [OpdIndukController::class, 'search'])->name('search');

    Route::get('/{id}/edit', [OpdIndukController::class, 'edit'])->name('edit');

    Route::match(['put', 'patch'], '/{id}', [OpdIndukController::class, 'update'])->name('update');

    Route::delete('/{id}', [OpdIndukController::class, 'destroy'])->name('destroy');

});

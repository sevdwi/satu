<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdController;

Route::prefix('opd_admin')->name('opd_admin.')->group(function () {

    Route::get('/search', [OpdController::class, 'search'])->name('search');

    Route::get('/bidang/{opd_induk_id}/', [OpdController::class, 'index'])->name('index');

    Route::get('/create/{opd_induk_id}/', [OpdController::class, 'create'])->name('create');

    Route::post('/', [OpdController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [OpdController::class, 'edit'])->name('edit');

    Route::match(['put', 'patch'], '/{id}', [OpdController::class, 'update'])->name('update');

    Route::delete('/{id}', [OpdController::class, 'destroy'])->name('destroy');

});

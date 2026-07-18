<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdController;

Route::prefix('opd')->name('opd.')->group(function () {


    // 1. Menampilkan halaman utama (daftar data)
    Route::get('/bidang/{opd_induk_id}/', [OpdController::class, 'index'])->name('index');

    // 2. Menampilkan form untuk membuat data baru
    Route::get('/create/{opd_induk_id}/', [OpdController::class, 'create'])->name('create');

    // 3. Menyimpan data baru yang dikirim dari form
    Route::post('/', [OpdController::class, 'store'])->name('store');

    // 4. Menampilkan detail dari satu data spesifik
    // Route::get('/{id}', [OpdController::class, 'show'])->name('show');

    // 5. Menampilkan form untuk mengedit data spesifik
    Route::get('/{id}/edit', [OpdController::class, 'edit'])->name('edit');

    // 6. Memperbarui data spesifik di database
    Route::match(['put', 'patch'], '/{id}', [OpdController::class, 'update'])->name('update');

    // 7. Menghapus data spesifik dari database
    Route::delete('/{id}', [OpdController::class, 'destroy'])->name('destroy');
    
    Route::get('/search', [OpdController::class, 'search'])
    ->name('search');


});


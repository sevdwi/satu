<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdIndukController;

Route::prefix('opd_induk')->name('opd_induk.')->group(function () {

    // 1. Menampilkan halaman utama (daftar data)
    Route::get('/', [OpdIndukController::class, 'index'])->name('index');

    // 2. Menampilkan form untuk membuat data baru
    Route::get('/create', [OpdIndukController::class, 'create'])->name('create');

    // 3. Menyimpan data baru yang dikirim dari form
    Route::post('/', [OpdIndukController::class, 'store'])->name('store');

    // 4. Menampilkan detail dari satu data spesifik
    Route::get('/{id}', [OpdIndukController::class, 'show'])->name('show');

    // 5. Menampilkan form untuk mengedit data spesifik
    Route::get('/{id}/edit', [OpdIndukController::class, 'edit'])->name('edit');

    // 6. Memperbarui data spesifik di database
    Route::match(['put', 'patch'], '/{id}', [OpdIndukController::class, 'update'])->name('update');

    // 7. Menghapus data spesifik dari database
    Route::delete('/{id}', [OpdIndukController::class, 'destroy'])->name('destroy');


    Route::get('/search', [OpdController::class, 'search'])
    ->name('search');


});


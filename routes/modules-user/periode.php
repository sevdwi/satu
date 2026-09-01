<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodeController; 


Route::prefix('periode')->name('periode.')->group(function () {

    // 1. Menampilkan halaman utama (daftar data)
    Route::get('/', [PeriodeController::class, 'index'])->name('index');

    // Route::get('/data/{periode?}', [PeriodeController::class, 'index'])->name('home');
    // Route::get('/manuver', [PeriodeController::class, 'manuver'])->name('manuver');
    // Route::get('/musnah', [PeriodeController::class, 'musnah'])->name('musnah');
    // Route::get('/bidang/{opd_induk_id}/', [OpdController::class, 'index'])->name('index');



    // 2. Menampilkan form untuk membuat data baru
    Route::get('/create', [PeriodeController::class, 'create'])->name('create');

    // 3. Menyimpan data baru yang dikirim dari form
    Route::post('/', [PeriodeController::class, 'store'])->name('store');

    // 4. Menampilkan detail dari satu data spesifik
    // Route::get('/{id}', [PeriodeController::class, 'show'])->name('show');

    // 5. Menampilkan form untuk mengedit data spesifik
    Route::get('/{opd_id}/edit', [PeriodeController::class, 'edit'])->name('edit');

    // 6. Memperbarui data spesifik di database
    Route::match(['put', 'patch'], '/{id}', [PeriodeController::class, 'update'])->name('update');

    // Route::post('/{id}', [PeriodeController::class, 'update']);

    // 7. Menghapus data spesifik dari database
    Route::delete('/{id}', [PeriodeController::class, 'destroy'])->name('destroy');

    // Route::post('/upload/{id}', [PeriodeController::class, 'upload'])
     
    // Route::get('/dashbord', [PeriodeController::class, 'dashbord'])->name('index');; 
    // Route::resource('/', PeriodeController::class);

});
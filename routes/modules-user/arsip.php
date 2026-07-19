<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController; 


Route::prefix('arsip')->name('arsip.')->group(function () {

    // 1. Menampilkan halaman utama (daftar data)
    // Route::get('/', [ArsipController::class, 'index'])->name('index');

    Route::get('/data', [ArsipController::class, 'index'])->name('home');

    // 2. Menampilkan form untuk membuat data baru
    Route::get('/create', [ArsipController::class, 'create'])->name('create');

    // 3. Menyimpan data baru yang dikirim dari form
    Route::post('/', [ArsipController::class, 'store'])->name('store');

    // 4. Menampilkan detail dari satu data spesifik
    // Route::get('/{id}', [ArsipController::class, 'show'])->name('show');

    // 5. Menampilkan form untuk mengedit data spesifik
    Route::get('/{id}/edit', [ArsipController::class, 'edit'])->name('edit');

    // 6. Memperbarui data spesifik di database
    Route::match(['put', 'patch'], '/{id}', [ArsipController::class, 'update'])->name('update');

    // Route::post('/{id}', [ArsipController::class, 'update']);

    // 7. Menghapus data spesifik dari database
    Route::delete('/{id}', [ArsipController::class, 'destroy'])->name('destroy');

    // Route::post('/upload/{id}', [ArsipController::class, 'upload'])
    Route::post('/uploads',[ArsipController::class, 'uploads_post'])->name('uploads');
    
    Route::get('/search', [ArsipController::class, 'search'])->name('search');
 
    // Route::get('/dashbord', [ArsipController::class, 'dashbord'])->name('index');; 
    // Route::resource('/', ArsipController::class);

});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('users')->name('users.')->group(function () {
    
    // 1. Menampilkan halaman utama (daftar data)
    Route::get('/', [UserController::class, 'index'])->name('index');
    
    // 2. Menampilkan form untuk membuat data baru
    Route::get('/create', [UserController::class, 'create'])->name('create');
    
    // 3. Menyimpan data baru yang dikirim dari form
    Route::post('/', [UserController::class, 'store'])->name('store');

    // 4. Menampilkan detail dari satu data spesifik
    Route::get('/{user}', [UserController::class, 'show'])->name('show');

    // 5. Menampilkan form untuk mengedit data spesifik
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');

    // 6. Memperbarui data spesifik di database
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::patch('/{user}', [UserController::class, 'update']);

    // 7. Menghapus data spesifik dari database
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});
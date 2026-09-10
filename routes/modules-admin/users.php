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

    // Catatan: route show() dihapus — UserController tidak punya method show(),
    // sebelumnya rute ini fatal error kalau diakses langsung (tidak dipakai
    // di mana pun via route('users.show', ...)).

    // 4. Menampilkan form untuk mengedit data spesifik
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');

    // 5. Memperbarui data spesifik di database
    Route::match(['put', 'patch'], '/{user}', [UserController::class, 'update'])->name('update');

    // 6. Menghapus data spesifik dari database
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

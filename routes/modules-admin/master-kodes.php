<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterKodeController;
use App\Http\Controllers\MasterKodeImportController;


Route::prefix('master-kodes')->name('master-kodes.')->group(function () {

Route::get('/search', [MasterKodeController::class, 'search']) ->name('search');
Route::get('/import', [MasterKodeController::class, 'import'])->name('import');

Route::post('/import', [MasterKodeController::class, 'store_import'])->name('store-import');
// Route::get('/search', [MasterKodeController::class, 'search2']);
// Route::resource('/', MasterKodeController::class);

// 1. Menampilkan semua data (Halaman Utama)
Route::get('/', [MasterKodeController::class, 'index'])->name('index');

// 2. Menampilkan formulir tambah data
Route::get('/create', [MasterKodeController::class, 'create'])->name('create');

// 3. Menyimpan data baru ke database
Route::post('/', [MasterKodeController::class, 'store'])->name('store');

// 4. Menampilkan detail satu data spesifik
Route::get('/{id}', [MasterKodeController::class, 'show'])->name('show');

// 5. Menampilkan formulir edit data
Route::get('/{id}/edit', [MasterKodeController::class, 'edit'])->name('edit');

// 6. Menyimpan perubahan data yang diedit
Route::put('/{id}', [MasterKodeController::class, 'update'])->name('update');

// 7. Menghapus data dari database
Route::delete('/{id}', [MasterKodeController::class, 'destroy'])->name('destroy');


});
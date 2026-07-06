<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RakArsipController; 


Route::prefix('rak_arsip')->name('rak_arsip.')->group(function () {
        
    // Rute kustom ditaruh di paling atas agar tidak tertukar dengan parameter ID
    Route::get('/dashbord', [RakArsipController::class, 'dashbord'])->name('dashboard');
    Route::get('/search', [RakArsipController::class, 'search'])->name('search'); 

    // Rute utama (Halaman Utama, Simpan, Tambah, Edit, Update, dan Hapus)
    Route::get('/', [RakArsipController::class, 'index'])->name('index');
    Route::post('/', [RakArsipController::class, 'store'])->name('store');
    Route::get('/create', [RakArsipController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [RakArsipController::class, 'edit'])->name('edit');
    Route::post('/{id}', [RakArsipController::class, 'update'])->name('update');
    
    // WAJIB: Tambahkan rute DELETE ini untuk memperbaiki error MethodNotAllowed sebelumnya
    Route::delete('/{id}', [RakArsipController::class, 'destroy'])->name('destroy');

});
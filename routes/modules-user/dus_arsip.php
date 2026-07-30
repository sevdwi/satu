<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DusArsipController; 


Route::prefix('dus_arsip')->name('dus_arsip.')->group(function () {

    // Route::get('/dashbord', [DusArsipController::class, 'dashbord'])->name('index');; 
    Route::get('/search', [DusArsipController::class, 'search'])->name('search'); 
    Route::get('/search', [DusArsipController::class, 'search2'])->name('search2'); 


    // Rute utama (Halaman Utama, Simpan, Tambah, Edit, Update, dan Hapus)
    Route::get('/', [DusArsipController::class, 'index'])->name('index');
    Route::post('/', [DusArsipController::class, 'store'])->name('store');
    Route::get('/create', [DusArsipController::class, 'create'])->name('create');
    Route::get('/{id}/edit', [DusArsipController::class, 'edit'])->name('edit');
    Route::post('/{id}', [DusArsipController::class, 'update'])->name('update');
    
    // WAJIB: Tambahkan rute DELETE ini untuk memperbaiki error MethodNotAllowed sebelumnya
    Route::delete('/{id}', [DusArsipController::class, 'destroy'])->name('destroy');

});
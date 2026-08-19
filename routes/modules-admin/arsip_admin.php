<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController;

Route::prefix('arsip_admin')->name('arsip_admin.')->group(function () {

    Route::get('/dashbord', [ArsipController::class, 'dashbord'])
        ->name('dashboard');

    // 1. Menampilkan halaman utama (daftar data)
    Route::get('/', [ArsipController::class, 'index'])->name('index');

    Route::get('/inaktif', [ArsipController::class, 'index_admin'])
    ->name('home-admin');

    Route::get('/musnah', [ArsipController::class, 'musnah_admin'])->name('musnah-admin');
    Route::get('/permanen', [ArsipController::class, 'permanen_admin'])->name('permanen-admin');


    Route::get('/data/{opd_induk_id}/', [ArsipController::class, 'detail_admin'])
    ->name('detail-admin');

    // 2. Menampilkan form untuk membuat data baru
    Route::get('/create', [ArsipController::class, 'create'])->name('create');

    // 3. Menyimpan data baru yang dikirim dari form
    Route::post('/', [ArsipController::class, 'store'])->name('store');

    // 4. Menampilkan detail dari satu data spesifik
    Route::get('/{id}', [ArsipController::class, 'show'])->name('show');

    // 5. Menampilkan form untuk mengedit data spesifik
    Route::get('/{id}/edit', [ArsipController::class, 'edit_admin'])->name('edit');

    Route::get('/{id}/edit-status', [ArsipController::class, 'edit_status'])->name('edit-status');

    // 6. Memperbarui data spesifik di database
    Route::match(['put', 'patch'], '/{id}', [ArsipController::class, 'update_admin'])->name('update-admin');

    // 7. Menghapus data spesifik dari database
    Route::delete('/{id}', [ArsipController::class, 'destroy'])->name('destroy');

    // Route::post('/upload/{id}', [ArsipController::class, 'upload'])
    Route::post('/uploads',[ArsipController::class, 'uploads_post'])->name('uploads');

    Route::get('/export/excel', [ArsipController::class, 'exportExcel_admin'])->name('export-admin');

});
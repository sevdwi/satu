<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController;

Route::prefix('arsip_admin')->name('arsip_admin.')->group(function () {

    Route::get('/dashbord', [ArsipController::class, 'dashbord'])
        ->name('dashboard');

    Route::get('/inaktif', [ArsipController::class, 'index_admin'])
        ->name('home-admin');

    Route::get('/musnah', [ArsipController::class, 'musnah_admin'])->name('musnah-admin');
    Route::get('/permanen', [ArsipController::class, 'permanen_admin'])->name('permanen-admin');

    Route::get('/data/{opd_induk_id}/', [ArsipController::class, 'detail_admin'])
        ->name('detail-admin');

    Route::get('/{id}/edit', [ArsipController::class, 'edit_admin'])->name('edit');

    Route::get('/{id}/edit-status', [ArsipController::class, 'edit_status'])->name('edit-status');

    Route::match(['put', 'patch'], '/{id}', [ArsipController::class, 'update_admin'])->name('update-admin');

    Route::delete('/{id}', [ArsipController::class, 'destroy'])->name('destroy');

    Route::post('/uploads',[ArsipController::class, 'uploads_post'])->name('uploads');

    Route::get('/export/excel', [ArsipController::class, 'exportExcel_admin'])->name('export-admin');

});

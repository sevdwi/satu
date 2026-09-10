<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdIndukController;

// Catatan: route '/search' SENGAJA tidak didaftarkan di sini lagi — dulu
// ada 2 kali (di sini dan di modules-user/opd_induk.php) dengan nama rute
// yang sama persis (opd_induk.search). Karena modules-admin di-load lebih
// dulu di routes/web.php, versi admin ini SELALU menang untuk pencocokan
// URL, jadi setiap kali pengolah biasa (bukan admin) pakai fitur cari OPD
// induk di form arsip, request-nya kena middleware admin dan gagal diam-
// diam. Sekarang cukup satu versi di modules-user/opd_induk.php yang
// dipasang di grup 'auth' umum (bisa diakses semua role, termasuk admin).
Route::prefix('opd_induk')->name('opd_induk.')->group(function () {

    Route::get('/', [OpdIndukController::class, 'index'])->name('index');

    Route::get('/create', [OpdIndukController::class, 'create'])->name('create');

    Route::post('/', [OpdIndukController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [OpdIndukController::class, 'edit'])->name('edit');

    Route::match(['put', 'patch'], '/{id}', [OpdIndukController::class, 'update'])->name('update');

    Route::delete('/{id}', [OpdIndukController::class, 'destroy'])->name('destroy');

});

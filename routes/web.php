<?php

use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\AdminUserController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController; 
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DepanController;

use App\Http\Controllers\MasterKodeController;
use App\Http\Controllers\MasterKodeImportController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\ArsipController; 
use App\Http\Controllers\DusArsipController;



Route::get('/', [DepanController::class, 'welcome'])->name('welcome');

Route::get('/dus_arsip/{id}', [DusArsipController::class, 'qr_list_berkas'])->name('qr_list');

//auth admin
Route::get('/administrator', [AdminUserController::class,'loginForm'])->name('login-admin');
Route::post('admin/login', [AdminUserController::class,'login']);
Route::post('admin/logout', [AdminUserController::class,'logout'])->name('logout-admin');

Route::get('/app/dashboard-admin', [AdminUserController::class,'index'])
    ->middleware(['auth', 'admin'])->name('dashboard-admin');

// Satu guard ('web') untuk semua role. Akses khusus admin dibatasi lewat
// middleware 'admin' (App\Http\Middleware\AdminMiddleware, cek role di
// tabel users), BUKAN lewat guard terpisah — sebelumnya ada guard 'admin'
// sendiri yang ternyata baca tabel & model yang sama persis dengan guard
// 'web', jadi cuma duplikasi konsep role lewat mekanisme guard.
Route::middleware(['auth', 'admin'])->prefix('app')->group(function () {
    foreach (glob(__DIR__.'/modules-admin/*.php') as $routeFile) {
        require $routeFile;
    }
});

//auth user
Route::get('/pengolah', [UserController::class,'loginForm'])->name('login');
Route::post('/login', [UserController::class,'login']); 
Route::post('/logout', [UserController::class,'logout'])->name('logout'); 

Route::get('/app/dashboard', [CustomerController::class,'index'])->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->prefix('app')->group(function () {
    foreach (glob(__DIR__.'/modules-user/*.php') as $routeFile) {
        require $routeFile;
    }
});

// Route::get('/opd/search', [OpdController::class, 'search2']);
// Route::resource('master-kodes', MasterKodeController::class);
// Route::resource('opd', OpdController::class);

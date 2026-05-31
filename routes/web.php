<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\MasterKodeController;
use App\Http\Controllers\MasterKodeImportController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\ArsipController; 



Route::get('/', [DepanController::class, 'welcome'])->name('welcome');

//auth admin 
Route::get('/administrator', [AdminUserController::class,'loginForm'])->name('login-admin');
Route::post('admin/login', [AdminUserController::class,'login']);
Route::post('admin/logout', [AdminUserController::class,'logout'])->name('logout-admin');

Route::get('/app/dashboard-admin', function () {
    // dd(session()->all());
    // dd(auth()->user());
    return view('dashboard-admin');
})->middleware('auth:admin')->name('dashboard-admin');

Route::middleware(['auth:admin'])->prefix('app')->group(function () {
    foreach (glob(__DIR__.'/modules-admin/*.php') as $routeFile) {
        require $routeFile;
    }
});

//auth user
Route::get('/user', [UserController::class,'loginForm'])->name('login');
Route::post('/login', [UserController::class,'login']);
Route::post('/logout', [UserController::class,'logout'])->name('logout');

Route::get('/privacy', [WelcomeController::class,'privacy'])->name('privacy');
Route::get('/request-deletion', [WelcomeController::class,'requestDeletion'])->name('request-deletion');
Route::post('/request-deletion-action', [WelcomeController::class,'requestDeletionAction'])->name('account.deletion.submit');

Route::get('/app/dashboard', function () {
    // dd(session()->all());
    // dd(auth()->user());
    return view('dashboard');
})->middleware('auth:web')->name('dashboard');

Route::middleware(['auth:web'])->prefix('app')->group(function () {
    foreach (glob(__DIR__.'/modules-user/*.php') as $routeFile) {
        require $routeFile;
    }
});

// Route::get('/opd/search', [OpdController::class, 'search2']);
// Route::resource('master-kodes', MasterKodeController::class);
// Route::resource('opd', OpdController::class);

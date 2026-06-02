<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterKodeController;
use App\Http\Controllers\MasterKodeImportController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\ArsipController; 


// Route::get('/', function () {
//     // return view('welcome');
//     return view('auth.login');

// });

Route::get('/', [DashboardController::class, 'welcome'])->name('welcome');
Route::get('/administrator', [UserController::class,'loginForm'])->name('login');
Route::post('/login', [UserController::class,'login']);
Route::post('/logout', [UserController::class,'logout'])->name('logout'); 

Route::get('/app/dashboard', function () {
    // dd(session()->all());
    // dd(auth()->user());
    return view('dashboard');
})->middleware('auth:admin')->name('dashboard');

Route::middleware(['auth:admin'])->prefix('app')->group(function () {
    foreach (glob(__DIR__.'/modules/*.php') as $routeFile) {
        require $routeFile;
    }
});

// Route::get('/opd/search', [OpdController::class, 'search2']);
// Route::resource('master-kodes', MasterKodeController::class);
// Route::resource('opd', OpdController::class);

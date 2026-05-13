<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PariwisataImageController;


Route::prefix('pariwisata_images')->name('pariwisata_images.')->group(function () {
    // Route::get('/', [PariwisataImageController::class, 'index'])->name('index');
    // Route::get('/pariwisata/{id}/images', [PariwisataImageController::class,'index'])->name('pariwisata_images.index');

    // Route::get('/create', [PariwisataImageController::class, 'create'])->name('create');
    // Route::get('/pariwisata/{id}/images/create', [PariwisataImageController::class,'create'])->name('pariwisata_images.create');

    // Route::post('/', [PariwisataImageController::class, 'store'])->name('store');
    // Route::post('/pariwisata/{id}/images', [PariwisataImageController::class,'store'])->name('pariwisata_images.store');

    // Route::get('/{pariwisata_images}', [PariwisataImageController::class, 'show'])->name('show');
    // Route::get('/{pariwisata_images}/edit', [PariwisataImageController::class, 'edit'])->name('edit');
    
    // Route::put('/{pariwisata_images}', [PariwisataImageController::class, 'update'])->name('update');
    // Route::patch('/{pariwisata_images}', [PariwisataImageController::class, 'update']);

    // Route::delete('/{pariwisata_images}', [PariwisataImageController::class, 'destroy'])->name('destroy');
    // Route::delete('/pariwisata_images/{id}', [PariwisataImageController::class,'destroy'])->name('pariwisata_images.destroy');

    Route::get('/', [PariwisataImageController::class,'index'])->name('index');

    Route::get('/{id}/create', [PariwisataImageController::class,'create'])->name('create');

    Route::get('/{id}/images', [PariwisataImageController::class,'index'])->name('index');

    Route::get('/{id}/show', [PariwisataImageController::class,'show'])->name('show');

    Route::post('/{id}', [PariwisataImageController::class,'store'])->name('store');

    Route::get('/{id}/edit', [PariwisataImageController::class,'edit'])->name('edit');

    Route::put('/{id}', [PariwisataImageController::class,'update'])->name('update');

    Route::delete('/{id}', [PariwisataImageController::class,'destroy'])->name('destroy');
});
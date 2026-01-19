<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\MapController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TanamanController;
use App\Http\Controllers\Admin\PenyakitController;
use App\Http\Controllers\Frontend\LandingController;

// Landing page publik
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Map publik
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/api/tanaman', [MapController::class, 'data'])->name('api.tanaman');
Route::get('/tanaman/{id}', [MapController::class, 'detail'])->name('tanaman.detail');



// Auth routes (Breeze)
require __DIR__.'/auth.php';

// Admin dashboard & CRUD (harus login)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('tanaman', TanamanController::class)->names('admin.tanaman');
    Route::resource('penyakit', PenyakitController::class)->names('admin.penyakit');
});

// Alias dashboard untuk Breeze
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

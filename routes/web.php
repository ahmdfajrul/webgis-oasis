<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\MapController;
use App\Http\Controllers\Frontend\LandingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TanamanController;
use App\Http\Controllers\Admin\PenyakitController;

/*
|--------------------------------------------------------------------------
| FRONTEND (PUBLIK)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/api/tanaman', [MapController::class, 'data'])->name('api.tanaman');
Route::get('/tanaman/{id}', [MapController::class, 'detail'])->name('tanaman.detail');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // RESOURCE TANAMAN TANPA SHOW
    Route::resource('tanaman', TanamanController::class)
        ->except(['show'])
        ->names('admin.tanaman');

    Route::resource('penyakit', PenyakitController::class)
        ->except(['show'])
        ->names('admin.penyakit');

    // Update lokasi tanaman (drag marker)
    Route::post('/tanaman/{id}/update-location',
        [TanamanController::class, 'updateLocation']
    )->name('admin.tanaman.update-location');

    // Cek kode pohon (AJAX)
    Route::get('/tanaman/cek-kode', function (Request $request) {
        return response()->json([
            'exists' => \App\Models\Tanaman::where(
                'kode_pohon',
                $request->kode
            )->exists()
        ]);
    })->name('admin.tanaman.cekKode');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD ALIAS
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

Route::get('/admin/map', [DashboardController::class,'mapAdmin'])->name('admin.map');

Route::post('/admin/tanaman/{id}/update-location', [TanamanController::class,'updateLocation'])->name('admin.tanaman.update-location');

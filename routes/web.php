<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MagangRegisterController;
use App\Http\Controllers\MagangStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('home');
})->name('home');

Route::get('/sample-register', [MagangRegisterController::class, 'index'])->name('sample.register.index');
Route::post('/sample-register', [MagangRegisterController::class, 'store'])->name('sample.register.store')->middleware('throttle:5,1');

// Route Cek Status & Upload Laporan (Public)
Route::get('/cek-status', [MagangStatusController::class, 'index'])->name('status.index');
Route::post('/cek-status', [MagangStatusController::class, 'check'])->name('status.check');
Route::post('/cek-status/upload/{id}', [MagangStatusController::class, 'uploadReport'])->name('status.upload');
Route::get('/cek-status/kinerja/{id}', [MagangStatusController::class, 'uploadKinerjaForm'])->name('status.kinerja.form');
Route::post('/cek-status/kinerja/{id}', [MagangStatusController::class, 'uploadKinerja'])->name('status.kinerja.upload');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group route untuk admin yang membutuhkan login
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/preview-file', [AdminController::class, 'previewFile'])->name('file.preview');
    Route::get('/{id}', [AdminController::class, 'show'])->name('show');
    Route::put('/{id}/status', [AdminController::class, 'updateStatus'])->name('update_status');
    Route::post('/{id}/interns', [AdminController::class, 'addIntern'])->name('interns.add');
    Route::put('/interns/{id}', [AdminController::class, 'updateIntern'])->name('interns.update');
    Route::delete('/interns/{id}', [AdminController::class, 'deleteIntern'])->name('interns.destroy');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
    Route::put('/kinerja/{id}', [AdminController::class, 'updateKinerja'])->name('kinerja.update');
    Route::delete('/kinerja/{id}', [AdminController::class, 'deleteKinerja'])->name('kinerja.destroy');
});

Route::get('/status/{id}/upload', [MagangStatusController::class, 'uploadForm'])->name('status.upload.form');

Route::get('/artisan-clear-xyz123', function () {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');

    return 'Cache cleared: '.\Artisan::output();
});

use Illuminate\Support\Facades\Artisan;

Route::get('/maintenance-on/{secret}', function ($secret) {
    if ($secret !== 'maintenis') {
        abort(404);
    }

    Artisan::call('down', [
        '--secret' => 'maintenis',
        '--retry' => 60,
    ]);

    return 'Maintenance mode: ON';
});

Route::get('/maintenance-off/{secret}', function ($secret) {
    if ($secret !== 'maintenis') {
        abort(404);
    }

    Artisan::call('up');

    return 'Maintenance mode: OFF';
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SampleRegisterController;
use App\Http\Controllers\MagangRegisterController;
use App\Http\Controllers\MagangStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->name('home');

Route::get('/sample-register', [MagangRegisterController::class, 'index'])->name('sample.register.index');
Route::post('/sample-register', [MagangRegisterController::class, 'store'])->name('sample.register.store');

// Route tambahan untuk memenuhi kebutuhan Unit Test
Route::post('/magang', [SampleRegisterController::class, 'store'])->name('test.magang.store');

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

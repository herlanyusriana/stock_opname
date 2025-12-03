<?php

use App\Http\Controllers\CountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('vendors', VendorController::class);
    Route::resource('parts', PartController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('counts', CountController::class);

    Route::get('locations/print/all', [LocationController::class, 'printAll'])->name('locations.printAll');

    Route::get('/qr/location/{location}', [QrController::class, 'generateLocationQr'])->name('qr.location');
    Route::get('/qr/part/{part}', [QrController::class, 'generatePartQr'])->name('qr.part');

    Route::post('counts/{count}/check', [CountController::class, 'check'])->name('counts.check');
    Route::post('counts/{count}/verify', [CountController::class, 'verify'])->name('counts.verify');
    Route::post('counts/{count}/reject', [CountController::class, 'reject'])->name('counts.reject');
    Route::post('counts/{count}/approve', [CountController::class, 'approve'])->name('counts.approve');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

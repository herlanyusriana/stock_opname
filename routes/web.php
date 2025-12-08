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
    
    // Parts import/export routes (before resource)
    Route::get('parts/import/page', [PartController::class, 'importPage'])->name('parts.import.page');
    Route::post('parts/import', [PartController::class, 'import'])->name('parts.import');
    Route::get('parts/export', [PartController::class, 'export'])->name('parts.export');
    Route::resource('parts', PartController::class);
    
    // Locations import/export routes (before resource)
    Route::get('locations/import/page', [LocationController::class, 'importPage'])->name('locations.import.page');
    Route::post('locations/import', [LocationController::class, 'import'])->name('locations.import');
    Route::get('locations/export', [LocationController::class, 'export'])->name('locations.export');
    Route::get('locations/print/all', [LocationController::class, 'printAll'])->name('locations.printAll');
    Route::resource('locations', LocationController::class);
    
    Route::resource('counts', CountController::class);

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

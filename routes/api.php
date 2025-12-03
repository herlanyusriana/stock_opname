<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CountApiController;
use App\Http\Controllers\Api\LookupController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/counts', [CountApiController::class, 'index']);
        Route::post('/counts', [CountApiController::class, 'store']);
        Route::get('/counts/{count}', [CountApiController::class, 'show']);
        Route::put('/counts/{count}', [CountApiController::class, 'update']);
        Route::post('/counts/{count}/check', [CountApiController::class, 'check']);
        Route::post('/counts/{count}/verify', [CountApiController::class, 'verify']);
        Route::post('/counts/{count}/reject', [CountApiController::class, 'reject']);
        Route::post('/counts/{count}/approve', [CountApiController::class, 'approve']);

        Route::get('/lookup/locations', [LookupController::class, 'locations']);
        Route::get('/lookup/parts', [LookupController::class, 'parts']);

        Route::get('/qr/location/{location}', [App\Http\Controllers\Api\QrController::class, 'showLocation']);
        Route::get('/qr/part/{part}', [App\Http\Controllers\Api\QrController::class, 'showPart']);
    });
});

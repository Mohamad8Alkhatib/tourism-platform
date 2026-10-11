<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventImageController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\PlaceImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::prefix('/places')->group(function () {
    Route::get('', [PlaceController::class, 'index']);
    Route::get('/{place}', [PlaceController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('', [PlaceController::class, 'store']);
        Route::put('/{place}', [PlaceController::class, 'update']);
        Route::delete('/{place}', [PlaceController::class, 'destroy']);
        Route::post('/{place}/images', [PlaceImageController::class, 'store']);
        Route::delete('{place}/images/{image}', [PlaceImageController::class, 'destroy']);
    });
});

Route::prefix('events')->group(function () {
    Route::get('', [EventController::class, 'index']);
    Route::get('/{event}', [EventController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('', [EventController::class, 'store']);
        Route::put('/{event}', [EventController::class, 'update']);
        Route::delete('/{event}', [EventController::class, 'destroy']);

        Route::post('/{event}/images', [EventImageController::class, 'store']);
        Route::delete('/{event}/images/{image}', [EventImageController::class, 'destroy']);
    });
});

<?php

use App\Http\Controllers\Api\V1\AppointmentController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\DoctorController;
use App\Http\Controllers\Api\V1\FaqController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\ServiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    // Public Auth
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    // Public Browsing
    Route::get('services', [ServiceController::class, 'index']);
    Route::get('services/{service}', [ServiceController::class, 'show']);

    Route::get('doctors', [DoctorController::class, 'index']);
    Route::get('doctors/{doctor}', [DoctorController::class, 'show']);
    Route::get('doctors/{doctor}/available-slots', [DoctorController::class, 'availableSlots']);

    Route::get('reviews', [ReviewController::class, 'index']);
    Route::get('blog', [BlogController::class, 'index']);
    Route::get('blog/{post:slug}', [BlogController::class, 'show']);
    Route::get('faqs', [FaqController::class, 'index']);
    Route::post('contact', [ContactController::class, 'store']);

    // Authenticated Endpoints
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);

        // Appointments
        Route::apiResource('appointments', AppointmentController::class);

        // Reviews
        Route::post('reviews', [ReviewController::class, 'store']);
    });
});

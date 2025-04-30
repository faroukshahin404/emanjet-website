<?php

use App\Http\Controllers\Api\PublicServiceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConfirmBookingController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/verify-register-otp', [AuthController::class, 'verify_register_otp']);
    Route::get('/forgot-password', [AuthController::class, 'forgot_password']);
    Route::post('/reset-password', [AuthController::class, 'reset_password']);
    Route::get('/refresh-token', [AuthController::class, 'refresh_token']);

});
Route::get('/cities', [PublicServiceController::class, 'cities']);
Route::group(['prefix' => 'booking'], function () {
    Route::get('/search-trips', [PublicServiceController::class, 'search_trips']);
    Route::get('trip-details', [PublicServiceController::class, 'trip_details']);
    Route::group(['middleware' => \App\Http\Middleware\ApiAuthMiddleware::class], function () {
        Route::post('/oneway-confirm-booking', [ConfirmBookingController::class, 'oneway_confirm_booking']);
        Route::post('/round-confirm-booking', [ConfirmBookingController::class, 'round_confirm_booking']);
    });
});
Route::group(['prefix' => 'profile', 'middleware' => \App\Http\Middleware\ApiAuthMiddleware::class], function () {
    Route::get('/get-profile', [ProfileController::class, 'get_profile']);
    Route::put('/update-profile', [ProfileController::class, 'update_profile']);
    Route::get('/tickets', [ProfileController::class, 'tickets']);
});

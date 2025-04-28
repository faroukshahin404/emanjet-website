<?php

use App\Http\Controllers\Api\PublicServiceController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'auth'], function(){
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/verify-register-otp' , [AuthController::class, 'verify_register_otp']);
    Route::get('/forgot-password',[AuthController::class, 'forgot_password']);
    Route::post('/reset-password', [AuthController::class, 'reset_password']);
});
Route::get('/cities', [PublicServiceController::class, 'cities']);
Route::group(['prefix' => 'booking'], function () {
    Route::get('/search-trips', [ PublicServiceController::class,'search_trips']);
    Route::get('trip-details', [PublicServiceController::class, 'trip_details']);
    
    
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnewayMobileController;
use App\Http\Controllers\OneWayTripController;
use App\Http\Controllers\RoundTripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/home', [HomeController::class, 'home']);
// web.php
Route::get('/get-cities', [HomeController::class, 'getCities']);
Route::get('/get-stations/{city}', [HomeController::class, 'getStations']);

// Desktop Routes
Route::group(['as' => 'one-way.', 'prefix' => 'one-way'], function () {
    Route::get('/trips', [OneWayTripController::class, 'trips'])->name('trips');
    Route::group(['middleware' => 'checkUserVerified'], function () {
        Route::get('/choose-seat', [OneWayTripController::class, 'chooseSeats'])->name('choose-seat');
        Route::post('/confirm-booking', [OneWayTripController::class, 'confirmBooking'])->name('confirm-booking');
    });
});
Route::group(['as' => 'round.', 'prefix' => 'round'], function () {
    Route::get('/trips', [RoundTripController::class, 'trips'])->name('trips');
    Route::group(['middleware' => 'checkUserVerified'], function () {
        Route::get('/choose-seat', [RoundTripController::class, 'chooseSeats'])->name('choose-seat');
        Route::post('/confirm-booking', [RoundTripController::class, 'confirmBooking'])->name('confirm-booking');

    });
});

// Mobile Routes
Route::group(['as' => 'mobile.', 'prefix' => 'mobile'], function () {
    Route::group(['as' => 'one-way.', 'prefix' => 'one-way'], function () {
        Route::get('/trips', [OnewayMobileController::class, 'trips'])->name('trips');
    });
});


Route::group([], function () {
    Route::get('contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
    Route::post('contact-us', [HomeController::class, 'submit_contact_form'])->name('submit-contact-form');


    Route::get('about-us', [HomeController::class, 'about_us'])->name('about-us');
    Route::get('blogs', [HomeController::class, 'blogs'])->name('blogs');
    Route::get('destinations', [HomeController::class, 'destinations'])->name('destinations');
});

Route::prefix('auth')->name('auth.')->group(function () {

    // راوتات OTP والتوثيق - مفتوحة للمستخدم إذا لم يتم التحقق
    Route::get('otp', [AuthController::class, 'otp'])->name('otp');
    Route::post('otp', [AuthController::class, 'postOtp'])->name('postOtp');
    Route::post('resend-otp', [AuthController::class, 'resendOtp'])->name('resendOtp');

    // راوتات الضيف (غير مسجل الدخول)
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'postLogin'])->name('postLogin');
        Route::get('register', [AuthController::class, 'register'])->name('register');
        Route::post('register', [AuthController::class, 'postRegister'])->name('postRegister');
    });

    // راوتات للمستخدم المسجل فقط
    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // إذا لم يتم التحقق
        Route::get('verify', [AuthController::class, 'showVerifyPage'])
            ->name('verify')
            ->middleware('checkUserNotVerified');

        // إذا تم التحقق
        Route::middleware('checkUserVerified')->group(function () {
            Route::get('profile', [AuthController::class, 'profile'])->name('profile');
            Route::post('profile', [AuthController::class, 'updateProfile'])->name('update-profile');
        });
    });
});

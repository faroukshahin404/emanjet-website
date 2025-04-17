<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OneWayTripController;
use App\Http\Controllers\RoundTripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/home', [HomeController::class, 'home']);
// web.php
Route::get('/get-cities', [HomeController::class, 'getCities']);
Route::get('/get-stations/{city}', [HomeController::class, 'getStations']);

Route::group(['as' => 'one-way.', 'prefix' => 'one-way'], function () {
    Route::get('/trips', [OneWayTripController::class, 'trips'])->name('trips');
    Route::get('/choose-seat', [OneWayTripController::class, 'chooseSeats'])->name('choose-seat');
});
Route::group(['as' => 'round.', 'prefix' => 'round'], function () {
    Route::get('/trips', [RoundTripController::class, 'trips'])->name('trips');
    Route::get('/choose-seat', [RoundTripController::class, 'chooseSeats'])->name('choose-seat');
});
Route::group([], function () {
    Route::get('contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
    Route::post('contact-us', [HomeController::class, 'submit_contact_form'])->name('submit-contact-form');
});

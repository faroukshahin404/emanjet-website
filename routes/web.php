<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OneWayTripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class , 'home']);

Route::get('/home', [HomeController::class , 'home']);

Route::group(['as'=>'one-way.', 'prefix'=>'one-way'], function(){
    Route::get('/trips', [OneWayTripController::class, 'trips'])->name('trips');
    Route::get('/choose-seat', [OneWayTripController::class, 'chooseSeats'])->name('choose-seat');
});
Route::group([], function(){
    Route::get('contact-us', [HomeController::class , 'contact_us'])->name('contact-us');
    Route::post('contact-us', [HomeController::class , 'submit_contact_form'])->name('submit-contact-form');
});
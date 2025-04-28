<?php

use App\Http\Controllers\Api\PublicServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/cities', [PublicServiceController::class, 'cities']);
Route::group(['prefix' => 'booking'], function () {
    Route::get('/search-trips', [ PublicServiceController::class,'search_trips']);
    Route::get('trip-details', [PublicServiceController::class, 'trip_details']);
    
});

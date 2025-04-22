<?php

use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnewayMobileController;
use App\Http\Controllers\OneWayTripController;
use App\Http\Controllers\RoundTripController;
use App\Http\Controllers\RoundTripMobileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



// routes/web.php

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'localeViewPath', 'localizationRedirect'],
], function () {


    /** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/

    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::get('/home', [HomeController::class, 'home']);
    // web.php
    Route::get('/get-cities', [HomeController::class, 'getCities']);
    Route::get('/get-stations/{city}', [HomeController::class, 'getStations']);

    // Tickets and Settings routes
    Route::get('/tickets', [HomeController::class, 'tickets'])->name('tickets');
    Route::get('/settings', [HomeController::class, 'settings'])->name('settings');

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
            Route::group(['middleware' => 'checkUserVerified'], function () {
                Route::get('/choose-seat', [OnewayMobileController::class, 'chooseSeats'])->name('choose-seat');
                Route::get('booking-summary', [OnewayMobileController::class, 'bookingSummary'])->name('booking-summary');
            });
        });
        Route::group(['as' => 'round.', 'prefix' => 'round'], function () {
            Route::get('/trips', [RoundTripMobileController::class, 'trips'])->name('trips');
            Route::get('/back-trips', [RoundTripMobileController::class, 'backTrips'])->name('back-trips');
            Route::group(['middleware' => 'checkUserVerified'], function () {
                Route::get('/choose-seat', [RoundTripMobileController::class, 'chooseSeats'])->name('choose-seat');
                Route::get('booking-summary', [RoundTripMobileController::class, 'bookingSummary'])->name('booking-summary');
            });
        });
    });


    Route::group([], function () {
        Route::get('contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
        Route::post('contact-us', [HomeController::class, 'submit_contact_form'])->name('submit-contact-form');


        Route::get('about-us', [HomeController::class, 'about_us'])->name('about-us');
        Route::get('blogs', [HomeController::class, 'blogs'])->name('blogs');
        Route::get('destinations', [HomeController::class, 'destinations'])->name('destinations');
        Route::get('faqs', [HomeController::class, 'faqs'])->name('faqs');
    });

    Route::prefix('auth')->name('auth.')->group(function () {

        // راوتات OTP والتوثيق - مفتوحة للمستخدم إذا لم يتم التحقق
        Route::get('phone', [AuthController::class, 'phone'])->name('phone');
        Route::get('otp', [AuthController::class, 'otp'])->name('otp');
        Route::post('otp', [AuthController::class, 'postOtp'])->name('postOtp');
        Route::get('resend-otp', [AuthController::class, 'resendOtp'])->name('resendOtp');

        // راوتات الضيف (غير مسجل الدخول)
        Route::middleware('guest')->group(function () {
            Route::get('login', [AuthController::class, 'login'])->name('login');
            Route::post('login', [AuthController::class, 'postLogin'])->name('postLogin');
            Route::get('register', [AuthController::class, 'register'])->name('register');
            Route::post('register', [AuthController::class, 'postRegister'])->name('postRegister');

        // راوتات نسيت كلمة المرور
        Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
        Route::get('reset-password', [AuthController::class, 'showResetPassword'])->name('showResetPassword');
        Route::get('/reset-password/new', [AuthController::class, 'showNewPasswordForm'])->name('showNewPasswordForm');

        Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
        Route::post('verify-reset-otp', [AuthController::class, 'verifyResetOtp'])->name('verifyResetOtp');
        Route::get('reset-password-new', [AuthController::class, 'resetPasswordNew'])->name('resetPasswordNew');
        Route::post('update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');
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

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });


Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/pages', PageController::class)->names('pages');
    Route::get('/pages-seo/{pageId}', [PageSeoController::class, 'index'])->name('pages-seo.index');
    Route::get('/pages-seo/{id}/edit', [PageSeoController::class, 'edit'])->name('pages-seo.edit');
    Route::put('/pages-seo/{id}', [PageSeoController::class, 'update'])->name('pages-seo.update');
    //cities
    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
    Route::post('/cities/{city}/toggle-available', [CityController::class, 'toggleAvailableOnline'])->name('cities.toggle-available');
    //stations
    Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
    Route::post('/stations/{station}/toggle-available', [StationController::class, 'toggleAvailableOnline'])->name('stations.toggle-available');
    //blog-categories
    Route::resource('/blog-categories', BlogCategoryController::class);
});




    Route::get('translation', function () {
        $translations = extractTranslations();
        dd($translations);

    });

    // routes/web.php
    Route::get('lang/{locale}', function ($locale) {
        // التأكد من أن اللغة المدخلة مدعومة
        if (array_key_exists($locale, LaravelLocalization::getSupportedLocales())) {
            // إعادة التوجيه إلى نفس الصفحة باللغة المحددة
            return redirect(LaravelLocalization::getLocalizedURL($locale, url()->previous()));
        }

        // إذا كانت اللغة غير مدعومة
        abort(404);
    })->name('lang.switch');







});

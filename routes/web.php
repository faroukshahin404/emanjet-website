<?php

use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\AdminAuth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusCategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnewayMobileController;
use App\Http\Controllers\OneWayTripController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoundTripController;
use App\Http\Controllers\RoundTripMobileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



// routes/web.php

Route::middleware([
    'setLocaleFromSession',
    'localize',
    'localeViewPath',
])->group(function () {


    /** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/

    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::get('/home', [HomeController::class, 'home']);
    Route::get('/payment/{payment_key}', [PaymentController::class, 'index'])->name('payment');
    Route::post('/payment/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
    // web.php
    Route::get('/get-cities', [HomeController::class, 'getCities']);
    Route::get('/get-stations/{city}', [HomeController::class, 'getStations']);

    // Tickets and Settings routes
    Route::get('/tickets', [HomeController::class, 'tickets'])->name('tickets')->middleware('checkUserVerified');
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
        Route::group(['middleware' => 'checkUserVerified'], function () {
            Route::get('tickets', [ProfileController::class, 'index'])->name('tickets');
            Route::get('settings', [ProfileController::class, 'settings'])->name('settings');
        });
    });


    Route::group([], function () {
        Route::get('contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
        Route::post('contact-us', [HomeController::class, 'submit_contact_form'])->name('submit-contact-form');


        Route::get('about-us', [HomeController::class, 'about_us'])->name('about-us');
        Route::get('blogs', [HomeController::class, 'blogs'])->name('blogs');
        Route::get('destinations', [HomeController::class, 'destinations'])->name('destinations');
        Route::get('faqs', [HomeController::class, 'faqs'])->name('faqs');
        Route::get('privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy-policy');
        Route::get('usage-terms', [HomeController::class, 'usage_terms'])->name('usage-terms');
    });
    Route::get('login', [AuthController::class, 'login'])->name('login');

    Route::prefix('auth')->name('auth.')->group(function () {

        // راوتات OTP والتوثيق - مفتوحة للمستخدم إذا لم يتم التحقق
        Route::get('phone', [AuthController::class, 'phone'])->name('phone');
        Route::get('otp', [AuthController::class, 'otp'])->name('otp');
        Route::post('otp', [AuthController::class, 'postOtp'])->name('postOtp');
        Route::post('resend-otp', [AuthController::class, 'resendOtp'])->name('resendOtp');

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
        Route::get('settings/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('settings/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            if (Auth::guard('admin')->check()) {
                return redirect()->route('admin.dashboard.index');
            }

            return redirect()->route('admin.login');
        });

        Route::get('/login', [\App\Http\Controllers\AdminAuth\LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    });

    Route::prefix('admin')->middleware(\App\Http\Middleware\AdminAuth::class)->as('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::post('/logout', [\App\Http\Controllers\AdminAuth\LoginController::class, 'logout'])->name('logout');

        Route::resource('/pages', PageController::class)->names('pages');
        Route::get('/pages-seo/{pageId}', [PageSeoController::class, 'index'])->name('pages-seo.index');
        Route::get('/pages-seo/{id}/edit', [PageSeoController::class, 'edit'])->name('pages-seo.edit');
        Route::put('/pages-seo/{id}', [PageSeoController::class, 'update'])->name('pages-seo.update');

        Route::resource('bus-categories', BusCategoryController::class)->names('bus-categories');

        Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
        Route::post('/cities/{city}/toggle-available', [CityController::class, 'toggleAvailableOnline'])->name('cities.toggle-available');

        Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
        Route::post('/stations/{station}/toggle-available', [StationController::class, 'toggleAvailableOnline'])->name('stations.toggle-available');

        Route::resource('/blog-categories', BlogCategoryController::class)->names('blog-categories');
        Route::resource('/blogs', BlogController::class)->names('blogs');
        Route::resource('/destinations', DestinationController::class)->names('destinations');
        Route::resource('/faqs', FaqController::class)->names('faqs');

        Route::prefix('translations')->name('translations.')->group(function () {
            Route::get('/scan', [TranslationController::class, 'scan'])->name('scan');
            Route::post('/sync-en', [TranslationController::class, 'syncFromEnglish'])->name('sync-en');
            Route::post('/append-scanned', [TranslationController::class, 'appendScanned'])->name('append-scanned');
        });
    });

    Route::get('lang/{locale}', function ($locale) {
        if (! array_key_exists($locale, LaravelLocalization::getSupportedLocales())) {
            abort(404);
        }

        session(['locale' => $locale]);

        $previous = url()->previous();
        $fallback = url('/');

        if (! $previous || $previous === url()->current()) {
            return redirect($fallback);
        }

        $target = LaravelLocalization::getNonLocalizedURL($previous);

        return redirect()->to($target ?: $fallback);
    })->name('lang.switch');


});

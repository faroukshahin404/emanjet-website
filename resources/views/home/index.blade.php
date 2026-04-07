@extends('layouts.master', [
    'isHome' => true,
])

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <style>
        .hero-section::before {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0,
            0, 0.2) 100%),
                url('{{ $heroSection['image'] ?? asset('images/hero-section.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
@endpush
@section('content')
    <!-- App Download Modal -->

    <!-- End App Download Modal -->

    <!-- start hero section  -->
    <div class="hero-section" id="heroSection">
        <div class="container-fluid px-5 box">
            <div class="row">
                <div class="col-lg-5 col-md-12 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">{{ $heroSection['card-title'] }}</h5>
                            <form id="tripForm" action="{{ route('one-way.trips') }}" method="GET">
                                <!-- Choice of trip type -->
                                <div class="text-center">
                                    <div class="trip-type-tabs nav nav-pills d-inline-flex" id="pills-tab" role="tablist">
                                        <div class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-oneway-tab" data-bs-toggle="pill"
                                                type="button" role="tab"
                                                onclick="document.getElementById('oneWayRadioDes').click()">{{ __('One Way Trip') }}</button>
                                        </div>
                                        <div class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-round-tab" data-bs-toggle="pill"
                                                type="button" role="tab"
                                                onclick="document.getElementById('roundTripRadioDes').click()">{{ __('Round Trip') }}</button>
                                        </div>
                                        <!-- Hidden radios for JS compatibility -->
                                        <input class="d-none" type="radio" name="tripType" id="oneWayRadioDes"
                                            value="oneway" checked>
                                        <input class="d-none" type="radio" name="tripType" id="roundTripRadioDes"
                                            value="round">
                                    </div>
                                </div>

                                <!-- start from to  -->
                                <div class="station-group mb-4">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div class="input-with-icon">
                                                <i class="fas fa-location-dot"></i>
                                                <input type="text" class="modern-input from-input"
                                                    placeholder="{{ __('From') }}" readonly aria-expanded="false"
                                                    value="{{ $stations->get(0)?->name ?? '' }}" id="fromInput">
                                                <ul class="dropdown-menu p-0 main-stations shadow" id="from-stations"></ul>
                                                <ul class="dropdown-menu p-0 sub-stations-dropdown shadow"
                                                    id="from-sub-stations"></ul>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="input-with-icon">
                                                <i class="fas fa-circle-dot text-success"></i>
                                                <input type="text" class="modern-input to-input"
                                                    placeholder="{{ __('To') }}" readonly aria-expanded="false"
                                                    id="toInput"
                                                    value="{{ request()->city_to_id ? ($stations->where('city_id', request()->city_to_id)->first()?->name ?? '') : ($stations->get(1)?->name ?? '') }}">
                                                <ul class="dropdown-menu p-0 main-stations shadow" id="to-stations"></ul>
                                                <ul class="dropdown-menu p-0 sub-stations-dropdown shadow"
                                                    id="to-sub-stations"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden Inputs for Station IDs (Required for the backend and JS) -->
                                    <input type="hidden" name="city_from_id" id="city_from_id"
                                        value="{{ $stations->get(0)?->city_id ?? '' }}">
                                    <input type="hidden" name="city_to_id" id="city_to_id"
                                        value="{{ request()->city_to_id ?? $stations->get(1)?->city_id ?? '' }}">
                                    <input type="hidden" name="station_from_id" id="station_from_id"
                                        value="{{ $stations->get(0)?->id ?? '' }}">
                                    <input type="hidden" name="station_to_id" id="station_to_id"
                                        value="{{ request()->city_to_id ? ($stations->where('city_id', request()->city_to_id)->first()?->id ?? '') : ($stations->get(1)?->id ?? '') }}">

                                    <button type="button" class="swap-btn-floating swap-btn">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div class="position-relative">
                                            <div class="input-with-icon">
                                                <i class="fas fa-calendar-alt"></i>
                                                <input type="text" class="modern-input" value="" readonly
                                                    id="dateTextInput">
                                            </div>
                                            <input type="hidden" name="go_date"
                                                value="{{ request()->go_date ?? date('Y-m-d') }}" id="dateRealInput">
                                        </div>
                                    </div>
                                    <div class="col-md-6 return-date-col d-none">
                                        <div class="position-relative">
                                            <div class="input-with-icon">
                                                <i class="fas fa-calendar-alt"></i>
                                                <input type="text" class="modern-input" value="" readonly
                                                    id="dateTextInput2">
                                            </div>
                                            <input type="hidden" name="back_date"
                                                value="{{ request()->back_date ?? date('Y-m-d') }}"
                                                id="dateRealInput2" data-max-date="2027-04-07">
                                        </div>
                                    </div>
                                    <div class="col-md-6 arrival-time-box">
                                        <button type="button"
                                            class="arrival-time d-flex align-items-center gap-2 text-muted small mt-2 btn btn-link p-0 border-0 bg-transparent text-start"
                                            onclick="document.getElementById('pills-round-tab').click(); document.getElementById('roundTripRadioDes').click();">
                                            <i class="fas fa-percent text-success" aria-hidden="true"></i>
                                            {{ __('Book Round Trip & Save') }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Number of travelers -->
                                <div
                                    class="d-flex align-items-center justify-content-between mb-4 p-3 rounded-4 passenger-box-home">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-user-friends text-main fs-5"></i>
                                        <div>
                                            <div class="fw-bold text-dark lh-1">{{ __('Number of travelers') }}</div>
                                            <small class="text-muted">{{ __('Adults/Children') }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <button type="button"
                                            class="btn btn-sm shadow-sm rounded-circle bg-white mo-btn-32"
                                            onclick="decrementPassengersdesktop()"
                                            aria-label="{{ __('Decrease number of travelers') }}">
                                            <i class="fas fa-minus small" aria-hidden="true"></i>
                                        </button>
                                        <span class="fw-bold fs-5" id="passengerCountdesktop">1</span>
                                        <input type="hidden" id="passengerCountDesktopInput" value="1"
                                            name="seats" />
                                        <button type="button"
                                            class="btn btn-sm shadow-sm rounded-circle bg-white mo-btn-32"
                                            onclick="incrementPassengersdesktop()"
                                            aria-label="{{ __('Increase number of travelers') }}">
                                            <i class="fas fa-plus small" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Search button -->
                                <button type="submit" class="hero-btn">
                                    <i class="fas fa-search"></i>
                                    {{ __('Search For Your Trip') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mx-auto col-md-12 hero-caption-box mt-5 mt-lg-0">
                    <div class="hero-caption-title text-start">
                        <h1 class="text-white fw-bold mb-3 display-4 animate__animated animate__fadeInUp">
                            {{ $heroSection['caption-title'] }}
                        </h1>
                        <h4
                            class="text-white fw-light mb-5 opacity-75 animate__animated animate__fadeInUp animate__delay-1s">
                            {{ $heroSection['caption-description'] }}
                        </h4>
                    </div>
                    <div class="text-white d-flex flex-lg-row flex-column justify-content-start align-items-center gap-3">
                        @if (!empty($apps['android']))
                            <a href="{{ $apps['android'] }}" target="_blank"
                                class="google-play-box rounded-5 text-decoration-none">
                                <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-2">
                                    <div class="google-play">
                                        <p>Get It On</p>
                                        <h6>Google Play</h6>
                                    </div>
                                    <img src="{{ asset('images/google-play-icon.png') }}" alt="google-play">
                                </div>
                            </a>
                        @endif

                        {{-- @if (!empty($apps['ios']))
                        <a href="{{ $apps['ios'] }}" target="_blank"
                            class="google-play-box rounded-5 text-decoration-none">
                            <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-2">
                                <div class="google-play">
                                    <p>Download On The</p>
                                    <h6>App Store</h6>
                                </div>
                                <i class="fa-brands fa-apple"></i>
                            </div>
                        </a>
                        @endif --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End hero section  -->

    <!-- start any where  -->
    {{-- <div class="any-where py-5 bg-white px-4">
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-md-6 any-where-caption d-flex flex-column align-items-start justify-content-center">
                    <h2>{{ $anyWhereSection['title'] }}</h2>
                    <p class="mt-5">
                        {{ $anyWhereSection['description'] }}
                    </p>

                </div>
                <div class="col-md-6 position-relative map">
                    <img class="" src="{{ asset('images/map.png') }}" alt="map">
                    <img class="" src="{{ $anyWhereSection['image'] }}" alt="map">
                    <div>
                        <div class="circle-alex"></div>
                        <div class="title-alex">{{ __('Alexandria') }}</div>
                        <div class="circle-cairo"></div>
                        <div class="title-cairo">{{ __('Cairo') }}</div>
                        <div class="circle-sharm"></div>
                        <div class="title-sharm">{{ __('Sharm El Sheikh') }}</div>
                        <div class="circle-her"></div>
                        <div class="title-her">{{ __('Hurghada') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End any where  -->


    <!-- start Popular Destinations -->
    <div class="popular-destinations py-5">
        <div class="container-fluid px-3 px-md-4 px-xl-5">
            <header class="popular-destinations__head text-center mb-4 mb-lg-5">
                <h2 class="popular-destinations__title h3 fw-bold mb-2">{{ $popularDestinationsSection['title'] }}</h2>
                @if (filled($popularDestinationsSection['description'] ?? null))
                    <p class="popular-destinations__lead text-muted mb-0 mx-auto" style="max-width: 36rem;">
                        {{ $popularDestinationsSection['description'] }}</p>
                @endif
            </header>

            <div class="popular-destinations__carousel-wrap position-relative">
                <div class="swiper mySwiperPopular popular-destinations-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($cities as $city)
                            @php
                                $cityPhoto = $city->getRawOriginal('image');
                                $hasCityPhoto =
                                    filled($cityPhoto) && is_file(public_path('uploads/city/' . $cityPhoto));
                                $cityName = $city->getTranslation('name', app()->getLocale());
                            @endphp
                            <div class="swiper-slide">
                                <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection"
                                    class="popular-dest-card d-block text-decoration-none h-100">
                                    <div class="popular-dest-card__inner rounded-4 overflow-hidden shadow-sm h-100">
                                        <div class="popular-dest-card__media popular-destination-thumb">
                                            @if ($hasCityPhoto)
                                                <img src="{{ asset('uploads/city/' . $cityPhoto) }}"
                                                    class="popular-dest-card__img object-fit-cover" alt="{{ $cityName }}"
                                                    loading="lazy">
                                            @else
                                                <div class="popular-dest-card__img popular-destination-placeholder"
                                                    role="img" aria-label="{{ $cityName }}">
                                                    <span class="popular-destination-placeholder__pattern"
                                                        aria-hidden="true"></span>
                                                    <i class="fas fa-image popular-destination-placeholder__icon"
                                                        aria-hidden="true"></i>
                                                </div>
                                            @endif
                                            <div class="popular-dest-card__overlay">
                                                <span class="popular-dest-card__name">{{ $cityName }}</span>
                                                <span class="popular-dest-card__hint">
                                                    <span>{{ __('Book Now') }}</span>
                                                    <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} popular-dest-card__hint-icon"
                                                        aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-scrollbar swiper-scrollbar-popular" aria-hidden="true"></div>
                </div>

                <div class="popular-dest-btn popular-dest-btn--prev swiper-button-prev" role="button" tabindex="0"
                    aria-label="{{ __('Previous') }}"></div>
                <div class="popular-dest-btn popular-dest-btn--next swiper-button-next" role="button" tabindex="0"
                    aria-label="{{ __('Next') }}"></div>
            </div>
        </div>
    </div>
    <!-- End Popular Destinations -->

    <!-- start pay  -->
    <div class="pay py-3 mt-5">
        <div class="container">
            <h2 class="text-center">{{ $paymentMethodsSection['title'] }}</h2>
            <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center mt-4">
                @foreach ($paymentMethodsSection['images'] as $image)
                    <img src="{{ $image }}" alt="pay">
                @endforeach
            </div>
        </div>
    </div>
    <!-- End pay  -->

    <!-- start bus type  -->
    @if($busTypesSection->isNotEmpty())
    <div class="bus-type">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center mb-5">{{ __('Bus Types') }}</h2>
                </div>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">

                        @foreach ($busTypesSection as $busType)
                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>
                                            {{ $busType['name'] }}</h5>
                                        <p class='cardBody text-gray'>
                                            {{ $busType['passengers'] }} {{ __('Passenger') }}
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                {!! render_stars($busType['rate']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="{{ $busType['image'] }}" alt="bus" />
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                    <div class="swiper-buttons">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif
    <!-- End bus type  -->

    <!-- start testimonials  -->
    <div class="testimonials py-5 px-3 " id="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center text-black">
                        {{ __('Testimonials') }}
                    </h2>
                </div>

                @foreach ($testimonials as $testimonial)
                    <div class="col-md-4 mb-3">
                        <div class='cardSection card p-3'>
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-end">
                                    <i class="fas fa-quote-left fs-25"></i>
                                </div>
                                <p class='text-gray'>
                                    {{ $testimonial->translated_name }}
                                </p>
                                <div class='d-flex justify-content-end align-items-center gap-2'>
                                    <p class="m-0">{{ $testimonial->translated_content }}</p>
                                    <div class="testimonial-avatar">
                                        @if(!empty($testimonial->image))
                                            <img src="{{ Str::startsWith($testimonial->image, ['http://', 'https://']) ? $testimonial->image : asset($testimonial->image) }}"
                                                alt="{{ $testimonial->translated_name }}">
                                        @else
                                            <span class="testimonial-avatar-placeholder">{{ mb_substr($testimonial->translated_name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </div>
    <!-- End testimonials  -->

    <!-- start reservation  -->
    <div class="">
        <div class="reservation">
            <h2>
                {{ $reservationSection['title'] }}
            </h2>
            <p>
                {{ $reservationSection['description'] }}
            </p>
            <a href="#heroSection">
                {{ __('Book Now') }}
            </a>
        </div>
    </div>

    <!-- End reservation  -->

    <!-- start blogs  -->
    <div class="blogs py-5 ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">{{ __('Our Story') }}</h2>
                </div>
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-md-4 mb-4 px-3">
                            <div class="cardSection card text-center rounded-bottom-4">
                                <img class="img-fluid rounded-top-4" src="{{ $blog->image }}" alt="blogs" />
                                <div class="cardbody card-body py-2">
                                    <h5>{{ $blog->translated_title }}</h5>
                                    <div class='cardBody'>
                                        <p>
                                            {{ $blog->created_at->format('F d, Y') }} -
                                            <i class="fa fa-clock"></i> {{ $blog->reading_time }} min read -
                                            <i class="fa fa-eye"></i> {{ $blog->views }} -
                                            <i class="fa fa-thumbs-up"></i> {{ $blog->likes }}
                                        </p>
                                        <h6>
                                            {{ \Str::limit(strip_tags($blog->translated_content), 90) }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- End blogs  -->
    @if (!empty($apps['android']) || !empty($apps['ios']))
        <div class="modal fade" id="appDownloadModal" tabindex="-1" aria-labelledby="appDownloadModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appDownloadModalLabel">{{ __('Download Our App') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-4">
                            <i class="fas fa-tags text-warning fa-2x mb-3"></i>
                            <h4>{{ __('Get Exclusive Discounts!') }}</h4>
                            <p>{{ __('Download the HighBus app now and enjoy special offers on your trips') }}</p>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            @if (!empty($apps['android']))
                                <a href="{{ $apps['android'] }}" target="_blank"
                                    class="google-play-box rounded-5 text-decoration-none">
                                    <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-3">
                                        <div class="google-play">
                                            <p>{{ __('Get It On') }}</p>
                                            <h6>{{ __('Google Play') }}</h6>
                                        </div>
                                        <img src="{{ asset('images/google-play-icon.png') }}" alt="google-play">
                                    </div>
                                </a>
                            @endif
                            @if (!empty($apps['ios']))
                                <a href="{{ $apps['ios'] }}" target="_blank"
                                    class="google-play-box rounded-5 text-decoration-none">
                                    <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-3">
                                        <div class="google-play">
                                            <p>{{ __('Download On The') }}</p>
                                            <h6>{{ __('App Store') }}</h6>
                                        </div>
                                        <i class="fa-brands fa-apple"></i>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Maybe Later') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- start footer  -->
@endsection
@include('mobile.home')
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper('.mySwiper', {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: false,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 10
                    },
                },
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isRTL = document.documentElement.dir === 'rtl';

            new Swiper('.mySwiper2', {
                slidesPerView: 1.5,
                spaceBetween: 10,
                loop: false,
                rtl: isRTL,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 10
                    },
                },
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isRTL = document.documentElement.dir === 'rtl';

            new Swiper('.mySwiper3', {
                slidesPerView: 1.25,
                spaceBetween: 10,
                loop: false,
                rtl: isRTL,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 10
                    },
                },
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isRTL = document.documentElement.dir === 'rtl';

            new Swiper('.mySwiper4', {
                slidesPerView: 3,
                spaceBetween: 10,
                loop: false,
                rtl: isRTL,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 10
                    },
                },
            });

            new Swiper('.mySwiperPopular', {
                slidesPerView: 1.15,
                spaceBetween: 14,
                loop: false,
                rtl: isRTL,
                watchOverflow: true,
                grabCursor: true,
                speed: 450,
                navigation: {
                    nextEl: '.popular-dest-btn--next',
                    prevEl: '.popular-dest-btn--prev',
                },
                scrollbar: {
                    el: '.swiper-scrollbar-popular',
                    draggable: true,
                    hide: false,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 16,
                    },
                    768: {
                        slidesPerView: 2.5,
                        spaceBetween: 18,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 22,
                    },
                },
            });
        });
    </script>

    <script>
        let passengerCountdesktop = 1;
        const countElementdesktop = document.getElementById('passengerCountdesktop');
        const countElementdesktopInput = document.getElementById('passengerCountDesktopInput');

        function incrementPassengersdesktop() {
            passengerCountdesktop++;
            countElementdesktop.textContent = passengerCountdesktop;
            countElementdesktopInput.value = passengerCountdesktop;
        }

        function decrementPassengersdesktop() {
            if (passengerCountdesktop > 1) {
                passengerCountdesktop--;
                countElementdesktop.textContent = passengerCountdesktop;
                countElementdesktopInput.value = passengerCountdesktop;
            }
        }
    </script>

    <script>
        let passengerCount = 1;
        const countElement = document.getElementById('passengerCount');
        const countElementInput = document.getElementById('passenger-count');
        const countElement2Input = document.getElementById('passenger-count2');

        function incrementPassengers() {
            passengerCount++;
            if (countElement) countElement.textContent = passengerCount;
            if (countElementInput) countElementInput.value = passengerCount;
            if (countElement2Input) countElement2Input.value = passengerCount;
        }

        function decrementPassengers() {
            if (passengerCount > 1) {
                passengerCount--;
                if (countElement) countElement.textContent = passengerCount;
                if (countElementInput) countElementInput.value = passengerCount;
                if (countElement2Input) countElement2Input.value = passengerCount;
            }
        }
    </script>
    <script>
        let passengerCount2 = 1;
        const countElement2 = document.getElementById('passengerCount2');
        const passengerCount2InputEl = document.getElementById('passenger-count2');
        const passengerCountInputEl = document.getElementById('passenger-count');

        function incrementPassengers2() {
            passengerCount2++;
            countElement2.textContent = passengerCount2;
            if (passengerCount2InputEl) passengerCount2InputEl.value = passengerCount2;
            if (passengerCountInputEl) passengerCountInputEl.value = passengerCount2;
        }

        function decrementPassengers2() {
            if (passengerCount2 > 1) {
                passengerCount2--;
                countElement2.textContent = passengerCount2;
                if (passengerCount2InputEl) passengerCount2InputEl.value = passengerCount2;
                if (passengerCountInputEl) passengerCountInputEl.value = passengerCount2;
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const oneWayRadio = document.getElementById('oneWayRadio');
            const roundTripRadio = document.getElementById('roundTripRadio');
            const returnDateCol = document.getElementById('returnDateCol');
            const passengersColSide = document.getElementById('passengersColSide');
            const passengersColBottom = document.getElementById('passengersColBottom');
            const departureDateCol = document.getElementById('departureDateCol');

            function updateLayout() {
                if (!returnDateCol || !departureDateCol || !passengersColSide || !passengersColBottom) return;
                if (roundTripRadio.checked) {
                    // Round trip layout
                    returnDateCol.classList.remove('d-none');
                    departureDateCol.classList.remove('col-md-6');
                    departureDateCol.classList.add('col-md-6');
                    passengersColSide.classList.add('d-none');
                    passengersColBottom.classList.remove('d-none');
                } else {
                    // One way layout
                    returnDateCol.classList.add('d-none');
                    departureDateCol.classList.remove('col-md-6');
                    departureDateCol.classList.add('col-md-6');
                    passengersColSide.classList.remove('d-none');
                    passengersColBottom.classList.add('d-none');
                }
            }

            if (oneWayRadio && roundTripRadio) {
                oneWayRadio.addEventListener('change', updateLayout);
                roundTripRadio.addEventListener('change', updateLayout);
                updateLayout();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const oneWayRadioDes = document.getElementById('oneWayRadioDes');
            const roundTripRadioDes = document.getElementById('roundTripRadioDes');
            const returnDateContainer = document.querySelector('.return-date-col');
            const arrivalTimeSection = document.querySelector('.arrival-time-box');
            const arrivalTimeLink = document.querySelector('.arrival-time');
            const tripForm = document.getElementById('tripForm');

            // Tab buttons
            const onewayTab = document.getElementById('pills-oneway-tab');
            const roundTab = document.getElementById('pills-round-tab');

            document.querySelectorAll('input[name="tripType"]').forEach(radio => {
                radio.addEventListener('change', updateTripTypeDisplay);
            });

            if (arrivalTimeLink) {
                arrivalTimeLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    roundTripRadioDes.checked = true;
                    // Trigger tab sync
                    roundTab.classList.add('active');
                    onewayTab.classList.remove('active');
                    updateTripTypeDisplay();
                });
            }

            function updateTripTypeDisplay() {
                if (roundTripRadioDes.checked) {
                    returnDateContainer.classList.remove('d-none');
                    arrivalTimeSection.classList.add('d-none');
                    tripForm.action = "{{ route('round.trips') }}";

                    // Sync tabs
                    roundTab.classList.add('active');
                    onewayTab.classList.remove('active');
                } else {
                    returnDateContainer.classList.add('d-none');
                    arrivalTimeSection.classList.remove('d-none');
                    tripForm.action = "{{ route('one-way.trips') }}";

                    // Sync tabs
                    onewayTab.classList.add('active');
                    roundTab.classList.remove('active');
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bellBox = document.querySelector('.mo-bell-box');
            const dropdown = document.querySelector('.notifications-dropdown');
            if (bellBox) {
                bellBox.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });

                // Close dropdown on outside click
                document.addEventListener('click', function() {
                    dropdown.style.display = 'none';
                });
            }
        });
    </script>

    <!-- Flatpickr: pinned version for stable API; locale bundled -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/ar.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof flatpickr === 'undefined') {
                return;
            }

            const isRTL = document.documentElement.dir === 'rtl';
            const currentLang = '{{ app()->getLocale() }}';
            const localeTag = currentLang === 'ar' ? 'ar-EG' : 'en-US';
            const desktopMq = window.matchMedia('(min-width: 992px)');

            function formatHeroDate(date) {
                if (!date || !(date instanceof Date) || isNaN(date.getTime())) {
                    return '';
                }
                return date.toLocaleDateString(localeTag, {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                });
            }

            let fp = null;
            let fp2 = null;

            function destroyHeroPickers() {
                if (fp) {
                    fp.destroy();
                    fp = null;
                }
                if (fp2) {
                    fp2.destroy();
                    fp2 = null;
                }
            }

            function initHeroPickers() {
                destroyHeroPickers();

                if (!desktopMq.matches) {
                    return;
                }

                const goHidden = document.getElementById('dateRealInput');
                const returnHidden = document.getElementById('dateRealInput2');
                const dateTextInput = document.getElementById('dateTextInput');
                const dateTextInput2 = document.getElementById('dateTextInput2');

                if (!goHidden || !dateTextInput) {
                    return;
                }

                const goYmd = goHidden.value || null;
                const returnMax = returnHidden && returnHidden.dataset.maxDate ? returnHidden.dataset.maxDate : '2027-04-07';

                const localeOpts = isRTL ? {
                    locale: 'ar'
                } : {};

                if (returnHidden && dateTextInput2) {
                    fp2 = flatpickr(dateTextInput2, Object.assign({
                        dateFormat: 'Y-m-d',
                        minDate: goYmd || 'today',
                        maxDate: returnMax,
                        disableMobile: true,
                        allowInput: false,
                        clickOpens: true,
                        appendTo: document.body,
                        defaultDate: returnHidden.value || undefined,
                        onChange: function(selectedDates, dateStr) {
                            returnHidden.value = dateStr;
                            if (selectedDates.length) {
                                dateTextInput2.value = formatHeroDate(selectedDates[0]);
                            }
                        },
                    }, localeOpts));
                }

                fp = flatpickr(dateTextInput, Object.assign({
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    disableMobile: true,
                    allowInput: false,
                    clickOpens: true,
                    appendTo: document.body,
                    defaultDate: goYmd || undefined,
                    onChange: function(selectedDates, dateStr) {
                        goHidden.value = dateStr;
                        if (selectedDates.length) {
                            dateTextInput.value = formatHeroDate(selectedDates[0]);
                        }
                        if (returnHidden && fp2) {
                            fp2.set('minDate', dateStr);
                            if (returnHidden.value && returnHidden.value < dateStr) {
                                fp2.setDate(dateStr, false);
                                returnHidden.value = dateStr;
                                if (dateTextInput2) {
                                    dateTextInput2.value = formatHeroDate(new Date(dateStr + 'T12:00:00'));
                                }
                            }
                        }
                    },
                }, localeOpts));

                if (goYmd) {
                    fp.setDate(goYmd, false);
                    dateTextInput.value = formatHeroDate(new Date(goYmd + 'T12:00:00'));
                }
                if (returnHidden && returnHidden.value && dateTextInput2 && fp2) {
                    const r = returnHidden.value;
                    fp2.set('minDate', goYmd || 'today');
                    fp2.setDate(r, false);
                    dateTextInput2.value = formatHeroDate(new Date(r + 'T12:00:00'));
                }
            }

            initHeroPickers();

            if (typeof desktopMq.addEventListener === 'function') {
                desktopMq.addEventListener('change', initHeroPickers);
            } else if (typeof desktopMq.addListener === 'function') {
                desktopMq.addListener(initHeroPickers);
            }
        });
    </script>

    <!-- stations  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stationUi = {
                chooseStation: @json(__('Choose station')),
                loading: @json(__('Loading...')),
                backToCities: @json(__('Back to cities')),
                chooseStationIn: @json(__('Choose station in')),
                noStationsAvailable: @json(__('No stations available')),
            };

            // DOM elements
            const fromInput = document.getElementById('fromInput');
            const toInput = document.getElementById('toInput');
            const fromStations = document.getElementById('from-stations');
            const toStations = document.getElementById('to-stations');

            // Pre-load Cities Immediately
            let cachedCities = null;
            const stationCache = {};

            async function getCities() {
                if (cachedCities) return cachedCities;
                try {
                    const response = await fetch('/get-cities');
                    cachedCities = await response.json();
                    return cachedCities;
                } catch (error) {
                    console.error('Error loading cities:', error);
                    return [];
                }
            }

            // Early init
            initDropdowns();

            async function loadStations(cityId) {
                if (stationCache[cityId]) return stationCache[cityId];
                try {
                    const response = await fetch(`/get-stations/${cityId}`);
                    const data = await response.json();
                    stationCache[cityId] = data;
                    return data;
                } catch (error) {
                    console.error('Error loading stations:', error);
                    return [];
                }
            }

            async function initDropdowns() {
                const cities = await getCities();
                initDropdown('from', cities);
                initDropdown('to', cities);

                // Pre-load stations for the default cities to make it instant
                const defaultFromCityId = document.getElementById('city_from_id').value;
                const defaultToCityId = document.getElementById('city_to_id').value;
                if (defaultFromCityId) loadStations(defaultFromCityId);
                if (defaultToCityId) loadStations(defaultToCityId);

                fromInput.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleDropdown('from-stations', true);
                    toggleDropdown('from-sub-stations', false);
                });
                fromInput.addEventListener('focus', function(e) {
                    console.log('fromInput clicked');
                    e.stopPropagation();
                    toggleDropdown('from-stations', true);
                    toggleDropdown('from-sub-stations', false);
                });

                toInput.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleDropdown('to-stations', true);
                    toggleDropdown('to-sub-stations', false);
                });

                // Live Filtering Logic
                fromInput.addEventListener('input', function() {
                    filterDropdown('from-stations', this.value);
                });
                toInput.addEventListener('input', function() {
                    filterDropdown('to-stations', this.value);
                });

                // Remove readonly on focus to allow typing
                fromInput.addEventListener('focus', function() {
                    this.removeAttribute('readonly');
                });
                toInput.addEventListener('focus', function() {
                    this.removeAttribute('readonly');
                });

                // Restore readonly on blur
                fromInput.addEventListener('blur', function() {
                    setTimeout(() => this.setAttribute('readonly', true), 200);
                });
                toInput.addEventListener('blur', function() {
                    setTimeout(() => this.setAttribute('readonly', true), 200);
                });

                // Close dropdowns on outside click
                document.addEventListener('click', function() {
                    toggleDropdown('from-stations', false);
                    toggleDropdown('from-sub-stations', false);
                    toggleDropdown('to-stations', false);
                    toggleDropdown('to-sub-stations', false);
                });
            }

            function filterDropdown(menuId, query) {
                const menu = document.getElementById(menuId);
                const items = menu.querySelectorAll('li.dropdown-item');
                const lowerQuery = query.toLowerCase();

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(lowerQuery) ? 'flex' : 'none';
                });
            }

            // Initialize one station dropdown
            async function initDropdown(type, cities) {
                const mainMenu = document.getElementById(`${type}-stations`);
                const subMenu = document.getElementById(`${type}-sub-stations`);

                // Clear menus
                mainMenu.innerHTML = '';
                subMenu.innerHTML = '';

                // Header row
                const titleItem = document.createElement('li');
                titleItem.className = 'dropdown-header py-2 px-3';
                titleItem.textContent = stationUi.chooseStation;
                mainMenu.appendChild(titleItem);

                // Top-level cities
                cities.forEach(city => {
                    const item = document.createElement('li');
                    item.className =
                        'dropdown-item d-flex justify-content-between align-items-center py-2 px-3';
                    const isRTL = document.documentElement.dir === 'rtl';
                    const chevronClass = isRTL ? 'fa-chevron-left' : 'fa-chevron-right';
                    item.innerHTML = `
                <span>${city.name}</span>
                <i class="fas ${chevronClass} ms-2 opacity-50 small"></i>
            `;

                    item.addEventListener('click', async (e) => {
                        e.stopPropagation();

                        // Set selected city id on hidden input
                        const cityInputId = type === 'from' ? 'city_from_id' : 'city_to_id';
                        document.getElementById(cityInputId).value = city.id;

                        // Loading state
                        const loadingItem = document.createElement('li');
                        loadingItem.className = 'dropdown-item py-2 px-3 text-center';
                        loadingItem.innerHTML =
                            '<i class="fas fa-spinner fa-spin"></i> ' + stationUi.loading;
                        subMenu.innerHTML = '';
                        subMenu.appendChild(loadingItem);

                        toggleDropdown(`${type}-stations`, false);
                        toggleDropdown(`${type}-sub-stations`, true);

                        // Load stations
                        const stations = await loadStations(city.id);
                        setTimeout(() => {
                            populateSubMenu(`${type}-sub-stations`, stations,
                                `${type}-stations`, city.name, type);
                        }, 50); // Tiny delay for smoother animation transition
                    });


                    mainMenu.appendChild(item);
                });
            }

            // Populate sub-menu with stations
            function populateSubMenu(subMenuId, stations, mainMenuId, cityName, type) {
                const subMenu = document.getElementById(subMenuId);
                subMenu.innerHTML = '';

                // Back to cities
                const backItem = document.createElement('li');
                backItem.className = 'dropdown-item back-item d-flex align-items-center py-2 px-3';
                backItem.innerHTML = `
                <i class="fas fa-arrow-right me-2"></i>
                <span class="fw-bold">${stationUi.backToCities}</span>
                `;
                backItem.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleDropdown(subMenuId, false);
                    toggleDropdown(mainMenuId, true);
                });
                subMenu.appendChild(backItem);

                // Sub-menu title
                const titleItem = document.createElement('li');
                titleItem.className = 'dropdown-header py-2 px-3';
                titleItem.textContent = stationUi.chooseStationIn + ' ' + cityName;
                subMenu.appendChild(titleItem);

                // Station rows
                if (stations.length === 0) {
                    const noStationsItem = document.createElement('li');
                    noStationsItem.className = 'dropdown-item py-2 px-3 text-muted';
                    noStationsItem.textContent = stationUi.noStationsAvailable;
                    subMenu.appendChild(noStationsItem);
                } else {
                    stations.forEach(station => {
                        const item = document.createElement('li');
                        item.className = 'dropdown-item py-2 px-3';
                        item.textContent = station.name;
                        item.addEventListener('click', () => {
                            const inputId = subMenuId.includes('from') ? 'fromInput' : 'toInput';
                            const hiddenId = subMenuId.includes('from') ? 'station_from_id' :
                                'station_to_id';
                            document.getElementById(inputId).value = station.name;
                            document.getElementById(hiddenId).value = station.id;
                            toggleDropdown(subMenuId, false);
                        });
                        subMenu.appendChild(item);
                    });
                }
            }


            // Swap stations: use delegation so both desktop and mobile swap buttons work
            document.addEventListener('click', function(e) {
                const swapBtn = e.target.closest('.swap-btn-floating, #swap-btn');
                if (!swapBtn) return;

                e.preventDefault();
                e.stopPropagation();

                // Desktop form (#tripForm)
                const tripForm = document.getElementById('tripForm');
                if (tripForm && tripForm.contains(swapBtn)) {
                    const cityFromId = tripForm.querySelector('#city_from_id');
                    const cityToId = tripForm.querySelector('#city_to_id');
                    const stationFromId = tripForm.querySelector('#station_from_id');
                    const stationToId = tripForm.querySelector('#station_to_id');
                    const fromInput = tripForm.querySelector('#fromInput');
                    const toInput = tripForm.querySelector('#toInput');
                    if (cityFromId && cityToId && stationFromId && stationToId && fromInput && toInput) {
                        const tempCity = cityFromId.value;
                        cityFromId.value = cityToId.value;
                        cityToId.value = tempCity;
                        const tempStation = stationFromId.value;
                        stationFromId.value = stationToId.value;
                        stationToId.value = tempStation;
                        const tempText = fromInput.value;
                        fromInput.value = toInput.value;
                        toInput.value = tempText;
                    }
                    return;
                }

                // Mobile form (#search-form)
                const searchForm = document.getElementById('search-form');
                if (searchForm && searchForm.contains(swapBtn)) {
                    const fromCityInput = document.getElementById('from-city');
                    const toCityInput = document.getElementById('to-city');
                    const fromStationInput = document.getElementById('from-station');
                    const toStationInput = document.getElementById('to-station');
                    const fromLocationSpan = document.getElementById('from-location');
                    const toLocationSpan = document.getElementById('to-location');
                    if (fromCityInput && toCityInput && fromStationInput && toStationInput &&
                        fromLocationSpan && toLocationSpan) {
                        const tempCityId = fromCityInput.value;
                        fromCityInput.value = toCityInput.value;
                        toCityInput.value = tempCityId;
                        const tempStationId = fromStationInput.value;
                        fromStationInput.value = toStationInput.value;
                        toStationInput.value = tempStationId;
                        const tempLocation = fromLocationSpan.textContent;
                        fromLocationSpan.textContent = toLocationSpan.textContent;
                        toLocationSpan.textContent = tempLocation;
                    }
                }
            });

            // Toggle dropdown visibility
            function toggleDropdown(menuId, show) {
                const menu = document.getElementById(menuId);
                if (menu) {
                    menu.style.display = show ? 'block' : 'none';
                    if (show) {
                        // Ensure it's above other elements but below navbar if navbar is fixed
                        const rect = menu.getBoundingClientRect();
                        if (rect.bottom > window.innerHeight) {
                            menu.style.top = 'auto';
                            menu.style.bottom = '100%';
                        } else {
                            menu.style.top = 'calc(100% + 10px)';
                            menu.style.bottom = 'auto';
                        }
                    }
                }
            }
        });
    </script>
    <!-- Arrow direction handling removed as it's now handled during dynamic population -->
    @if (!empty($apps['android']) || !empty($apps['ios']))
        <script>
            // Show app modal only after full page load so the home page is visible first
            window.addEventListener('load', function() {
                if (localStorage.getItem('appModalShown')) return;
                setTimeout(function() {
                    var el = document.getElementById('appDownloadModal');
                    if (el) {
                        var appDownloadModal = new bootstrap.Modal(el);
                        appDownloadModal.show();
                        localStorage.setItem('appModalShown', 'true');
                    }
                }, 1500);
            });
        </script>
    @endif
@endpush

@extends('layouts.master', [
    'isHome' => true,
])

@push('styles')
    <style>
        /* .hero-section::before {
            background: linear-gradient(to right, #00000040, #00000040), url({{ $heroSection['image'] }});
            transform: scaleX(1);
        } */
    </style>
@endpush
@section('content')
    <!-- start hero section  -->
    <div class="hero-section"id="heroSection">
        <div class="container-fluid px-5 box">
            <div class="row">
                <div class="col-lg-5 col-md-12 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold mb-3">{{ $heroSection['card-title'] }}</h5>
                            <form id="tripForm" action="{{ route('one-way.trips') }}" method="GET">
                                <!-- اختيار نوع الرحلة -->
                                <div class="d-flex justify-content-center gap-3 mb-3 trip-type py-3">
                                    <div class="form-check">
                                        <input class="form-check-input form-check-input-pay" type="radio" name="tripType"
                                            id="oneWayRadioDes" value="oneway" checked>
                                        <label class="form-check-label fw-bold text-black"
                                            for="oneWayRadioDes">{{ __('One Way Trip') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input form-check-input-pay" type="radio" value="round"
                                            name="tripType" id="roundTripRadioDes">
                                        <label class="form-check-label fw-bold text-black"
                                            for="roundTripRadioDes">{{ __('Round Trip') }}</label>
                                    </div>
                                    <span class="badge bg-warning text-white">{{ __('Special Discount') }}</span>
                                </div>

                                <!-- start from to  -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6 position-relative">
                                        <div
                                            class="d-flex align-items-center gap-2 rounded-6 px-3 py-1 desktop-from-input-box">
                                            <i class="fas fa-location-dot from-icon"></i>
                                            <input type="text" class="border-0 from-input desktop-from-input"
                                                placeholder="{{ __('From') }}" readonly data-bs-toggle="dropdown" aria-expanded="false"
                                                value="{{ $stations[0]->name }}" id="fromInput">
                                            <ul class="dropdown-menu p-0 main-stations" id="from-stations"></ul>
                                            <ul class="dropdown-menu p-0 sub-stations-dropdown" id="from-sub-stations"></ul>
                                        </div>
                                    </div>

                                    <div class="col-md-6 position-relative">
                                        <div
                                            class="d-flex align-items-center gap-2 rounded-6 px-3 py-1 desktop-from-input-box">
                                            <i class="fas fa-circle-dot to-icon"></i>
                                            <input type="text" class="border-0 to-input desktop-from-input"
                                                placeholder="إلى" readonly data-bs-toggle="dropdown" aria-expanded="false"
                                                id="toInput"
                                                value=" {{ request()->city_to_id ? $stations->where('city_id', request()->city_to_id)->first()->name : $stations[1]->name }}">
                                            <ul class="dropdown-menu p-0 main-stations" id="to-stations"></ul>
                                            <ul class="dropdown-menu p-0 sub-stations-dropdown" id="to-sub-stations"></ul>
                                        </div>
                                    </div>

                                    <!-- Hidden inputs for IDs -->
                                    <input type="hidden" name="city_from_id" id="cityFrom_id"
                                        value="{{ $stations[0]->city_id }}">
                                    <input type="hidden" name="city_to_id" id="cityTo_id"
                                        value="{{ request()->city_to_id ? request()->city_to_id : $stations[1]->city_id }}">
                                    <input type="hidden" name="station_from_id" id="stationFrom_id"
                                        value="{{ $stations[0]->id }}">
                                    <input type="hidden" name="station_to_id" id="stationTo_id"
                                        value="{{ request()->city_to_id ? $stations->where('city_id', request()->city_to_id)->first()->id : $stations[1]->id }}">

                                </div>

                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label fw-bold text-black">
                                            <i class="fas fa-calendar-alt mx-1"></i>
                                            {{ __('Travel Date') }}
                                        </label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control datepicker-text" value=""
                                                readonly id="dateTextInput">

                                            <input type="date" class="form-control datepicker-real"
                                                min="{{ date('Y-m-d') }}" name="go_date"
                                                value="{{ request()->go_date ?? date('Y-m-d') }}" id="dateRealInput">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <div class="d-flex flex-column">
                                            <label class="form-label fw-bold text-black">
                                                <i class="fas fa-calendar-alt mx-1"></i>
                                                {{ __('Back Date') }}
                                            </label>

                                            <div class="position-relative">
                                                <input type="text" class="form-control datepicker-text" value=""
                                                    readonly id="dateTextInput2">

                                                <input type="date" class="form-control datepicker-real"
                                                    min="{{ date('Y-m-d') }}" max="2027-04-07"
                                                    value="{{ request()->back_date ?? date('Y-m-d') }}"
                                                    id="dateRealInput2" name="back_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2 col-md-6 mt-4">
                                        <i class="fas fa-calendar-alt mx-1 text-main"></i>
                                        <a href="#" class="text-warning fw-bold arrival-time">
                                            {{ __('When are you coming back? Book your seat') }}
                                            <span class="badge bg-warning text-white fs-10">
                                                {{ __('Special Discount') }}
                                            </span>
                                        </a>

                                    </div>
                                </div>

                                <!-- عدد المسافرين -->
                                <div class="d-flex flex-column align-items-start gap-2 mb-3">
                                    <label class="fw-bold text-black">
                                        <i class="fas fa-user mx-1"></i>
                                        {{ __('Number of travelers') }}</label>
                                    <div class="d-flex align-items-center rounded px-3 py-1 trip-input">
                                        <button type="button" class="plus-btn" onclick="incrementPassengersdesktop()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <span class="mx-3" id="passengerCountdesktop">1</span>
                                        <input type="hidden" id="passengerCountDesktopInput" value="1"
                                            name="seats" />
                                        <button type="button" class="minus-btn" onclick="decrementPassengersdesktop()">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- زر البحث -->
                                <div class="d-flex justify-content-center">
                                    <button type="submit"
                                        class="btn search-trip-btn fw-bold py-2">{{ __('Search For Your Trip') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mx-auto col-md-12 hero-caption-box">
                    <div class="hero-caption-title">
                        <p class="text-white m-0">
                            {{ $heroSection['caption-title'] }}
                        </p>
                        <h6 class="text-white">
                            {{ $heroSection['caption-description'] }}
                        </h6>
                    </div>
                    {{-- <div class="text-white d-flex flex-lg-row flex-column justify-content-start align-items-center gap-3">

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
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
    <!-- End hero section  -->

    <!-- start any where  -->
    <div class="any-where py-5 bg-white px-4">
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
                    {{-- <img class="" src="{{ $anyWhereSection['image'] }}" alt="map"> --}}
                    <div>
                        <div class="circle-alex"></div>
                        <div class="title-alex">الاسكندرية</div>
                        <div class="circle-cairo"></div>
                        <div class="title-cairo">القاهرة</div>
                        <div class="circle-sharm"></div>
                        <div class="title-sharm">شرم الشيخ</div>
                        <div class="circle-her"></div>
                        <div class="title-her">الغردقة</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End any where  -->

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
                                            {{ app()->getLocale() == 'ar' ? $busType->name_ar : $busType->name_en }}</h5>
                                        <p class='cardBody text-gray'>
                                            {{ $busType->passengers }} {{ __('Passenger') }}
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                {!! render_stars($busType->rate) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="{{ $busType->image }}" alt="bus" />
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
                                    <div>
                                        <img src="{{ $testimonial->image }}"
                                            alt="صورة {{ $testimonial->translated_name }}">
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
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateTextInput = document.getElementById('dateTextInput');
            const dateRealInput = document.getElementById('dateRealInput');
            const selectedDate = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            dateTextInput.value = selectedDate.toLocaleDateString('ar-EG', options);
            dateTextInput.addEventListener('click', function() {
                dateRealInput.showPicker();
            });

            dateRealInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dateTextInput.value = selectedDate.toLocaleDateString('ar-EG', options);
                const dateTextInput2 = document.getElementById('dateTextInput2');
                dateTextInput2.value = dateTextInput.value;
                const dateRealInput2 = document.getElementById('dateRealInput2');
                dateRealInput2.value = selectedDate;
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateTextInput2 = document.getElementById('dateTextInput2');
            const dateRealInput2 = document.getElementById('dateRealInput2');
            const selectedDate = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            dateTextInput2.value = selectedDate.toLocaleDateString('ar-EG', options);
            dateTextInput2.addEventListener('click', function() {
                dateRealInput2.showPicker();
            });

            dateRealInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dateTextInput.value = selectedDate.toLocaleDateString('ar-EG', options);

                const dateTextInput2 = document.getElementById('dateTextInput2');
                dateTextInput2.value = dateTextInput.value;

                const dateRealInput2 = document.getElementById('dateRealInput2');
                dateRealInput2.value = selectedDate.toISOString().split('T')[0];
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
            countElement.textContent = passengerCount;
            countElementInput.value = passengerCount;
            countElement2Input.value = passengerCount;
        }

        function decrementPassengers() {
            if (passengerCount > 1) {
                passengerCount--;
                countElement.textContent = passengerCount;
                countElementInput.value = passengerCount;
                countElement2Input.value = passengerCount;
            }
        }
    </script>
    <script>
        let passengerCount2 = 1;
        const countElement2 = document.getElementById('passengerCount2');
        const countElement2Input = document.getElementById('passenger-count2');
        const countElementInput = document.getElementById('passenger-count');

        function incrementPassengers2() {
            passengerCount2++;
            countElement2.textContent = passengerCount2;
            countElement2Input.value = passengerCount2;
            countElementInput.value = passengerCount2;
        }

        function decrementPassengers2() {
            if (passengerCount2 > 1) {
                passengerCount2--;
                countElement2.textContent = passengerCount2;
                countElement2Input.value = passengerCount2;
                countElementInput.value = passengerCount2;
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swapBtn = document.querySelector('.swap-btn');

            swapBtn.addEventListener('click', function() {
                const fromInput = document.querySelector('.from-input');
                const toInput = document.querySelector('.to-input');

                const tempValue = fromInput.value;

                fromInput.value = toInput.value;
                toInput.value = tempValue;

                this.classList.add('clicked');
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 300);
            });
        });
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
                if (roundTripRadio.checked) {
                    // حالة ذهاب وعودة
                    returnDateCol.classList.remove('d-none');
                    departureDateCol.classList.remove('col-md-6');
                    departureDateCol.classList.add('col-md-6');
                    passengersColSide.classList.add('d-none');
                    passengersColBottom.classList.remove('d-none');
                } else {
                    // حالة ذهاب فقط
                    returnDateCol.classList.add('d-none');
                    departureDateCol.classList.remove('col-md-6');
                    departureDateCol.classList.add('col-md-6');
                    passengersColSide.classList.remove('d-none');
                    passengersColBottom.classList.add('d-none');
                }
            }

            oneWayRadio.addEventListener('change', updateLayout);
            roundTripRadio.addEventListener('change', updateLayout);

            updateLayout();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const oneWayRadioDes = document.getElementById('oneWayRadioDes');
            const roundTripRadioDes = document.getElementById('roundTripRadioDes');
            const returnDateContainer = document.querySelector('.col-md-6.d-none');
            const arrivalTimeSection = document.querySelector('.col-md-6.mt-4');
            const arrivalTimeLink = document.querySelector('.arrival-time');

            document.querySelectorAll('input[name="tripType"]').forEach(radio => {
                radio.addEventListener('change', updateTripTypeDisplay);
            });

            arrivalTimeLink.addEventListener('click', function(e) {
                e.preventDefault();
                roundTripRadioDes.checked = true;
                updateTripTypeDisplay();
            });

            function updateTripTypeDisplay() {
                if (roundTripRadioDes.checked) {
                    // إظهار تاريخ العودة
                    returnDateContainer.classList.remove('d-none');
                    arrivalTimeSection.classList.add('d-none');

                    // تغيير الـ action لرحلة ذهاب وعودة
                    tripForm.action = "{{ route('round.trips') }}";
                } else {
                    // إخفاء تاريخ العودة
                    returnDateContainer.classList.add('d-none');
                    arrivalTimeSection.classList.remove('d-none');

                    // تغيير الـ action لرحلة ذهاب فقط
                    tripForm.action = "{{ route('one-way.trips') }}";
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

                // إغلاق القائمة عند النقر خارجها
                document.addEventListener('click', function() {
                    dropdown.style.display = 'none';
                });
            }
        });
    </script>
    <style>
        #to-sub-stations,
        #from-sub-stations {
            z-index: 9999999 !important;
            max-height: 300px !important;
            overflow-y: scroll !important;
        }

        .main-stations,
        .sub-stations-dropdown {
            transform: none !important;
            top: 100% !important;
            left: 0 !important;
            position: absolute;
            inset: 0px 0px auto auto;
            margin: 0px;
        }

        /* لما تقف على الـ input */
        .from-input,
        .to-input {
            cursor: pointer;
        }

        /* لما تقف على عناصر القائمة */
        #fromInput,
        #toInput,
        #from-stations li,
        #to-stations li,
        #from-sub-stations li,
        #to-sub-stations li {
            cursor: pointer;
        }
    </style>

    <!-- stations  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // عناصر DOM
            const fromInput = document.getElementById('fromInput');

            const toInput = document.getElementById('toInput');
            const fromStations = document.getElementById('from-stations');
            const toStations = document.getElementById('to-stations');
            const fromSubStations = document.getElementById('from-sub-stations');
            const toSubStations = document.getElementById('to-sub-stations');
            initDropdowns();

            // تحميل المدن من API
            async function loadCities() {
                try {
                    const response = await fetch('/get-cities');
                    if (!response.ok) throw new Error('Network response was not ok');
                    return await response.json();
                } catch (error) {
                    console.error('Error loading cities:', error);
                    return [];
                }
            }

            // تحميل المحطات من API
            async function loadStations(cityId) {
                try {
                    const response = await fetch(`/get-stations/${cityId}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    return await response.json();
                } catch (error) {
                    console.error('Error loading stations:', error);
                    return [];
                }
            }

            // تهيئة القوائم المنسدلة
            async function initDropdowns() {
                console.log('initDropdowns');
                const cities = await loadCities();

                initDropdown('from', cities);
                initDropdown('to', cities);
                console.log('initDropdowns after');
                // أحداث النقر على المدخلات
                fromInput.addEventListener('click', function(e) {
                    console.log('fromInput clicked');
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
                toInput.addEventListener('focus', function(e) {
                    e.stopPropagation();
                    toggleDropdown('to-stations', true);
                    toggleDropdown('to-sub-stations', false);
                });

                // إغلاق القوائم عند النقر خارجها
                document.addEventListener('click', function() {
                    toggleDropdown('from-stations', false);
                    toggleDropdown('from-sub-stations', false);
                    toggleDropdown('to-stations', false);
                    toggleDropdown('to-sub-stations', false);
                });
            }

            // تهيئة قائمة منسدلة واحدة
            async function initDropdown(type, cities) {
                const mainMenu = document.getElementById(`${type}-stations`);
                const subMenu = document.getElementById(`${type}-sub-stations`);

                // تفريغ القوائم
                mainMenu.innerHTML = '';
                subMenu.innerHTML = '';

                // إضافة عنصر العنوان
                const titleItem = document.createElement('li');
                titleItem.className = 'dropdown-header py-2 px-3';
                titleItem.textContent = 'اختر المحطة';
                mainMenu.appendChild(titleItem);

                // إضافة المدن الرئيسية
                cities.forEach(city => {
                    const item = document.createElement('li');
                    item.className =
                        'dropdown-item d-flex justify-content-between align-items-center py-2 px-3';
                    item.innerHTML = `
                <span>${city.name}</span>
                <i class="fas fa-chevron-left ms-2"></i>
            `;

                    item.addEventListener('click', async (e) => {
                        e.stopPropagation();

                        // حط ID المدينة في الـ hidden input المناسب
                        const cityInputId = type === 'from' ? 'cityFrom_id' : 'cityTo_id';
                        document.getElementById(cityInputId).value = city.id;

                        // عرض حالة التحميل
                        const loadingItem = document.createElement('li');
                        loadingItem.className = 'dropdown-item py-2 px-3 text-center';
                        loadingItem.innerHTML =
                            '<i class="fas fa-spinner fa-spin"></i> جاري التحميل...';
                        subMenu.innerHTML = '';
                        subMenu.appendChild(loadingItem);

                        toggleDropdown(`${type}-stations`, false);
                        toggleDropdown(`${type}-sub-stations`, true);

                        // تحميل المحطات
                        const stations = await loadStations(city.id);
                        populateSubMenu(`${type}-sub-stations`, stations,
                            `${type}-stations`, city.name, type);
                    });


                    mainMenu.appendChild(item);
                });
            }

            // تعبئة القائمة الفرعية
            function populateSubMenu(subMenuId, stations, mainMenuId, cityName, type) {
                const subMenu = document.getElementById(subMenuId);
                subMenu.innerHTML = '';

                // زر الرجوع
                const backItem = document.createElement('li');
                backItem.className = 'dropdown-item d-flex align-items-center py-2 px-3';
                backItem.innerHTML = `
        <i class="fas fa-arrow-left me-2"></i>
        <span>رجوع إلى ${cityName}</span>
    `;
                backItem.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleDropdown(subMenuId, false);
                    toggleDropdown(mainMenuId, true);
                });
                subMenu.appendChild(backItem);

                // العنوان
                const titleItem = document.createElement('li');
                titleItem.className = 'dropdown-header py-2 px-3';
                titleItem.textContent = `اختر محطة في ${cityName}`;
                subMenu.appendChild(titleItem);

                // المحطات الفرعية
                if (stations.length === 0) {
                    const noStationsItem = document.createElement('li');
                    noStationsItem.className = 'dropdown-item py-2 px-3 text-muted';
                    noStationsItem.textContent = 'لا توجد محطات متاحة';
                    subMenu.appendChild(noStationsItem);
                } else {
                    stations.forEach(station => {
                        const item = document.createElement('li');
                        item.className = 'dropdown-item py-2 px-3';
                        item.textContent = station.name;
                        item.addEventListener('click', () => {
                            const inputId = subMenuId.includes('from') ? 'fromInput' : 'toInput';
                            const hiddenId = subMenuId.includes('from') ? 'stationFrom_id' :
                                'stationTo_id';
                            document.getElementById(inputId).value = station.name;
                            document.getElementById(hiddenId).value = station.id; // ✅ حفظ ID المحطة
                            toggleDropdown(subMenuId, false);
                        });
                        subMenu.appendChild(item);
                    });
                }
            }


            // تبديل حالة القائمة المنسدلة
            function toggleDropdown(menuId, show) {
                const menu = document.getElementById(menuId);
                if (menu) {
                    menu.style.display = show ? 'block' : 'none';
                    // تعديل position إذا كانت القائمة طويلة
                    if (show) {
                        const rect = menu.getBoundingClientRect();
                        if (rect.bottom > window.innerHeight) {
                            menu.style.top = 'auto';
                            menu.style.bottom = '100%';
                        }
                    }
                }
            }

            // تهيئة أولية
        });
    </script>

@endpush

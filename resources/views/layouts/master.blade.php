<!DOCTYPE html>
<html lang="en" dir="rtl">

@include('layouts.head')

<body>
    <div class="custom-toastr-container"></div>

    <div class="desktop d-lg-block d-none">

        @include('layouts.header')
        @yield('content')
        @include('layouts.footer')

    </div>
    <div class="mobile d-lg-none d-block">
        <div class="container mo-view mb-5 mt-3 px-4 ">
            <div class="row">

                <!-- start header  -->
                <div class="mobileHeader d-flex justify-content-between">
                    <p class="m-0 text-black">مرحبا بك يا احمد</p>
                    <div class="mo-bell-box position-relative">
                        <div class="bell-icon">
                            <p class="notification-count position-absolute m-0">1</p>
                            <i class="fa-regular fa-bell text-main fs-18"></i>
                        </div>
                        <div class="notifications-dropdown">
                            <div class="notification-header">
                                <h5>الإشعارات</h5>
                            </div>
                            <div class="notification-list">
                                <div class="notification-item unread">
                                    <span class="notification-time">لديك رسالة جديدة</span>
                                </div>
                                <div class="notification-item">
                                    <span class="notification-time">تمت الموافقة على طلبك</span>
                                </div>
                            </div>
                            <div class="notification-footer">
                                <a href="#">عرض جميع الإشعارات</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End header  -->

                <!-- Start Search  -->
                <div class="search-trip">
                    <form action="bus.html">

                        <!-- start trip type -->
                        <div class="trip-type bg-white  mt-3 d-flex justify-content-between align-items-center p-3">
                            <div class="form-check">
                                <input class="form-check-input form-check-input-pay" type="radio"
                                    name="flexRadioDefault" id="oneWayRadio" checked>
                                <label class="form-check-label" for="oneWayRadio">
                                    ذهاب فقط
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input-pay" type="radio"
                                    name="flexRadioDefault" id="roundTripRadio">
                                <label class="form-check-label" for="roundTripRadio">
                                    ذهاب وعودة
                                </label>
                            </div>
                            <div class="special-offer">
                                عرض خاص
                            </div>
                        </div>
                        <!-- End trip type -->

                        <!-- start from to  -->
                        <div class="form-to border rounded-7 px-3 py-3 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-location-dot from-icon"></i>
                                        <input type="text" class="border-0 from-input" placeholder="من"
                                            value="القاهرة">
                                    </div>
                                    <hr>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-circle-dot to-icon"></i>
                                        <input type="text" class="border-0 to-input" placeholder="إلى"
                                            value="الإسكندرية">
                                    </div>
                                </div>
                                <button type="button" class="swap-btn bg-transparent border-0"
                                    aria-label="تبديل الوجهات">
                                    <img src="{{ asset('images/mobile/swap.png') }}" alt="swap">
                                </button>
                            </div>
                        </div>

                        <!-- Start date and passenger numer -->
                        <div class="date-passenger mt-3">
                            <div class="row g-2" id="tripLayoutContainer">
                                <div class="col-md-6 d-flex flex-column" id="departureDateCol">
                                    <label>
                                        <span>تاريخ السفر</span>
                                        <i class="fa fa-calendar mx-1"></i>
                                    </label>
                                    <input class="form-control rounded-6" type="date" name="departure_date"
                                        id="departureDate">
                                </div>

                                <div class="col-md-6" id="passengersColSide">
                                    <div class="d-flex flex-column w-100 h-100 justify-content-end">
                                        <label>
                                            <span>الركاب</span>
                                            <i class="fa fa-user mx-1"></i>
                                        </label>
                                        <div
                                            class="d-flex justify-content-center align-items-center border rounded-6 p-1">
                                            <button type="button" class="border passenger-btn plus-btn"
                                                onclick="decrementPassengers()">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <span class="mx-3" id="passengerCount">1</span>
                                            <button type="button" class="passenger-btn minus-btn"
                                                onclick="incrementPassengers()">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 d-none" id="returnDateCol">
                                    <div class="d-flex flex-column">
                                        <label>
                                            <span>تاريخ العودة</span>
                                            <i class="fa fa-calendar mx-1"></i>
                                        </label>
                                        <input class="form-control rounded-6" type="date" name="return_date"
                                            id="returnDate">
                                    </div>
                                </div>

                                <div class="col-12 d-none" id="passengersColBottom">
                                    <div class="d-flex flex-column w-100">
                                        <label>
                                            <span>الركاب</span>
                                            <i class="fa fa-user mx-1"></i>
                                        </label>
                                        <div
                                            class="d-flex justify-content-center align-items-center border rounded-6 p-1">
                                            <button type="button" class="border passenger-btn"
                                                onclick="decrementPassengers2()">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <span class="mx-3" id="passengerCount2">1</span>
                                            <button type="button" class="passenger-btn"
                                                onclick="incrementPassengers2()">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End date and passenger numer -->

                        <div class=" d-flex justify-content-center align-items-center mt-3">
                            <button class="search-btn">
                                البحث عن الرحلات
                            </button>
                        </div>

                    </form>
                </div>
                <!-- Start Search  -->

                <!-- start last search  -->
                <div class="last-search">

                    <div class="d-flex justify-content-between align-items-center my-3">
                        <p class="m-0">البحث الاخير</p>
                        <a href="last-search.html">عرض الكل</a>
                    </div>

                    <div class="swiper mySwiper2">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="border rounded-7 px-3 py-4">
                                    <div
                                        class="d-flex justify-content-start gap-3 align-items-center text-black fw-bold">
                                        <p class="m-0 fs-18">القاهرة</p>
                                        <i class="fas fa-arrow-left-long fs-18"></i>
                                        <p class="m-0 fs-18">الاسكندرية</p>
                                    </div>
                                    <div class="mt-3">
                                        <p class="m-0 text-gray">
                                            24 فبراير 2023 . 1 راكب . درجة اولي
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">

                                <div class="border rounded-6 px-3 py-4">
                                    <div
                                        class="d-flex justify-content-start gap-3 align-items-center text-black fw-bold">
                                        <p class="m-0 fs-18">القاهرة</p>
                                        <i class="fas fa-arrow-left-long fs-18"></i>
                                        <p class="m-0 fs-18">الاسكندرية</p>
                                    </div>
                                    <div class="mt-3">
                                        <p class="m-0 text-gray">
                                            24 فبراير 2023 . 1 راكب . درجة اولي
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End last search  -->

                <!-- start promo  -->
                <div class="promo mt-3">
                    <h2 class="text-black mb-2">احصل على عروض ترويجية</h2>
                    <div class="swiper mySwiper3">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="position-relative rounded-7 promo-box">
                                    <div class="m-0 position-absolute promo-caption">
                                        <p class="m-0">خصم</p>
                                        <span class="fs-20">30%</span>
                                        <p class="m-0">للمستخدمين الجدد</p>
                                    </div>
                                    <img class="promo-img rounded-7" src="{{ asset('images/mobile/promo.png') }}"
                                        alt="promo">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="position-relative rounded-7 promo-box">
                                    <div class="m-0 position-absolute promo-caption">
                                        <p class="m-0">خصم</p>
                                        <span class="fs-20">30%</span>
                                        <p class="m-0">للمستخدمين الجدد</p>
                                    </div>
                                    <img class="promo-img rounded-7" src="{{ asset('images/mobile/promo.png') }}"
                                        alt="promo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End promo  -->

                <!-- start new places  -->
                <div class="new-places mt-3">
                    <h2 class="text-black mb-1">استكشف اماكن جديدة</h2>
                    <div class="swiper mySwiper4">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}"
                                        alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}"
                                        alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}"
                                        alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}"
                                        alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="{{ asset('images/mobile/new-places.png') }}"
                                        alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End new places  -->
            </div>
        </div>

        <!-- start bottom navbar  -->
        <div>
            <div class="bottom-navbar">
                <a href="index.html" class="nav-item active">
                    <div>
                        <i class="fa fa-home"></i>
                        <p>الرئيسية</p>
                    </div>
                </a>
                <a href="tickets.html" class="nav-item">
                    <div>
                        <i class="fas fa-ticket"></i>
                        <p>التذاكر</p>
                    </div>
                </a>
                <a href="setting-page.html" class="nav-item">
                    <div>
                        <i class="fas fa-gear"></i>
                        <p>الاعدادات</p>
                    </div>
                </a>
            </div>
        </div>
        <!-- End bottom navbar  -->

    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    @stack('scripts')

    <!-- MDB JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
    <!-- WOW.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/custom-toastr.js') }}"></script>

    @if (session('success'))
        <script>
            showToast('success', "{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            showToast('error', "{{ session('error') }}");
        </script>
    @endif

    @if ($errors->any())
        <script>
            showToast('error', "{{ $errors->first() }}");
        </script>
    @endif

    @include('includes.logout-modal')
</body>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDB CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <!-- apple-touch-icon -->
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Super Jet</title>
</head>

<body>

    <!-- start desktop view  -->
    <div class="desktop d-lg-block d-none">

        <!-- start navbar  -->
        <div id="navbar" class=""></div>
        <!-- End navbar  -->

        <!-- start hero section  -->
        <div class="hero-section">
            <div class="container-fluid px-5 box">
                <div class="row">
                    <div class="col-lg-5 col-md-12 m-auto">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold mb-3">احجز رحلتك دلوقتي!</h5>
                                <form>
                                    <!-- اختيار نوع الرحلة -->
                                    <div class="d-flex justify-content-center gap-3 mb-3 trip-type py-3">
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input-pay" type="radio"
                                                name="tripType" id="oneWayRadioDes" checked>
                                            <label class="form-check-label fw-bold text-black" for="oneWayRadioDes">ذهاب
                                                فقط</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input-pay" type="radio"
                                                name="tripType" id="roundTripRadioDes">
                                            <label class="form-check-label fw-bold text-black"
                                                for="roundTripRadioDes">ذهاب
                                                وعودة</label>
                                        </div>
                                        <span class="badge bg-warning text-white">خصم خاص</span>
                                    </div>

                                    <!-- اختيار المدن -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-black text-center">
                                                <i class="fas fa-location-dot mx-1"></i>
                                                السفر من
                                            </label>
                                            <select class="form-select trip-select">
                                                <option>القاهرة</option>
                                                <option>الإسكندرية</option>
                                                <option>أسوان</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-black">
                                                <i class="fas fa-location-dot mx-1"></i>
                                                الوصول إلى
                                            </label>
                                            <select class="form-select  trip-select">
                                                <option>مرسى مطروح</option>
                                                <option>شرم الشيخ</option>
                                                <option>الغردقة</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <div class="mb-2 col-md-6">
                                            <label class="form-label fw-bold text-black">
                                                <i class="fas fa-calendar-alt mx-1"></i>
                                                تاريخ السفر
                                            </label>

                                            <div class="position-relative">
                                                <input type="text" class="form-control datepicker-text"
                                                    value="الإثنين 7 أبريل 2025" readonly id="dateTextInput">

                                                <input type="date" class="form-control datepicker-real"
                                                    min="2025-04-07" max="2027-04-07" value="2025-04-07"
                                                    id="dateRealInput">
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <div class="d-flex flex-column">
                                                <label class="form-label fw-bold text-black">
                                                    <i class="fas fa-calendar-alt mx-1"></i>
                                                    تاريخ العودة
                                                </label>

                                                <div class="position-relative">
                                                    <input type="text" class="form-control datepicker-text"
                                                        value="الإثنين 7 أبريل 2025" readonly id="dateTextInput2">

                                                    <input type="date" class="form-control datepicker-real"
                                                        min="2025-04-07" max="2027-04-07" value="2025-04-07"
                                                        id="dateRealInput2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-md-6 mt-4">
                                            <i class="fas fa-calendar-alt mx-1 text-main"></i>
                                            <a href="#" class="text-warning fw-bold  arrival-time">"راجع امتي؟
                                                احجز
                                                مكانك" <span class="badge bg-warning text-white fs-10">خصم
                                                    خاص</span></a>
                                        </div>
                                    </div>

                                    <!-- عدد المسافرين -->
                                    <div class="d-flex flex-column align-items-start gap-2 mb-3">
                                        <label class="fw-bold text-black">
                                            <i class="fas fa-user mx-1"></i>
                                            عدد المسافرين</label>
                                        <div class="d-flex align-items-center rounded px-3 py-1 trip-input">
                                            <button type="button" class="plus-btn"
                                                onclick="incrementPassengersdesktop()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <span class="mx-3" id="passengerCountdesktop">1</span>
                                            <button type="button" class="minus-btn"
                                                onclick="decrementPassengersdesktop()">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- زر البحث -->
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn search-trip-btn fw-bold py-2">ابحث
                                            عن
                                            رحلتك</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mx-auto col-md-12 hero-caption-box">
                        <div class="hero-caption-title">
                            <p class="text-white m-0">
                                خلصها بسرعة!
                            </p>
                            <h6 class="text-white">
                                احجز رحلتك مع السوبر جيت وادفع بالبطاقة الائتمانية في لحظة!

                            </h6>
                        </div>
                        <div
                            class="text-white d-flex flex-lg-row flex-column justify-content-start align-items-center gap-3">

                            <button class="google-play-box rounded-5">
                                <div class=" d-flex justify-content-center align-items-center gap-3 py-2 px-2">
                                    <div class="google-play">
                                        <p>Download On The</p>
                                        <h6>App Store</h6>
                                    </div>
                                    <i class="fa-brands fa-apple"></i>
                                </div>
                            </button>
                            <button class="google-play-box rounded-5">
                                <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-2">
                                    <div class="google-play">
                                        <p>Get It On</p>
                                        <h6>Google Play</h6>
                                    </div>
                                    <img src="{{ asset('images/google-play-icon.png') }}" alt="">
                                </div>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End hero section  -->

        <!-- start any where  -->
        <div class="any-where py-5 bg-white px-4">
            <div class="container-fluid px-5">
                <div class="row">
                    <div
                        class="col-md-6 any-where-caption d-flex flex-column align-items-start justify-content-center">
                        <h2>سوبر جيت معك في آي مكان</h2>
                        <p class="mt-5">
                            لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل،
                            وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب
                            الشعور
                            بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر
                            عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل
                            المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد
                            وأسي.
                        </p>
                        <h6>
                            و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن
                            من
                            لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن
                            يتجنب
                            الألم الذي ربما تنجم عنه بعض المتعة ؟
                        </h6>
                    </div>
                    <div class="col-md-6 position-relative map">
                        <img class="" src="{{ asset('images/map.png') }}" alt="map">
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
                <h2 class="text-center">اختر طريقة الدفع اللي تناسبك</h2>
                <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center mt-4">
                    <img src="./images/pay/visa.png" alt="pay">
                    <img src="./images/pay/master.png" alt="pay">
                    <img src="./images/pay/meeza.png" alt="pay">
                    <img src="./images/pay/qnp.png" alt="pay">
                    <img src="./images/pay/ahly.png" alt="pay">
                    <img src="./images/pay/fawry.png" alt="pay">
                </div>
            </div>
        </div>
        <!-- End pay  -->

        <!-- start bus type  -->
        <div class="bus-type">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center mb-5">أنواع الحافلات</h2>
                    </div>
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class='cardSection card'>

                                    <div class="cardbody card-body py-2">
                                        <h5 class='cardTitle'>VIP Business</h5>
                                        <p class='cardBody text-gray'>
                                            39 - 57 راكب
                                        </p>
                                        <div class='cardRate'>
                                            <div>
                                                <i class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative bus-bg-box mt-3">
                                        <div class="bus-bg position-absolute">
                                        </div>
                                        <img src="./images/bus.png" alt="bus" />
                                    </div>
                                </div>
                            </div>

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
        <div class="testimonials py-5 px-3 ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center text-black">
                            آراء عملائنا
                        </h2>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class='cardSection card p-3'>

                            <div class="cardbody card-body py-2">
                                <div class="d-flex justify-content-end">
                                    <i class="fas fa-quote-left fs-25"></i>
                                </div>
                                <p class='cardBody text-gray'>
                                    "مكان يليق بالمناسبات الخاصة."
                                    الأطباق مُبتكرة لكنها تحافظ على الروح التقليدية، والديكور يضفي شعورًا بالفخامة.
                                    المندي
                                    والدجاج المشوي مذهلان.
                                </p>
                                <div class='d-flex justify-content-end align-items-center gap-2'>
                                    <p class="m-0">سامر النوري</p>
                                    <div>
                                        <img src="./images/user.png" alt="user">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class='cardSection card p-3'>

                            <div class="cardbody card-body py-2">
                                <div class="d-flex justify-content-end">
                                    <i class="fas fa-quote-left fs-25"></i>
                                </div>
                                <p class='cardBody text-gray'>
                                    "مكان يليق بالمناسبات الخاصة."
                                    الأطباق مُبتكرة لكنها تحافظ على الروح التقليدية، والديكور يضفي شعورًا بالفخامة.
                                    المندي
                                    والدجاج المشوي مذهلان.
                                </p>
                                <div class='d-flex justify-content-end align-items-center gap-2'>
                                    <p class="m-0">سامر النوري</p>
                                    <div>
                                        <img src="./images/user.png" alt="user">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class='cardSection card p-3'>

                            <div class="cardbody card-body py-2">
                                <div class="d-flex justify-content-end">
                                    <i class="fas fa-quote-left fs-25"></i>
                                </div>
                                <p class='cardBody text-gray'>
                                    "مكان يليق بالمناسبات الخاصة."
                                    الأطباق مُبتكرة لكنها تحافظ على الروح التقليدية، والديكور يضفي شعورًا بالفخامة.
                                    المندي
                                    والدجاج المشوي مذهلان.
                                </p>
                                <div class='d-flex justify-content-end align-items-center gap-2'>
                                    <p class="m-0">سامر النوري</p>
                                    <div>
                                        <img src="./images/user.png" alt="user">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End testimonials  -->

        <!-- start reservation  -->
        <div class="">
            <div class="reservation">
                <h2>
                    انطلق إلى سحر شواطئ مصر الخلابة واستمتع بالمياه الفيروزية والأجواء المنعشة!
                </h2>
                <p>
                    لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل، وسأعرض
                    لك
                    التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن
                    بفضل
                    هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا
                    لمواجهة
                    الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن
                    نتيجة
                    لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.
                </p>
                <button>
                    احجز الان
                </button>
            </div>
        </div>

        <!-- End reservation  -->

        <!-- start blogs  -->
        <div class="blogs py-5 ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">حكاياتنا</h2>
                    </div>
                    <div class="col-md-4 mb-4 px-3">
                        <div class='cardSection card text-center rounded-bottom-4'>
                            <img class="img-fluid rounded-top-4" src="./images/blogs.jpeg" alt="blogs" />
                            <div class="cardbody card-body py-2">
                                <h5>Lorem ipsum dolor </h5>
                                <div class='cardBody'>
                                    <p>
                                        March 12, 2022 - 6 min read
                                    </p>
                                    <h6>
                                        Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui odio id
                                        enim.
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 px-3">
                        <div class='cardSection card text-center rounded-bottom-4'>
                            <img class="img-fluid rounded-top-4" src="./images/blogs.jpeg" alt="blogs" />
                            <div class="cardbody card-body py-2">
                                <h5>Lorem ipsum dolor </h5>
                                <div class='cardBody'>
                                    <p>
                                        March 12, 2022 - 6 min read
                                    </p>
                                    <h6>
                                        Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui odio id
                                        enim.
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 px-3">
                        <div class='cardSection card text-center rounded-bottom-4'>
                            <img class="img-fluid rounded-top-4" src="./images/blogs.jpeg" alt="blogs" />
                            <div class="cardbody card-body py-2">
                                <h5>Lorem ipsum dolor </h5>
                                <div class='cardBody'>
                                    <p>
                                        March 12, 2022 - 6 min read
                                    </p>
                                    <h6>
                                        Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui odio id
                                        enim.
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 px-3">
                        <div class='cardSection card text-center rounded-bottom-4'>
                            <img class="img-fluid rounded-top-4" src="./images/blogs.jpeg" alt="blogs" />
                            <div class="cardbody card-body py-2">
                                <h5>Lorem ipsum dolor </h5>
                                <div class='cardBody'>
                                    <p>
                                        March 12, 2022 - 6 min read
                                    </p>
                                    <h6>
                                        Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui odio id
                                        enim.
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 px-3">
                        <div class='cardSection card text-center rounded-bottom-4'>
                            <img class="img-fluid rounded-top-4" src="./images/blogs.jpeg" alt="blogs" />
                            <div class="cardbody card-body py-2">
                                <h5>Lorem ipsum dolor </h5>
                                <div class='cardBody'>
                                    <p>
                                        March 12, 2022 - 6 min read
                                    </p>
                                    <h6>
                                        Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui odio id
                                        enim.
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 px-3">
                        <div class='cardSection card text-center rounded-bottom-4'>
                            <img class="img-fluid rounded-top-4" src="./images/blogs.jpeg" alt="blogs" />
                            <div class="cardbody card-body py-2">
                                <h5>Lorem ipsum dolor </h5>
                                <div class='cardBody'>
                                    <p>
                                        March 12, 2022 - 6 min read
                                    </p>
                                    <h6>
                                        Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui odio id
                                        enim.
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End blogs  -->

        <!-- start footer  -->
        <div id="footer"></div>
        <!-- End footer  -->
    </div>
    <!-- End desktop view  -->

    <!-- start Mobile view  -->

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
                                    <img class="promo-img rounded-7" src="./images/mobile/promo.png" alt="promo">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="position-relative rounded-7 promo-box">
                                    <div class="m-0 position-absolute promo-caption">
                                        <p class="m-0">خصم</p>
                                        <span class="fs-20">30%</span>
                                        <p class="m-0">للمستخدمين الجدد</p>
                                    </div>
                                    <img class="promo-img rounded-7" src="./images/mobile/promo.png" alt="promo">
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
                                    <img class="promo-img" src="./images/mobile/new-places.png" alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="./images/mobile/new-places.png" alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="./images/mobile/new-places.png" alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="./images/mobile/new-places.png" alt="new-places">
                                    <p class="text-black">الاسكندرية</p>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div>
                                    <img class="promo-img" src="./images/mobile/new-places.png" alt="new-places">
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

    <!-- End Mobile view  -->


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
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
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateTextInput2 = document.getElementById('dateTextInput2');
            const dateRealInput2 = document.getElementById('dateRealInput2');

            dateTextInput2.addEventListener('click', function() {
                dateRealInput2.showPicker();
            });

            dateRealInput2.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                dateTextInput2.value = selectedDate.toLocaleDateString('ar-EG', options);
            });
        });
    </script>


    <script>
        let passengerCountdesktop = 1;
        const countElementdesktop = document.getElementById('passengerCountdesktop');

        function incrementPassengersdesktop() {
            passengerCountdesktop++;
            countElementdesktop.textContent = passengerCountdesktop;
        }

        function decrementPassengersdesktop() {
            if (passengerCountdesktop > 1) {
                passengerCountdesktop--;
                countElementdesktop.textContent = passengerCountdesktop;
            }
        }
    </script>

    <script>
        let passengerCount = 1;
        const countElement = document.getElementById('passengerCount');

        function incrementPassengers() {
            passengerCount++;
            countElement.textContent = passengerCount;
        }

        function decrementPassengers() {
            if (passengerCount > 1) {
                passengerCount--;
                countElement.textContent = passengerCount;
            }
        }
    </script>
    <script>
        let passengerCount2 = 1;
        const countElement2 = document.getElementById('passengerCount2');

        function incrementPassengers2() {
            passengerCount2++;
            countElement2.textContent = passengerCount2;
        }

        function decrementPassengers2() {
            if (passengerCount2 > 1) {
                passengerCount2--;
                countElement2.textContent = passengerCount2;
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
                    returnDateContainer.classList.remove('d-none');
                    arrivalTimeSection.classList.add('d-none');
                } else {
                    returnDateContainer.classList.add('d-none');
                    arrivalTimeSection.classList.remove('d-none');
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bellBox = document.querySelector('.mo-bell-box');
            const dropdown = document.querySelector('.notifications-dropdown');

            bellBox.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });

            // إغلاق القائمة عند النقر خارجها
            document.addEventListener('click', function() {
                dropdown.style.display = 'none';
            });
        });
    </script>

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
    <script src="./js/main.js" defer></script>
</body>

</html>

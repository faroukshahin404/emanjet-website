@extends('layouts.master')

@section('content')
    <!-- start hero section  -->
    <div class="hero-section-destination">
        <div class="container box-destination">
            <div class="row">
                <div class="col-md-6">
                    <form action="">
                        <input type="search" name="" id="" placeholder="مسافر علي فين؟">
                        <i class="fa fa-search search-icon"></i>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End hero section  -->

    <!-- start popular -->
    <div class="popular pt-5 px-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <h2 class="text-right text-black">
                        استكشف الوجهات الأكثر شهرة
                    </h2>
                </div>
            </div>

            <div class="row" id="cards-container">

                @for ($i = 0; $i < 9; $i++)
                    <div class="col-md-4 mb-4 px-3">
                        <div class='cardSection card text-center rounded-bottom-4 pb-3'>
                            <img class="img-fluid rounded-top-4" src="./images/blogs.jpeg" alt="blogs" />
                            <div class="cardbody card-body py-2">
                                <div class='cardBody mb-3 d-flex justify-content-between align-items-center'>
                                    <p class="m-0 popular-title">الاسكندريه</p>
                                    <button class="heart-btn">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>

                                <div class='cardBody d-flex justify-content-between align-items-center'>
                                    <button class="reserve"> احجز الان </button>
                                    <div class="d-flex flex-column align-items-end">
                                        <h6 class="m-0">350 egp</h6>
                                        <p class="m-0">per seat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor

            </div>

        </div>
    </div>
    <!-- End popular -->

    <!-- start try -->
    <div class="try">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 try-caption">
                    <h6>
                        جرب الفخامة من مستوى أعلى
                    </h6>
                    <p class="m-0">
                        سوبر جيت دلوقتي بباصات دورين لأول مرة في مصر! راحة أكتر، مساحة أوسع، وتجربة سفر ولا أروع. احجز
                        مقعدك واستمتع بالرحلة
                    </p>
                </div>
                <div class="col-md-6">
                    <img class="try-img" src="./images/bus-2.png" alt="bus">
                </div>
            </div>
        </div>
    </div>
    <!-- End try -->

    <!-- start app  -->
    <div class="app mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 box">
                    <img class="" src="./images/phone.png" alt="">
                </div>
                <div class="col-md-6 try-caption text-black">
                    <h4>
                        خطط سفرك بضغطة زر!
                    </h4>
                    <h5>
                        سوبر جيت دلوقتي بباصات دورين لأول مرة في مصر! راحة أكتر، مساحة أوسع، وتجربة سفر
                    </h5>

                    <div
                        class="text-white d-flex flex-lg-row flex-column justify-content-start align-items-center gap-lg-3 gap-1">

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
                                <img src="./images/google-play-icon.png" alt="">
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End app  -->
@endsection

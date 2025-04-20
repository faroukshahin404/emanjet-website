@extends('layouts.master')

@section('content')
    <!-- start about-us caption  -->
    <div class="about-us-caption">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col-md-6 about-us-caption-box">
                    <h2>
                        حكايات الباص
                    </h2>
                    <p>
                        لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار النشوة وتمجيد الألم نشأت بالفعل،
                        وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور
                        بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر
                        عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل
                        المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد
                        وأسي.
                    </p>
                    <h6>
                        و سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من
                        لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب
                        الألم الذي ربما تنجم عنه بعض المتعة ؟
                    </h6>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid rounded-bottom-4" src="./images/about-bg.png" alt="about-page">
                </div>
            </div>
        </div>
    </div>
    <!-- End about-us caption  -->

    <!-- Start Blogs Tabs -->
    <div class="blogs-taps pt-5 px-5">
        <div class="container-fluid">
            <div class="row">
                <h2 class="text-center">حكايتنا</h2>

                <ul class="nav nav-pills d-flex justify-content-center flex-wrap align-items-center mb-3" id="blogTabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1">أفضل الوجهات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2">نصائح السفر</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3" data-bs-toggle="tab" href="#content3">أماكن تستحق الزيارة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab4" data-bs-toggle="tab" href="#content4">تجارب المسافرين</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab5" data-bs-toggle="tab" href="#content5">خدمات الباصات</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="content1">
                        <div class="row">

                            <div class="col-md-4 mb-4 px-3 px-1">
                                <div class='cardSection card text-center rounded-bottom-4'>
                                    <img class="img-fluid rounded-top-4" src="./images/blogs.jpeg" alt="blogs" />
                                    <div class="cardbody card-body py-2">
                                        <h5>Lorem ipsum dolor </h5>
                                        <div class='cardBody'>
                                            <p>
                                                March 12, 2022 - 6 min read
                                            </p>
                                            <h6>
                                                Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui
                                                odio
                                                id
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
                                                Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui
                                                odio
                                                id
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
                                                Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui
                                                odio
                                                id
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
                                                Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui
                                                odio
                                                id
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
                                                Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui
                                                odio
                                                id
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
                                                Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui
                                                odio
                                                id
                                                enim.
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade text-center" id="content2">
                        <h3>نصائح السفر</h3>
                        <p>أهم النصائح التي تحتاجها لرحلتك القادمة...</p>
                    </div>
                    <div class="tab-pane fade text-center" id="content3">
                        <h3>أماكن تستحق الزيارة</h3>
                        <p>أماكن مميزة لا تفوتك زيارتها...</p>
                    </div>
                    <div class="tab-pane fade text-center" id="content4">
                        <h3>تجارب المسافرين</h3>
                        <p>قصص وتجارب ملهمة من مختلف المسافرين...</p>
                    </div>
                    <div class="tab-pane fade text-center" id="content5">
                        <h3>خدمات الباصات</h3>
                        <p>تفاصيل حول خدمات الباصات المتاحة...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blogs Tabs -->

    <!-- start trip start here -->
    <div class="trip-start my-5 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-center align-items-end gap-1 flex-lg-row flex-column">
                        <img class="img-1" src="./images/beach.jpeg" alt="trip">
                        <img class="img-2" src="./images/beach.jpeg" alt="trip">

                    </div>
                    <div class="d-flex justify-content-center align-items-start gap-1 mt-1 flex-lg-row flex-column">
                        <img class="img-3" src="./images/beach.jpeg" alt="trip">
                        <img class="img-4" src="./images/beach.jpeg" alt="trip">
                        <img class="img-5" src="./images/beach.jpeg" alt="trip">

                    </div>

                </div>
                <div class="col-md-6 trip-start-caption pt-3">
                    <h2>
                        رحلاتك تبدأ هنا
                    </h2>
                    <p>
                        رحلاتك تبدأ هنا
                    </p>
                    <h6>
                        سأعرض مثال حي لهذا، من منا لم يتحمل جهد بدني شاق إلا من أجل الحصول على ميزة أو فائدة؟ ولكن من
                        لديه الحق أن ينتقد شخص ما أراد أن يشعر بالسعادة التي لا تشوبها عواقب أليمة أو آخر أراد أن يتجنب
                        الألم الذي ربما تنجم عنه بعض المتعة ؟
                    </h6>
                    <button>
                        ابحث عن رحلتك
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End trip start here -->
@endsection

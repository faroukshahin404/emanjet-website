
<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand mx-4" href="index.html">
            <img src="./images/logo.png" alt="logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Offcanvas Sidebar -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html"
                            data-lang='{"en": "Home", "ar": "الرئيسية"}'>الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="destinations.html" data-lang='{"en": "Destinations", "ar": "وجهات السفر"}'>وجهات
                            السفر</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blogs.html" data-lang='{"en": "Bus Blogs", "ar": "حكايات الباص"}'>حكايات
                            الباص</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about-us.html" data-lang='{"en": "About Us", "ar": "عنا"}'>عنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us.html" data-lang='{"en": "Contact Us", "ar": "تواصل معنا"}'>تواصل
                            معنا</a>
                    </li>
                </ul>

                <select id="languageSelect" class="form-select w-auto mx-3 select-lang">
                    <option value="ar">العربية</option>
                    <option value="en">English</option>
                </select>

                <button class="loginBtn" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-unlock"></i>
                        <p class="m-0" data-lang='{"en": "Login", "ar": "تسجيل الدخول"}'>تسجيل الدخول</p>
                    </div>
                </button>

                <div class="dropdown mx-2">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        مرحبا , سيد اسامة
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="profile.html">رحلاتي</a></li>
                        <li><a class="dropdown-item" href="profile.html">بياناتي</a></li>
                        <li><a class="dropdown-item" href="#">خروج</a></li>
                    </ul>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"
                    aria-hidden="true" data-bs-backdrop="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h5 class="modal-title mx-auto">تسجيل الدخول</h5>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="" class="login-form">
                                    <div class="position-relative">
                                        <input type="text" class="phoneInput" placeholder="رقم الهاتف">
                                        <i class="fas fa-phone phone-icon"></i>
                                    </div>
                                    <p>سنقوم بإرسال رمز تحقق إلى رقم هاتفك للتأكد من أنك صاحب الحساب وإتمام عملية
                                        التأكيد بنجاح</p>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="submitBtn mt-3">ارسال</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
@extends('layouts.master')
@section('content')
    <!-- start register  -->
    <div class="register-desktop">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow pb-3">
                <div class="col-md-6">
                    <h2 class="text-center text-black mb-3">التسجيل</h2>
                    <form action="{{ route('auth.postRegister') }}" method="POST" class="w-75 m-auto d-flex flex-column">
                        @csrf
                        <div class="position-relative mb-3">
                            <i class="fa fa-user position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="phoneInput" type="text" name="name" id="name" placeholder="الاسم" value="{{old('name')}}"
                                required>
                        </div>

                        <div class="position-relative mb-3">
                            <i class="fa fa-phone position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="phoneInput" type="text" name="phone" id="phone" placeholder="رقم الهاتف" value="{{old('phone')}}"
                                required>
                        </div>

                        {{-- password --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-key position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="passwordInput" type="password" name="password" id="password"
                                placeholder="كلمة السر" required>
                        </div>
                        {{-- confirm password --}}
                        <div class="position-relative mb-3">
                            <i class="fa fa-key position-absolute top-50 translate-middle-y px-2"></i>
                            <input class="passwordInput" type="password" name="password_confirmation"
                                id="password_confirmation" placeholder="تأكيد كلمة السر" required>
                        </div>

                        <p>
                            سنقوم بإرسال رمز تحقق إلى رقم هاتفك للتأكد من أنك صاحب الحساب وإتمام عملية
                            التأكيد بنجاح
                        </p>

                        <p class="text-center text-muted">إذا كنت تمتلك حسابًا، يمكنك تسجيل الدخول من خلال الضغط على
                            <a href="{{ route('auth.login') }}" class="text-primary">تسجيل دخول</a>
                        </p>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="submitBtn mt-3">ارسال</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid" src="../images/hero-section.png" alt="register">
                </div>
            </div>
        </div>
    </div>
    <!-- end register  -->
@endsection

@push('scripts')
    <script>
        function changeLanguage(lang) {
            document.documentElement.lang = lang;
            document.documentElement.dir = lang === "ar" ? "rtl" : "ltr";
            localStorage.setItem("selectedLang", lang);
            document.getElementById("languageSelect").value = lang;

            document.querySelectorAll("[data-lang]").forEach(element => {
                const translations = JSON.parse(element.getAttribute("data-lang"));
                element.textContent = translations[lang];
            });
        }

        window.onload = function() {
            let savedLang = localStorage.getItem("selectedLang") || "ar";
            changeLanguage(savedLang);
        };

        document.getElementById("languageSelect").addEventListener("change", function() {
            changeLanguage(this.value);
        });

        window.addEventListener("scroll", function() {
            const navbar = document.querySelector(".navbar");
            if (window.scrollY > 0) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    </script>

    <script>
        window.addEventListener('load', function() {
            const navbar = document.querySelector('.navbar');
            const heroSection = document.querySelector('.hero-section');
            const navbarHeight = navbar.offsetHeight;
            heroSection.style.paddingTop = `${navbarHeight}px`;
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentPage = window.location.pathname.split("/").pop() || "index.html";
            const navLinks = document.querySelectorAll(".navbar-white .navbar-nav .nav-link");
            navLinks.forEach(link => {
                const linkHref = link.getAttribute("href").split("/").pop();
                if (linkHref === currentPage) {
                    link.classList.add("active");
                }
            });
        });
    </script>
@endpush

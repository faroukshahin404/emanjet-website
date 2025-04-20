@extends('layouts.master')
@section('content')
    <!-- start about-us caption  -->
    <div class="contact-us mb-5">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col-md-6 text-center pt-3 d-flex flex-column justify-content-center align-items-center">
                    <h2>
                        تواصل معنا!
                    </h2>
                    <p>
                        نحن هنا لمساعدتك! أرسل استفسارك عبر النموذج أدناه لأي مشكلة تواجهها.
                    </p>
                    <form action="{{route('submit-contact-form')}}" method="POST" class="w-100">
                        @csrf
                        <div class="input-box">
                            <input type="text" name="name" id="" placeholder="الاسم" required>
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="input-box">
                            <input type="text" name="phone" id="" placeholder="رقم الهاتف"required>
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <textarea class="form-control" name="message" id="" placeholder="ارسل لنا رسالة" required></textarea>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="contact-btn">
                                ارسال
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid" src="./images/about-bg.png" alt="about-page">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 need-help mt-5">
                    <h2>
                        تحتاج الي المزيد من المساعدة:
                    </h2>
                    <div>
                        <span>اتصل بنا علي: </span>
                        <a href="tel:0100000">010000000</a>
                    </div>
                    <div>
                        <span>للتواصل على طريق الواتس اب: </span>
                        <a href="whatsapp:0110000">01000000</a>
                    </div>
                    <div>
                        <span>او أرسل رسالة إلكترونية علي</span>
                        <a href="mailto:Info@superje">Info@superje</a>
                    </div>
                    <div>
                        <span>وللشكاوي برجاء التواصل علي</span>
                        <a href="www.customer-complaints@superjet-eg.com">customer-complaints@superjet-eg.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
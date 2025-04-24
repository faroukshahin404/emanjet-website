@extends('layouts.master')
@section('content')
    <!-- start about-us caption  -->
    <div class="contact-us mb-5">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col-md-6 text-center pt-3 d-flex flex-column justify-content-center align-items-center">
                    <h2>
                        {{ $contactForm['title'] }} </h2>
                    <p>
                        {{ $contactForm['description'] }}
                    </p>
                    <form action="{{ route('submit-contact-form') }}" method="POST" class="w-100">
                        @csrf
                        <div class="input-box">
                            <input type="text" name="name" id="" placeholder="{{ __('Name') }}" required>
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="input-box">
                            <input type="text" name="phone" id=""
                                placeholder="{{ __('Phone Number') }}"required>
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <textarea class="form-control" name="message" id="" placeholder="{{ __('Send Us a Message') }}" required></textarea>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="contact-btn">
                                {{ __('Send') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ asset($contactForm['image']) }}" alt="about-page">

                </div>
            </div>

            <div class="row">
                <div class="col-md-12 need-help mt-5">
                    <h2>{{ __('Need More Help') }}:</h2>

                    @if (!empty($contactUs['phone']))
                        <div>
                            <span>{{ __('Contact us at') }}: </span>
                            <a href="tel:{{ $contactUs['phone'] }}">{{ $contactUs['phone'] }}</a>
                        </div>
                    @endif

                    @if (!empty($contactUs['whatsapp']))
                        <div>
                            <span>{{ __('Contact us via WhatsApp') }}: </span>
                            <a href="https://api.whatsapp.com/send?phone={{ $contactUs['whatsapp'] }}" target="_blank">
                                {{ $contactUs['whatsapp'] }}
                            </a>
                        </div>
                    @endif

                    @if (!empty($contactUs['email']))
                        <div>
                            <span>{{ __('Or send an email to') }}</span>
                            <a href="mailto:{{ $contactUs['email'] }}">{{ $contactUs['email'] }}</a>
                        </div>
                    @endif

                    @if (!empty($contactUs['complaints_email']))
                        <div>
                            <span>{{ __('For complaints, please contact us at') }}</span>
                            <a href="mailto:{{ $contactUs['complaints_email'] }}">{{ $contactUs['complaints_email'] }}</a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-3">

        <i class="fas fa-arrow-right fs-25 text-black" onclick="window.history.back()"></i>
        
        <p class="m-0 fs-25 text-black">{{__('Contact Us')}}</p>
        <div></div>
    </div>

    <div class="mt-3">
        <h6 class="text-black mb-4">
            {{ $contactForm['description'] }}
        </h6>
        <form action="{{route('submit-contact-form')}}" method="POST" class="login-form">
            @csrf
            @if(!auth()->check())
            <div class="position-relative mb-3">
                <i class="fa fa-user position-absolute top-50 translate-middle-y"></i>
                <input class="form-control rounded-6 ps-4" type="text" name="name" id="" placeholder="{{__('Name')}}">
            </div>

            <div class="position-relative mb-3">
                <i class="fa fa-phone position-absolute top-50 translate-middle-y"></i>
                <input class="form-control rounded-6 ps-4" type="text" name="phone" id=""
                    placeholder="{{__('Phone Number')}}">
            </div>
            @else
            <div class="position-relative mb-3">
                <i class="fa fa-user position-absolute top-50 translate-middle-y"></i>
                <input class="form-control rounded-6 ps-4" type="text" value="{{auth()->user()->name}}" name="name" id="" placeholder="{{__('Name')}}">
            </div>

            <div class="position-relative mb-3">
                <i class="fa fa-phone position-absolute top-50 translate-middle-y"></i>
                <input class="form-control rounded-6 ps-4" value="{{auth()->user()->mobile}}" type="text" name="phone" id=""
                    placeholder="{{__('Phone Number')}}">
            </div> 
            @endif

            <div class="position-relative">
                <i class="fa fa-envelope position-absolute"></i>
                <textarea name="message" id="" class="form-control rounded-6 ps-4" placeholder="الرسالة"></textarea>
            </div>

            <div class="col-md-12 d-flex justify-content-center align-items-center my-3">
                <a class="login" href="">{{__('Submit')}}</a>
            </div>
        </form>
    </div>
@endsection

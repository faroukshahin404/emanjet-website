@extends('layouts.master')

@section('content')
    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- HERO SECTION                                            --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <section class="contact-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 contact-hero-content wow fadeInUp" data-wow-delay="0.1s">
                    <h1>{{ $contactForm['title'] ?? __('Contact Us') }}</h1>
                    @if(!empty($contactForm['description']))
                        <p>{{ $contactForm['description'] }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- MAIN CONTENT GRID                                       --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-5">
                
                {{-- Left: Contact Form --}}
                <div class="col-lg-7 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="contact-card">
                        <h4 class="fw-bold mb-4">{{ $contactForm['form-title'] ?? __('Send Us a Message') }}</h4>
                        <form action="{{ route('submit-contact-form') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="contact-form-label">{{ __('Name') }}</label>
                                    <div class="contact-input-wrapper">
                                        <i class="fa-solid fa-user"></i>
                                        <input type="text" name="name" class="contact-control" 
                                               placeholder="{{ __('Enter your name') }}" 
                                               value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="contact-form-label">{{ __('Phone Number') }}</label>
                                    <div class="contact-input-wrapper">
                                        <i class="fa-solid fa-phone"></i>
                                        <input type="text" name="phone" class="contact-control" 
                                               placeholder="{{ __('Enter phone number') }}" 
                                               value="{{ auth()->check() ? auth()->user()->mobile : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="contact-form-label">{{ __('Message') }}</label>
                                    <div class="contact-input-wrapper">
                                        <i class="fa-solid fa-envelope"></i>
                                        <textarea name="message" class="contact-control" rows="5" 
                                                  placeholder="{{ __('How can we help you?') }}" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="contact-submit-btn">
                                        {{ $contactForm['button-text'] ?? __('Submit Message') }}
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right: Contact Info --}}
                <div class="col-lg-5 wow fadeInRight" data-wow-delay="0.3s">
                    <div class="ps-lg-4">
                        <h4 class="fw-bold mb-4">{{ __('Quick Contact') }}</h4>
                        
                        {{-- Phone --}}
                        @if (!empty($contactUs['phone']))
                            <a href="tel:{{ $contactUs['phone'] }}" class="info-action-card">
                                <div class="info-icon-box">
                                    <i class="fa-solid fa-phone-volume"></i>
                                </div>
                                <div class="info-text-box">
                                    <span class="label">{{ __('Call Us') }}</span>
                                    <span class="value">{{ $contactUs['phone'] }}</span>
                                </div>
                            </a>
                        @endif

                        {{-- WhatsApp --}}
                        @if (!empty($contactUs['whatsapp']))
                            <a href="https://api.whatsapp.com/send?phone={{ $contactUs['whatsapp'] }}" target="_blank" class="info-action-card">
                                <div class="info-icon-box">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </div>
                                <div class="info-text-box">
                                    <span class="label">{{ __('WhatsApp') }}</span>
                                    <span class="value">{{ $contactUs['whatsapp'] }}</span>
                                </div>
                            </a>
                        @endif

                        {{-- Email --}}
                        @if (!empty($contactUs['email']))
                            <a href="mailto:{{ $contactUs['email'] }}" class="info-action-card">
                                <div class="info-icon-box">
                                    <i class="fa-solid fa-at"></i>
                                </div>
                                <div class="info-text-box">
                                    <span class="label">{{ __('Email Us') }}</span>
                                    <span class="value">{{ $contactUs['email'] }}</span>
                                </div>
                            </a>
                        @endif

                        {{-- Complaints Banner --}}
                        @if (!empty($contactUs['complaints_email']))
                            <div class="complaints-banner">
                                <i class="fa-solid fa-headset corner-icon"></i>
                                <h5>{{ $contactForm['complaints-title'] ?? __('Complaints & Feedback') }}</h5>
                                <p>{{ $contactForm['complaints-description'] ?? __('Experience any issues? We are here to listen and improve our service.') }}</p>
                                <a href="mailto:{{ $contactUs['complaints_email'] }}">
                                    {{ $contactUs['complaints_email'] }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('mobile-content')
    <div class="w-100 py-3">
        {{-- Mobile Header --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <button onclick="window.history.back()" class="btn btn-outline-light border-0 text-black p-0">
                <i class="fa-solid fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} fs-4"></i>
            </button>
            <h1 class="fw-bold fs-3 mb-0">{{ __('Contact Us') }}</h1>
        </div>

        {{-- Form Section --}}
        <div class="bg-white rounded-5 shadow-sm p-4 mb-4 border border-light-subtle">
            <h5 class="fw-bold mb-3">{{ __('Send a Message') }}</h5>
            <form action="{{ route('submit-contact-form') }}" method="POST">
                @csrf
                <div class="contact-input-wrapper mb-3">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" class="contact-control" 
                           placeholder="{{ __('Name') }}" 
                           value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                </div>
                <div class="contact-input-wrapper mb-3">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="phone" class="contact-control" 
                           placeholder="{{ __('Phone Number') }}" 
                           value="{{ auth()->check() ? auth()->user()->mobile : '' }}" required>
                </div>
                <div class="contact-input-wrapper mb-4">
                    <i class="fa-solid fa-message"></i>
                    <textarea name="message" class="contact-control" rows="4" 
                              placeholder="{{ __('Message') }}" required></textarea>
                </div>
                <button type="submit" class="contact-submit-btn">
                    {{ __('Submit') }}
                </button>
            </form>
        </div>

        {{-- Info Grid --}}
        <div class="row g-3">
            @if (!empty($contactUs['phone']))
                <div class="col-6">
                    <a href="tel:{{ $contactUs['phone'] }}" class="bg-white rounded-4 p-3 text-center d-block border border-light-subtle shadow-xs h-100">
                        <i class="fa-solid fa-phone text-main fs-4 mb-2"></i>
                        <span class="d-block small text-muted">{{ __('Call') }}</span>
                    </a>
                </div>
            @endif
            @if (!empty($contactUs['whatsapp']))
                <div class="col-6">
                    <a href="https://api.whatsapp.com/send?phone={{ $contactUs['whatsapp'] }}" class="bg-white rounded-4 p-3 text-center d-block border border-light-subtle shadow-xs h-100">
                        <i class="fa-brands fa-whatsapp text-success fs-4 mb-2"></i>
                        <span class="d-block small text-muted">{{ __('WhatsApp') }}</span>
                    </a>
                </div>
            @endif
            @if (!empty($contactUs['email']))
                <div class="col-12">
                    <a href="mailto:{{ $contactUs['email'] }}" class="bg-white rounded-4 p-3 d-flex align-items-center gap-3 border border-light-subtle shadow-xs">
                        <div class="info-icon-box bg-light-subtle" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-envelope text-main"></i>
                        </div>
                        <span class="small text-muted text-truncate">{{ $contactUs['email'] }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

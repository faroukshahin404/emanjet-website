@extends('layouts.master')

@push('styles')
<style>
    /* Destination specific premium tweaks */
    .dest-hero {
        padding-top: 100px;
        background: #fff;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(var(--main-color-rgb), 0.1);
    }
    
    .dest-hero::before {
        content: '';
        position: absolute;
        top: 0;
        inset-inline-end: 0;
        width: 45%;
        height: 100%;
        background: linear-gradient(135deg, rgba(var(--main-color-rgb), 0.08), rgba(var(--main-color-rgb), 0.03));
        pointer-events: none;
        border-radius: 0 0 0 80px;
    }

    .dest-hero-content {
        padding: 4rem 0;
    }

    .dest-hero-img-wrap {
        position: relative;
        height: 440px;
    }

    .dest-hero-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 32px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
        position: relative;
        z-index: 1;
    }

    .dest-hero-img-wrap::after {
        content: '';
        position: absolute;
        bottom: -20px;
        inset-inline-end: -20px;
        width: 80%;
        height: 80%;
        border: 3px solid rgba(var(--main-color-rgb), 0.4);
        border-radius: 32px;
        z-index: 0;
    }

    /* Modern search bar within hero */
    .hero-search-wrap {
        background: #fff;
        padding: 8px;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #eee;
        display: flex;
        align-items: center;
        max-width: 500px;
        margin-top: 2rem;
        transition: all 0.3s ease;
    }

    .hero-search-wrap:focus-within {
        box-shadow: 0 15px 40px rgba(var(--main-color-rgb), 0.15);
        border-color: rgba(var(--main-color-rgb), 0.3);
        transform: translateY(-2px);
    }

    .hero-search-input {
        border: none !important;
        outline: none !important;
        padding: 10px 20px;
        flex-grow: 1;
        font-weight: 500;
        background: transparent;
    }

    .hero-search-btn {
        background: var(--main-color);
        color: #fff;
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .hero-search-btn:hover {
        background: var(--main-hover);
        transform: scale(1.05);
    }

    /* Premium City Cards */
    .city-premium-card {
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        position: relative;
    }

    .city-card-img-box {
        height: 240px;
        overflow: hidden;
        position: relative;
    }

    .city-card-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .city-premium-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.12);
        border-color: transparent;
    }

    .city-premium-card:hover .city-card-img-box img {
        transform: scale(1.1);
    }

    .city-badge {
        position: absolute;
        top: 20px;
        inset-inline-start: 20px;
        z-index: 2;
        background: rgba(var(--main-color-rgb), 0.95);
        color: #fff;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        backdrop-filter: blur(4px);
    }

    .city-card-body {
        padding: 1.75rem;
    }

    .city-card-body h3 {
        font-weight: 800;
        font-size: 1.4rem;
        margin-bottom: 0.75rem;
        color: #111;
    }

    .city-card-body p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .city-book-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--main-color);
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .city-book-btn i {
        background: rgba(var(--main-color-rgb), 0.1);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .city-premium-card:hover .city-book-btn i {
        background: var(--main-color);
        color: #fff;
        transform: translateX(5px);
    }
    
    [dir="rtl"] .city-premium-card:hover .city-book-btn i {
        transform: translateX(-5px);
    }
</style>
@endpush

@section('content')
    {{-- Hero Section --}}
    <section class="dest-hero">
        {{-- Decorative Glows --}}
        <div class="position-absolute top-0 start-50 translate-middle-x w-100 h-100 overflow-hidden pointer-events-none" style="z-index: 0;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 70% 20%, rgba(var(--main-color-rgb), 0.12), transparent 70%);"></div>
        </div>

        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 dest-hero-content wow animate__animated animate__fadeInLeft">
                    <div class="badge-label pulse-animation" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(var(--main-color-rgb), 0.12); color: #8a6200; border: 1px solid rgba(var(--main-color-rgb), 0.35); border-radius: 50px; padding: 6px 18px; font-size: 13px; font-weight: 700; margin-bottom: 1.5rem;">
                        <i class="fa-solid fa-map-location-dot"></i>
                        {{ $heroSection['pre-title'] ?? __('OUR ROUTES') }}
                    </div>
                    
                    <h1 class="display-4 fw-800 mb-3" style="font-weight: 800; line-height: 1.15; color: #111;">
                        {!! str_replace(['Adventure', 'المغامرة'], '<span class="text-main">' . ($heroSection['title-accent'] ?? __('Adventure')) . '</span>', $heroSection['title'] ?? __('Discover Your Next Adventure')) !!}
                    </h1>
                    
                    <p class="lead opacity-90 text-muted" style="line-height: 1.8; max-width: 540px;">
                        {{ $heroSection['description'] ?? __('Explore the best destinations across the country with :brand. Premium services, safe journeys, and unforgettable experiences.', ['brand' => __('Eman Jet')]) }}
                    </p>

                    <form action="{{ route('destinations') }}" method="GET">
                        <div class="hero-search-wrap">
                            <input type="text" name="search" class="hero-search-input" 
                                   placeholder="{{ $heroSection['search-title'] ?? __('Search destinations...') }}" 
                                   value="{{ request('search') }}">
                            <button type="submit" class="hero-search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                @if (!empty($heroSection['image']))
                <div class="col-lg-6 wow animate__animated animate__fadeInRight">
                    <div class="dest-hero-img-wrap">
                        <img src="{{ asset($heroSection['image']) }}" alt="Destinations" class="shadow-premium">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Popular Destinations --}}
    <section class="py-5 bg-light" style="padding: 100px 0;">
        <div class="container">
            <div class="row mb-5 text-center wow animate__animated animate__fadeInUp">
                <div class="col-lg-7 mx-auto">
                    <p class="pre-title mb-2" style="color: var(--main-color); letter-spacing: 2px; font-weight: 700; text-transform: uppercase;">
                        <i class="fa-solid fa-star me-2"></i>
                        {{ $popularCitiesSection['pre-title'] ?? __('TRAVEL THE COUNTRY') }}
                    </p>
                    <h2 class="display-6 fw-800 text-black">{{ $popularCitiesSection['title'] ?? __('Explore Popular Cities') }}</h2>
                    <div class="section-divider mx-auto my-3" style="width: 60px; height: 4px; background: var(--main-color); border-radius: 2px;"></div>
                    <p class="text-muted">{{ $popularCitiesSection['description'] ?? __('Curated routes for your ultimate comfort. Choose your destination and book your ticket in seconds.') }}</p>
                </div>
            </div>

            <div class="row g-4 mt-4">
                @foreach ($cities as $city)
                    <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                        <div class="city-premium-card">
                            <div class="city-card-img-box">
                                <div class="city-badge">
                                    <i class="fa fa-arrow-trend-up me-1"></i>
                                    {{ __('Most Visited') }}
                                </div>
                                <img src="{{ $city->image }}" alt="{{ $city->getTranslation('name', app()->getLocale()) }}">
                            </div>
                            <div class="city-card-body">
                                <h3>{{ $city->getTranslation('name', app()->getLocale()) }}</h3>
                                <p>{{ __('Enjoy a comfortable and safe journey to') }} {{ $city->getTranslation('name', app()->getLocale()) }} {{ __('with our premium bus services.') }}</p>
                                <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection" class="city-book-btn">
                                    <span>{{ __('Book Now') }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Quick Booking CTA --}}
    @if (!empty($trySection['title']))
    <section class="py-5 my-5">
        <div class="container">
            <div class="rounded-5 overflow-hidden position-relative p-5 shadow-premium" 
                 style="background: linear-gradient(135deg, #0b0c10, #1c1d22); min-height: 400px; display: flex; align-items: center;">
                
                {{-- Decorative background icon --}}
                <i class="fa-solid fa-bus position-absolute text-white opacity-05" style="font-size: 20rem; bottom: -50px; inset-inline-end: -50px; z-index: 0; pointer-events: none;"></i>

                <div class="row align-items-center position-relative" style="z-index: 1; width: 100%;">
                    <div class="col-lg-7 text-white wow animate__animated animate__fadeInLeft">
                        <div class="badge bg-accent mb-3 px-3 py-2 rounded-pill fw-bold">{{ __('QUICK BOOKING') }}</div>
                        <h2 class="display-5 fw-800 mb-4">{{ $trySection['title'] }}</h2>
                        <p class="fs-5 opacity-75 mb-5">{{ $trySection['description'] }}</p>
                        <a href="{{ route('home') }}" class="btn btn-main btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg">
                            {{ $trySection['button-text'] ?? __('Find your trip now') }}
                            <i class="fas fa-search ms-2"></i>
                        </a>
                    </div>
                    @if (!empty($trySection['image']))
                    <div class="col-lg-5 text-center d-none d-lg-block wow animate__animated animate__fadeInRight">
                        <img src="{{ asset($trySection['image']) }}" alt="Quick Booking" class="img-fluid rounded-4 shadow-lg" style="max-height: 320px; transform: rotate(3deg);">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@section('mobile-content')
    <div class="w-100 py-3">
        {{-- Mobile Header --}}
        <div class="d-flex align-items-center gap-3 mb-4 wow animate__animated animate__fadeIn">
            <button onclick="window.history.back()" class="btn btn-outline-light border-0 text-black p-0">
                <i class="fa-solid fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} fs-4"></i>
            </button>
            <h1 class="fw-800 fs-3 mb-0">{{ __('Destinations') }}</h1>
        </div>

        {{-- Mobile Hero --}}
        <div class="bg-white rounded-5 shadow-sm p-4 mb-4 border border-light-subtle position-relative overflow-hidden wow animate__animated animate__fadeInUp">
            <div class="position-absolute top-0 end-0 p-3 opacity-10">
                <i class="fa-solid fa-route fa-4x text-main"></i>
            </div>
            <h2 class="fw-800 fs-4 mb-2 text-black">{{ __('Explore Best Cities') }}</h2>
            <p class="text-muted small mb-3">{{ __('Find your next destination with ease.') }}</p>
            
            <form action="{{ route('destinations') }}" method="GET" class="mt-3">
                <div class="hero-search-wrap m-0 w-100 shadow-none border-light-subtle" style="background: #f8f9fa;">
                    <input type="text" name="search" class="hero-search-input py-2" 
                           placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                    <button type="submit" class="hero-search-btn" style="width: 40px; height: 40px;">
                        <i class="fas fa-search small"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Section Title --}}
        <div class="d-flex align-items-center justify-content-between mb-3 px-1 wow animate__animated animate__fadeInUp">
            <h5 class="fw-800 text-black mb-0">{{ __('Popular Routes') }}</h5>
            <span class="badge bg-main-subtle text-main rounded-pill small">{{ $cities->count() }} {{ __('Cities') }}</span>
        </div>

        {{-- City List for Mobile --}}
        <div class="row g-3">
            @foreach ($cities as $city)
                <div class="col-12 wow animate__animated animate__fadeInUp" data-wow-delay="{{ $loop->index * 0.05 }}s">
                    <div class="bg-white rounded-5 shadow-sm p-3 border border-light-subtle d-flex align-items-center gap-3">
                        <div class="rounded-4 overflow-hidden flex-shrink-0 shadow-xs" style="width: 90px; height: 90px;">
                            <img src="{{ $city->image }}" alt="{{ $city->name }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-800 text-black mb-1">{{ $city->getTranslation('name', app()->getLocale()) }}</h6>
                            <p class="text-muted small mb-2 line-clamp-2" style="font-size: 0.8rem;">{{ __('Travel safely to') }} {{ $city->name }}</p>
                            <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection" class="text-main fw-bold small text-decoration-none">
                                {{ __('Book Now') }} <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} ms-1" style="font-size: 8px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Quick Book Mobile --}}
        @if (!empty($trySection['title']))
        <div class="mt-5 mb-4 wow animate__animated animate__fadeInUp">
            <div class="rounded-5 p-4 text-white position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0b0c10, #1c1d22); min-height: 200px;">
                <i class="fa-solid fa-bus position-absolute text-white opacity-05" style="font-size: 8rem; bottom: -20px; right: -20px; z-index: 0;"></i>
                <div class="position-relative" style="z-index: 1;">
                    <span class="badge bg-accent mb-2 small">{{ __('QUICK BOOK') }}</span>
                    <h4 class="fw-800 mb-2">{{ $trySection['title'] }}</h4>
                    <p class="small opacity-75 mb-3">{{ $trySection['description'] }}</p>
                    <a href="{{ route('home') }}" class="btn btn-main rounded-pill w-100 py-2 fw-bold">{{ __('Find a Trip') }}</a>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

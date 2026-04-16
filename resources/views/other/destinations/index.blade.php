@extends('layouts.master')

@push('styles')
<style>
    .hero-section-destination::before {
        background: linear-gradient(to right, #00000040, #00000040),
            url({{ asset(!empty($heroSection['image']) ? $heroSection['image'] : 'images/hero-section.png') }});
        transform: scale(1);
    }

    .destinations-mobile-hero {
        min-height: 140px;
        border-radius: 1rem;
        background-size: cover;
        background-position: center;
        margin-bottom: 1rem;
        position: relative;
    }

    .destinations-mobile-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 0;
        border-radius: inherit;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.45) 0%, rgba(0, 0, 0, 0.25) 100%);
    }

    .destinations-mobile-hero__inner {
        position: relative;
        z-index: 1;
    }

    .search-wrapper {
        position: relative;
        width: 100%;
    }

    .search-wrapper input[type="search"] {
        width: 100%;
        padding: 10px 55px 10px 55px; /* extra horizontal padding for icons */
        border: 1px solid #ccc;
        border-radius: 30px;
        font-size: 16px;
        outline: none;
        text-align: left;
        direction: ltr;
        box-sizing: border-box;
    }

    /* Hide browser default search clear control */
    .search-wrapper input[type="search"]::-webkit-search-cancel-button {
        -webkit-appearance: none;
        appearance: none;
        display: none;
    }

    .search-wrapper .search-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 20px; /* offset search icon */
        cursor: pointer;
        font-size: 18px;
        color: #555;
        pointer-events: none;
    }

    .search-wrapper .clear-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 20px; /* offset clear icon */
        cursor: pointer;
        font-size: 18px;
        color: #555;
        display: none;
    }

    /* RTL layout */
    html[dir="rtl"] .search-wrapper input[type="search"] {
        text-align: right;
        direction: rtl;
        padding: 10px 55px 10px 55px; /* mirror padding, same spacing */
    }

    html[dir="rtl"] .search-wrapper .search-icon {
        left: auto;
        right: 20px;
    }

    html[dir="rtl"] .search-wrapper .clear-icon {
        right: auto;
        left: 20px;
    }
    html[dir="ltr"] .search-wrapper input[type="search"] {
    text-align: left;
    direction: ltr;
    padding: 10px 55px 10px 55px;
}

html[dir="ltr"] .search-wrapper .search-icon {
    left: 20px;
    right: auto;
}

html[dir="ltr"] .search-wrapper .clear-icon {
    right: 20px;
    left: auto;
}

</style>
@endpush

@section('content')
<!-- start hero section  -->
<div class="hero-section-destination d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="text-white fw-bold mb-4 display-4">{{ __('Discover Your Next Adventure') }}</h1>
                <p class="text-white-50 mb-5 fs-5">{{ __('Explore the best destinations across the country with Superjet') }}</p>
                
                <form action="{{ route('destinations') }}" method="GET" class="destination-search-form">
                    <div class="search-wrapper mx-auto" style="max-width: 600px;">
                        <input type="search" name="search" class="destination-search-input py-3" placeholder="{{ $heroSection['search-title'] }}" value="{{ old('search', request()->input('search')) }}" autocomplete="off">
                        <i class="fa fa-search search-icon" aria-hidden="true"></i>
                        <i class="fa fa-times clear-icon" role="button" tabindex="0" aria-label="{{ __('Clear search') }}"></i>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End hero section  -->

<!-- start popular -->
<div class="popular py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <span class="text-main fw-bold text-uppercase letter-spacing-1 small d-block mb-2">{{ __('TRAVEL THE COUNTRY') }}</span>
                        <h2 class="text-black fw-bold display-6">
                            {{ __('Explore Popular Destinations') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4" id="cards-container">
            @foreach ($cities as $city)
            <div class="col-md-6 col-lg-4">
                <div class='cardSection card border-0'>
                    <!-- Hot Badge -->
                    <div class="destination-badge">
                        <i class="fa fa-arrow-trend-up me-1"></i>
                        {{ __('Most Visited') }}
                    </div>
                    
                    <img class="img-fluid" src="{{ $city->image }}" alt="{{ $city->getTranslation('name', app()->getLocale()) }}" />
                    
                    <div class="cardbody card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="popular-title m-0">{{ $city->getTranslation('name', app()->getLocale()) }}</h3>
                        </div>
                        
                        <p class="text-muted small mb-4">
                            {{ __('Enjoy a comfortable and safe journey to') }} {{ $city->getTranslation('name', app()->getLocale()) }} {{ __('with our premium bus services.') }}
                        </p>
                        
                        <div class="mt-4">
                            <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection" class="reserve">
                                <i class="fas fa-ticket-alt"></i>
                                {{ __('Book Now') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
<!-- End popular -->

<!-- start try -->
<div class="try py-5 my-5 bg-light rounded-5 mx-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 try-caption p-5">
                <span class="badge bg-main mb-3">{{ __('QUICK BOOKING') }}</span>
                <h2 class="display-5 fw-bold text-black mb-4">{{ $trySection['title'] }}</h2>
                <p class="text-muted fs-5 mb-5">{{ $trySection['description'] }}</p>
                <a href="{{ route('home') }}" class="btn btn-main btn-lg px-5 py-3 rounded-pill fw-bold">
                    {{ __('Find a Trip') }}
                </a>
            </div>
            <div class="col-md-6 text-center">
                <img class="img-fluid rounded-4 shadow-lg" src="{{ asset($trySection['image']) }}" alt="bus" style="max-height: 400px;">
            </div>
        </div>
    </div>
</div>
<!-- End try -->
@endsection

@section('mobile-content')
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            @if (app()->getLocale() == 'ar')
                <i class="fas fa-arrow-right fs-18 text-black" role="button" tabindex="0" aria-label="{{ __('Back') }}" onclick="window.history.back()"></i>
            @else
                <i class="fas fa-arrow-left fs-18 text-black" role="button" tabindex="0" aria-label="{{ __('Back') }}" onclick="window.history.back()"></i>
            @endif
            <p class="m-0 fs-20 text-black fw-bold">{{ __('Destinations') }}</p>
            <div class="invisible" aria-hidden="true"><i class="fas fa-arrow-left fs-18"></i></div>
        </div>

        <div class="hero-section-destination rounded-4 d-flex align-items-center mb-4" style="height: 200px;">
            <div class="container py-3 px-4">
                <h2 class="text-white fw-bold fs-4 mb-3">{{ __('Explore Best Cities') }}</h2>
                <form action="{{ route('destinations') }}" method="GET" class="destination-search-form">
                    <div class="search-wrapper">
                        <input type="search" name="search" class="destination-search-input" placeholder="{{ $heroSection['search-title'] }}" value="{{ old('search', request()->input('search')) }}" autocomplete="off">
                        <i class="fa fa-search search-icon" aria-hidden="true"></i>
                        <i class="fa fa-times clear-icon" role="button" tabindex="0" aria-label="{{ __('Clear search') }}"></i>
                    </div>
                </form>
            </div>
        </div>

        <h2 class="h5 text-black fw-bold mb-4">
            {{ __('Most Popular Destinations') }}
        </h2>

        <div class="row g-4 mb-5">
            @foreach ($cities as $city)
                <div class="col-12">
                    <div class="cardSection card border-0">
                        <div class="destination-badge">
                            <i class="fa fa-arrow-trend-up me-1"></i>
                            {{ __('Most Visited') }}
                        </div>
                        <img class="img-fluid" src="{{ $city->image }}" alt="{{ $city->getTranslation('name', app()->getLocale()) }}">
                        <div class="cardbody card-body">
                            <h3 class="popular-title m-0 fs-5">{{ $city->getTranslation('name', app()->getLocale()) }}</h3>
                            <p class="text-muted small my-3">
                                {{ __('Discover the beauty of') }} {{ $city->getTranslation('name', app()->getLocale()) }} {{ __('with Superjet.') }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection" class="reserve px-4">
                                    <i class="fas fa-ticket-alt"></i>
                                    {{ __('Book Now') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if (!empty($trySection['title']) || !empty($trySection['description']) || !empty($trySection['image']))
            <div class="rounded-5 overflow-hidden bg-white shadow-sm p-4 mb-4 border border-light">
                <span class="badge bg-main mb-2 small">{{ __('QUICK BOOK') }}</span>
                @if (!empty($trySection['title']))
                    <h3 class="h5 text-black fw-bold mb-2">{{ $trySection['title'] }}</h3>
                @endif
                @if (!empty($trySection['description']))
                    <p class="text-muted small mb-4">{{ $trySection['description'] }}</p>
                @endif
                @if (!empty($trySection['image']))
                    <img class="img-fluid rounded-4 w-100 shadow-sm" src="{{ asset($trySection['image']) }}" alt="try">
                @endif
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-main rounded-pill w-100 py-2 fw-bold">{{ __('Find a Trip') }}</a>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form.destination-search-form').forEach(function(searchForm) {
        const searchField = searchForm.querySelector('input.destination-search-input[type="search"]');
        const searchIcon = searchForm.querySelector('.search-icon');
        const clearIcon = searchForm.querySelector('.clear-icon');
        if (!searchField || !searchIcon || !clearIcon) {
            return;
        }

        function toggleClearIcon() {
            clearIcon.style.display = searchField.value ? 'block' : 'none';
        }

        toggleClearIcon();

        searchField.addEventListener('input', toggleClearIcon);

        searchIcon.addEventListener('click', function() {
            searchForm.submit();
        });

        clearIcon.addEventListener('click', function() {
            searchField.value = '';
            toggleClearIcon();
            searchField.focus();
        });

        clearIcon.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                searchField.value = '';
                toggleClearIcon();
                searchField.focus();
            }
        });

        searchField.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                searchForm.submit();
            }
        });
    });
});
</script>
@endpush

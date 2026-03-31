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
        padding: 10px 55px 10px 55px; /* تعديل المسافة لزيادة البُعد عن الأيقونات */
        border: 1px solid #ccc;
        border-radius: 30px;
        font-size: 16px;
        outline: none;
        text-align: left;
        direction: ltr;
        box-sizing: border-box;
    }

    /* إخفاء زر المسح الافتراضي للمتصفح */
    .search-wrapper input[type="search"]::-webkit-search-cancel-button {
        -webkit-appearance: none;
        appearance: none;
        display: none;
    }

    .search-wrapper .search-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 20px; /* إبعاد الأيقونة لليسار */
        cursor: pointer;
        font-size: 18px;
        color: #555;
        pointer-events: none;
    }

    .search-wrapper .clear-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 20px; /* إبعاد أيقونة المسح لليمين */
        cursor: pointer;
        font-size: 18px;
        color: #555;
        display: none;
    }

    /* دعم RTL للغة العربية */
    html[dir="rtl"] .search-wrapper input[type="search"] {
        text-align: right;
        direction: rtl;
        padding: 10px 55px 10px 55px; /* عكس المسافات، والاحتفاظ بنفس البُعد */
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
<div class="hero-section-destination">
    <div class="container box-destination">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('destinations') }}" method="GET" class="destination-search-form">
                    <div class="search-wrapper">
                        <input type="search" name="search" class="destination-search-input" placeholder="{{ $heroSection['search-title'] }}" value="{{ old('search', request()->input('search')) }}" autocomplete="off">
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
<div class="popular pt-5 px-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2 class="text-right text-black">
                    {{ __('Explore the Most Popular Destinations ') }}
                </h2>
            </div>
        </div>

        <div class="row" id="cards-container">
            @foreach ($cities as $city)
            <div class="col-md-4 mb-4 px-3">
                <div class='cardSection card text-center rounded-bottom-4 pb-3'>
                    <img class="img-fluid rounded-top-4" src="{{ $city->image }}" alt="blogs" />
                    <div class="cardbody card-body py-2">
                        <div class='cardBody mb-3 d-flex justify-content-between align-items-center'>
                            <p class="m-0 popular-title">{{ $city->getTranslation('name', app()->getLocale()) }}</p>
                        </div>
                        <div class='cardBody d-flex justify-content-between align-items-center'>
                            <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection" class="reserve">
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
<div class="try">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 try-caption">
                <h6>{{ $trySection['title'] }}</h6>
                <p class="m-0">{{ $trySection['description'] }}</p>
            </div>
            <div class="col-md-6">
                <img class="try-img" src="{{ asset($trySection['image']) }}" alt="bus">
            </div>
        </div>
    </div>
</div>
<!-- End try -->
@endsection

@section('mobile-content')
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (app()->getLocale() == 'ar')
                <i class="fas fa-arrow-right fs-18 text-black" role="button" tabindex="0" aria-label="{{ __('Back') }}" onclick="window.history.back()"></i>
            @else
                <i class="fas fa-arrow-left fs-18 text-black" role="button" tabindex="0" aria-label="{{ __('Back') }}" onclick="window.history.back()"></i>
            @endif
            <p class="m-0 fs-25 text-black fw-semibold">{{ __('Destinations') }}</p>
            <div class="invisible" aria-hidden="true"><i class="fas fa-arrow-left fs-18"></i></div>
        </div>

        @php
            $heroBg = !empty($heroSection['image']) ? asset($heroSection['image']) : asset('images/hero-section.png');
        @endphp
        <div class="destinations-mobile-hero mb-3" style="background-image: url('{{ $heroBg }}');">
            <div class="destinations-mobile-hero__inner p-3 d-flex align-items-end" style="min-height: 140px;">
                <form action="{{ route('destinations') }}" method="GET" class="destination-search-form w-100">
                    <div class="search-wrapper">
                        <input type="search" name="search" class="destination-search-input" placeholder="{{ $heroSection['search-title'] }}" value="{{ old('search', request()->input('search')) }}" autocomplete="off">
                        <i class="fa fa-search search-icon" aria-hidden="true"></i>
                        <i class="fa fa-times clear-icon" role="button" tabindex="0" aria-label="{{ __('Clear search') }}"></i>
                    </div>
                </form>
            </div>
        </div>

        <h2 class="h5 text-black mb-3 text-start">
            {{ __('Explore the Most Popular Destinations ') }}
        </h2>

        <div class="row g-3 mb-4">
            @foreach ($cities as $city)
                <div class="col-12">
                    <div class="cardSection card text-center rounded-bottom-4 pb-3">
                        <img class="img-fluid rounded-top-4" src="{{ $city->image }}" alt="{{ $city->getTranslation('name', app()->getLocale()) }}">
                        <div class="cardbody card-body py-2">
                            <div class="cardBody mb-3 d-flex justify-content-between align-items-center">
                                <p class="m-0 popular-title">{{ $city->getTranslation('name', app()->getLocale()) }}</p>
                            </div>
                            <div class="cardBody d-flex justify-content-between align-items-center">
                                <a href="{{ route('home', ['city_to_id' => $city->id]) }}#heroSection" class="reserve">
                                    {{ __('Book Now') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if (!empty($trySection['title']) || !empty($trySection['description']) || !empty($trySection['image']))
            <div class="rounded-4 overflow-hidden bg-light p-3 mb-4">
                @if (!empty($trySection['title']))
                    <h3 class="h6 text-black mb-2">{{ $trySection['title'] }}</h3>
                @endif
                @if (!empty($trySection['description']))
                    <p class="text-muted small mb-3 mb-md-0">{{ $trySection['description'] }}</p>
                @endif
                @if (!empty($trySection['image']))
                    <img class="img-fluid rounded-3 w-100 mt-2" src="{{ asset($trySection['image']) }}" alt="">
                @endif
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

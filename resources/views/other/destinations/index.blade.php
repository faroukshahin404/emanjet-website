@extends('layouts.master')

@push('styles')
<style>
    .hero-section-destination::before {
        background: linear-gradient(to right, #00000040, #00000040), url({{ asset($heroSection['image']) }});
        transform: scale(1);
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
                <form action="{{ route('destinations') }}" method="GET" id="search-form">
                    <div class="search-wrapper">
                        <input type="search" name="search" id="search-field" placeholder="{{ $heroSection['search-title'] }}" value="{{ old('search', request()->input('search')) }}">
                        <i class="fa fa-search search-icon" id="search-icon" aria-label="{{ __('Search') }}"></i>
                        <i class="fa fa-times clear-icon" id="clear-icon" aria-label="{{ __('Clear search') }}"></i>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchField = document.getElementById('search-field');
    const searchIcon = document.getElementById('search-icon');
    const clearIcon = document.getElementById('clear-icon');
    const searchForm = document.getElementById('search-form');
    const isArabic = {{ app()->getLocale() == 'ar' ? 'true' : 'false' }};

    if (isArabic) {
        document.documentElement.setAttribute('dir', 'rtl');
        document.documentElement.setAttribute('lang', 'ar');
    } else {
        document.documentElement.setAttribute('dir', 'ltr');
        document.documentElement.setAttribute('lang', 'en');
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

    searchField.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchForm.submit();
        }
    });
});
</script>
@endpush

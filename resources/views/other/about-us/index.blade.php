@extends('layouts.master')

@php
    /**
     * Map each section key to its display icon (FontAwesome 6) and label.
     */
    $sections = [
        'vision'           => ['label' => __('Our Vision'),          'icon' => 'fa-eye'],
        'mission'          => ['label' => __('Our Mission'),         'icon' => 'fa-bullseye'],
        'values'           => ['label' => __('Our Values'),          'icon' => 'fa-heart'],
        'branches'         => ['label' => __('Eman Jet Branches'),  'icon' => 'fa-map-location-dot'],
        'routes'           => ['label' => __('Eman Jet Airlines'),   'icon' => 'fa-route'],
        'payment_methods'  => ['label' => __('Payment Methods'),     'icon' => 'fa-credit-card'],
        'safety_and_comfort' => ['label' => __('Safety & Comfort'),  'icon' => 'fa-shield-heart'],
    ];

    $filledSections = array_filter(
        $sections,
        fn($key) => !empty($serviceSection[$key]),
        ARRAY_FILTER_USE_KEY
    );

    // If we have dynamic items in serviceSection, we should consider it "filled"
    $hasDynamicItems = !empty($serviceSection['items']);
@endphp

@section('content')

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- HERO SECTION                                            --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <section class="about-hero position-relative">
        {{-- Decorative Glows --}}
        <div class="position-absolute top-0 start-50 translate-middle-x w-100 h-100 overflow-hidden pointer-events-none" style="z-index: 0;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 70% 20%, rgba(var(--main-color-rgb), 0.12), transparent 70%);"></div>
        </div>

        <div class="container py-lg-5 position-relative" style="z-index: 1;">
            <div class="row align-items-center g-5">

                {{-- Text column --}}
                <div class="col-lg-6 about-hero-content wow animate__animated animate__fadeInLeft">
                    <div class="badge-label pulse-animation">
                        <i class="fa-solid fa-plane-departure"></i>
                        {{ $heroSection['pre-title'] ?? __('Who We Are') }}
                    </div>

                    <h1 class="display-4 fw-800 mb-3">
                        {!! str_replace(config('app.name'), '<span class="text-main">' . config('app.name') . '</span>', $heroSection['title'] ?? __('About :brand', ['brand' => __('Eman Jet')])) !!}
                    </h1>

                    @if (!empty($heroSection['description']))
                        <p class="lead opacity-90">{{ $heroSection['description'] }}</p>
                    @endif

                    {{-- Quick stats strip --}}
                    @if(!empty($heroSection['stats']))
                        <div class="about-hero-stats">
                            @foreach($heroSection['stats'] as $index => $stat)
                                <div class="about-stat-item">
                                    <span class="stat-num">{{ $stat['number'] }}</span>
                                    <span class="stat-label">{{ $stat['label'] }}</span>
                                </div>
                                @if(!$loop->last)
                                    <div class="about-hero-stats-divider"></div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="about-hero-stats">
                            <div class="about-stat-item">
                                <span class="stat-num">10+</span>
                                <span class="stat-label">{{ __('Years') }}</span>
                            </div>
                            <div class="about-hero-stats-divider"></div>
                            <div class="about-stat-item">
                                <span class="stat-num">50+</span>
                                <span class="stat-label">{{ __('Routes') }}</span>
                            </div>
                            <div class="about-hero-stats-divider"></div>
                            <div class="about-stat-item">
                                <span class="stat-num">1M+</span>
                                <span class="stat-label">{{ __('Passengers') }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Image column --}}
                @if (!empty($heroSection['image']))
                    <div class="col-lg-6 wow animate__animated animate__fadeInRight">
                        <div class="about-hero-img-wrap">
                            <img
                                src="{{ publicMediaUrl($heroSection['image']) }}"
                                alt="{{ $heroSection['title'] ?? __('About Us') }}"
                                class="shadow-premium"
                            >
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- FEATURE CARDS SECTION                                   --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    @if (!empty($filledSections) || $hasDynamicItems)
        <section class="about-sections-wrap py-5">
            <div class="container py-lg-5">

                {{-- Unified Section heading --}}
                <div class="home-section-head text-center wow animate__animated animate__fadeInUp">
                    <p class="pre-title mb-2" style="color: var(--main-color); letter-spacing: 2px; font-weight: 700;">
                        <i class="fa-solid fa-star me-2"></i>
                        {{ $serviceSection['pre-title'] ?? __('EXPERIENCE EXCELLENCE') }}
                    </p>
                    <h2>{{ $serviceSection['title'] ?? __('Learn More About Us') }}</h2>
                    <div class="section-divider mx-auto"></div>
                    <p class="mt-3 opacity-75">{{ $serviceSection['description'] ?? __('Discover our vision, mission, and values that drive us forward to provide the best travel service in the region.') }}</p>
                </div>

                {{-- Cards grid --}}
                <div class="row g-4 mt-4">
                    @if(!empty($serviceSection['items']))
                        @foreach ($serviceSection['items'] as $index => $item)
                            <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeInUp" data-wow-delay="{{ $index * 0.1 }}s">
                                <div class="feature-card h-100">
                                    <div class="feature-card-icon">
                                        <i class="{{ $item['icon'] ?? 'fa-solid fa-star' }}"></i>
                                    </div>
                                    <h5 class="fw-800">{{ $item['title'] }}</h5>
                                    <p class="fc-text">{{ $item['description'] }}</p>
                                    <button class="fc-read-more-btn" style="display:none;">
                                        <span class="btn-text">{{ __('Read more') }}</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($filledSections as $key => $meta)
                            <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                                <div class="feature-card h-100">
                                    <div class="feature-card-icon">
                                        <i class="fa-solid {{ $meta['icon'] }}"></i>
                                    </div>
                                    <h5 class="fw-800">{{ $meta['label'] }}</h5>
                                    <p class="fc-text">{{ $serviceSection[$key] }}</p>
                                    <button class="fc-read-more-btn" style="display:none;">
                                        <span class="btn-text">{{ __('Read more') }}</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </section>
    @endif

@endsection

@push('scripts')
<script>
/**
 * Feature card read-more toggle.
 * Only shows the button when text actually overflows the 4-line clamp.
 */
$(function () {
    var readMoreLabel  = '{{ __('Read more') }}';
    var readLessLabel  = '{{ __('Read less') }}';

    $('.feature-card').each(function () {
        var $p   = $(this).find('.fc-text');
        var $btn = $(this).find('.fc-read-more-btn');

        // Show toggle button only when natural height exceeds clamped height
        if ($p[0].scrollHeight > $p[0].offsetHeight + 2) {
            $btn.show();
        }

        $btn.on('click', function () {
            var $b = $(this);
            var expanded = $p.hasClass('expanded');

            $p.toggleClass('expanded', !expanded);
            $b.toggleClass('expanded', !expanded);
            $b.find('.btn-text').text(expanded ? readMoreLabel : readLessLabel);
        });
    });
});
</script>
@endpush

@section('mobile-content')
    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- MOBILE: Clean premium card layout                       --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <div class="w-100 py-3">

        {{-- Mobile hero card with refined look --}}
        <div class="text-center mb-4 px-3">
            @if (!empty($heroSection['image']))
                <div class="position-relative mb-4">
                    <img
                        src="{{ publicMediaUrl($heroSection['image'] ?? '') }}"
                        alt="{{ $heroSection['title'] ?? __('About Us') }}"
                        class="img-fluid rounded-5 shadow-lg"
                        style="max-height: 250px; width: 100%; object-fit: cover;"
                    >
                    <div class="position-absolute bottom-0 start-50 translate-middle-x bg-white px-3 py-1 rounded-pill shadow-sm" style="margin-bottom: -15px;">
                        <span class="text-main fw-bold small"><i class="fa-solid fa-star small"></i> {{ __('Since 1990') }}</span>
                    </div>
                </div>
            @endif
            <h1 class="fw-800 fs-3 text-black mb-2">
                {{ $heroSection['title'] ?? __('About Us') }}
            </h1>
            @if (!empty($heroSection['description']))
                <p class="text-muted small mb-0 px-2" style="line-height: 1.6;">{{ $heroSection['description'] }}</p>
            @endif
        </div>

        {{-- Quick stats strip (mobile) - Modernized with better contrast --}}
        @if(!empty($heroSection['stats']))
            <div class="mx-3 d-flex justify-content-around rounded-5 p-4 mb-4"
                 style="background: linear-gradient(135deg, #0b0c10, #1c1d22); box-shadow: 0 15px 30px rgba(0,0,0,0.2);">
                @foreach($heroSection['stats'] as $index => $stat)
                    <div class="text-center">
                        <span class="d-block fw-800 fs-4 text-main">{{ $stat['number'] }}</span>
                        <span class="text-white opacity-75" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">{{ $stat['label'] }}</span>
                    </div>
                    @if(!$loop->last)
                        <div class="vr bg-white opacity-25"></div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="mx-3 d-flex justify-content-around rounded-5 p-4 mb-4"
                 style="background: linear-gradient(135deg, #0b0c10, #1c1d22); box-shadow: 0 15px 30px rgba(0,0,0,0.2);">
                <div class="text-center">
                    <span class="d-block fw-800 fs-4 text-main">10+</span>
                    <span class="text-white opacity-75" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">{{ __('Years') }}</span>
                </div>
                <div class="vr bg-white opacity-25"></div>
                <div class="text-center">
                    <span class="d-block fw-800 fs-4 text-main">50+</span>
                    <span class="text-white opacity-75" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">{{ __('Routes') }}</span>
                </div>
                <div class="vr bg-white opacity-25"></div>
                <div class="text-center">
                    <span class="d-block fw-800 fs-4 text-main">1M+</span>
                    <span class="text-white opacity-75" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">{{ __('Passengers') }}</span>
                </div>
            </div>
        @endif

        {{-- Section cards for mobile --}}
        <div class="px-3">
            @if(!empty($serviceSection['items']))
                @foreach ($serviceSection['items'] as $index => $item)
                    <div class="bg-white rounded-5 shadow-sm p-4 mb-3 border border-light-subtle">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="d-flex align-items-center justify-content-center rounded-4 flex-shrink-0 shadow-sm"
                                 style="width:50px; height:50px; background: rgba(var(--main-color-rgb), 0.1);">
                                <i class="{{ $item['icon'] ?? 'fa-solid fa-star' }} text-main fs-5"></i>
                            </div>
                            <h6 class="fw-800 text-black mb-0" style="font-size: 1.05rem;">{{ $item['title'] }}</h6>
                        </div>
                        <p class="text-muted small mb-0" style="line-height: 1.8; font-size: 0.9rem;">{{ $item['description'] }}</p>
                    </div>
                @endforeach
            @else
                @foreach ($sections as $key => $meta)
                    @if (!empty($serviceSection[$key]))
                        <div class="bg-white rounded-5 shadow-sm p-4 mb-3 border border-light-subtle">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-4 flex-shrink-0 shadow-sm"
                                     style="width:50px; height:50px; background: rgba(var(--main-color-rgb), 0.1);">
                                    <i class="fa-solid {{ $meta['icon'] }} text-main fs-5"></i>
                                </div>
                                <h6 class="fw-800 text-black mb-0" style="font-size: 1.05rem;">{{ $meta['label'] }}</h6>
                            </div>
                            <p class="text-muted small mb-0" style="line-height: 1.8; font-size: 0.9rem;">{{ $serviceSection[$key] }}</p>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        @if (empty($filledSections) && !$hasDynamicItems)
            <div class="text-center py-5">
                <i class="fa-solid fa-circle-info fa-3x text-main mb-3"></i>
                <p class="text-muted">{{ __('No Information Available') }}</p>
            </div>
        @endif
    </div>
@endsection

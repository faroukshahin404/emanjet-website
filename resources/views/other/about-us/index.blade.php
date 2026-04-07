@extends('layouts.master')

@section('content')
    <!-- start about-us caption  -->
    <div class="about-us-caption">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col-md-6 about-us-caption-box">
                    <h2>
                        {{ $heroSection['title'] }}
                    </h2>
                    <p>
                        {{ $heroSection['description'] }}
                    </p>

                </div>
                <div class="col-md-6">

                    <img class="img-fluid" src="{{ publicMediaUrl($heroSection['image'] ?? '') }}" alt="about-page">

                </div>
            </div>
        </div>
    </div>
    <!-- End about-us caption  -->

    <!-- start about-caption-text  -->
    <div class="about-caption-text mt-5">
        <div class="container">
            @php
                $sections = [
                    'vision' => __('Our Vision'),
                    'mission' => __('Our Mission'),
                    'values' => __('Our Values'),
                    'branches' => __('Super Jet branches'),
                    'routes' => __('Superjet Airlines'),
                    'payment_methods' => __('Payment Methods'),
                    'safety_and_comfort' => __('Safety and Comfort'),
                ];
            @endphp

            <div class="row">
                @foreach ($sections as $key => $label)
                    @if (!empty($serviceSection[$key]))
                        <h6>{{ $label }}</h6>
                        <p>{{ $serviceSection[$key] }}</p>
                        <hr>
                    @endif
                @endforeach
            </div>

        </div>
    </div>
    <!-- End  about-caption-text  -->
@endsection

@section('mobile-content')
    {{-- Mobile About Us: Clean card-based layout --}}
    <div class="py-2">
        {{-- Header --}}
        <div class="mb-4 text-center">
            <h1 class="fw-bold fs-4 text-black mb-1">{{ $heroSection['title'] ?? __('About Us') }}</h1>
            @if (!empty($heroSection['description']))
                <p class="text-muted small">{{ $heroSection['description'] }}</p>
            @endif
            @if (!empty($heroSection['image']))
                <img src="{{ publicMediaUrl($heroSection['image'] ?? '') }}" alt="{{ $heroSection['title'] }}"
                    class="img-fluid rounded-4 mt-3 shadow-sm" style="max-height: 200px; object-fit: cover; width: 100%;">
            @endif
        </div>

        {{-- Sections --}}
        @php
            $sections = [
                'vision' => __('Our Vision'),
                'mission' => __('Our Mission'),
                'values' => __('Our Values'),
                'branches' => __('Super Jet branches'),
                'routes' => __('Superjet Airlines'),
                'payment_methods' => __('Payment Methods'),
                'safety_and_comfort' => __('Safety and Comfort'),
            ];
        @endphp

        @foreach ($sections as $key => $label)
            @if (!empty($serviceSection[$key]))
                <div class="bg-white rounded-4 shadow-sm p-4 mb-3 border border-light-subtle">
                    <h6 class="fw-bold text-main mb-2">
                        <i class="fas fa-circle-dot me-2 small"></i>{{ $label }}
                    </h6>
                    <p class="text-muted small mb-0">{{ $serviceSection[$key] }}</p>
                </div>
            @endif
        @endforeach

        @if (collect($serviceSection)->filter()->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-info-circle fa-3x text-main mb-3"></i>
                <p class="text-muted">{{ __('About Us') }}</p>
            </div>
        @endif
    </div>
@endsection

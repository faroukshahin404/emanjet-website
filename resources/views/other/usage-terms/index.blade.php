@extends('layouts.master')

@section('content')
    <section class="policy-header text-center">
        <div class="glow"></div>
        <div class="container position-relative" style="z-index: 1;">
            <p class="text-main fw-bold text-uppercase mb-2 wow animate__animated animate__fadeInUp" style="letter-spacing: 2px; font-size: 14px;">
                {{ __('Official Guidelines') }}
            </p>
            <h1 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.1s">
                {{ $heroSection['title'] }}
            </h1>
        </div>
    </section>

    <div class="container pb-5">
        <div class="policy-card wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
            <div class="policy-content">
                {!! $heroSection['description'] !!}
            </div>
        </div>
    </div>
@endsection

@section('mobile-content')
    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" 
             style="width: 40px; height: 40px;" onclick="window.history.back()">
            <i class="fas fa-arrow-right fs-18 text-black"></i>
        </div>
        <h1 class="m-0 fs-4 fw-800 text-black">{{ $heroSection['title'] }}</h1>
    </div>

    <div class="bg-white rounded-5 shadow-sm p-4 border border-light-subtle">
        <div class="policy-content" style="font-size: 0.95rem; line-height: 1.8;">
            {!! $heroSection['description'] !!}
        </div>
    </div>
@endsection

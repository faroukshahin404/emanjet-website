@extends('layouts.master')

@section('content')
    <div class="about-us-caption">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col about-us-caption-box">
                    <h2>
                        {{ $heroSection['title'] }}
                    </h2>
                    <p>
                        {{ $heroSection['description'] }}
                    </p>

                </div>
              
            </div>
        </div>
    </div>
@endsection
@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <i class="fas fa-arrow-right fs-18 text-black" onclick="window.history.back()"></i>

        <p class="m-0 fs-25 text-black">{{ $heroSection['title'] }}</p>
        <div></div>
    </div>

    <div class="mt-3">
        {!! $heroSection['description'] !!}

    </div>
@endsection

@extends('layouts.master')

@section('content')
    <div class="about-us-caption">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col about-us-caption-box">
                    <h2>
                        {{ $heroSection['title'] }}
                    </h2>
                    <p>
                        {{ $heroSection['description'] }}
                    </p>

                </div>
              
            </div>
        </div>
    </div>
@endsection
@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <i class="fas fa-arrow-right fs-18 text-black" onclick="window.history.back()"></i>

        <p class="m-0 fs-25 text-black">{{ $heroSection['title'] }}</p>
        <div></div>
    </div>

    <div class="mt-3">
        {!! $heroSection['description'] !!}

    </div>
@endsection
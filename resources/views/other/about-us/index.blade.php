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
                    <img class="img-fluid" src="{{ $heroSection['image'] }}" alt="about-page">
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
                    'vision' => 'رؤيتنا',
                    'mission' => 'مهمتنا',
                    'values' => 'قيمنا',
                    'branches' => 'فروع سوبر جيت',
                    'routes' => 'خطوط سوبر جيت',
                    'payment_methods' => 'طرق الدفع',
                    'safety_and_comfort' => 'رفاهية وأمان',
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

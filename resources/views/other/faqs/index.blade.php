@extends('layouts.master')

@section('content')
    <!-- start about-us caption  -->
    <div class="questions contact-us mb-5">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col-md-6 text-center pt-5">
                    <h2>
                        {{ $heroSection['title'] ?? __('FAQs') }}
                    </h2>
                    <p>
                        {{ $heroSection['description'] ?? __('FAQs default hero description') }}
                    </p>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ $heroSection['image'] }}" alt="{{ __('FAQs hero image alt') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 need-help mt-5">
                    <h2 class="text-center mb-5">
                        {{ __('FAQs') }}
                    </h2>
                    <div class="accordion" id="accordionExample">
                        <div class="row">

                            @if ($faqs->isNotEmpty())
                                <div class="row" id="accordionExample">
                                    @foreach ($faqs as $faq)
                                        <div class="col-md-6 mb-3">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading_{{ $faq->id }}">
                                                    <button class="accordion-button " type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse_{{ $faq->id }}" aria-expanded="false"
                                                        aria-controls="collapse_{{ $faq->id }}">
                                                        {{ $faq->translated_question }}
                                                        <span class="icon ms-2">
                                                            <i class="fa fa-plus"></i>
                                                        </span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_{{ $faq->id }}" class="accordion-collapse collapse "
                                                    aria-labelledby="heading_{{ $faq->id }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        {{ $faq->translated_answer }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End about-us caption  -->
@endsection

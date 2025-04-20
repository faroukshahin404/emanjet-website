@extends('layouts.master')

@section('content')
    <!-- start about-us caption  -->
    <div class="questions contact-us mb-5">
        <div class="container-fluid">
            <div class="row rounded-bottom-4 box-shadow">
                <div class="col-md-6 text-center pt-5">
                    <h2>
                        {{ $heroSection['title'] ?? 'الاسئلة الشائعة' }}
                    </h2>
                    <p>
                        {{ $heroSection['description'] ?? 'تجد هنا اجوبة عن جميع استفساراتك حول خدماتنا ووجهاتنا. نحن هنا لمساعدتك في كل ما تحتاجه.' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ $heroSection['image'] }}" alt="about-page">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 need-help mt-5">
                    <h2 class="text-center mb-5">
                        الاسئلة الشائعة
                    </h2>
                    <div class="accordion" id="accordionExample">
                        <div class="row">

                            @if (!empty($faqsList['faqs']) && is_array($faqsList['faqs']))
                                <div class="row" id="accordionExample">
                                    @foreach ($faqsList['faqs'] as $faq)
                                        <div class="col-md-6 mb-3">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading_{{ $loop->index }}">
                                                    <button class="accordion-button " type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse_{{ $loop->index }}" aria-expanded="false"
                                                        aria-controls="collapse_{{ $loop->index }}">
                                                        {{ $faq['question'] }}
                                                        <span class="icon ms-2">
                                                            <i class="fa fa-plus"></i>
                                                        </span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_{{ $loop->index }}" class="accordion-collapse collapse "
                                                    aria-labelledby="heading_{{ $loop->index }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        {{ $faq['answer'] }}
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

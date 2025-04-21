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
                    <img class="img-fluid rounded-bottom-4" src="{{ $heroSection['image'] }}" alt="about-page">
                </div>
            </div>
        </div>
    </div>
    <!-- End about-us caption  -->

    <!-- Start Blogs Tabs -->
    <div class="blogs-taps pt-5 px-5">
        <div class="container-fluid">
            <div class="row">
                <h2 class="text-center">حكايتنا</h2>

                <ul class="nav nav-pills d-flex justify-content-center flex-wrap align-items-center mb-3" id="blogTabs">
                    @foreach ($blogsCategories as $index => $category)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab{{ $index + 1 }}"
                                data-bs-toggle="tab" href="#content{{ $index + 1 }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach ($blogsCategories as $index => $category)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="content{{ $index + 1 }}">
                            <div class="row">
                                @forelse ($category->blogs as $blog)
                                    <div class="col-md-4 mb-4 px-3 px-1">
                                        <div class="cardSection card text-center rounded-bottom-4">
                                            <img class="img-fluid rounded-top-4" src="{{ $blog->image }}" alt="blogs" />
                                            <div class="cardbody card-body py-2">
                                                <h5>{{ $blog->title }}</h5>
                                                <div class="cardBody">
                                                    <p>

                                                        {{ $blog->created_at->format('F d, Y') }} -
                                                        <i class="fa fa-clock"></i> {{ $blog->reading_time }} min read -
                                                        <i class="fa fa-eye"></i> {{ $blog->views }} -
                                                        <i class="fa fa-thumbs-up"></i> {{ $blog->likes }}
                                                    </p>

                                                    <h6>
                                                        {{ \Str::limit(strip_tags($blog->content), 100) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-3">
                                        <p>لا توجد مقالات في هذا التصنيف.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <!-- End Blogs Tabs -->

    <!-- start trip start here -->
    @php
        $tripStart = $tripStartSection; // المتغير اللي جاي من الكنترولر
    @endphp

    <div class="trip-start my-5 py-5">
        <div class="container">
            <div class="row">
                <!-- الصور -->
                <div class="col-md-6">
                    <div class="d-flex justify-content-center align-items-end gap-1 flex-lg-row flex-column">
                        <img class="img-1" src="{{ $tripStart['images'][0] ?? '' }}" alt="trip">
                        <img class="img-2" src="{{ $tripStart['images'][1] ?? '' }}" alt="trip">
                    </div>
                    <div class="d-flex justify-content-center align-items-start gap-1 mt-1 flex-lg-row flex-column">
                        <img class="img-3" src="{{ $tripStart['images'][2] ?? '' }}" alt="trip">
                        <img class="img-4" src="{{ $tripStart['images'][3] ?? '' }}" alt="trip">
                        <img class="img-5" src="{{ $tripStart['images'][4] ?? '' }}" alt="trip">
                    </div>
                </div>

                <!-- النصوص -->
                <div class="col-md-6 trip-start-caption pt-3">
                    <h2>{{ $tripStart['title'] ?? 'رحلاتك تبدأ هنا' }}</h2>
                    <p>{{ $tripStart['description'] ?? '' }}</p>

                    <button>
                        {{ $tripStart['button-text'] ?? 'ابحث عن رحلتك' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- End trip start here -->
@endsection

@extends('layouts.master')

@section('content')
    <!-- start Blogs Hero  -->
    <div class="hero-section-destination d-flex align-items-center justify-content-center" style="height: 450px;">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="text-white fw-bold mb-4 display-4">{{ $heroSection['title'] }}</h1>
                    <p class="text-white-50 mb-0 fs-5">{{ $heroSection['description'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blogs Hero  -->

    <!-- Start Blogs Tabs -->
    <div class="blogs-taps py-5">
        <div class="container">
            <div class="row">
                <div class="text-center mb-5">
                    <span class="text-main fw-bold text-uppercase letter-spacing-1 small d-block mb-2">{{ __('OUR STORIES') }}</span>
                    <h2 class="text-black fw-bold display-6">{{ __('Latest Travel News') }}</h2>
                </div>

                <ul class="nav nav-pills d-flex justify-content-center flex-wrap align-items-center mb-5" id="blogTabs">
                    @foreach ($blogsCategories as $index => $category)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab{{ $index + 1 }}"
                                data-bs-toggle="tab" href="#content{{ $index + 1 }}">
                                {{ $category->translated_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach ($blogsCategories as $index => $category)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="content{{ $index + 1 }}">
                            <div class="row g-4">
                                @forelse ($category->blogs as $blog)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="cardSection card border-0">
                                            <div class="destination-badge">
                                                <i class="fa fa-newspaper-o me-1"></i>
                                                {{ __('NEWS') }}
                                            </div>
                                            <img class="img-fluid" src="{{ $blog->image }}"
                                                alt="{{ $blog->translated_title }}" />
                                            <div class="cardbody card-body">
                                                <div class="d-flex gap-3 mb-3">
                                                    <span class="blog-meta-item"><i class="fa fa-calendar-o"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                                                    <span class="blog-meta-item"><i class="fa fa-clock-o"></i> {{ $blog->reading_time }} {{ __('min') }}</span>
                                                </div>
                                                <h3 class="popular-title mb-3">{{ $blog->translated_title }}</h3>
                                                <div class="blog-card-content">
                                                    {{ \Str::limit(strip_tags($blog->translated_content), 120) }}
                                                </div>
                                                <a href="#" class="reserve justify-content-between px-4">
                                                    {{ __('Read Article') }}
                                                    <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-5">
                                        <div class="bg-light p-5 rounded-5 mt-3">
                                            <i class="fa fa-newspaper-o fa-3x text-muted mb-3"></i>
                                            <p class="text-muted fs-5">{{ __('No blogs available in this category yet.') }}</p>
                                        </div>
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
        $tripStart = $tripStartSection; // from controller
    @endphp

    <div class="trip-start py-5 my-5 bg-light rounded-5 mx-4">
        <div class="container p-4">
            <div class="row align-items-center">
                <!-- Images Grid -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="row g-2">
                        <div class="col-6">
                            <img class="img-fluid rounded-4 shadow-sm w-100 mb-2" src="{{asset($tripStart['images'][0]) ?? '' }}" alt="trip" style="height: 200px; object-fit: cover;">
                            <img class="img-fluid rounded-4 shadow-sm w-100" src="{{ asset($tripStart['images'][2]) ?? '' }}" alt="trip" style="height: 140px; object-fit: cover;">
                        </div>
                        <div class="col-6">
                            <img class="img-fluid rounded-4 shadow-sm w-100 mb-2" src="{{ asset($tripStart['images'][1]) ?? '' }}" alt="trip" style="height: 140px; object-fit: cover;">
                            <img class="img-fluid rounded-4 shadow-sm w-100" src="{{ asset($tripStart['images'][3]) ?? '' }}" alt="trip" style="height: 200px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <!-- Copy -->
                <div class="col-lg-6 trip-start-caption ps-lg-5">
                    <span class="badge bg-main mb-3">{{ __('JOIN US') }}</span>
                    <h2 class="display-5 fw-bold text-black mb-4">{{ $tripStart['title'] ?? __('Your journeys start here') }}</h2>
                    <p class="text-muted fs-5 mb-5">{{ $tripStart['description'] ?? '' }}</p>

                    <button class="btn btn-main btn-lg px-5 py-3 rounded-pill fw-bold" onclick="window.location.href='{{ route('home') }}'">
                        {{ $tripStart['button-text'] ?? __('Search for your trip') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End trip start here -->

    <!-- End trip start here -->
@endsection

@section('mobile-content')
    <div class="py-2">
        {{-- Header --}}
        <div class="mb-4 text-center py-4 bg-light rounded-5 mx-2">
            <span class="text-main fw-bold text-uppercase small d-block mb-2">{{ __('OUR STORIES') }}</span>
            <h1 class="fw-bold fs-3 text-black mb-2">{{ $heroSection['title'] ?? __('Travel Blog') }}</h1>
            @if (!empty($heroSection['description']))
                <p class="text-muted small px-4">{{ $heroSection['description'] }}</p>
            @endif
        </div>

        {{-- Blog Category Tabs --}}
        @if ($blogsCategories->isNotEmpty())
            <div class="mb-4 px-2">
                <div class="d-flex gap-2 overflow-auto pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>.overflow-auto::-webkit-scrollbar { display: none; }</style>
                    @foreach ($blogsCategories as $index => $category)
                        <button
                            class="btn btn-sm rounded-pill fw-bold px-4 py-2 flex-shrink-0 mo-blog-cat-btn {{ $index === 0 ? 'btn-main text-white shadow-sm' : 'btn-white border' }}"
                            data-target="cat-{{ $index }}"
                            onclick="switchBlogCat(this, 'cat-{{ $index }}')">
                            {{ $category->translated_name }}
                        </button>
                    @endforeach
                </div>
            </div>

            @foreach ($blogsCategories as $index => $category)
                <div id="cat-{{ $index }}" class="mo-blog-cat-pane px-2 {{ $index !== 0 ? 'd-none' : '' }}">
                    @forelse ($category->blogs as $blog)
                        <div class="cardSection card border-0 mb-4">
                            <div class="destination-badge">
                                <i class="fas fa-chart-line me-1"></i>
                                {{ __('Most Visited') }}
                            </div>
                            @if ($blog->image)
                                <img src="{{ $blog->image }}" alt="{{ $blog->translated_title }}"
                                    class="img-fluid" style="height: 200px;">
                            @endif
                            <div class="cardbody card-body">
                                <div class="d-flex gap-3 mb-2">
                                    <span class="blog-meta-item"><i class="fa fa-calendar-o"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                                    <span class="blog-meta-item"><i class="fa fa-clock-o"></i> {{ $blog->reading_time }} {{ __('min') }}</span>
                                </div>
                                <h3 class="popular-title m-0 fs-5 mb-3">{{ $blog->translated_title }}</h3>
                                <p class="text-muted small mb-4">
                                    {{ Str::limit(strip_tags($blog->translated_content), 100) }}
                                </p>
                                <a href="#" class="reserve px-4">
                                    {{ __('Read More') }}
                                    <i class="fas fa-arrow-right ms-2 focus-icon"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 bg-white rounded-5 border border-light">
                            <i class="fa fa-newspaper-o fa-2x text-muted mb-3"></i>
                            <p class="text-muted small mb-0">{{ __('No blogs available in this category yet.') }}</p>
                        </div>
                    @endforelse
                </div>
            @endforeach
        @else
            <div class="text-center py-5 px-4">
                <div class="bg-light p-5 rounded-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">{{ __('No blogs available yet. Please check back later.') }}</p>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function switchBlogCat(btn, targetId) {
            // Hide all panes
            document.querySelectorAll('.mo-blog-cat-pane').forEach(p => p.classList.add('d-none'));
            // Reset all buttons
            document.querySelectorAll('.mo-blog-cat-btn').forEach(b => {
                b.classList.remove('btn-main', 'text-white');
                b.classList.add('btn-light');
            });
            // Show target and activate button
            document.getElementById(targetId)?.classList.remove('d-none');
            btn.classList.add('btn-main', 'text-white');
            btn.classList.remove('btn-light');
        }
    </script>
@endpush

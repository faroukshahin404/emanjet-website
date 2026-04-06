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
                    <img class="img-fluid rounded-bottom-4" src="{{ asset($heroSection['image']) }}" alt="about-page">
                </div>
            </div>
        </div>
    </div>
    <!-- End about-us caption  -->

    <!-- Start Blogs Tabs -->
    <div class="blogs-taps pt-5 px-5">
        <div class="container-fluid">
            <div class="row">
                <h2 class="text-center">{{ __('Our Story') }}</h2>

                <ul class="nav nav-pills d-flex justify-content-center flex-wrap align-items-center mb-3" id="blogTabs">
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
                            <div class="row">
                                @forelse ($category->blogs as $blog)
                                    <div class="col-md-4 mb-4 px-3 px-1">
                                        <div class="cardSection card text-center rounded-bottom-4">
                                            <img class="img-fluid rounded-top-4" src="{{ $blog->image }}"
                                                alt="blogs" />
                                            <div class="cardbody card-body py-2">
                                                <h5>{{ $blog->translated_title }}</h5>
                                                <div class="cardBody">
                                                    <p>

                                                        {{ $blog->created_at->format('F d, Y') }} -
                                                        <i class="fa fa-clock"></i> {{ $blog->reading_time }} min read -
                                                        <i class="fa fa-eye"></i> {{ $blog->views }} -
                                                        <i class="fa fa-thumbs-up"></i> {{ $blog->likes }}
                                                    </p>

                                                    <h6>
                                                        {{ \Str::limit(strip_tags($blog->translated_content), 100) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-3">
                                        <p>{{ __('No blogs available in this category yet. Please check back later.') }}
                                        </p>
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
                        <img class="img-1" src="{{asset($tripStart['images'][0]) ?? '' }}" alt="trip">
                        <img class="img-2" src="{{ asset($tripStart['images'][1]) ?? '' }}" alt="trip">
                    </div>
                    <div class="d-flex justify-content-center align-items-start gap-1 mt-1 flex-lg-row flex-column">
                        <img class="img-3" src="{{ asset($tripStart['images'][2]) ?? '' }}" alt="trip">
                        <img class="img-4" src="{{ asset($tripStart['images'][3]) ?? '' }}" alt="trip">
                        <img class="img-5" src="{{ asset($tripStart['images'][4]) ?? '' }}" alt="trip">
                    </div>
                </div>

                <!-- النصوص -->
                <div class="col-md-6 trip-start-caption pt-3">
                    <h2>{{ $tripStart['title'] ?? 'رحلاتك تبدأ هنا' }}</h2>
                    <p>{{ $tripStart['description'] ?? '' }}</p>

                    <button onclick="window.location.href='{{ route('home') }}'">
                        {{ $tripStart['button-text'] ?? 'ابحث عن رحلتك' }}
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- End trip start here -->
@endsection

@section('mobile-content')
    {{-- Mobile Blogs: Clean categorized list --}}
    <div class="py-2">
        {{-- Header --}}
        <div class="mb-4 text-center">
            <h1 class="fw-bold fs-4 text-black mb-1">{{ $heroSection['title'] ?? __('Bus Blogs') }}</h1>
            @if (!empty($heroSection['description']))
                <p class="text-muted small">{{ $heroSection['description'] }}</p>
            @endif
        </div>

        {{-- Blog Category Tabs --}}
        @if ($blogsCategories->isNotEmpty())
            <div class="mb-3">
                <div class="d-flex gap-2 overflow-auto pb-2" style="scrollbar-width: none;">
                    @foreach ($blogsCategories as $index => $category)
                        <button
                            class="btn btn-sm rounded-pill fw-bold px-3 flex-shrink-0 mo-blog-cat-btn {{ $index === 0 ? 'btn-main text-white' : 'btn-light' }}"
                            data-target="cat-{{ $index }}"
                            onclick="switchBlogCat(this, 'cat-{{ $index }}')">
                            {{ $category->translated_name }}
                        </button>
                    @endforeach
                </div>
            </div>

            @foreach ($blogsCategories as $index => $category)
                <div id="cat-{{ $index }}" class="mo-blog-cat-pane {{ $index !== 0 ? 'd-none' : '' }}">
                    @forelse ($category->blogs as $blog)
                        <div class="bg-white rounded-4 shadow-sm overflow-hidden mb-3 border border-light-subtle">
                            @if ($blog->image)
                                <img src="{{ $blog->image }}" alt="{{ $blog->translated_title }}"
                                    class="w-100 object-fit-cover" style="height: 160px;">
                            @endif
                            <div class="p-3">
                                <h6 class="fw-bold text-black mb-1">{{ $blog->translated_title }}</h6>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-clock me-1"></i>{{ $blog->reading_time }} {{ __('Minutes') }}
                                    &nbsp;&middot;&nbsp;
                                    <i class="fas fa-eye me-1"></i>{{ $blog->views }}
                                </p>
                                <p class="text-muted small mb-0">
                                    {{ Str::limit(strip_tags($blog->translated_content), 120) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">
                            {{ __('No blogs available in this category yet. Please check back later.') }}
                        </div>
                    @endforelse
                </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-main mb-3"></i>
                <p class="text-muted">{{ __('No blogs available in this category yet. Please check back later.') }}</p>
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

@extends('layouts.master')

@push('styles')
<style>
    /* Blogs specific premium tweaks */
    .blog-hero {
        padding-top: 100px;
        background: #fff;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(var(--main-color-rgb), 0.1);
    }
    
    .blog-hero::before {
        content: '';
        position: absolute;
        top: 0;
        inset-inline-end: 0;
        width: 45%;
        height: 100%;
        background: linear-gradient(135deg, rgba(var(--main-color-rgb), 0.08), rgba(var(--main-color-rgb), 0.03));
        pointer-events: none;
        border-radius: 0 0 0 80px;
    }

    .blog-hero-content {
        padding: 4rem 0;
    }

    .blog-hero-img-wrap {
        position: relative;
        height: 400px;
    }

    .blog-hero-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 32px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
        position: relative;
        z-index: 1;
    }

    /* Premium Tabs */
    .premium-tabs {
        border-bottom: none;
        gap: 12px;
    }

    .premium-tabs .nav-link {
        border: 1px solid #eee !important;
        border-radius: 50px !important;
        padding: 10px 25px !important;
        color: #666 !important;
        font-weight: 700 !important;
        transition: all 0.3s ease !important;
        background: #fff !important;
    }

    .premium-tabs .nav-link.active {
        background: var(--main-color) !important;
        color: #fff !important;
        border-color: var(--main-color) !important;
        box-shadow: 0 8px 20px rgba(var(--main-color-rgb), 0.2) !important;
    }

    .premium-tabs .nav-link:hover:not(.active) {
        border-color: var(--main-color) !important;
        color: var(--main-color) !important;
        background: rgba(var(--main-color-rgb), 0.05) !important;
    }

    /* Blog Premium Card */
    .blog-premium-card {
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        position: relative;
    }

    .blog-card-img-box {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .blog-card-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .blog-premium-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.12);
        border-color: transparent;
    }

    .blog-premium-card:hover .blog-card-img-box img {
        transform: scale(1.1);
    }

    .blog-meta-strip {
        display: flex;
        gap: 15px;
        margin-bottom: 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--main-color);
        opacity: 0.8;
    }

    .blog-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .blog-premium-body {
        padding: 1.75rem;
    }

    .blog-premium-title {
        font-weight: 800;
        font-size: 1.25rem;
        line-height: 1.4;
        margin-bottom: 1rem;
        color: #111;
        transition: color 0.3s ease;
    }

    .blog-premium-card:hover .blog-premium-title {
        color: var(--main-color);
    }

    .blog-premium-card .reserve {
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    /* Mobile specific */
    .mo-blog-pill {
        white-space: nowrap;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #eee;
        background: #fff;
        color: #666;
    }

    .mo-blog-pill.active {
        background: var(--main-color);
        color: #fff;
        border-color: var(--main-color);
    }
</style>
@endpush

@section('content')
    {{-- Hero Section --}}
    <section class="blog-hero">
        <div class="position-absolute top-0 start-50 translate-middle-x w-100 h-100 overflow-hidden pointer-events-none" style="z-index: 0;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 70% 20%, rgba(var(--main-color-rgb), 0.12), transparent 70%);"></div>
        </div>

        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 blog-hero-content wow animate__animated animate__fadeInLeft">
                    <div class="badge-label pulse-animation" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(var(--main-color-rgb), 0.12); color: #8a6200; border: 1px solid rgba(var(--main-color-rgb), 0.35); border-radius: 50px; padding: 6px 18px; font-size: 13px; font-weight: 700; margin-bottom: 1.5rem;">
                        <i class="fa-solid fa-feather-pointed"></i>
                        {{ __('OUR STORIES') }}
                    </div>
                    
                    <h1 class="display-4 fw-800 mb-3" style="font-weight: 800; line-height: 1.15; color: #111;">
                        {{ $heroSection['title'] ?? __('Latest Travel News') }}
                    </h1>
                    
                    <p class="lead opacity-90 text-muted" style="line-height: 1.8; max-width: 540px;">
                        {{ $heroSection['description'] ?? __('Discover inspiring travel stories, tips, and the latest updates from our routes.') }}
                    </p>
                </div>

                <div class="col-lg-6 wow animate__animated animate__fadeInRight">
                    <div class="blog-hero-img-wrap">
                        <img src="{{ (isset($heroSection['image']) && !empty($heroSection['image']) && !str_contains($heroSection['image'], 'placehold.co')) ? $heroSection['image'] : asset('images/hero-section.png') }}" alt="{{ $heroSection['title'] ?? __('Blog') }}" class="shadow-premium">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Blogs Main Section --}}
    <section class="py-5 bg-light" style="padding: 100px 0;">
        <div class="container">
            {{-- Category Filter --}}
            <div class="row mb-5 wow animate__animated animate__fadeInUp">
                <div class="col-12">
                    <ul class="nav nav-pills d-flex justify-content-center premium-tabs" id="blogTabs" role="tablist">
                        @foreach ($blogsCategories as $index => $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $index == 0 ? 'active' : '' }}" 
                                        id="tab{{ $index + 1 }}"
                                        data-bs-toggle="pill" 
                                        data-bs-target="#content{{ $index + 1 }}" 
                                        type="button" role="tab">
                                    {{ $category->translated_name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Tabs Content --}}
            <div class="tab-content" id="blogTabsContent">
                @foreach ($blogsCategories as $index => $category)
                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="content{{ $index + 1 }}" role="tabpanel">
                        <div class="row g-4">
                            @forelse ($category->blogs as $blog)
                                <div class="col-lg-4 col-md-6 wow animate__animated animate__fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                                    <div class="blog-premium-card">
                                        <div class="blog-card-img-box">
                                            <img src="{{ $blog->image }}" alt="{{ $blog->translated_title }}">
                                        </div>
                                        <div class="blog-premium-body">
                                            <div class="blog-meta-strip">
                                                <div class="blog-meta-item">
                                                    <i class="fa-solid fa-calendar-alt"></i>
                                                    {{ $blog->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="blog-meta-item">
                                                    <i class="fa-solid fa-clock"></i>
                                                    {{ $blog->reading_time }} {{ __('min read') }}
                                                </div>
                                            </div>
                                            <h3 class="blog-premium-title">{{ $blog->translated_title }}</h3>
                                            <p class="text-muted small mb-4">
                                                {{ \Str::limit(strip_tags($blog->translated_content), 120) }}
                                            </p>
                                            <a href="#" class="reserve justify-content-between px-4">
                                                {{ __('Read More') }}
                                                <i class="fa-solid fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <div class="bg-white p-5 rounded-5 border border-light-subtle shadow-sm">
                                        <i class="fa-solid fa-newspaper fa-3x text-muted mb-3 opacity-50"></i>
                                        <p class="text-muted fs-5">{{ __('No stories available in this category yet.') }}</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Trip Start CTA --}}
    <section class="py-5 my-5">
        <div class="container">
            <div class="rounded-5 overflow-hidden position-relative p-5 shadow-premium" 
                 style="background: #fff; border: 1px solid #f0f0f0;">
                
                <div class="row align-items-center">
                    {{-- Images Grid --}}
                    <div class="col-lg-6 mb-5 mb-lg-0 wow animate__animated animate__fadeInLeft">
                        <div class="row g-3">
                            <div class="col-6">
                                <img class="img-fluid rounded-4 shadow-sm w-100 mb-3" src="{{ asset($tripStartSection['images'][0] ?? '') }}" alt="trip" style="height: 200px; object-fit: cover; transform: rotate(-2deg);">
                                <img class="img-fluid rounded-4 shadow-sm w-100" src="{{ asset($tripStartSection['images'][2] ?? '') }}" alt="trip" style="height: 140px; object-fit: cover; transform: rotate(1deg);">
                            </div>
                            <div class="col-6">
                                <img class="img-fluid rounded-4 shadow-sm w-100 mb-3" src="{{ asset($tripStartSection['images'][1] ?? '') }}" alt="trip" style="height: 140px; object-fit: cover; transform: rotate(2deg);">
                                <img class="img-fluid rounded-4 shadow-sm w-100" src="{{ asset($tripStartSection['images'][3] ?? '') }}" alt="trip" style="height: 200px; object-fit: cover; transform: rotate(-1deg);">
                            </div>
                        </div>
                    </div>

                    {{-- Copy --}}
                    <div class="col-lg-6 ps-lg-5 wow animate__animated animate__fadeInRight">
                        <div class="badge bg-main-subtle text-main mb-3 px-3 py-2 rounded-pill fw-bold">{{ __('JOIN US') }}</div>
                        <h2 class="display-5 fw-800 text-black mb-4">{{ $tripStartSection['title'] ?? __('Your journeys start here') }}</h2>
                        <p class="text-muted fs-5 mb-5">{{ $tripStartSection['description'] ?? '' }}</p>

                        <a href="{{ route('home') }}" class="btn btn-main btn-lg px-5 py-3 rounded-pill fw-bold shadow-premium">
                            {{ $tripStartSection['button-text'] ?? __('Search for your trip') }}
                            <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('mobile-content')
    <div class="w-100 py-3">
        {{-- Mobile Header --}}
        <div class="d-flex align-items-center gap-3 mb-4 wow animate__animated animate__fadeIn">
            <button onclick="window.history.back()" class="btn btn-outline-light border-0 text-black p-0">
                <i class="fa-solid fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} fs-4"></i>
            </button>
            <h1 class="fw-800 fs-3 mb-0">{{ __('Latest News') }}</h1>
        </div>

        {{-- Mobile Category Filter --}}
        <div class="mb-4 px-1 wow animate__animated animate__fadeInUp">
            <div class="d-flex gap-2 overflow-auto pb-2 no-scrollbar" style="scrollbar-width: none;">
                @foreach ($blogsCategories as $index => $category)
                    <button class="mo-blog-pill shadow-xs {{ $index === 0 ? 'active' : '' }}"
                            onclick="switchBlogCat(this, 'mo-cat-{{ $index }}')">
                        {{ $category->translated_name }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Blog Panes for Mobile --}}
        @foreach ($blogsCategories as $index => $category)
            <div id="mo-cat-{{ $index }}" class="mo-blog-pane {{ $index !== 0 ? 'd-none' : '' }}">
                @forelse ($category->blogs as $blog)
                    <div class="bg-white rounded-5 shadow-sm p-3 mb-4 border border-light-subtle wow animate__animated animate__fadeInUp" data-wow-delay="{{ $loop->index * 0.05 }}s">
                        <div class="rounded-5 overflow-hidden mb-3" style="height: 180px;">
                            <img src="{{ $blog->image }}" alt="{{ $blog->translated_title }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="d-flex gap-3 mb-2 opacity-75" style="font-size: 0.75rem; font-weight: 700; color: var(--main-color);">
                            <span><i class="fa-solid fa-calendar-alt small me-1"></i> {{ $blog->created_at->format('d M') }}</span>
                            <span><i class="fa-solid fa-clock small me-1"></i> {{ $blog->reading_time }} {{ __('min') }}</span>
                        </div>
                        <h6 class="fw-800 text-black mb-2 line-clamp-2">{{ $blog->translated_title }}</h6>
                        <p class="text-muted small mb-3 line-clamp-2" style="font-size: 0.8rem;">
                            {{ Str::limit(strip_tags($blog->translated_content), 80) }}
                        </p>
                        <a href="#" class="text-main fw-bold small text-decoration-none">
                            {{ __('Read Story') }} <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} ms-1" style="font-size: 8px;"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-5 bg-white rounded-5 border border-light-subtle shadow-xs">
                        <i class="fa-solid fa-newspaper fa-2x text-muted mb-3 opacity-50"></i>
                        <p class="text-muted small">{{ __('No stories in this category.') }}</p>
                    </div>
                @endforelse
            </div>
        @endforeach

        {{-- Mobile Trip Start CTA --}}
        <div class="mt-4 mb-4 wow animate__animated animate__fadeInUp">
            <div class="rounded-5 p-4 text-center border border-light-subtle bg-white shadow-sm">
                <span class="badge bg-main-subtle text-main mb-2 small">{{ __('JOIN US') }}</span>
                <h4 class="fw-800 text-black mb-2">{{ $tripStartSection['title'] ?? __('Ready to travel?') }}</h4>
                <div class="mt-3 mb-4">
                    <div class="row g-2">
                        @foreach(array_slice($tripStartSection['images'] ?? [], 0, 2) as $img)
                            <div class="col-6">
                                <img src="{{ asset($img) }}" class="img-fluid rounded-4 shadow-xs" style="height: 80px; width: 100%; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('home') }}" class="btn btn-main rounded-pill w-100 py-2 fw-bold">{{ __('Find a Trip') }}</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function switchBlogCat(btn, targetId) {
            // Hide all mobile panes
            document.querySelectorAll('.mo-blog-pane').forEach(p => p.classList.add('d-none'));
            // Reset all mobile pills
            document.querySelectorAll('.mo-blog-pill').forEach(b => b.classList.remove('active'));
            
            // Show target pane
            const target = document.getElementById(targetId);
            if(target) target.classList.remove('d-none');
            
            // Activate clicked button
            btn.classList.add('active');
        }
    </script>
@endpush

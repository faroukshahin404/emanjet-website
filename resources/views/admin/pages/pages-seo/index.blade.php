@extends('admin.layouts.master')

@section('title', __('Page sections'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Page sections')" :parent-url="route('admin.pages.index')" :parent-label="__('Pages')">
        <x-slot name="toolbar">
            <x-admin.index-collapse-toolbar id-prefix="pageSeo" :show-filters="false" />
        </x-slot>
    </x-admin.page-header>
@endsection

@push('css')
    <style>
        .seo-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem;
        }

        .seo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .seo-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .seo-back-btn {
            background-color: #6b7280;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .seo-back-btn:hover {
            background-color: #4b5563;
        }

        /* Alert message */
        .seo-alert-success {
            background-color: #d1fae5;
            border: 1px solid #34d399;
            color: #065f46;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }

        /* Grid layout */
        .seo-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .seo-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Card styles */
        .seo-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .seo-card-header {
            background-color: #f3f4f6;
            padding: 0.75rem 1.5rem;

        }

        .seo-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
        }

        .seo-card-body {
            padding: 1.5rem;
        }

        .seo-content {
            margin-bottom: 1rem;
        }

        .seo-content-item {
            margin-bottom: 1.25rem;
        }

        .seo-content-label {
            display: block;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .seo-content-value {
            color: #4b5563;
        }

        .seo-meta {
            font-size: 0.875rem;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .seo-meta p {
            margin-bottom: 0.25rem;
        }

        .seo-status-active {
            font-weight: 500;
            color: #059669;
        }

        .seo-status-inactive {
            font-weight: 500;
            color: #dc2626;
        }

        .seo-edit-btn {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .seo-edit-btn:hover {
            background-color: #2563eb;
        }

        /* Language tabs */
        .language-tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1rem;
        }

        .language-tab {
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .language-tab.active {
            border-bottom-color: #3b82f6;
            color: #3b82f6;
        }

        .language-content {
            display: none;
        }

        .language-content.active {
            display: block;
        }

        .rtl-text {
            direction: rtl;
            text-align: right;
        }
    </style>
@endpush

@section('content')
    <div class="collapse show mb-4" id="pageSeoSummaryCollapse">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Total sections')" :value="number_format($stats['total'])"
                    icon="bi-layers-fill" color="primary" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Active sections')" :value="number_format($stats['active'])"
                    icon="bi-toggle-on" color="success" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Section types')" :value="number_format($stats['section_types'])"
                    icon="bi-grid-1x2-fill" color="info" />
            </div>
        </div>
    </div>

    <div class="mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h5 class="mb-1 fw-bold">{{ __('Page sections for:') }}</h5>
                    <p class="mb-0 text-muted">{{ is_array($page->title) ? $page->title['en'] : $page->title }}</p>
                </div>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('Back to Pages') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row g-4">
            @foreach ($page->pageSeos->sortBy('order') as $seo)
                @continue($seo->section_type === 'apps')
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <h6 class="mb-0 fw-bold">{{ ucfirst(str_replace('-', ' ', $seo->section_type)) }}</h6>
                            @if ($seo->section_type === 'hero-section')
                                <span class="badge bg-label-primary text-wrap text-start">{{ __('Hero: title, text & main image') }}</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.page-sections.toggle-status', $seo) }}" method="POST"
                                class="mb-3 pb-3 border-bottom">
                                @csrf
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                    <span class="small fw-semibold text-body mb-0">{{ __('Show on website') }}</span>
                                    <div class="form-check form-switch form-switch-lg mb-0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="section_visible_{{ $seo->id }}"
                                            {{ $seo->status ? 'checked' : '' }}
                                            onchange="this.form.requestSubmit ? this.form.requestSubmit() : this.form.submit();"
                                            aria-label="{{ __('Toggle section visibility on the website') }}">
                                    </div>
                                </div>
                            </form>
                            <ul class="list-unstyled small text-muted mb-3">
                                <li>{{ __('Order') }}: {{ $seo->order }}</li>
                                <li>{{ __('Last Updated') }}: {{ $seo->updated_at->format('M d, Y') }}</li>
                            </ul>
                            <a href="{{ route('admin.page-sections.edit', $seo) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil me-1"></i>{{ __('Edit Section') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.language-tab');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const sectionId = tab.getAttribute('data-section');
                    const lang = tab.getAttribute('data-lang');

                    // Update active tab in this section
                    const sectionTabs = document.querySelectorAll(
                        `.language-tab[data-section="${sectionId}"]`);
                    sectionTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    // Update active content
                    const sectionContents = document.querySelectorAll(
                        `[id^="section-${sectionId}-"]`);
                    sectionContents.forEach(content => content.classList.remove('active'));
                    document.getElementById(`section-${sectionId}-${lang}`).classList.add('active');
                });
            });
        });
    </script>
@endsection

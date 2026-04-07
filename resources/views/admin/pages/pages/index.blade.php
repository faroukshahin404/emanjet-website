@extends('admin.layouts.master')

@section('title', __('Pages'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Pages')" :create-url="route('admin.pages.create')">
        <x-slot name="toolbar">
            <x-admin.index-collapse-toolbar id-prefix="pages" :show-filters="false" />
        </x-slot>
    </x-admin.page-header>
@endsection

@push('css')
    <style>
        /* Enhanced styling for better visual hierarchy and modern design */
        .page-container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
        }

        .create-button {
            background-color: #10b981;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .create-button:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }

        .page-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        .page-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #f3f4f6;
        }

        .page-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .card-language {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .language-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            background-color: #e5e7eb;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .language-badge svg {
            width: 16px;
            height: 16px;
            margin-right: 4px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

    

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background-color: #d1fae5;
            color: #047857;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-description {
            color: #6b7280;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .meta-item svg {
            width: 16px;
            height: 16px;
            color: #9ca3af;
        }

        .card-actions {
            display: flex;
            gap: 0.75rem;
        }

        .action-button {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s ease;
            flex: 1;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .edit-button {
            background-color: #3b82f6;
            color: white;
        }

        .edit-button:hover {
            background-color: #2563eb;
        }

        .sections-button {
            background-color: #0d9488;
            color: white;
        }

        .sections-button:hover {
            background-color: #0f766e;
            color: white;
        }

        .preview-button {
            background-color: #f3f4f6;
            color: #374151;
        }

        .preview-button:hover {
            background-color: #e5e7eb;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background-color: #f9fafb;
            border-radius: 0.75rem;
            border: 2px dashed #e5e7eb;
        }

        .empty-state-icon {
            margin-bottom: 1.5rem;
            color: #9ca3af;
            font-size: 3rem;
        }

        .empty-state-text {
            font-size: 1.125rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        /* Responsive design */
        @media (min-width: 640px) {
            .page-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .page-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
@endpush

@section('content')
    <div class="collapse show mb-4" id="pagesSummaryCollapse">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Pages')" :value="number_format($stats['total'])"
                    icon="bi-file-earmark-text" color="primary" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Active')" :value="number_format($stats['active'])"
                    icon="bi-check-circle-fill" color="success" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('With page sections')" :value="number_format($stats['with_sections'])"
                    icon="bi-diagram-3-fill" color="info" />
            </div>
        </div>
    </div>

    <div class="page-container px-0">
        @if(count($pages) > 0)
            <div class="page-grid">
                @foreach($pages as $page)
                    <div class="page-card">
                        <div class="card-header">
                            <div class="card-language">
                               
                            </div>
                            <div class="card-title">
                                <span>{{ is_array($page->title) ? $page->title['en'] : $page->title }}</span>
                            </div>
                          
                        </div>
                        <div class="card-body">
                            <p class="card-description">
                                {{ is_array($page->meta_description) ? ($page->meta_description['en'] ?? '') : $page->meta_description }}
                            </p>
                            <div class="card-meta">
                                <div class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <span>{{ __('Sections') }}: {{ $page->pageSeos->count() }}</span>
                                </div>
                                <div class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Updated: {{ \Carbon\Carbon::parse($page->updated_at)->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="card-actions">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="action-button edit-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Edit Page
                                </a>
                                <a href="{{ route('admin.pages.sections.index', $page) }}" class="action-button sections-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                    {{ __('Page sections') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <p class="empty-state-text">No pages found. Create your first page to get started.</p>
                <a href="{{ route('admin.pages.create') }}" class="create-button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Create Page
                </a>
            </div>
        @endif
    </div>
@endsection

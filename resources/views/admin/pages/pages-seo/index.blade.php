@extends('admin.layouts.master')

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
        border-bottom: 1px solid #e5e7eb;
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
        margin-bottom: 0.75rem;
    }
    
    .seo-content-label {
        font-weight: 500;
        color: #111827;
    }
    
    .seo-content-value {
        color: #4b5563;
    }
    
    .seo-meta {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 1rem;
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
</style>
@endpush

@section('content')
    <div class="seo-container">
        <div class="seo-header">
            <h1 class="seo-title">SEO Sections for: {{ $page->title }}</h1>
            <a href="{{ route('admin.pages.index') }}" class="seo-back-btn">Back to Pages</a>
        </div>

        @if (session('success'))
            <div class="seo-alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="seo-grid">
            @foreach ($page->pageSeos->sortBy('order') as $seo)
                <div class="seo-card">
                    <div class="seo-card-header">
                        <h2 class="seo-card-title">{{ ucfirst(str_replace('-', ' ', $seo->section_type)) }}</h2>
                    </div>
                    <div class="seo-card-body">
                        <div class="seo-content">
                            @php
                                $contentArray = json_decode($seo->content_json, true);
                            @endphp

                            @foreach ($contentArray as $key => $value)
                                <div class="seo-content-item">
                                    <span class="seo-content-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                    @if (is_array($value))
                                        <span class="seo-content-value">
                                            @if (isset($value[0]) && is_string($value[0]))
                                                [{{ count($value) }} items]
                                            @else
                                                [Complex structure]
                                            @endif
                                        </span>
                                    @else
                                        <span class="seo-content-value">
                                            {{ is_string($value) && strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="seo-meta">
                            <p>Order: {{ $seo->order }}</p>
                            <p>Status: <span
                                    class="seo-status-{{ $seo->status ? 'active' : 'inactive' }}">{{ $seo->status ? 'Active' : 'Inactive' }}</span>
                            </p>
                            <p>Last Updated: {{ $seo->updated_at->format('M d, Y') }}</p>
                        </div>

                        <div>
                            <a href="{{ route('admin.pages-seo.edit', $seo->id) }}" class="seo-edit-btn">
                                Edit Section
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
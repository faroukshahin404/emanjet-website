@props([
    'title',
    'createUrl' => null,
    'createLabel' => null,
    'homeUrl' => null,
    'parentUrl' => null,
    'parentLabel' => null,
])

@php
    $homeUrl = $homeUrl ?? url('/');
@endphp

<div class="mb-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <nav aria-label="breadcrumb" class="flex-grow-1 min-w-0">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ $homeUrl }}" class="text-decoration-none"><i class="bi bi-house-door"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard.index') }}"
                            class="text-decoration-none">{{ __('Dashboard') }}</a>
                    </li>
                    @if ($parentUrl)
                        <li class="breadcrumb-item">
                            <a href="{{ $parentUrl }}" class="text-decoration-none">{{ $parentLabel }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
            <div class="d-flex flex-wrap align-items-center gap-2 ms-auto">
                @isset($toolbar)
                    {{ $toolbar }}
                @endisset
                @if ($createUrl)
                    <a href="{{ $createUrl }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>{{ $createLabel ?? __('Create') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

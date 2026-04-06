@props([
    'idPrefix' => 'adminList',
    'filterKeys' => [],
    'showFilters' => true,
])

@php
    $filtersExpanded = false;
    foreach ($filterKeys as $key) {
        if (request()->filled($key)) {
            $filtersExpanded = true;
            break;
        }
    }
    $summaryId = $idPrefix . 'SummaryCollapse';
    $filtersId = $idPrefix . 'FiltersCollapse';
@endphp

<div class="d-flex flex-wrap gap-2">
    <button type="button" class="btn btn-sm btn-outline-info d-inline-flex align-items-center gap-1"
        data-bs-toggle="collapse" data-bs-target="#{{ $summaryId }}" aria-expanded="true"
        aria-controls="{{ $summaryId }}">
        <i class="bi bi-bar-chart-line"></i>
        <span>{{ __('Summary') }}</span>
    </button>
    @if ($showFilters)
        <button type="button" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1"
            data-bs-toggle="collapse" data-bs-target="#{{ $filtersId }}"
            aria-expanded="{{ $filtersExpanded ? 'true' : 'false' }}" aria-controls="{{ $filtersId }}">
            <i class="bi bi-funnel"></i>
            <span>{{ __('Filters') }}</span>
        </button>
    @endif
</div>

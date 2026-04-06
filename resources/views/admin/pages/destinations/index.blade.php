@extends('admin.layouts.master')

@section('title', __('Destinations'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Destinations')" :create-url="route('admin.destinations.create')">
        <x-slot name="toolbar">
            <x-admin.index-collapse-toolbar id-prefix="destinations" :filter-keys="['destination']" />
        </x-slot>
    </x-admin.page-header>
@endsection

@section('content')
    <div class="collapse show mb-4" id="destinationsSummaryCollapse">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Destinations')" :value="number_format($stats['total'])"
                    icon="bi-signpost-split-fill" color="primary" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Ordered entries')" :value="number_format($stats['ordered'])"
                    icon="bi-sort-numeric-down" color="info" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Last 7 days')" :value="number_format($stats['recent'])"
                    icon="bi-clock-history" color="success" />
            </div>
        </div>
    </div>

    <div class="collapse mb-4 @if (request()->filled('destination')) show @endif" id="destinationsFiltersCollapse">
        @include('admin.pages.destinations.filter')
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @include('admin.pages.destinations.list')
        </div>
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center pt-0 pb-4">
            {{ $results->appends(request()->all())->links() }}
        </div>
    </div>
@endsection

@extends('admin.layouts.master')

@section('title', __('Bus Categories'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Bus Categories')" :create-url="route('admin.bus-categories.create')">
        <x-slot name="toolbar">
            <x-admin.index-collapse-toolbar id-prefix="busCategories" :filter-keys="['search']" />
        </x-slot>
    </x-admin.page-header>
@endsection

@section('content')
    <div class="collapse show mb-4" id="busCategoriesSummaryCollapse">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Bus Categories')" :value="number_format($stats['total'])"
                    icon="bi-bus-front-fill" color="primary" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Avg. passengers')" :value="(string) $stats['avg_passengers']"
                    icon="bi-people-fill" color="info" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Last 7 days')" :value="number_format($stats['recent'])"
                    icon="bi-clock-history" color="success" />
            </div>
        </div>
    </div>

    <div class="collapse mb-4 @if (request()->filled('search')) show @endif" id="busCategoriesFiltersCollapse">
        @include('admin.pages.bus-categories.filters')
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                @include('admin.pages.bus-categories.list')
            </div>
        </div>
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center pt-0 pb-4">
            {{ $results->appends(request()->all())->links() }}
        </div>
    </div>
@endsection

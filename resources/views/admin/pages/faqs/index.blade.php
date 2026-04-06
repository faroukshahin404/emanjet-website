@extends('admin.layouts.master')

@section('title', __('FAQs'))

@section('breadcrumb')
    <x-admin.page-header :title="__('FAQs')" :create-url="route('admin.faqs.create')">
        <x-slot name="toolbar">
            <x-admin.index-collapse-toolbar id-prefix="faqs" :filter-keys="['search', 'status']" />
        </x-slot>
    </x-admin.page-header>
@endsection

@section('content')
    <div class="collapse show mb-4" id="faqsSummaryCollapse">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Total FAQs')" :value="number_format($stats['total'])"
                    icon="bi-question-circle-fill"
                    color="primary" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Active')" :value="number_format($stats['active'])"
                    icon="bi-check-circle-fill" color="success" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Last 7 days')" :value="number_format($stats['recent'])"
                    icon="bi-clock-history" color="info" />
            </div>
        </div>
    </div>

    <div class="collapse mb-4 @if (request()->filled('search') || request()->filled('status')) show @endif"
        id="faqsFiltersCollapse">
        @include('admin.pages.faqs.filters')
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @include('admin.pages.faqs.list')
        </div>
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center pt-0 pb-4">
            {{ $results->links() }}
        </div>
    </div>
@endsection

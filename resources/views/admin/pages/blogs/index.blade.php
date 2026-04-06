@extends('admin.layouts.master')

@section('title', __('Blogs'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Blogs')" :create-url="route('admin.blogs.create')">
        <x-slot name="toolbar">
            <x-admin.index-collapse-toolbar id-prefix="blogs" :filter-keys="['blog', 'category']" />
        </x-slot>
    </x-admin.page-header>
@endsection

@section('content')
    <div class="collapse show mb-4" id="blogsSummaryCollapse">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Blogs')" :value="number_format($stats['total'])"
                    icon="bi-journal-text" color="primary" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Categories in use')" :value="number_format($stats['categories_used'])"
                    icon="bi-folder2-open" color="info" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Last 7 days')" :value="number_format($stats['recent'])"
                    icon="bi-clock-history" color="success" />
            </div>
        </div>
    </div>

    <div class="collapse mb-4 @if (request()->filled('blog') || request()->filled('category')) show @endif"
        id="blogsFiltersCollapse">
        @include('admin.pages.blogs.filter')
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @include('admin.pages.blogs.list')
        </div>
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center pt-0 pb-4">
            {{ $results->appends(request()->all())->links() }}
        </div>
    </div>
@endsection

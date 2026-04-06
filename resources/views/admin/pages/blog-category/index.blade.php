@extends('admin.layouts.master')

@section('title', __('Blog Categories'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Blog Categories')" :create-url="route('admin.blog-categories.create')">
        <x-slot name="toolbar">
            <x-admin.index-collapse-toolbar id-prefix="blogCategories" :filter-keys="['category']" />
        </x-slot>
    </x-admin.page-header>
@endsection

@section('content')
    <div class="collapse show mb-4" id="blogCategoriesSummaryCollapse">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Blog Categories')" :value="number_format($stats['total'])"
                    icon="bi-folder" color="primary" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('With posts')" :value="number_format($stats['with_posts'])"
                    icon="bi-journal-check" color="info" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Last 7 days')" :value="number_format($stats['recent'])"
                    icon="bi-clock-history" color="success" />
            </div>
        </div>
    </div>

    <div class="collapse mb-4 @if (request()->filled('category')) show @endif" id="blogCategoriesFiltersCollapse">
        @include('admin.pages.blog-category.filter')
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @include('admin.pages.blog-category.list')
        </div>
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center pt-0 pb-4">
            {{ $results->appends(request()->all())->links() }}
        </div>
    </div>
@endsection

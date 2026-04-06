@extends('admin.layouts.master')

@section('title', __('Blogs'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Blogs')" :create-url="route('admin.blogs.create')" />
@endsection

@section('content')
    <div class="mb-4">
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

@extends('admin.layouts.master')

@section('title', __('Bus Categories'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Bus Categories')" :create-url="route('admin.bus-categories.create')" />
@endsection

@section('content')
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

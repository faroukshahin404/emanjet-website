@extends('admin.layouts.master')

@section('title', __('FAQs'))

@section('breadcrumb')
    <x-admin.page-header :title="__('FAQs')" :create-url="route('admin.faqs.create')" />
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @include('admin.pages.faqs.list')
        </div>
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center pt-0 pb-4">
            {{ $results->appends(request()->all())->links() }}
        </div>
    </div>
@endsection

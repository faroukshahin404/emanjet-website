@extends('admin.layouts.master')

@section('title', __('Blog Categories'))

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="box p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard.index') }}">{{ __('Dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Blog Categories') }}</li>
                        </ol>
                    </nav>
                    <a class="btn btn-default" href="{{ route('admin.blog-categories.create') }}">
                        {{ __('Create') }}
                        <i class="fa fa-plus-circle ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-12">
                    @include('admin.pages.blog-category.filter')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            @include('admin.pages.blog-category.list')
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $results->appends(request()->all())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Custom scripts if needed --}}
@endpush

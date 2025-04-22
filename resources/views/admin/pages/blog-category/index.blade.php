@extends('admin.layouts.master')
@section('title', __('Blog Categories'))
@section('breadcrumb')
    <div class="content-header row">
        <div class="col-lg-4 d-flex align-items-center">
            <div class="me-auto">
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route('admin.dashboard.index') }}">
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Blog Categories') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-lg d-flex justify-content-end">
            <div>
                <a class="waves-effect waves-light btn btn-primary mb-5"
                    href="{{ route('admin.blog-categories.create') }}">{{ __('Create') }}<i class="fa fa-plus-circle"
                        style="margin-inline: 5px;"></i></a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            @include('admin.pages.blog-category.list')
                        </div>
                    </div>
                    <div class="box-footer">
                        {{ $results->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush

@extends('admin.layouts.master')

@section('title', __('Blogs'))

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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Blogs') }}</li>
                        </ol>
                    </nav>
                    <a class="btn btn-default" href="{{ route('admin.blogs.create') }}">
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
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">

                            @include('admin.pages.blogs.filter')
                            @include('admin.pages.blogs.list')
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

@push('css')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> --}}
@endpush

@push('scripts')
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example5').DataTable({
                "paging": false,
            });
        });
    </script>
@endpush

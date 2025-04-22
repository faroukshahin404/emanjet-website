@extends('admin.layouts.master')
Procedures
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Blog Categories') }}</h4>
                    </div>
                    <div class="card-body">
                       @include('admin.blog-category.list')
                        <div class="d-flex justify-content-center mt-3">
                            {{ $results->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

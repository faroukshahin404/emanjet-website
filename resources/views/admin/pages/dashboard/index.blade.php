@extends('admin.layouts.master')
@section('content')
    <div class="col-xl-3 col-md-6 col-12">
        <div class="box box-body bg-success text-center">
            <h5 class="mb-0">
                <span class="text-uppercase" style="color: white">{{ __(' Pages -  الصفحات') }}</span>
            </h5>
            <br>
            <span class="d-flex justify-content-center"><a class="btn btn-rounded btn-white btn-outline"
                    href="{{ route('admin.pages.index') }}">{{ __('Manage') }}</a></span>
        </div>
    </div>
@endsection

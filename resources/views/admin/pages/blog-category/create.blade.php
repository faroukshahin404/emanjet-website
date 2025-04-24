@extends('admin.layouts.master')

@section('title', isset($category) ? __('Edit Category') : __('Create Category'))

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="box p-3 mb-3">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blog-categories.index') }}">{{ __('Blog Categories') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($category) ? __('Edit Category') : __('Create Category') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form method="POST" action="{{ isset($category) ? route('admin.blog-categories.update', $category) : route('admin.blog-categories.store') }}">
                        @csrf
                        @if (isset($category))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_{{ $lang }}">{{ __('Name') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="name_{{ $lang }}" name="name[{{ $lang }}]" value="{{ old("name.$lang", $category->name[$lang] ?? '') }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group mb-3">
                            <label for="slug">{{ __('Slug') }}</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug ?? '') }}" placeholder="{{ __('Will be generated automatically if empty') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ isset($category) ? __('Update') : __('Create') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameEn = document.getElementById('name_en');
            const slug = document.getElementById('slug');

            nameEn.addEventListener('blur', function () {
                if (!slug.value) {
                    fetch('/admin/generate-slug?text=' + encodeURIComponent(nameEn.value))
                        .then(response => response.json())
                        .then(data => {
                            slug.value = data.slug;
                        });
                }
            });
        });
    </script>
@endpush

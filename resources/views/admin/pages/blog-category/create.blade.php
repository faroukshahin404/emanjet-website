@extends('admin.layouts.master')
@section('title', isset($category) ? __('Edit Category') : __('Create Category'))

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
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route('admin.blog-categories.index') }}">
                                    {{ __('Blog Categories') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($category) ? __('Edit Category') : __('Create Category') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($category) ? __('Edit Category') : __('Create Category') }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ isset($category) ? route('admin.blog-categories.update', $category) : route('admin.blog-categories.store') }}">
                            @csrf
                            @if(isset($category))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_en">{{ __('English Name') }}</label>
                                        <input type="text" class="form-control" id="name_en" name="name[en]"
                                            value="{{ old('name.en', $category->name['en'] ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_ar">{{ __('Arabic Name') }}</label>
                                        <input type="text" class="form-control" id="name_ar" name="name[ar]"
                                            value="{{ old('name.ar', $category->name['ar'] ?? '') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="slug">{{ __('Slug') }}</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    value="{{ old('slug', $category->slug ?? '') }}"
                                    placeholder="{{ __('Will be generated automatically if empty') }}">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($category) ? __('Update') : __('Create') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-generate slug from English name if slug is empty
            const nameEn = document.getElementById('name_en');
            const slug = document.getElementById('slug');

            nameEn.addEventListener('blur', function() {
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

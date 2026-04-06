@extends('admin.layouts.master')

@section('title', isset($category) ? __('Edit Category') : __('Create Category'))

@section('breadcrumb')
    <x-admin.page-header
        :title="isset($category) ? __('Edit Category') : __('Create Category')"
        :parent-url="route('admin.blog-categories.index')"
        :parent-label="__('Blog Categories')" />
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
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
                                        <input type="text" class="form-control" id="name_{{ $lang }}" name="name[{{ $lang }}]" value="{{ old("name.$lang", isset($category) ? ($category->name[$lang] ?? '') : '') }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ isset($category) ? __('Update') : __('Create') }}
                        </button>
                    </form>
        </div>
    </div>
@endsection

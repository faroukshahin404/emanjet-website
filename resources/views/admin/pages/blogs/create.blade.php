@extends('admin.layouts.master')

@section('title', isset($item) ? __('Edit Blog') : __('Create Blog'))

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="box p-3 mb-3">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.blogs.index') }}">{{ __('Blogs') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($item) ? __('Edit Blog') : __('Create Blog') }}
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
                    <form method="POST" action="{{ isset($item) ? route('admin.blogs.update', $item) : route('admin.blogs.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if (isset($item))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_{{ $lang }}">{{ __('Title') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="title_{{ $lang }}" name="title[{{ $lang }}]" value="{{ old("title.$lang", $item->title[$lang] ?? '') }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="form-group mb-3">
                            <label for="image">{{ __('Image') }}</label>
                            <input type="file" class="dropify" id="image" name="image" data-default-file="{{ isset($item) && $item->image ? asset($item->image) : '' }}">
                        </div>

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="content_{{ $lang }}">{{ __('Content') }} ({{ $label }})</label>
                                        <textarea class="form-control" id="content_{{ $lang }}" name="content[{{ $lang }}]" rows="4">{{ old("content.$lang", $item->content[$lang] ?? '') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group mb-3">
                            <label for="category_id">{{ __('Category') }}</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $item->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->translated_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="views">{{ __('Views') }}</label>
                                    <input type="number" class="form-control" id="views" name="views" value="{{ old('views', $item->views ?? 0) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="likes">{{ __('Likes') }}</label>
                                    <input type="number" class="form-control" id="likes" name="likes" value="{{ old('likes', $item->likes ?? 0) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reading_time">{{ __('Reading Time (mins)') }}</label>
                                    <input type="number" class="form-control" id="reading_time" name="reading_time" value="{{ old('reading_time', $item->reading_time ?? 0) }}">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title_{{ $lang }}">{{ __('Meta Title') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="meta_title_{{ $lang }}" name="meta_title[{{ $lang }}]" value="{{ old("meta_title.$lang", $item->meta_title[$lang] ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description_{{ $lang }}">{{ __('Meta Description') }} ({{ $label }})</label>
                                        <textarea class="form-control" id="meta_description_{{ $lang }}" name="meta_description[{{ $lang }}]" rows="2">{{ old("meta_description.$lang", $item->meta_description[$lang] ?? '') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags_{{ $lang }}">{{ __('Meta Tags') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="meta_tags_{{ $lang }}" name="meta_tags[{{ $lang }}]" value="{{ old("meta_tags.$lang", is_array($item->meta_tags ?? null) ? implode(',', $item->meta_tags[$lang] ?? []) : '') }}">
                                        <small class="text-muted">{{ __('Comma separated') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            {{ isset($item) ? __('Update') : __('Create') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endpush

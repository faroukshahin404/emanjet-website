@extends('admin.layouts.master')

@section('title', isset($item) ? __('Edit Destination') : __('Create Destination'))

@section('breadcrumb')
    <x-admin.page-header
        :title="isset($item) ? __('Edit Destination') : __('Create Destination')"
        :parent-url="route('admin.destinations.index')"
        :parent-label="__('Destinations')" />
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
                    <form method="POST" action="{{ isset($item) ? route('admin.destinations.update', $item) : route('admin.destinations.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if (isset($item))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name_{{ $lang }}">{{ __('Name') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="name_{{ $lang }}" name="name[{{ $lang }}]" value="{{ old("name.$lang", isset($item) ? ($item->name[$lang] ?? '') : '') }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="image">{{ __('Image') }}</label>
                            <input type="file" class="dropify" id="image" name="image" data-default-file="{{ isset($item) && $item->image ? asset($item->image) : '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="order">{{ __('Order') }}</label>
                            <input type="number" class="form-control" id="order" name="order" value="{{ old('order', isset($item) ? $item->order : 0) }}">
                        </div>

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="content_{{ $lang }}">{{ __('Content') }} ({{ $label }})</label>
                                        <textarea class="form-control" id="content_{{ $lang }}" name="content[{{ $lang }}]" rows="10">{{ old("content.$lang", isset($item) ? ($item->content[$lang] ?? '') : '') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="meta_title_{{ $lang }}">{{ __('Meta Title') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="meta_title_{{ $lang }}" name="meta_title[{{ $lang }}]" value="{{ old("meta_title.$lang", isset($item) ? ($item->meta_title[$lang] ?? '') : '') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="meta_description_{{ $lang }}">{{ __('Meta Description') }} ({{ $label }})</label>
                                        <textarea class="form-control" id="meta_description_{{ $lang }}" name="meta_description[{{ $lang }}]" rows="8">{{ old("meta_description.$lang", isset($item) ? ($item->meta_description[$lang] ?? '') : '') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="meta_tags_{{ $lang }}">{{ __('Meta Tags') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="meta_tags_{{ $lang }}" name="meta_tags[{{ $lang }}]" value="{{ old("meta_tags.$lang", isset($item) && is_array($item->meta_tags ?? null) ? implode(',', $item->meta_tags[$lang] ?? []) : '') }}">
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
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.dropify').dropify();
        });
    </script>
@endpush

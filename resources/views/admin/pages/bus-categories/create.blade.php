@extends('admin.layouts.master')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ $isEdit ? __('Edit Bus Category') : __('Create New Bus Category') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            action="{{ $isEdit ? route('admin.bus-categories.update', $busCategory->id) : route('admin.bus-categories.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_ar" class="form-label">{{ __('Name (Arabic)') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                            id="name_ar" name="name_ar"
                                            value="{{ old('name_ar', $busCategory->name_ar) }}" required>
                                        @error('name_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_en" class="form-label">{{ __('Name (English)') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                            id="name_en" name="name_en"
                                            value="{{ old('name_en', $busCategory->name_en) }}" required>
                                        @error('name_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rate" class="form-label">{{ __('Rate') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('rate') is-invalid @enderror"
                                            id="rate" name="rate" value="{{ old('rate', $busCategory->rate) }}"
                                            min="0" max="5" step="0.1" required>
                                        @error('rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passengers" class="form-label">{{ __('Passengers') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('passengers') is-invalid @enderror"
                                            id="passengers" name="passengers"
                                            value="{{ old('passengers', $busCategory->passengers) }}" min="1"
                                            required>
                                        @error('passengers')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">{{ __('Image') }}</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        @if ($busCategory->image)
                                            <div class="mt-2">
                                                <p>{{ __('Current Image:') }}</p>
                                                <img src="{{ asset('storage/' . $busCategory->image) }}"
                                                    alt="{{ $busCategory->name_en }}" class="preview-image"
                                                    id="current-image">
                                            </div>
                                        @endif

                                        <div class="mt-2" id="image-preview-container" style="display: none;">
                                            <p>{{ __('New Image Preview:') }}</p>
                                            <img src="" alt="Preview" class="preview-image" id="image-preview">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.bus-categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    {{ $isEdit ? __('Update Category') : __('Create Category') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Image preview
            $('#image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result);
                        $('#image-preview-container').show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#image-preview-container').hide();
                }
            });
        });
    </script>
@endpush

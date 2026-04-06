<form method="GET" action="{{ route('admin.blogs.index') }}">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="blog" class="form-label">{{ __('Blog ') }}</label>
                    <select id="blog" name="blog" class="form-select select2">
                        <option value="">{{ __('Select Blog') }}</option>
                        @foreach ($blogs as $blog)
                            <option value="{{ $blog->id }}" {{ request('blog') == $blog->id ? 'selected' : '' }}>
                                {{ $blog->translated_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label">{{ __('Category') }}</label>
                    <select id="category" name="category" class="form-select select2">
                        <option value="">{{ __('Select category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->translated_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex flex-wrap gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i>{{ __('Apply Filters') }}
                    </button>
                    @if (request()->filled('blog') || request()->filled('category'))
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i>{{ __('Clear') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            if ($.fn.select2) {
                $('.select2').select2({
                    placeholder: "{{ __('Select City') }}",
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    </script>
@endpush

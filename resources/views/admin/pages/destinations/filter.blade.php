<form method="GET" action="{{ route('admin.destinations.index') }}">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="destination" class="form-label">{{ __('Destination') }}</label>
                    <select id="destination" name="destination" class="form-select select2">
                        <option value="">{{ __('Select Destination') }}</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ request('destination') == $destination->id ? 'selected' : '' }}>
                                {{ $destination->translated_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 d-flex flex-wrap gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i>{{ __('Apply Filters') }}
                    </button>
                    @if (request()->filled('destination'))
                        <a href="{{ route('admin.destinations.index') }}" class="btn btn-outline-secondary">
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
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    </script>
@endpush

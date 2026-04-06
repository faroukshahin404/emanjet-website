<form method="GET" action="{{ route('admin.stations.index') }}">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="station" class="form-label">{{ __('Station') }}</label>
                    <select id="station" name="station" class="form-select select2">
                        <option value="">{{ __('Select Station') }}</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}" {{ request('station') == $station->id ? 'selected' : '' }}>
                                {{ $station->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select id="status" name="status" class="form-select select2">
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>{{ __('Available') }}</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>{{ __('Unavailable') }}</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex flex-wrap gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i>{{ __('Apply Filters') }}
                    </button>
                    @if (request()->filled('station') || request()->filled('status'))
                        <a href="{{ route('admin.stations.index') }}" class="btn btn-outline-secondary">
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

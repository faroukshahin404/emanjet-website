<form method="GET" action="{{ route('admin.cities.index') }}">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="city" class="form-label">{{ __('Cities') }}</label>
                    <select id="city" name="city" class="form-select select2">
                        <option value="">{{ __('Select city') }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
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
                <div class="col-md-4 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>{{ __('Search') }}
                    </button>
                    <a href="{{ route('admin.cities.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>{{ __('Reset') }}
                    </a>
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

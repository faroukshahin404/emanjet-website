<form method="GET" action="{{ route('admin.bus-categories.index') }}">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label for="bus_cat_search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="bus_cat_search" name="search"
                            value="{{ request('search') }}" placeholder="{{ __('Search...') }}">
                    </div>
                </div>
                <div class="col-md-3 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i>{{ __('Apply Filters') }}
                    </button>
                    @if (request()->filled('search'))
                        <a href="{{ route('admin.bus-categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i>{{ __('Clear') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>

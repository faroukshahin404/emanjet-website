<form method="GET" action="{{ route('admin.faqs.index') }}">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="faq_search" class="form-label">{{ __('Search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="faq_search" name="search"
                            value="{{ request('search') }}" placeholder="{{ __('Search...') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="faq_status" class="form-label">{{ __('Status') }}</label>
                    <select id="faq_status" name="status" class="form-select">
                        <option value="">{{ __('All') }}</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i>{{ __('Apply Filters') }}
                    </button>
                    @if (request()->filled('search') || request()->filled('status'))
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i>{{ __('Clear') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>

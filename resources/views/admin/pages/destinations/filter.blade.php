<form method="GET" action="{{ route('admin.destinations.index') }}">
    <div class="box">
        <div class="box-body">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="destination">{{ __('Destination') }}</label>
                    <select id="destination" name="destination" class="form-control select2">
                        <option value="">{{ __('Select Destination') }}</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ request('destination') == $destination->id ? 'selected' : '' }}>
                                {{ $destination->translated_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="category">{{ __('Category') }}</label>
                    <select id="category" name="category" class="form-control select2">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->translated_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i> {{ __('Search') }}
                    </button>
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-default mx-2">
                        <i class="fa fa-undo"></i> {{ __('Reset') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
